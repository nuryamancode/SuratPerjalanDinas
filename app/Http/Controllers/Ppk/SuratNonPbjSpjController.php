<?php

namespace App\Http\Controllers\Ppk;

use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use App\Models\SuratNonPbjSpj;
use Illuminate\Http\Request;

class SuratNonPbjSpjController extends Controller
{
    public function index()
    {
        $items = SuratNonPbjSpj::latest()->get();
        // dd($items);
        return view('ppk.pages.surat-non-pbj-spj.index', [
            'title' => 'Surat Non PBJ SPJ',
            'items' => $items
        ]);
    }
    public function show($id)
    {
        $item = SuratNonPbjSpj::where('id', $id)->firstOrFail();
        // dd($item);
        return view('ppk.pages.surat-non-pbj-spj.show', [
            'title' => 'Detail Surat Non PBJ SPJ',
            'item' => $item
        ]);
    }

    public function acc($id)
    {
        $item = SuratNonPbjSpj::where('id', $id)->firstOrFail();

        $item->update([
            'acc_ppk' => 1,
            'status_spj' => 'Disetujui Oleh Pejabat Pembuat Komitmen',
        ]);
        $item->suratNonPbj()->update([
            'status_surat' => 'Selesai',
            'is_arsip' => 1
        ]);
        return redirect()->route('ppk.surat-non-pbj-spj.index')->with('success', 'SPJ Berhasil ditanggapi.');
    }
    public function tolak($id)
    {
        $item = SuratNonPbjSpj::where('id', $id)->firstOrFail();

        $item->update([
            'acc_ppk' => 2,
            'keterangan_ppk' => request('keterangan'),
            'status_spj' => 'Ditolak Oleh Pejabat Pembuat Komitmen',
        ]);
        $item->suratNonPbj()->update([
            'status_surat' => 'Belum Selesai'
        ]);
        $item->details()->delete();
        return redirect()->route('ppk.surat-non-pbj-spj.index')->with('success', 'SPJ Tidak Berhasil ditanggapi.');
    }

    public function print($id)
    {
        $item = SuratNonPbjSpj::where('id', $id)->firstOrFail();
        $bendahara = Karyawan::whereHas('user', function ($user) {
            $user->role('Bendahara Keuangan');
        })->firstOrFail();
        $ppk = Karyawan::whereHas('user', function ($user) {
            $user->role('Pejabat Pembuat Komitmen');
        })->firstOrFail();
        return view('ppk.pages.surat-non-pbj-spj.print', [
            'title' => 'Cetak Kwitansi',
            'item' => $item,
            'bendahara' => $bendahara,
            'ppk' => $ppk,
        ]);
    }


}
