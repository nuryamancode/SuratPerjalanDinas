<?php

namespace App\Http\Controllers\Pengelolakeuangan;

use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use App\Models\SPDPelaksana;
use App\Models\SPDSupir;
use App\Models\SuratPerjalananDinas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BuatSPDController extends Controller
{
    public function create($id)
    {
        $spd = SuratPerjalananDinas::where('id', $id)->firstOrFail();
        return view('pengelola-keuangan.pages.spd.create', [
            'title' => 'Buat SPD',
            'spd' => $spd,
            'selectedKaryawan' => $spd->surat->pelaksana->pluck('karyawan.id')->toArray(),
            'data_karyawan' => Karyawan::orderBy('nama', 'ASC')->get(),
        ]);
    }
    public function create_supir($id)
    {
        $spd = SuratPerjalananDinas::where('id', $id)->firstOrFail();
        if ($spd->spd_pelaksana_dinas()) {
            null;
        }
        else {
            return redirect()->back()->with('error', 'Silahkan Buat SPD Pelaksana Dinas Dulu.');
        }
        return view('pengelola-keuangan.pages.spd.create-supir', [
            'title' => 'Buat SPD',
            'spd' => $spd,
            'selectedKaryawan' => $spd->surat->pelaksana->pluck('karyawan.id')->toArray(),
            'data_karyawan' => Karyawan::orderBy('nama', 'ASC')->get(),
        ]);
    }

    public function store()
    {
        request()->validate([
            'tingkat_biaya' => ['required'],
            'alat_angkut' => ['required'],
            'pembebanan_anggaran' => ['required'],
            'instansi' => ['required'],
            'mata_anggaran_kegiatan' => ['required'],
            'dikeluarkan_di' => ['required'],
        ]);
        DB::beginTransaction();
        try {
            $permohonan = SuratPerjalananDinas::where('id', request('id_spd'))->firstOrFail();
            $permohonan->spd_pelaksana_dinas()->create([
                'tingkat_biaya' => request('tingkat_biaya'),
                'maksud_perjalanan_dinas' => request('maksud_perjalanan_dinas'),
                'alat_angkut' => request('alat_angkut'),
                'tempat_berangkat' => request('tempat_berangkat'),
                'tempat_tujuan' => request('tempat_tujuan'),
                'lama_perjalanan' => request('lama_hari'),
                'tanggal_berangkat' => request('tanggal_mulai'),
                'pembebanan_anggaran' => request('pembebanan_anggaran'),
                'instansi' => request('instansi'),
                'mata_anggaran_kegiatan' => request('mata_anggaran_kegiatan'),
                'dikeluarkan_di' => request('dikeluarkan_di'),
                'keterangan_lain_lain' => request('keterangan_lainnya'),
            ]);
            $permohonan->update([
                'status'=> 'Menunggu Persetujuan PPK',
            ]);
            DB::commit();

            return redirect()->route('pengelola-keuangan.permohonan-spd.index')->with('success', 'Surat Perjalanan Dinas Berhasil dibuat.');
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function store_supir()
    {
        request()->validate([
            'tingkat_biaya' => ['required'],
            'alat_angkut' => ['required'],
            'pembebanan_anggaran' => ['required'],
            'instansi' => ['required'],
            'mata_anggaran_kegiatan' => ['required'],
            'dikeluarkan_di' => ['required'],
        ]);
        DB::beginTransaction();
        try {
            $permohonan = SuratPerjalananDinas::where('id', request('id_spd'))->firstOrFail();
            $permohonan->spd_supir()->create([
                'tingkat_biaya' => request('tingkat_biaya'),
                'maksud_perjalanan_dinas' => request('maksud_perjalanan_dinas'),
                'alat_angkut' => request('alat_angkut'),
                'tempat_berangkat' => request('tempat_berangkat'),
                'tempat_tujuan' => request('tempat_tujuan'),
                'lama_perjalanan' => request('lama_hari'),
                'tanggal_berangkat' => request('tanggal_mulai'),
                'pembebanan_anggaran' => request('pembebanan_anggaran'),
                'instansi' => request('instansi'),
                'mata_anggaran_kegiatan' => request('mata_anggaran_kegiatan'),
                'dikeluarkan_di' => request('dikeluarkan_di'),
                'keterangan_lain_lain' => request('keterangan_lainnya'),
            ]);
            $permohonan->update([
                'status'=> 'Menunggu Persetujuan PPK',
            ]);
            DB::commit();

            return redirect()->route('pengelola-keuangan.permohonan-spd.index')->with('success', 'Surat Perjalanan Dinas Berhasil dibuat.');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function show($id)
    {
        $item = SuratPerjalananDinas::where('id', $id)->firstOrFail();
        return view('pengelola-keuangan.pages.spd.show', [
            'title' => 'Lihat Surat Perjalanan Dinas Pelaksana Dinas',
            'item' => $item
        ]);
    }
    public function show_supir($id)
    {
        $item = SuratPerjalananDinas::where('id', $id)->firstOrFail();
        return view('pengelola-keuangan.pages.spd.show-supir', [
            'title' => 'Lihat Surat Perjalanan Dinas Supir',
            'item' => $item
        ]);
    }

    public function print($id)
    {
        $item = SPDPelaksana::where('id', $id)->firstOrFail();
        $items = SPDSupir::where('id', $id)->firstOrFail();
        $ppk = User::role('Pejabat Pembuat Komitmen')->first()->karyawan;
        return view('pengelola-keuangan.pages.spd.print', [
            'title' => 'Cetak SPD Pelaksana Dinas',
            'item' => $item,
            'items' => $items,
            'ppk' => $ppk
        ]);
    }
    public function print_pelaksana($id)
    {
        $item = SPDPelaksana::where('id', $id)->firstOrFail();
        $ppk = User::role('Pejabat Pembuat Komitmen')->first()->karyawan;
        return view('pengelola-keuangan.pages.spd.print-pelaksana', [
            'title' => 'Cetak SPD Supir',
            'item' => $item,
            'ppk' => $ppk
        ]);
    }
}
