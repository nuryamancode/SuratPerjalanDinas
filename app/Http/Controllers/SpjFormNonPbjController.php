<?php

namespace App\Http\Controllers;

use App\Models\PengajuanBarangJasa;
use App\Models\PengajuanBarangJasaDetail;
use App\Models\PengajuanBarangJasaPelaksana;
use App\Models\SpjBarangJasa;
use App\Models\SpjBarangJasaDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SpjFormNonPbjController extends Controller
{
    public function index()
    {
        // $data = SpjBarangJasa::with('spd_detail');
        // $items = $data->latest()->get();
        $items = PengajuanBarangJasa::formNonPbj()->whereHas('pelaksana', function ($q) {
            $q->where('karyawan_id', auth()->user()->karyawan->id);
        })->get();
        return view('pages.spj-barang-jasa.index', [
            'title' => 'Surat Pertanggung Jawaban Data',
            'items' => $items
        ]);
    }
    public function create()
    {
        $pengajuan_barang_jasa_uuid = request('pengajuan_barang_jasa_uuid');
        $pengajuan = PengajuanBarangJasa::where('uuid', $pengajuan_barang_jasa_uuid)->firstOrFail();
        $pelaksana = PengajuanBarangJasaPelaksana::where('pengajuan_barang_jasa_id', $pengajuan->id)->where('karyawan_id', auth()->user()->karyawan->id)->first();
        $spj = SpjBarangJasa::where('pengajuan_barang_jasa_pelaksana_id', $pelaksana->id)->first();
        if ($spj) {
            // edit spj
            return redirect()->route('spj-form-non-pbj.edit', $spj->uuid);
        }
        $pengajuan = PengajuanBarangJasa::where('uuid', $pengajuan_barang_jasa_uuid)->formNonPbj()->whereHas('pelaksana', function ($q) {
            $q->where('karyawan_id', auth()->user()->karyawan->id);
        })->first();
        dd($pengajuan);
        return view('pages.spj-barang-jasa.create', [
            'title' => 'Buat SPJ',
            'data_pengajuan' => $data_pengajuan
        ]);
    }

    public function store()
    {
        request()->validate([
            'draft' => ['required', 'mimes:pdf']
        ]);

        DB::beginTransaction();
        try {
            $data_perincian_biaya = request('perincian_biaya');
            $data_nominal = request('nominal');
            $data_keterangan = request('keterangan');
            $data_file = request('file');
            // dd(request()->all());
            $pengajuan = PengajuanBarangJasa::formNonPbj()->where('uuid', request('pengajuan_barang_jasa_uuid'))->firstOrFail();
            $pelaksana = $pengajuan->pelaksana()->where('karyawan_id', auth()->user()->karyawan->id)->first();

            $spj = SpjBarangJasa::create([
                'uuid' => \Str::uuid(),
                'pengajuan_barang_jasa_pelaksana_id' => $pelaksana->id,
                'file' => request()->file('draft')->store('spj', 'public'),
                'status' => 0
            ]);

            foreach ($data_perincian_biaya as $key => $perincian) {
                // harus ada isi
                if ($perincian && isset($data_nominal[$key]) && isset($data_file[$key])) {
                    $spj->details()->create([
                        'uuid' => \Str::uuid(),
                        'perincian_biaya' => $perincian,
                        'nominal' => $data_nominal[$key],
                        'keterangan' => $data_keterangan[$key],
                        'file' => $data_file[$key]->store('spj-detail', 'public')
                    ]);
                }
            }
            DB::commit();
            return redirect()->route('spj-form-non-pbj.index')->with('success', 'Surat Pertanggung Jawaban Berhasil dibuat.');
        } catch (\Throwable $th) {
            throw $th;
            DB::rollBack();
            return redirect()->route('spj-form-non-pbj.index')->with('error', $th->getMessage());
        }
    }

    public function edit($uuid)
    {
        // dd($uuid);
        $item = SpjBarangJasa::where('uuid', $uuid)->firstOrFail();
        return view('pages.spj-barang-jasa.edit', [
            'title' => 'Buat SPJ',
            'item' => $item
        ]);
    }

    public function update($uuid)
    {
        request()->validate([
            'draft' => ['mimes:pdf']
        ]);

        DB::beginTransaction();
        try {
            $item = SpjBarangJasa::where('uuid', $uuid)->firstOrFail();
            $data = [];
            if (request()->file('draft')) {
                Storage::disk('public')->delete($item->file);
                $data['file'] = request()->file('draft')->store('spj', 'public');
            }
            $item->update($data);
            DB::commit();
            return redirect()->route('spj-form-non-pbj.index')->with('success', 'Surat Pertanggung Jawaban Berhasil diupdate.');
        } catch (\Throwable $th) {
            throw $th;
            DB::rollBack();
            return redirect()->route('spj-form-non-pbj.index')->with('error', $th->getMessage());
        }
    }

    public function show($uuid)
    {
        $pengajuan = PengajuanBarangJasa::formNonPbj()->where('uuid', $uuid)->firstOrFail();
        $pelaksana = PengajuanBarangJasaPelaksana::where('pengajuan_barang_jasa_id', $pengajuan->id)->where('karyawan_id', auth()->user()->karyawan->id)->first();
        $spj = SpjBarangJasa::where('pengajuan_barang_jasa_pelaksana_id', $pelaksana->id)->first();
        // if(!$spj)
        // {
        //     return redirect()->route('spj-form-non-pbj.create',[
        //         'pengajuan)ba'
        //     ])
        // }
        return view('pages.spj-barang-jasa.show', [
            'title' => 'Detail Surat Pertanggung Jawaban',
            'item' => $item
        ]);
    }

    public function destroy($uuid)
    {
        $item = SpjBarangJasa::where('uuid', $uuid)->firstOrFail();
        if ($item->file)
            Storage::disk('public')->delete($item->file);
        foreach ($item->details as $detail) {
            Storage::disk('public')->delete($detail->file);
        }
        $item->delete();
        return redirect()->route('spj-form-non-pbj.index')->with('success', 'Surat Pertanggung Jawaban Berhasil dihapus.');
    }

    public function verifikasi()
    {
        request()->validate([
            'status' => ['required']
        ]);

        DB::beginTransaction();
        try {
            $item = SpjBarangJasa::where('uuid', request('uuid'))->firstOrFail();
            $item->update([
                'status' => request('status')
            ]);
            DB::commit();
            return redirect()->route('spj-form-non-pbj.index')->with('success', 'Surat Pertanggung Jawaban Berhasil diupdate.');
        } catch (\Throwable $th) {
            throw $th;
            DB::rollBack();
            return redirect()->route('spj-form-non-pbj.index')->with('error', $th->getMessage());
        }
    }
}
