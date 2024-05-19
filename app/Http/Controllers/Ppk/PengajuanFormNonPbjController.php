<?php

namespace App\Http\Controllers\Ppk;

use App\Http\Controllers\Controller;
use App\Models\FormNonPbj;
use App\Models\PengajuanBarangJasa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengajuanFormNonPbjController extends Controller
{
    public function index()
    {
        $items = FormNonPbj::latest()->get();
        return view('ppk.pages.pengajuan-form-non-pbj.index', [
            'title' => 'Pengajuan Form Non PBJ',
            'items' => $items
        ]);
    }

    public function show($id)
    {
        $item = FormNonPbj::where('id', $id)->firstOrFail();
        return view('ppk.pages.pengajuan-form-non-pbj.show', [
            'title' => 'Detail Pengajuan Form Non PBJ',
            'item' => $item
        ]);
    }

    public function acc($uuid)
    {
        request()->validate([
            'status' => ['required']
        ]);
        $item = PengajuanBarangJasa::formNonPbj()->where('uuid', $uuid)->firstOrFail();

        $item->update([
            'acc_ppk' => request('status'),
            'keterangan_ppk' => request('keterangan_ppk')
        ]);
        return redirect()->back()->with('success', 'Verifikasi Surat Perjalanan Dinas Berhasil disubmit.');
    }
}
