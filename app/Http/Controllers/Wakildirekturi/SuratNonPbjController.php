<?php

namespace App\Http\Controllers\Wakildirekturi;

use App\Http\Controllers\Controller;
use App\Models\SuratNonPbj;
use Illuminate\Http\Request;

class SuratNonPbjController extends Controller
{
    public function index()
    {
        $items = SuratNonPbj::where('karyawan_id', auth()->user()->karyawan->id)->latest()->get();
        // dd($items);
        return view('wakil-direktur-i.pages.surat-non-pbj.index', [
            'title' => 'Pengajuan Surat Non PBJ',
            'items' => $items
        ]);
    }

    public function show($uuid)
    {
        $item = SuratNonPbj::where('karyawan_id', auth()->user()->karyawan->id)->where('uuid', $uuid)->firstOrFail();
        return view('wakil-direktur-i.pages.surat-non-pbj.show', [
            'title' => 'Detail Pengajuan Surat Non PBJ',
            'item' => $item
        ]);
    }

    public function verifikasi($uuid)
    {
        $item = SuratNonPbj::where('uuid', $uuid)->firstorFail();
        $item->update([
            'verifikasi_wadir1' => 1,
            'status' => 'Pemeriksaan Wakil Direktur II'
        ]);

        return redirect()->route('wakil-direktur-i.surat-non-pbj.index')->with('success', 'Surat Non PBJ berhasil disetujui.');
    }
}
