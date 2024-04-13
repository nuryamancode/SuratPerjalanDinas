<?php

namespace App\Http\Controllers\Wakildirekturii;

use App\Http\Controllers\Controller;
use App\Models\SuratPerjalananDinas;
use Illuminate\Http\Request;

class PermohonanSpdController extends Controller
{
    public function index()
    {
        $items = SuratPerjalananDinas::notActive()->latest()->get();
        return view('wakil-direktur-ii.pages.permohonan-spd.index', [
            'title' => 'Surat Perjalanan Dinas',
            'items' => $items
        ]);
    }

    public function show($id)
    {
        $item = SuratPerjalananDinas::notActive()->findOrFail($id);
        return view('wakil-direktur-ii.pages.permohonan-spd.show', [
            'title' => 'Detail Surat Perjalanan Dinas',
            'item' => $item
        ]);
    }

    public function verifikasi($id)
    {
        $item = SuratPerjalananDinas::notActive()->findOrFail($id);

        // cek ttd dulu
        if (!auth()->user()->karyawan->tte_file) {
            return redirect()->back()->with('error', 'Silahkan upload terlebih dahulu TTE nya.');
        }
        $item->update([
            'verifikasi_wadir2' => 1
        ]);

        return redirect()->back()->with('success', 'Permohonan Surat Perjalanan Dinas Berhasil diverifikasi.');
    }
}
