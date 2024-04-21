<?php

namespace App\Http\Controllers\Ppk;

use App\Http\Controllers\Controller;
use App\Models\PengajuanBarangJasa;
use Illuminate\Http\Request;

class PengajuanPbjController extends Controller
{
    public function index()
    {
        $items = PengajuanBarangJasa::pbj()->accWadir2()->latest()->get();
        return view('ppk.pages.pengajuan-pbj.index', [
            'title' => 'Pengajuan PBJ',
            'items' => $items
        ]);
    }

    public function show($uuid)
    {
        $item = PengajuanBarangJasa::pbj()->where('uuid', $uuid)->firstOrFail();
        return view('ppk.pages.pengajuan-pbj.show', [
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
            'acc_ppk' => request('status'),
            'keterangan_ppk' => request('keterangan_ppk'),
        ]);
        return redirect()->back()->with('success', 'Pengajuan Barang Jasa Berhasil ditanggapi.');
    }
}
