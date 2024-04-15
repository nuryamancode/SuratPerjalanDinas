<?php

namespace App\Http\Controllers\Ppk;

use App\Http\Controllers\Controller;
use App\Models\PengajuanBarangJasa;
use App\Models\SpjBarangJasa;
use Illuminate\Http\Request;

class PengajuanFormNonPbjSpjController extends Controller
{
    public function index()
    {
        $items = SpjBarangJasa::latest()->get();
        return view('ppk.pages.pengajuan-form-non-pbj-spj.index', [
            'title' => 'Pengajuan Form Non PBJ',
            'items' => $items
        ]);
    }

    public function show($uuid)
    {
        $item = SpjBarangJasa::where('uuid', $uuid)->firstOrFail();
        return view('ppk.pages.pengajuan-form-non-pbj-spj.show', [
            'title' => 'Detail Pengajuan Form Non PBJ',
            'item' => $item
        ]);
    }

    public function acc($uuid)
    {
        request()->validate([
            'status' => ['required']
        ]);
        $item = SpjBarangJasa::where('uuid', $uuid)->firstOrFail();
        $item->update([
            'acc_ppk' => request('status'),
            'keterangan_ppk' => request('keterangan_ppk')
        ]);
        return redirect()->back()->with('success', 'Surat Perjalanan Dinas Berhasil ditanggapi.');
    }
}
