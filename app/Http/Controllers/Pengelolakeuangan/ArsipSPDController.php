<?php

namespace App\Http\Controllers\Pengelolakeuangan;

use App\Http\Controllers\Controller;
use App\Models\SPJPelaksana;
use App\Models\SPJSupir;
use App\Models\SuratPerjalananDinas;
use Illuminate\Http\Request;

class ArsipSPDController extends Controller
{
    public function spd_spj()
    {
        $items = SuratPerjalananDinas::where('is_arsip', 1)->latest()->get();
        return view('pengelola-keuangan.pages.arsip-spd.spd-spj', [
            'title' => 'Surat Perjalanan Dinas',
            'items' => $items,
        ]);
    }

    public function show($uuid)
    {
        $item = SuratPerjalananDinas::where('id', $uuid)->firstOrFail();
        return view('pengelola-keuangan.pages.arsip-spd.show', [
            'title' => 'Detail SPJ Perjalanan Dinas',
            'item' => $item
        ]);
    }
    public function spd_spj_detail($uuid)
    {
        $item = SPJPelaksana::where('id', $uuid)->firstOrFail();
        return view('pengelola-keuangan.pages.arsip-spd.spd-spj-detail', [
            'title' => 'Detail SPJ Perjalanan Dinas',
            'item' => $item
        ]);
    }
    public function spd_spj_detail_supir($uuid)
    {
        $item = SPJSupir::where('id', $uuid)->firstOrFail();
        return view('pengelola-keuangan.pages.arsip-spd.spd_spj_detail-supir', [
            'title' => 'Detail SPJ Perjalanan Dinas',
            'item' => $item
        ]);
    }
}
