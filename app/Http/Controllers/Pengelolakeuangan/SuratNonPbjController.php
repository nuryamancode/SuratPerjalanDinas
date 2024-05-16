<?php

namespace App\Http\Controllers\Pengelolakeuangan;

use App\Http\Controllers\Controller;
use App\Models\SuratNonPbj;
use Illuminate\Http\Request;

class SuratNonPbjController extends Controller
{
    public function index(){
        $items = SuratNonPbj::whereHas("disposisi_snpbj", function ($q){
            $q->where("teruskan_ke_2",auth()->user()->karyawan->id);
        })->where('verifikasi_ppk', 1)->latest()->get();
        return view('pengelola-keuangan.pages.surat-non-pbj.index', [
            'title' => 'Pengajuan Surat Non PBJ',
            'items'=> $items
        ]);
    }

    public function show($id){
        $item = SuratNonPbj::findOrFail($id);
        return view('pengelola-keuangan.pages.surat-non-pbj.show', [
            'title'=> 'Detail Pengajuan Surat Non PBJ',
            'item'=> $item,
        ]);
    }
}
