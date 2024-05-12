<?php

namespace App\Http\Controllers\Ppk;

use App\Http\Controllers\Controller;
use App\Models\SuratPerjalananDinas;
use Illuminate\Http\Request;

class PermohonanSpdController extends Controller
{
    public function index()
    {
        $items = SuratPerjalananDinas::verifikasiWadir2()->latest()->get();
        return view('ppk.pages.permohonan-spd.index', [
            'title' => 'Surat Perjalanan Dinas',
            'items' => $items
        ]);
    }

    public function show($uuid)
    {
        $item = SuratPerjalananDinas::where('id', $uuid)->firstOrFail();
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
        dd(request()->all());
        $item = SuratPerjalananDinas::notActive()->where('id', $uuid)->firstOrFail();
        $item->update([
            'acc_ppk' => request('status'),
            'keterangan_ppk' => request('keterangan_ppk')
        ]);
        return redirect()->back()->with('success', 'Verifikasi Surat Pe');
    }

    public function verifikasi_ppk($uuid)
    {
        $item = SuratPerjalananDinas::where('id', $uuid)->firstOrFail();
        dd($item);
        $item->update([
            'verifikasi_ppk' => 1,
            'status' => 'Menunggu Didistribusikan Uang Muka'
        ]);
        return redirect()->back()->with('success', 'Verifikasi ');
    }
}
