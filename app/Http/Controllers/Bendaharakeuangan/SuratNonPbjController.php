<?php

namespace App\Http\Controllers\Bendaharakeuangan;

use App\Http\Controllers\Controller;
use App\Models\SuratNonPbj;
use Illuminate\Http\Request;

class SuratNonPbjController extends Controller
{
    public function index()
    {
        $items = SuratNonPbj::where('acc_ppk', 1)->latest()->get();
        return view('bendahara-keuangan.pages.surat-non-pbj.index', [
            'title' => 'Pengajuan Surat Non PBJ',
            'items' => $items
        ]);
    }

    public function show($uuid)
    {
        $item = SuratNonPbj::where('acc_ppk', 1)->where('uuid', $uuid)->firstOrFail();
        return view('bendahara-keuangan.pages.surat-non-pbj.show', [
            'title' => 'Detail Pengajuan Surat Non PBJ',
            'item' => $item
        ]);
    }
}
