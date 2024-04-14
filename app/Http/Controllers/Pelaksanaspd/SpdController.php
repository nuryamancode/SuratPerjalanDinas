<?php

namespace App\Http\Controllers\Pelaksanaspd;

use App\Http\Controllers\Controller;
use App\Models\SuratPerjalananDinasDetail;
use Illuminate\Http\Request;

class SpdController extends Controller
{
    public function index()
    {
        $items = SuratPerjalananDinasDetail::where('karyawan_id', auth()->user()->karyawan->id)->latest()->get();
        return view('pelaksana-spd.pages.spd.index', [
            'title' => 'Surat Perjalanan Dinas',
            'items' => $items
        ]);
    }
}
