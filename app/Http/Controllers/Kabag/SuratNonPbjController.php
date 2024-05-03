<?php

namespace App\Http\Controllers\Kabag;

use App\Http\Controllers\Controller;
use App\Models\SuratNonPbj;
use Illuminate\Http\Request;

class SuratNonPbjController extends Controller
{
    public function index()
    {
        $items = SuratNonPbj::where('karyawan_id', auth()->user()->karyawan->id)->latest()->get();
        return view('kabag.pages.surat-non-pbj.index', [
            'title' => 'Pengajuan Surat Non PBJ',
            'items' => $items
        ]);
    }

    public function show($uuid)
    {
        $item = SuratNonPbj::where('karyawan_id', auth()->user()->karyawan->id)->where('uuid', $uuid)->firstOrFail();
        return view('kabag.pages.surat-non-pbj.show', [
            'title' => 'Detail Pengajuan Surat Non PBJ',
            'item' => $item
        ]);
    }

    public function verifikasi($uuid)
    {
        $item = SuratNonPbj::where('uuid', $uuid)->firstorFail();
        $item->update([
            'verifikasi_kabag' => 1,
            'status' => 'Pemeriksaan Wakil Direktur II'
        ]);

        return redirect()->route('kabag.surat-non-pbj.index')->with('success', 'Surat Non PBJ berhasil disetujui.');
    }
}
