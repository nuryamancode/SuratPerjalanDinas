<?php

namespace App\Http\Controllers\Wakildirekturii;

use App\Http\Controllers\Controller;
use App\Models\PengajuanBarangJasa;
use App\Models\SuratNonPbj;
use Illuminate\Http\Request;

class SuratNonPbjController extends Controller
{
    public function index()
    {
        $items = PengajuanBarangJasa::suratNonPbj()->latest()->get();
        return view('wakil-direktur-ii.pages.surat-non-pbj.index', [
            'title' => 'Pengajuan Surat Non PBJ',
            'items' => $items
        ]);
    }

    public function show($id)
    {
        $item = PengajuanBarangJasa::suratNonPbj()->where('id', $id)->firstOrFail();
        return view('wakil-direktur-ii.pages.surat-non-pbj.show', [
            'title' => 'Detail Pengajuan Surat Non PBJ',
            'item' => $item
        ]);
    }

    public function acc($uuid)
    {
        $item = SuratNonPbj::where('uuid', $uuid)->firstOrFail();
        request()->validate([
            'status' => ['required']
        ]);

        // cek tte
        if (!auth()->user()->karyawan->tte_file) {
            return redirect()->route('tte.index')->with('error', 'Silahkan upload TTE terlebih dahulu.');
        }

        $item->update([
            'acc_wadir2' => request('status'),
            'keterangan_wadir2' => request('keterangan_wadir2'),
        ]);
        return redirect()->back()->with('success', 'Pengajuan Surat Non PBJ Berhasil ditanggapi.');
    }
}
