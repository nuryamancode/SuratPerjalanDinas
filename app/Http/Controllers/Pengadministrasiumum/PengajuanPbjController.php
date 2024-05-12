<?php

namespace App\Http\Controllers\Pengadministrasiumum;

use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use App\Models\PengajuanBarangJasa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PengajuanPbjController extends Controller
{
    public function index()
    {
        $items = PengajuanBarangJasa::pbj()->latest()->get();

        return view('pengadministrasi-umum.pages.pengajuan-pbj.index', [
            'title' => 'Pengajuan PBJ',
            'items' => $items
        ]);
    }

    public function create()
    {
        $data_karyawan = Karyawan::orderBy('nama', 'ASC')->get();
        // $data_karyawan2 = Karyawan::whereHas('user', function ($q) {
        //     $q->whereHas('roles', function ($role) {
        //         $role->whereIn('name', ['Wakil Direktur II']);
        //     });
        // })->orderBy('nama', 'ASC')->get();
        return view('pengadministrasi-umum.pages.pengajuan-pbj.create', [
            'title' => 'Tambah Pengajuan PBj',
            'data_karyawan' => $data_karyawan,
        ]);
    }

    public function store()
    {
        request()->validate([
            'nomor_surat' => ['required', 'unique:pbj,nomor_surat'],
            'nomor_agenda' => ['required', 'unique:pbj,nomor_agenda'],
            'perihal' => ['required'],
            'pengusul' => ['required', 'array'],
            'lampiran.*' => 'mimes:pdf',
            'dokumen_surat' => ['file'],
        ]);

        DB::beginTransaction();
        try {
            $data = request()->only(['nomor_surat', 'perihal', 'nomor_agenda']);
            $data_pengusul = request('pengusul');
            $data_lampiran = request()->file('lampiran');
            if (request()->file('dokumen_surat')) {
                $data['dokumen_surat'] = request()->file('dokumen_surat')->store('pbj/dokumen_surat', 'public');
            }
            $data['status_surat'] = 'Menunggu Persetujuan Wakil Direktur II';
            $data['jenis'] = 'pbj';
            $data['asal_surat'] = auth()->user()->karyawan->id;
            $item  = PengajuanBarangJasa::pbj()->create($data);
            // $pbj_id = $item->id;

            // create pengusul
            if (!empty($data_pengusul)) {
                foreach ($data_pengusul as $pengusul) {
                    $item->pengusul()->create([
                        'pengusul_id' => $pengusul
                    ]);
                }
            }

            if (!empty($data_lampiran)) {
                foreach ($data_lampiran as $lampiran) {
                    $item->lampiranpbj()->create([
                        'file' => $lampiran->store('lampiran-pbj', 'public')
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('pengadministrasi-umum.pengajuan-pbj.index')->with('success', 'Pengajuan PBJ berhasil ditambahkan.');
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function show($uuid)
    {
        $item = PengajuanBarangJasa::pbj()->where('id', $uuid)->firstOrFail();
        return view('pengadministrasi-umum.pages.pengajuan-pbj.show', [
            'title' => 'Detail Pengajuan PBJ',
            'item' => $item
        ]);
    }

    public function edit($uuid)
    {
        $item = PengajuanBarangJasa::pbj()->where('id', $uuid)->firstOrFail();
        return view('pengadministrasi-umum.pages.pengajuan-pbj.edit', [
            'title' => 'Edit Pengajuan PBJ',
            'item' => $item,
            'data_karyawan' => Karyawan::orderBy('nama', 'ASC')->get(),
            'selectedKaryawan' => $item->pengusul->pluck('karyawan.id')->toArray()
        ]);
    }

    public function update($uuid)
    {
        request()->validate([
            'nomor_surat' => 'required|unique:pbj,nomor_surat,' . $uuid . ',id',
            'perihal' => ['required'],
            'pengusul' => ['required', 'array'],
        ]);

        DB::beginTransaction();
        try {
            $data = request()->only(['nomor_surat', 'perihal', 'nomor_agenda', 'created_at']);
            $item = PengajuanBarangJasa::pbj()->where('id', $uuid)->firstOrFail();
            $data_lampiran = request()->file('lampiran');
            $data_dokumen = request()->file('dokumen_surat');
            if (!empty($data_dokumen)) {
                if ($item->dokumen_surat) {
                    Storage::delete('public/pbj/dokumen_surat/' . $item->dokumen_surat);
                }
                if (request()->hasFile('dokumen_surat') && request()->file('dokumen_surat')->isValid()) {
                    $data['dokumen_surat'] = request()->file('dokumen_surat')->store('pbj/dokumen_surat', 'public');
                }
            }
            $data_pengusul = request('pengusul');
            $data['acc_wadi2'] = 0;
            $item->update($data);

            // create pelaksana
            if (!empty($data_pengusul)) {
                // hapus pelaksana
                $item->pengusul()->delete();
                foreach ($data_pengusul as $pengusul) {
                    $item->pengusul()->create([
                        'pengusul_id' => $pengusul
                    ]);
                }
            }

            if (!empty($data_lampiran)) {
                $item->lampiranpbj()->delete();
                foreach ($data_lampiran as $lampiran) {
                    $item->lampiranpbj()->create([
                        'file' => $lampiran->store('lampiran-pbj', 'public')
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('pengadministrasi-umum.pengajuan-pbj.index')->with('success', 'Pengajuan PBJ berhasil diupdate.');
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function destroy($uuid)
    {

        DB::beginTransaction();
        try {
            $item = PengajuanBarangJasa::pbj()->where('id', $uuid)->first();
            $item->delete();
            DB::commit();
            return redirect()->route('pengadministrasi-umum.pengajuan-pbj.index')->with('success', 'Pengajuan PBJ berhasil dihapus.');
        } catch (\Throwable $th) {
            DB::rollBack();
            // throw $th;
            return redirect()->back()->with('error', 'Surat Tidak bisa dihapus, dikarenakan berada di transaksi lain.');
        }
    }
}
