<?php

namespace App\Http\Controllers\Pengadministrasiumum;

use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use App\Models\PengajuanBarangJasa;
use App\Models\SuratNonPbj;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PengajuanSuratNonPbjController extends Controller
{
    public function index()
    {
        $items = SuratNonPbj::whereNotNull('nomor_surat')->orWhereHas('pengusul', function($q){
            $q->where('pengusul_id', auth()->user()->karyawan->id);
        })->latest()->get();
        return view('pengadministrasi-umum.pages.pengajuan-surat-non-pbj.index', [
            'title' => 'Pengajuan Non PBJ Surat',
            'items' => $items
        ]);
    }

    public function create()
    {
        $data_karyawan = Karyawan::whereHas('user', function ($q) {
            $q->whereHas('roles', function ($role) {
                $role->whereNotIn('name', ['Supir']);
            });
        })->orderBy('nama', 'ASC')->get();
        return view('pengadministrasi-umum.pages.pengajuan-surat-non-pbj.create', [
            'title' => 'Tambah Pengajuan Non PBJ Surat',
            'data_karyawan' => $data_karyawan
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
            'dokumen_surat' => ['required', 'file'],
        ]);

        DB::beginTransaction();
        try {
            $data = request()->only(['nomor_surat', 'perihal', 'nomor_agenda',]);
            $data_pengusul = request('pengusul');
            $data_lampiran = request()->file('lampiran');
            if (request()->file('dokumen_surat')) {
                $data['dokumen_surat'] = request()->file('dokumen_surat')->store('snpbj/dokumen_surat', 'public');
            }
            $data['status_surat'] = 'Menunggu Persetujuan Wakil Direktur II';
            $data['jenis'] = 'non pbj surat';
            $data['asal_surat'] = auth()->user()->karyawan->id;
            $item  = SuratNonPbj::create($data);

            if (!empty($data_pengusul)) {
                foreach ($data_pengusul as $pengusul) {
                    $item->pengusul()->create([
                        'pengusul_id' => $pengusul
                    ]);
                }
            }
            if (!empty($data_lampiran)) {
                foreach ($data_lampiran as $lampiran) {
                    $item->lampiransnpbj()->create([
                        'file' => $lampiran->store('lampiran-snpbj', 'public')
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('pengadministrasi-umum.pengajuan-surat-non-pbj.index')->with('success', 'Pengajuan Form Non PBJ berhasil ditambahkan.');
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function show($id)
    {
        $item = SuratNonPbj::where('id', $id)->firstOrFail();
        return view('pengadministrasi-umum.pages.pengajuan-surat-non-pbj.show', [
            'title' => 'Detail Pengajuan Form Non PBJ',
            'item' => $item
        ]);
    }

    public function edit($id)
    {
        $item = SuratNonPbj::where('id', $id)->firstOrFail();
        return view('pengadministrasi-umum.pages.pengajuan-surat-non-pbj.edit', [
            'title' => 'Edit Pengajuan Form Non PBJ',
            'item' => $item,
            'data_karyawan' =>  Karyawan::whereHas('user', function ($q) {
                $q->whereHas('roles', function ($role) {
                    $role->whereNotIn('name', ['Supir']);
                });
            })->orderBy('nama', 'ASC')->get(),
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
            $item = SuratNonPbj::where('id', $uuid)->firstOrFail();
            $data_lampiran = request()->file('lampiran');
            $data_dokumen = request()->file('dokumen_surat');
            if (!empty($data_dokumen)) {
                if ($item->dokumen_surat) {
                    Storage::delete('public/snpbj/dokumen_surat/' . $item->dokumen_surat);
                }
                if (request()->hasFile('dokumen_surat') && request()->file('dokumen_surat')->isValid()) {
                    $data['dokumen_surat'] = request()->file('dokumen_surat')->store('snpbj/dokumen_surat', 'public');
                }
            }
            $data_pengusul = request('pengusul');
            $data['acc_wadir2'] = '0';
            $data['status_surat'] = 'Menunggu Persetujuan Wakil Direktur II';
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
                $item->lampiransnpbj()->delete();
                foreach ($data_lampiran as $lampiran) {
                    $item->lampiransnpbj()->create([
                        'file' => $lampiran->store('lampiran-snpbj', 'public')
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('pengadministrasi-umum.pengajuan-surat-non-pbj.index')->with('success', 'Pengajuan PBJ berhasil diupdate.');
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function destroy($id)
    {

        DB::beginTransaction();
        try {
            $item = SuratNonPbj::where('id', $id)->first();
            $item->delete();
            DB::commit();
            return redirect()->route('pengadministrasi-umum.pengajuan-surat-non-pbj.index')->with('success', 'Pengajuan Form Non PBJ berhasil dihapus.');
        } catch (\Throwable $th) {
            DB::rollBack();
            // throw $th;
            return redirect()->back()->with('error', 'Surat Tidak bisa dihapus, dikarenakan berada di transaksi lain.');
        }
    }
}
