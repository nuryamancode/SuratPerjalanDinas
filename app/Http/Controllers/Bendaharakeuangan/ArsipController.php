<?php

namespace App\Http\Controllers\Bendaharakeuangan;

use App\Http\Controllers\Controller;
use App\Models\SPJPelaksana;
use App\Models\SPJSupir;
use App\Models\SuratNonPbj;
use App\Models\SuratPerjalananDinas;
use App\Models\SuratPerjalananDinasDetail;
use App\Models\SuratPertanggungJawaban;
use Illuminate\Http\Request;

class ArsipController extends Controller
{
    public function spd_spj()
    {
        $items = SuratPerjalananDinas::where('is_arsip', 1)->latest()->get();
        return view('bendahara-keuangan.pages.arsip.spd-spj', [
            'title' => 'Surat Perjalanan Dinas',
            'items' => $items,
        ]);
    }

    public function show($uuid)
    {
        $item = SuratPerjalananDinas::where('id', $uuid)->firstOrFail();
        return view('bendahara-keuangan.pages.arsip.show', [
            'title' => 'Detail SPJ Perjalanan Dinas',
            'item' => $item
        ]);
    }
    public function spd_spj_detail($uuid)
    {
        $item = SPJPelaksana::where('id', $uuid)->firstOrFail();
        return view('bendahara-keuangan.pages.arsip.spd-spj-detail', [
            'title' => 'Detail SPJ Perjalanan Dinas',
            'item' => $item
        ]);
    }
    public function spd_spj_detail_supir($uuid)
    {
        $item = SPJSupir::where('id', $uuid)->firstOrFail();
        return view('bendahara-keuangan.pages.arsip.spd_spj_detail-supir', [
            'title' => 'Detail SPJ Perjalanan Dinas',
            'item' => $item
        ]);
    }

    public function spd_arsip($uuid)
    {
        $spd = SuratPerjalananDinas::where('uuid', $uuid)->firstOrFail();
        $spd->update([
            'is_arsip' => 1
        ]);

        return redirect()->back()->with('success', 'SPD Berhasil diarsipkan.');
    }
}
