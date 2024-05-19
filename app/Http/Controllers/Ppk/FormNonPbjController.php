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
    public function show($id)
    {
        $item = FormNonPbj::where('id', $id)->firstOrFail();
        return view('ppk.pages.form-non-pbj.show', [
            'title' => 'Pengajuan Form Non PBJ',
            'item' => $item
        ]);
    }

    public function acc($uuid)
    {
        request()->validate([
            'status' => ['required']
        ]);
        $item = FormNonPbj::where('uuid', $uuid)->firstOrFail();

        $item->update([
            'acc_ppk' => request('status'),
            'keterangan_ppk' => request('keterangan_ppk'),
            'status' => 'Menunggu Bendahara Memberikan Uang Muka'
        ]);
        return redirect()->back()->with('success', 'Verifikasi Surat Perjalanan Dinas Berhasil disubmit.');
    }
}
