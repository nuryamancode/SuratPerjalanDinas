<?php

namespace App\Http\Controllers\Bendaharakeuangan;

use App\Http\Controllers\Controller;
use App\Models\SuratNonPbj;
use App\Models\SuratNonPbjSpj;
use Illuminate\Http\Request;

class SuratNonPbjController extends Controller
{
    public function index()
    {
        $items = SuratNonPbj::whereHas('disposisi_snpbj', function ($q){
            $q->where('teruskan_ke_2',auth()->user()->karyawan->id);
        })->where('verifikasi_ppk', 1)->latest()->get();
        return view('bendahara-keuangan.pages.surat-non-pbj.index', [
            'title' => 'Pengajuan Surat Non PBJ',
            'items' => $items
        ]);
    }

    public function show($id)
    {
        $item = SuratNonPbj::where('id', $id)->firstOrFail();
        return view('bendahara-keuangan.pages.surat-non-pbj.show', [
            'title' => 'Detail Pengajuan Surat Non PBJ',
            'item' => $item
        ]);
    }

    public function submit_arsip($uuid)
    {
        $item = SuratNonPbj::where('acc_ppk', 1)->where('uuid', $uuid)->firstOrFail();

        $item->update([
            'is_arsip' => 1
        ]);

        return redirect()->back()->with('success', 'Surat Non PBJ berhasil diarsipkan.');
    }


    public function arsip_index()
    {
        $items = SuratNonPbj::where('is_arsip', 1)->latest()->get();
        return view('bendahara-keuangan.pages.surat-non-pbj.arsip', [
            'title' => 'Pengajuan Surat Non PBJ',
            'items' => $items
        ]);
    }

    public function arsip_spj($uuid)
    {
        $item = SuratNonPbjSpj::where('acc_ppk', 1)->where('uuid', $uuid)->firstOrFail();
        return view('bendahara-keuangan.pages.surat-non-pbj.arsip-spj', [
            'title' => 'Detail Pengajuan Surat Non PBJ',
            'item' => $item
        ]);
    }
}
