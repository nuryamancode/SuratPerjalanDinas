<?php

namespace App\Http\Controllers\Ppk;

use App\Http\Controllers\Controller;
use App\Models\SuratPerjalananDinasDetail;
use App\Models\SuratPertanggungJawaban;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SpdSpjController extends Controller
{
    public function index()
    {
        $items = SuratPertanggungJawaban::latest()->get();
        return view('ppk.pages.spd-spj.index', [
            'title' => 'Data SPJ Perjalanan Dinas',
            'items' => $items
        ]);
    }


    public function show($uuid)
    {
        $item = SuratPertanggungJawaban::where('uuid', $uuid)->firstOrFail();
        return view('ppk.pages.spd-spj.show', [
            'title' => 'Detail SPJ Perjalanan Dinas',
            'item' => $item
        ]);
    }
    public function verifikasi($uuid)
    {
        request()->validate([
            'status' => ['required']
        ]);

        // cek tte
        if (request()->status == 1 && auth()->user()->karyawan->tte_file == NULL) {
            return redirect()->route('ppk.tte.index')->with('error', 'Silahka upload terlebih dahulu TTE nya.');
        }

        // dd(request()->all());
        $item = SuratPertanggungJawaban::where('uuid', $uuid)->firstOrFail();
        $item->update([
            'status' => request('status'),
            'keterangan_ppk' => request('keterangan_ppk')
        ]);
        $item->update([
            'acc_ppk' => request('status'),
            'keterangan_acc_ppk' => request('keterangan_ppk')
        ]);
        return redirect()->back()->with('success', 'Verifikasi Surat Pertanggung Jawaban Berhasil disubmit.');
    }
}
