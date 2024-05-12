<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\PengajuanBarangJasa;
use App\Models\PengajuanBarangJasaPelaksana;
use Illuminate\Http\Request;

class PengajuanPbjController extends Controller
{
    public function index()
    {
        $items = PengajuanBarangJasa::pbj()->whereHas('pengusul', function ($q) {
            $q->where('pengusul_id', auth()->user()->karyawan->id);
        })->latest()->get();
        return view('karyawan.pages.pengajuan-pbj.index', [
            'title' => 'Riwayat PBJ',
            'items' => $items
        ]);
    }

    public function show($id)
    {
        $item = PengajuanBarangJasa::pbj()->where('id', $id)->firstOrFail();
        return view('karyawan.pages.pengajuan-pbj.show', [
            'title' => 'Detail Pengajuan PBJ',
            'item' => $item
        ]);
    }
}
