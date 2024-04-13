<?php

namespace App\Http\Controllers\Ppk;

use App\Http\Controllers\Controller;
use App\Models\SuratPerjalananDinas;
use Illuminate\Http\Request;

class PermohonanSpdController extends Controller
{
    public function index()
    {
        $items = SuratPerjalananDinas::notActive()->verifikasiWadir2()->latest()->get();
        return view('ppk.pages.permohonan-spd.index', [
            'title' => 'Surat Perjalanan Dinas',
            'items' => $items
        ]);
    }

    public function show($uuid)
    {
        $item = SuratPerjalananDinas::notActive()->where('uuid', $uuid)->firstOrFail();
        return view('ppk.pages.permohonan-spd.show', [
            'title' => 'Detail Surat Perjalanan Dinas',
            'item' => $item
        ]);
    }

    public function acc_ppk($uuid)
    {
        request()->validate([
            'status' => ['required']
        ]);
        $item = SuratPerjalananDinas::notActive()->where('uuid', $uuid)->firstOrFail();
        $item->update([
            'acc_ppk' => request('status'),
            'keterangan_acc_ppk' => request('keterangan_ppk')
        ]);
        return redirect()->back()->with('success', 'Verifikasi Surat Perjalanan Dinas Berhasil disubmit.');
    }
}
