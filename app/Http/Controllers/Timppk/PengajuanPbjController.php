<?php

namespace App\Http\Controllers\Timppk;

use App\Http\Controllers\Controller;
use App\Models\PengajuanBarangJasa;
use App\Models\PengajuanBarangJasaPelaksana;
use Illuminate\Http\Request;

class PengajuanPbjController extends Controller
{
    public function index()
    {
        $items = PengajuanBarangJasaPelaksana::where('karyawan_id', auth()->user()->karyawan->id)->latest()->get();
        dd($items);
        return view('timppk.pages.pengajuan-pbj.index', [
            'title' => 'Pengajuan PBJ',
            'items' => $items
        ]);
    }

    public function show($uuid)
    {
        $item = PengajuanBarangJasa::pbj()->where('uuid', $uuid)->firstOrFail();
        return view('timppk.pages.pengajuan-pbj.show', [
            'title' => 'Detail Pengajuan PBJ',
            'item' => $item
        ]);
    }
}
