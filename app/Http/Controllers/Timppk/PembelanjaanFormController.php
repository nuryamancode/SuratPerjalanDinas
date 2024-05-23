<?php

namespace App\Http\Controllers\Timppk;

use App\Http\Controllers\Controller;
use App\Models\FormNonPbj;
use App\Models\FormNonPbjSpj;
use App\Models\FormNonPbjUangMuka;
use App\Models\Karyawan;
use Illuminate\Http\Request;

class PembelanjaanFormController extends Controller
{
    public function index()
    {
        $items = FormNonPbjUangMuka::where('karyawan_id', auth()->user()->karyawan->id)->latest()->get();
        return view('timppk.pages.pembelanjaan-form-non-pbj.index',[
            'title' => 'Pembelanjaan Form Non PBJ',
            'items' => $items
        ]);
    }
    public function show($id){
        $item = FormNonPbj::find($id);
        return view('timppk.pages.pembelanjaan-form-non-pbj.show',[
            'title' => 'Detail Pembelanjaan Form Non PBJ',
            'item' => $item
        ]);
    }

    public function kirim_ulang($id){
        $item = FormNonPbj::where('id',$id)->firstOrFail();
        $item->spj->update([
            'acc_ppk' => 0,
        ]);
        return redirect()->route('timppk.form-non-pbj-spj.show', $item->id)->with('success', 'Berhasil Dikirim Ulang');
    }

    public function print($id)
    {
        $item = FormNonPbjSpj::where('id', $id)->firstOrFail();
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
