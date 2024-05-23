<?php

namespace App\Http\Controllers\Bendaharakeuangan;

use App\Http\Controllers\Controller;
use App\Models\FormNonPbjUangMuka;
use App\Models\SuratNonPbjUangMuka;
use Illuminate\Http\Request;

class DistribusiBelanjaController extends Controller
{
    public function form_non_pbj()
    {
        $item = FormNonPbjUangMuka::latest()->get();
        return view('bendahara-keuangan.pages.distribusi-belanja.form-non-pbj.index', [
            'title' => 'Distribusi Belanja',
            'item' => $item,
        ]);
    }
    public function surat_non_pbj()
    {
        $items = SuratNonPbjUangMuka::where('acc_bendahara', 1)->latest()->get();
        return view('bendahara-keuangan.pages.distribusi-belanja.surat-non-pbj.index', [
            'title' => 'Distribusi Belanja',
            'items' => $items,
        ]);
    }
}
