<?php

namespace App\Http\Controllers\Ppk;

use App\Http\Controllers\Controller;
use App\Models\FormNonPbj;
use App\Models\FormNonPbjSpj;
use App\Models\Karyawan;
use Illuminate\Http\Request;

class FormNonPbjSpjController extends Controller
{
    public function index()
    {
        $items = FormNonPbjSpj::latest()->get();
        return view('ppk.pages.form-non-pbj-spj.index', [
            'title' => 'Pengajuan Form Non PBJ',
            'items' => $items
        ]);
    }
    public function show($id)
    {
        $item = FormNonPbjSpj::where('id', $id)->firstOrFail();
        return view('ppk.pages.form-non-pbj-spj.show', [
            'title' => 'Pengajuan Form Non PBJ',
            'item' => $item
        ]);
    }

    public function acc($id)
    {
        $item = FormNonPbjSpj::where('id', $id)->firstOrFail();

        $item->update([
            'acc_ppk' => 1,
        ]);
        $item->formNonPbj()->update([
            'status' => 'Selesai',
            'is_arsip' => 1,
        ]);
        return redirect()->route('ppk.surat-non-pbj-spj.index')->with('success', 'SPJ Berhasil ditanggapi.');
    }

    public function print($uuid)
    {
        $item = FormNonPbjSpj::where('uuid', $uuid)->firstOrFail();
        $bendahara = Karyawan::whereHas('user', function ($user) {
            $user->role('Bendahara Keuangan');
        })->firstOrFail();
        $ppk = Karyawan::whereHas('user', function ($user) {
            $user->role('Pejabat Pembuat Komitmen');
        })->firstOrFail();
        return view('ppk.pages.form-non-pbj-spj.print', [
            'title' => 'Cetak Kwitansi',
            'item' => $item,
            'bendahara' => $bendahara,
            'ppk' => $ppk,
        ]);
    }
}
