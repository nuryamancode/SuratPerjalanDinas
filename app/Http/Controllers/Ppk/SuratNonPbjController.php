<?php

namespace App\Http\Controllers\Ppk;

use App\Http\Controllers\Controller;
use App\Models\PengajuanBarangJasa;
use App\Models\SuratNonPbj;
use App\Models\SuratNonPbjDisposisi;
use Illuminate\Http\Request;

class SuratNonPbjController extends Controller
{
    public function index()
    {
        $items = SuratNonPbjDisposisi::whereHas('surat_non_pbj', function ($q) {
            $q->whereNotNull('nilai_taksiran')->where('verifikasi_wadir2', 1);
        })->orWhere('teruskan_ke_1', auth()->user()->karyawan->id)->latest()->get();
        return view('ppk.pages.surat-non-pbj.index', [
            'title' => 'Pengajuan Surat Non PBJ',
            'items' => $items
        ]);
    }

    public function show($id)
    {
        $item = SuratNonPbjDisposisi::where('id', $id)->firstOrFail();
        return view('ppk.pages.surat-non-pbj.show', [
            'title' => 'Detail Pengajuan Surat Non PBJ',
            'item' => $item
        ]);
    }

    public function verifikasi($id)
    {
        $item = SuratNonPbjDisposisi::where('id', $id)->firstOrFail();
        if (!auth()->user()->karyawan->tte_file) {
            return redirect()->route('ppk.tte.index')->with('error', 'Silahkan upload terlebih dahulu TTE nya.');
        }
        if ($item->surat_non_pbj->acc_ppk != '1') {
            return redirect()->back()->with('error', 'Anda belum menyetujui atau Disposisi kosong.');
        }
        $item->surat_non_pbj()->update([
            'verifikasi_ppk' => true,
        ]);
        return redirect()->back()->with('success', 'Pengajuan Surat Non PBJ Berhasil diverifikasi.');
    }

    public function print_disposisi($id)
    {
        $item = SuratNonPbjDisposisi::where('id', $id)->firstOrFail();
        return view('ppk.pages.surat-non-pbj.print', [
            'title' => 'Cetak Disposisi',
            'item' => $item
        ]);
    }
}
