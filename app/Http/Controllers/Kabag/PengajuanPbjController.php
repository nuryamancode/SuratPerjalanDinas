<?php

namespace App\Http\Controllers\Kabag;

use App\Http\Controllers\Controller;
use App\Models\PengajuanBarangJasa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengajuanPbjController extends Controller
{
    public function index()
    {
        $items = PengajuanBarangJasa::pbj()->latest()->get();
        return view('kabag.pages.pengajuan-pbj.index', [
            'title' => 'Pengajuan PBJ',
            'items' => $items
        ]);
    }

    public function show($uuid)
    {
        $item = PengajuanBarangJasa::pbj()->where('uuid', $uuid)->firstOrFail();
        return view('kabag.pages.pengajuan-pbj.show', [
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
                'verifikasi_kabag' => 1,
                'status' => 'Pemeriksaan Wakil Direktur II'
            ]);
            DB::commit();
            return redirect()->back()->with('success', 'Permohonan PBJ berhasil verifikasi.');
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
