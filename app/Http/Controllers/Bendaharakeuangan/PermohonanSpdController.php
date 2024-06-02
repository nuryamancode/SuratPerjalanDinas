<?php

namespace App\Http\Controllers\Bendaharakeuangan;

use App\Http\Controllers\Controller;
use App\Models\SuratPerjalananDinas;
use App\Models\User;
use Illuminate\Http\Request;

class PermohonanSpdController extends Controller
{
    public function index()
    {
        $items = SuratPerjalananDinas::with(['spd_pelaksana_dinas','spd_supir'])->verifikasiWadir2Ppk()->latest()->get();
        // dd($items);
        return view('bendahara-keuangan.pages.permohonan-spd.index', [
            'title' => 'Surat Perjalanan Dinas',
            'items' => $items
        ]);
    }

    public function show($uuid)
    {
        $item = SuratPerjalananDinas::notActive()->where('id', $uuid)->firstOrFail();
        return view('bendahara-keuangan.pages.permohonan-spd.show', [
            'title' => 'Detail Surat Perjalanan Dinas',
            'item' => $item
        ]);
    }

    public function print($spd_uuid)
    {
        $spd = SuratPerjalananDinas::where('id', $spd_uuid)->firstOrFail();
        // dd($spd->disposisi);
        $ppk = User::role('Pejabat Pembuat Komitmen')->first();
        return view('bendahara-keuangan.pages.permohonan-spd.print', [
            'title' => 'Cetak Disposisi',
            'spd' => $spd,
            'ppk' => $ppk
        ]);
    }
    public function printppk($spd_uuid)
    {
        $spd = SuratPerjalananDinas::where('id', $spd_uuid)->firstOrFail();
        return view('ppk.pages.permohonan-spd-disposisi.print', [
            'title' => 'Cetak Disposisi',
            'spd' => $spd,
        ]);
    }
}
