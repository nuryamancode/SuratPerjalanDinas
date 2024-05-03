<?php

namespace App\Http\Controllers\Ppk;

use App\Http\Controllers\Controller;
use App\Models\SuratNonPbj;
use Illuminate\Http\Request;

class SuratNonPbjController extends Controller
{
    public function index()
    {
        $items = SuratNonPbj::whereNotNull('acc_ppk')->latest()->get();
        return view('ppk.pages.surat-non-pbj.index', [
            'title' => 'Pengajuan Surat Non PBJ',
            'items' => $items
        ]);
    }

    public function show($uuid)
    {
        $item = SuratNonPbj::where('uuid', $uuid)->firstOrFail();
        return view('ppk.pages.surat-non-pbj.show', [
            'title' => 'Detail Pengajuan Surat Non PBJ',
            'item' => $item
        ]);
    }

    public function acc($uuid)
    {
        $item = SuratNonPbj::where('uuid', $uuid)->firstOrFail();
        request()->validate([
            'status' => ['required']
        ]);

        $item->update([
            'acc_ppk' => request('status'),
            'keterangan_ppk' => request('keterangan_ppk'),
        ]);

        if (request('status') == 1) {
            $item->update([
                'status' => 'Menunggu Bendahara memberikan uang muka pembayaran'
            ]);
        }
        return redirect()->back()->with('success', 'Pengajuan Surat Non PBJ Berhasil ditanggapi.');
    }
}
