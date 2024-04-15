<?php

namespace App\Http\Controllers\Pelaksanabelanja;

use App\Http\Controllers\Controller;
use App\Models\PengajuanBarangJasa;
use App\Models\PengajuanBarangJasaPelaksana;
use App\Models\SpjBarangJasa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengajuanFormNonPbjSpjController extends Controller
{
    public function index()
    {
        $pengajuan = PengajuanBarangJasa::formNonPbj()->where('uuid', request('pengajuan_uuid'))->firstOrFail();
        $pelaksana = PengajuanBarangJasaPelaksana::where('pengajuan_barang_jasa_id', $pengajuan->id)->where('karyawan_id', auth()->user()->karyawan->id)->firstOrFail();
        // dd($pelaksana->spjFormNonPbj->pelaksanaFormNonPbj->pengajuan);
        // dd($pelaksana->spjFormNonPbj->details);
        if ($pelaksana->spjFormNonPbj == null) {
            return view('pelaksana-belanja.pages.pengajuan-form-non-pbj-spj.index', [
                'title' => 'Pengajuan Form Non PBJ',
                'pelaksana' => $pelaksana
            ]);
        } else {
            $pengajuan = $pelaksana->spjFormNonPbj->pelaksanaFormNonPbj->pengajuan;
            return view('pelaksana-belanja.pages.pengajuan-form-non-pbj-spj.show', [
                'title' => 'Pengajuan Form Non PBJ',
                'item' => $pelaksana,
                'pengajuan' => $pengajuan
            ]);
        }
    }



    public function store()
    {
        request()->validate([
            'via' => ['required']
        ]);

        DB::beginTransaction();
        try {
            $data_perincian_biaya = request('perincian_biaya');
            $data_nominal = request('nominal');
            $data_keterangan = request('keterangan');
            $data_file = request('file');

            $pengajuan = PengajuanBarangJasa::formNonPbj()->where('uuid', request('pengajuan_uuid'))->firstOrFail();
            $pelaksana = PengajuanBarangJasaPelaksana::where('pengajuan_barang_jasa_id', $pengajuan->id)->where('karyawan_id', auth()->user()->karyawan->id)->firstOrFail();

            if ($pelaksana->spjFormNonPbj) {
                // update
                $spj = $pelaksana->spjFormNonPbj()->update([
                    'uuid' => \Str::uuid(),
                    'pengajuan_barang_jasa_pelaksana_id' => $pelaksana->id,
                    'via' => request('via')
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
            } else {
                // create
                $spj = SpjBarangJasa::create([
                    'uuid' => \Str::uuid(),
                    'pengajuan_barang_jasa_pelaksana_id' => $pelaksana->id,
                    'via' => request('via'),
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
            }

            DB::commit();
            return redirect()->route('pelaksana-belanja.pengajuan-form-non-pbj.index')->with('success', 'Surat Pertanggung Jawaban Berhasil dibuat.');
        } catch (\Throwable $th) {
            throw $th;
            DB::rollBack();
            return redirect()->route('pelaksana-belanja.pengajuan-form-non-pbj.index')->with('error', $th->getMessage());
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
        $item = SpjBarangJasa::where('uuid', $uuid)->firstOrFail();
        dd($item);
        return view('pelaksana-belanja.pages.pengajuan-form-non-pbj-spj.show', [
            'title' => 'Detail Pengajuan Form Non PBJ',
            'item' => $item
        ]);
    }
}
