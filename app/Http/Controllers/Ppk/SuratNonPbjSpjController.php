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

    public function acc($uuid)
    {
        request()->validate([
            'status' => ['required']
        ]);
        $item = SuratNonPbjSpj::where('uuid', $uuid)->firstOrFail();

        $item->update([
            'acc_ppk' => request('status'),
            'keterangan_ppk' => request('keterangan_ppk'),
        ]);
        if (request('status') == 1) {
            $item->suratNonPbj()->update([
                'status' => 'Selesai'
            ]);
        }
        return redirect()->back()->with('success', 'SPJ Berhasil ditanggapi.');
    }

    public function print($uuid)
    {
        $item = SuratNonPbjSpj::where('uuid', $uuid)->firstOrFail();
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
