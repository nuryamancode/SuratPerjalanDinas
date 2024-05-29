<?php

namespace App\Http\Controllers\Wakildirekturii;

use App\Http\Controllers\Controller;
use App\Models\LampiranPBJ;
use App\Models\PengajuanBarangJasa;
use App\Models\SuratNonPbj;
use Illuminate\Http\Request;

class PengajuanBelanja extends Controller
{
    public function index(){
        $items = SuratNonPbj::latest()->get();
        $item = PengajuanBarangJasa::latest()->get();
        $data = [
            'items'=> $items,
            'item'=> $item
        ];
        return view('wakil-direktur-ii.pages.pengajuan-belanja.index', $data);
    }

    public function show_pbj($id)
    {
        $item = PengajuanBarangJasa::where('id', $id)->firstOrFail();
        return view('wakil-direktur-ii.pages.pengajuan-belanja.show-pbj', [
            'title' => 'Detail Pengajuan PBJ',
            'item' => $item
        ]);
    }

    public function show_suratnonpbj($id)
    {
        $item = SuratNonPbj::where('id', $id)->firstOrFail();
        return view('wakil-direktur-ii.pages.pengajuan-belanja.show-suratnonpbj', [
            'title' => 'Detail Pengajuan Surat Non PBJ',
            'item' => $item
        ]);
    }
}
