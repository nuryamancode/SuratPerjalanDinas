<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\SuratNonPbj;
use Illuminate\Http\Request;

class SuratNonPbjController extends Controller
{
    public function index(){
        $item = SuratNonPbj::whereHas('pengusul', function ($q) {
            $q->where('pengusul_id', auth()->user()->karyawan->id);
        })->latest()->get();
        return view('karyawan.pages.surat-non-pbj.index', [
            'title' => 'Surat Non PBJ',
            'items' => $item,
        ]);
    }

    public function show($id){
        $item = SuratNonPbj::find($id);
        return view('karyawan.pages.surat-non-pbj.show', [
            'title' => 'Detail Surat Non PBJ',
            'item' => $item,
        ]);
    }
}
