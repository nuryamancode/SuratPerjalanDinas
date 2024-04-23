<?php

namespace App\Http\Controllers\Ppk;

use App\Http\Controllers\Controller;
use App\Models\FormNonPbj;
use Illuminate\Http\Request;

class FormNonPbjController extends Controller
{
    public function index()
    {
        $items = FormNonPbj::latest()->get();
        return view('ppk.pages.form-non-pbj.index', [
            'title' => 'Pengajuan Form Non PBJ',
            'items' => $items
        ]);
    }


    public function acc($uuid)
    {
        request()->validate([
            'status' => ['required']
        ]);
        $item = FormNonPbj::formNonPbj()->where('uuid', $uuid)->firstOrFail();

        $item->update([
            'acc_ppk' => request('status'),
            'keterangan_ppk' => request('keterangan_ppk')
        ]);
        return redirect()->back()->with('success', 'Verifikasi Surat Perjalanan Dinas Berhasil disubmit.');
    }
}
