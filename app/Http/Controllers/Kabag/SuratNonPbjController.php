<?php

namespace App\Http\Controllers\Kabag;

use App\Http\Controllers\Controller;
use App\Models\PengajuanBarangJasa;
use App\Models\SuratNonPbj;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class SuratNonPbjController extends Controller
{
    public function index()
    {
        $items = PengajuanBarangJasa::suratNonPbj()->whereHas('disposisi_pbj', function ($q) {
            $q->where('teruskan_ke_1', auth()->user()->karyawan->id);
        })->where('verifikasi_wadir2', 1)->latest()->get();
        return view('kabag.pages.surat-non-pbj.index', [
            'title' => 'Pengajuan Surat Non PBJ',
            'items' => $items
        ]);
    }

    public function show($id)
    {
        $item = PengajuanBarangJasa::suratNonPbj()->where('id', $id)->firstOrFail();
        return view('kabag.pages.surat-non-pbj.show', [
            'title' => 'Detail Pengajuan Surat Non PBJ',
            'item' => $item
        ]);
    }

    public function verifikasi($id)
    {
        $item = PengajuanBarangJasa::suratNonPbj()->where('id', $id)->firstorFail();
        $item->update([
            'verifikasi_kabag' => 1,
            'status_surat'=> auth()->user()->karyawan->jabatan->nama . ' Sudah Melakukan Taksiran',
        ]);
        return redirect()->route('kabag.surat-non-pbj.index')->with('success', 'Surat Non PBJ berhasil diverifikasi.');
    }

    public function taksiran($id){
        request()->validate([
            'nilai_taksiran'=>'required',
        ]);
        DB::beginTransaction();
        try {
            $data = request()->input('nilai_taksiran');
            $item = PengajuanBarangJasa::suratNonPbj()->where('id',$id)->firstOrFail();
            $item->update([
                'nilai_taksiran'=> $data,
            ]);
            DB::commit();
            return redirect()->route('kabag.surat-non-pbj.index')->with('success','Nilai Taksiran berhasil ditambahkan.');
        }
        catch (Throwable $th) {
            throw $th;
        }
    }
}
