<?php

namespace App\Http\Controllers\Wakildirekturi;

use App\Http\Controllers\Controller;
use App\Models\SuratNonPbj;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class SuratNonPbjController extends Controller
{
    public function index()
    {
        $items = SuratNonPbj::whereHas('disposisi_snpbj', function ($q) {
            $q->where('teruskan_ke_1', auth()->user()->karyawan->id);
        })->where('verifikasi_wadir2' , 1)->latest()->get();
        // dd($items);
        return view('wakil-direktur-i.pages.surat-non-pbj.index', [
            'title' => 'Pengajuan Surat Non PBJ',
            'items' => $items
        ]);
    }

    public function show($id)
    {
        $item = SuratNonPbj::where('id', $id)->firstOrFail();
        return view('wakil-direktur-i.pages.surat-non-pbj.show', [
            'title' => 'Detail Pengajuan Surat Non PBJ',
            'item' => $item
        ]);
    }
    public function verifikasi($id)
    {
        $item = SuratNonPbj::where('id', $id)->firstorFail();
        if ($item->nilai_taksiran == null) {
            return redirect()->back()->with('error','Anda belum mengisi nilai taksiran');
        }
        $item->update([
            'verifikasi_wadir1' => 1,
            'status_surat'=> auth()->user()->karyawan->jabatan->nama . ' Sudah Melakukan Taksiran',
        ]);
        return redirect()->route('wakil-direktur-i.surat-non-pbj.index')->with('success', 'Surat Non PBJ berhasil diverifikasi.');
    }

    public function taksiran($id){
        request()->validate([
            'nilai_taksiran'=>'required',
        ]);
        DB::beginTransaction();
        try {
            $data = request()->input('nilai_taksiran');
            $item = SuratNonPbj::where('id',$id)->firstOrFail();
            $item->update([
                'nilai_taksiran'=> $data,
            ]);
            DB::commit();
            return redirect()->route('wakil-direktur-i.surat-non-pbj.index')->with('success','Nilai Taksiran berhasil ditambahkan.');
        }
        catch (Throwable $th) {
            throw $th;
        }
    }
}
