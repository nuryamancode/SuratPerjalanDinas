<?php

namespace App\Http\Controllers\Bendaharakeuangan;

use App\Http\Controllers\Controller;
use App\Models\SuratPerjalananDinas;
use App\Models\SuratPerjalananDinasDetail;
use App\Models\SuratPertanggungJawaban;
use Illuminate\Http\Request;

class ArsipController extends Controller
{
    public function spd_spj()
    {
        $spd_uuid = request('spd_uuid');
        $items = SuratPerjalananDinasDetail::whereHas('surat_perjalanan_dinas', function ($q) use ($spd_uuid) {
            $q->where('uuid', $spd_uuid);
        })->latest()->get();
        $data_permohonan = SuratPerjalananDinas::verifikasiPpk()->latest()->get();
        return view('bendahara-keuangan.pages.arsip.spd-spj', [
            'title' => 'Surat Perjalanan Dinas',
            'items' => $items,
            'data_permohonan' => $data_permohonan
        ]);
    }

    public function spd_spj_detail($uuid)
    {
        $item = SuratPertanggungJawaban::where('uuid', $uuid)->firstOrFail();
        return view('bendahara-keuangan.pages.arsip.spd-spj-detail', [
            'title' => 'Detail SPJ Perjalanan Dinas',
            'item' => $item
        ]);
    }
}
