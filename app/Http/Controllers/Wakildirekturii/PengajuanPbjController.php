<?php

namespace App\Http\Controllers\Wakildirekturii;

use App\Http\Controllers\Controller;
use App\Models\PengajuanBarangJasa;
use Illuminate\Http\Request;

class PengajuanPbjController extends Controller
{
    public function index()
    {
        $items = PengajuanBarangJasa::pbj()->verifikasiWadirKabag()->latest()->get();
        return view('wakil-direktur-ii.pages.pengajuan-pbj.index', [
            'title' => 'Pengajuan PBJ',
            'items' => $items
        ]);
    }

    public function show($uuid)
    {
        $item = PengajuanBarangJasa::pbj()->where('uuid', $uuid)->firstOrFail();
        return view('wakil-direktur-ii.pages.pengajuan-pbj.show', [
            'title' => 'Detail Pengajuan PBJ',
            'item' => $item
        ]);
    }

    public function acc($uuid)
    {
        request()->validate([
            'status' => ['required']
        ]);
        $item = PengajuanBarangJasa::pbj()->where('uuid', $uuid)->firstOrFail();

        $item->update([
            'acc_wadir2' => request('status'),
            'keterangan_wadir2' => request('keterangan_wadir2'),
        ]);
        return redirect()->back()->with('success', 'Pengajuan Barang Jasa Berhasil ditanggapi.');
    }
}
