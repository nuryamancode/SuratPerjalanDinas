<?php

namespace App\Http\Controllers\Kabag;

use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use App\Models\PengajuanBarangJasa;
use App\Models\PengajuanBarangJasaPengusul;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class PengajuanPbjController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $karyawan = Karyawan::where('user_id', $user->id)->first();
        $items = PengajuanBarangJasa::pbj()->whereHas('pengusul' , function ($query) use ($karyawan) {
            $query->where('pengusul_id', $karyawan->id);
        } )->latest()->get();
        return view('kabag.pages.pengajuan-pbj.index', [
            'title' => 'Pengajuan PBJ',
            'items' => $items
        ]);
    }

    public function show($id)
    {
        $item = PengajuanBarangJasa::pbj()->where('id', $id)->firstOrFail();
        return view('kabag.pages.pengajuan-pbj.show', [
            'title' => 'Detail Pengajuan PBJ',
            'item' => $item
        ]);
    }


    public function verifikasi($id)
    {
        DB::beginTransaction();
        try {
            $item = PengajuanBarangJasa::pbj()->where('id', $id)->firstOrFail();
            $item->update([
                'acc_kabag' => true,
                'status' => 'Menunggu Persetujuan Wakil Direktur II'
            ]);
            DB::commit();
            return redirect()->back()->with('success', 'Permohonan PBJ berhasil verifikasi.');
        } catch (Throwable $th) {
            throw $th;
        }
    }
}
