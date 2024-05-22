<?php

namespace App\Http\Controllers\Bendaharakeuangan;

use App\Http\Controllers\Controller;
use App\Models\FormNonPbjDisposisi;
use Illuminate\Http\Request;

class PermohonanBelanjaController extends Controller
{
    public function index()
    {
        $items = FormNonPbjDisposisi::where('diteruskan_ke', auth()->user()->karyawan->id)->latest()->get();
        return view('bendahara-keuangan.pages.permohonan-belanja.index',[
            'title' => 'Permohonan Belanja Form Non PBJ',
            'items' => $items
        ]);
    }
    public function show($id){
        $item = FormNonPbjDisposisi::find($id);
        return view('bendahara-keuangan.pages.permohonan-belanja.show',[
            'title' => 'Detail Permohonan Belanja Form Non PBJ',
            'item' => $item
        ]);
    }
}
