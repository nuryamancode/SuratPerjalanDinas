<?php

namespace App\Http\Controllers\Bendaharakeuangan;

use App\Http\Controllers\Controller;
use App\Models\FormNonPbjUangMuka;
use App\Models\SuratNonPbjUangMuka;
use Illuminate\Http\Request;

class DistribusiBelanjaController extends Controller
{
    public function index()
    {
        $items = SuratNonPbjUangMuka::where('acc_bendahara', 1)->latest()->get();
        $item = FormNonPbjUangMuka::latest()->get();
        return view('bendahara-keuangan.pages.distribusi-belanja.index', [
            'title' => 'Distribusi Belanja',
            'items' => $items,
            'item' => $item,
        ]);
    }
}
