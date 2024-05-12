<?php

namespace App\Http\Controllers\Wakildirekturi;

use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use App\Models\PengajuanBarangJasa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengajuanPbjController extends Controller
{
    public function index()
    {
        $karyawan = Karyawan::where('user_id', auth()->user()->id)->first();
        $items = PengajuanBarangJasa::pbj()->whereHas('pengusul', function ($q) use ($karyawan){
            $q->where('pengusul_id', $karyawan->id);
        })
        ->latest()->get();
        return view('wakil-direktur-i.pages.pengajuan-pbj.index', [
            'title' => 'Pengajuan PBJ',
            'items' => $items
        ]);
    }

    public function show($uuid)
    {
        $item = PengajuanBarangJasa::pbj()->where('uuid', $uuid)->firstOrFail();
        return view('wakil-direktur-i.pages.pengajuan-pbj.show', [
            'title' => 'Detail Pengajuan PBJ',
            'item' => $item
        ]);
    }

    public function verifikasi($pengajuan_uuid)
    {
        DB::beginTransaction();
        try {
            $item = PengajuanBarangJasa::pbj()->where('uuid', $pengajuan_uuid)->firstOrFail();
            $item->update([
                'verifikasi_wadir1' => 1
            ]);
            DB::commit();
            return redirect()->back()->with('success', 'Permohonan PBJ berhasil verifikasi.');
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
