<?php

namespace App\Http\Controllers\Pengelolakeuangan;

use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use App\Models\PengajuanBarangJasa;
use Illuminate\Http\Request;

class PbjController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $karyawan = Karyawan::where('user_id', $user->id)->first();
        $items = PengajuanBarangJasa::pbj()->whereHas('pengusul' , function ($query) use ($karyawan) {
            $query->where('pengusul_id', $karyawan->id);
        } )->latest()->get();
        return view('pengelola-keuangan.pages.pbj.index', [
            'title' => 'Pengajuan PBJ',
            'items' => $items
        ]);
    }

    public function show($id)
    {
        $item = PengajuanBarangJasa::pbj()->where('id', $id)->firstOrFail();
        return view('pengelola-keuangan.pages.pbj.show', [
            'title' => 'Detail Pengajuan PBJ',
            'item' => $item
        ]);
    }
}
