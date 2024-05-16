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
        $items = SuratNonPbj::latest()->get();
        return view('wakil-direktur-ii.pages.surat-non-pbj.index', [
            'title' => 'Pengajuan Surat Non PBJ',
            'items' => $items
        ]);
    }

    public function show($id)
    {
        $item = SuratNonPbj::where('id', $id)->firstOrFail();
        return view('wakil-direktur-ii.pages.surat-non-pbj.show', [
            'title' => 'Detail Pengajuan Surat Non PBJ',
            'item' => $item
        ]);
    }

    public function tolak($id)
    {
        $item = SuratNonPbj::where('id', $id)->firstOrFail();
        $item->update([
            'acc_wadir2' => '2',
            'keterangan_wadir2' => request('keterangan'),
            'status_surat' => 'Persetujuan Ditolak',
        ]);
        return redirect()->back()->with('success', 'Pengajuan Barang Jasa Tidak Berhasil ditanggapi.');
    }

    public function verifikasi($id){
        $item = SuratNonPbj::where('id', $id)->firstOrFail();
        if (!auth()->user()->karyawan->tte_file) {
            return redirect()->route('wakil-direktur-ii.tte.index')->with('error','Silahkan upload terlebih dahulu TTE nya.');
        }
        if ($item->acc_wadir2 != '1') {
            return redirect()->back()->with('error','Anda belum menyetujui atau Disposisi kosong.');

        }
        $item->update([
            'verifikasi_wadir2'=> true,
        ]);
        return redirect()->back()->with('success', 'Pengajuan PBJ Berhasil diverifikasi.');
    }

    public function print_disposisi($id)
    {
        $item = SuratNonPbj::where('id', $id)->firstOrFail();
        return view('wakil-direktur-ii.pages.surat-non-pbj.print', [
            'title' => 'Cetak Disposisi',
            'item' => $item
        ]);
    }
}
