<?php

namespace App\Http\Controllers\Ppk;

use App\Http\Controllers\Controller;
use App\Models\SuratPerjalananDinas;
use Illuminate\Http\Request;

class PermohonanSpdController extends Controller
{
    public function index()
    {
        $items = SuratPerjalananDinas::verifikasiWadir2()->latest()->get();
        return view('ppk.pages.permohonan-spd.index', [
            'title' => 'Surat Perjalanan Dinas',
            'items' => $items
        ]);
    }

    public function show($uuid)
    {
        $item = SuratPerjalananDinas::where('id', $uuid)->firstOrFail();
        return view('ppk.pages.permohonan-spd.show', [
            'title' => 'Detail Surat Perjalanan Dinas',
            'item' => $item
        ]);
    }

    public function tolak($uuid)
    {
        $item = SuratPerjalananDinas::notActive()->where('id', $uuid)->firstOrFail();
        $item->update([
            'acc_ppk' => 2,
            'status' => 'Pengajuan Ditolak',
            'keterangan_acc_ppk' => request('keterangan')
        ]);
        return redirect()->back()->with('success', 'Surat Perjalanan Dinas Berhasil ditolak.');
    }
    public function verifikasi_ppk($uuid)
    {
        $item = SuratPerjalananDinas::where('id', $uuid)->firstOrFail();
        if (!auth()->user()->karyawan->tte_file) {
            return redirect()->back()->with('error', 'Silahkan upload terlebih dahulu TTE nya.');
        }
        $item->update([
            'verifikasi_ppk' => 1,
            'acc_ppk' => 1,
        ]);
        return redirect()->back()->with('success', 'Verifikasi ');
    }
    public function print($spd_uuid)
    {
        $spd = SuratPerjalananDinas::where('id', $spd_uuid)->firstOrFail();
        // dd($spd->disposisi);
        return view('wakil-direktur-ii.pages.permohonan-spd-disposisi.print', [
            'title' => 'Cetak Disposisi',
            'spd' => $spd
        ]);
    }
}
