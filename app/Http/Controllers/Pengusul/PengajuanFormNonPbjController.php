<?php

namespace App\Http\Controllers\Pengusul;

use App\Http\Controllers\Controller;
use App\Models\PengajuanBarangJasa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengajuanFormNonPbjController extends Controller
{
    public function index()
    {
        $items = PengajuanBarangJasa::formNonPbj()->latest()->get();
        return view('pengusul.pages.pengajuan-form-non-pbj.index', [
            'title' => 'Pengajuan Form Non PBJ',
            'items' => $items
        ]);
    }

    public function show($uuid)
    {
        $item = PengajuanBarangJasa::formNonPbj()->where('uuid', $uuid)->firstOrFail();
        return view('pengusul.pages.pengajuan-form-non-pbj.show', [
            'title' => 'Detail Pengajuan Form Non PBJ',
            'item' => $item
        ]);
    }

    public function verifikasi($pengajuan_uuid)
    {
        DB::beginTransaction();
        try {
            $item = PengajuanBarangJasa::formNonPbj()->where('uuid', $pengajuan_uuid)->firstOrFail();
            $item->update([
                'verifikasi_pengusul' => 1
            ]);
            DB::commit();
            return redirect()->back()->with('success', 'Permohonan PBJ berhasil verifikasi.');
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
