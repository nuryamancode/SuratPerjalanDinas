<?php

namespace App\Http\Controllers\Timppk;

use App\Http\Controllers\Controller;
use App\Models\PengajuanBarangJasa;
use App\Models\PengajuanBarangJasaDisposisi;
use App\Models\PengajuanBarangJasaPelaksana;
use App\Models\TahapanPbj;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengajuanPbjController extends Controller
{
    public function index()
    {
        $items = PengajuanBarangJasaDisposisi::where('teruskan_ke_2', auth()->user()->karyawan->id)
        ->orWhereHas('pengajuan_barang_jasa', function ($query) {
            $query->whereHas('pengusul', function ($q) {
                $q->where('pengusul_id', auth()->user()->karyawan->id);
            });
        })
        ->latest()->get();
        return view('timppk.pages.pengajuan-pbj.index', [
            'title' => 'Pengajuan PBJ',
            'items' => $items
        ]);
    }

    public function show($id)
    {
        $data_tahapan = TahapanPbj::all();
        $item = PengajuanBarangJasaDisposisi::where('id', $id)->firstOrFail();
        return view('timppk.pages.pengajuan-pbj.show', [
            'title' => 'Detail Pengajuan PBJ',
            'item' => $item,
            'data_tahapan' => $data_tahapan,
        ]);
    }

    public function update_proses($id)
    {
        DB::beginTransaction();
        try {
            $item = PengajuanBarangJasaDisposisi::where('id', $id)->firstOrFail();
            $item->pbj()->update([
                'status_surat' => request('tahapan')
            ]);
            DB::commit();
            return redirect()->route('timppk.pengajuan-pbj.index')->with('success', 'Status berhasil diubah.');
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
