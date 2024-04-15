<?php

namespace App\Http\Controllers\Pelaksanabelanja;

use App\Http\Controllers\Controller;
use App\Models\PengajuanBarangJasa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengajuanFormNonPbjController extends Controller
{
    public function index()
    {
        $items = PengajuanBarangJasa::formNonPbj()->verifikasiUangMuka()->whereHas('pelaksana', function ($q) {
            $q->where('karyawan_id', auth()->user()->karyawan->id);
        })->latest()->get();
        return view('pelaksana-belanja.pages.pengajuan-form-non-pbj.index', [
            'title' => 'Pengajuan Form Non PBJ',
            'items' => $items
        ]);
    }

    public function show($uuid)
    {
        $item = PengajuanBarangJasa::formNonPbj()->where('uuid', $uuid)->firstOrFail();
        return view('pelaksana-belanja.pages.pengajuan-form-non-pbj.show', [
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
