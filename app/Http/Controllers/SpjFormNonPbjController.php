<?php

namespace App\Http\Controllers;

use App\Models\PengajuanBarangJasa;
use App\Models\PengajuanBarangJasaDetail;
use App\Models\PengajuanBarangJasaPelaksana;
use App\Models\SpjBarangJasa;
use App\Models\SpjBarangJasaDetail;
use Illuminate\Http\Request;

class SpjFormNonPbjController extends Controller
{
    public function index()
    {
        $data = SpjBarangJasa::with('spd_detail');
        $items = $data->latest()->get();
        return view('pages.spj-barang-jasa.index', [
            'title' => 'Surat Pertanggung Jawaban Data',
            'items' => $items
        ]);
    }
    public function create()
    {
        $data_pengajuan = PengajuanBarangJasa::formNonPbj()->whereHas('details', function ($q) {
            $q->where('karyawan_id', auth()->user()->karyawan->id);
        })->latest()->get();
        return view('pages.spj-barang-jasa.create', [
            'title' => 'Buat SPJ',
            'data_pengajuan' => $data_pengajuan
        ]);
    }

    public function store()
    {
        request()->validate([
            'draft' => ['required', 'mimes:pdf'],
            'spd_detail_id' => ['required']
        ]);

        DB::beginTransaction();
        try {
            $data_perincian_biaya = request('perincian_biaya');
            $data_nominal = request('nominal');
            $data_keterangan = request('keterangan');
            $data_file = request('file');
            // cek spj
            $cekSpj = SpjBarangJasa::where('spd_detail_id', request('spd_detail_id'))->count();
            if ($cekSpj) {
                return redirect()->route('surat-pertanggung-jawaban.index')->with('error', 'Surat Pertanggung Jawaban sudah ada di database.');
            }
            $spj = SpjBarangJasa::create([
                'uuid' => \Str::uuid(),
                'spd_detail_id' => request('spd_detail_id'),
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
            return redirect()->route('surat-pertanggung-jawaban.index')->with('success', 'Surat Pertanggung Jawaban Berhasil dibuat.');
        } catch (\Throwable $th) {
            throw $th;
            DB::rollBack();
            return redirect()->route('surat-pertanggung-jawaban.index')->with('error', $th->getMessage());
        }
    }

    public function edit($uuid)
    {
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
            return redirect()->route('surat-pertanggung-jawaban.index')->with('success', 'Surat Pertanggung Jawaban Berhasil diupdate.');
        } catch (\Throwable $th) {
            throw $th;
            DB::rollBack();
            return redirect()->route('surat-pertanggung-jawaban.index')->with('error', $th->getMessage());
        }
    }

    public function show($uuid)
    {
        $item = SpjBarangJasa::where('uuid', $uuid)->firstOrFail();
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
        return redirect()->route('surat-pertanggung-jawaban.index')->with('success', 'Surat Pertanggung Jawaban Berhasil dihapus.');
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
            return redirect()->route('surat-pertanggung-jawaban.index')->with('success', 'Surat Pertanggung Jawaban Berhasil diupdate.');
        } catch (\Throwable $th) {
            throw $th;
            DB::rollBack();
            return redirect()->route('surat-pertanggung-jawaban.index')->with('error', $th->getMessage());
        }
    }
}
