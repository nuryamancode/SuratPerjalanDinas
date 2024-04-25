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

    public function acc($uuid)
    {
        request()->validate([
            'status' => ['required']
        ]);
        $item = FormNonPbjSpj::where('uuid', $uuid)->firstOrFail();

        $item->update([
            'acc_ppk' => request('status'),
            'keterangan_ppk' => request('keterangan_ppk'),
        ]);
        $item->formNonPbj()->update([
            'status' => 'Selesai'
        ]);
        return redirect()->back()->with('success', 'SPJ Berhasil ditanggapi.');
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
