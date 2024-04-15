<?php

namespace App\Http\Controllers\Bendaharakeuangan;

use App\Http\Controllers\Controller;
use App\Models\PengajuanBarangJasa;
use Illuminate\Http\Request;

class PengajuanFormNonPbjController extends Controller
{
    public function index()
    {
        $items = PengajuanBarangJasa::formNonPbj()->accPpk()->latest()->get();
        return view('bendahara-keuangan.pages.pengajuan-form-non-pbj.index', [
            'title' => 'Pengajuan Form Non PBJ',
            'items' => $items
        ]);
    }

    public function show($uuid)
    {
        $item = PengajuanBarangJasa::formNonPbj()->where('uuid', $uuid)->firstOrFail();
        return view('bendahara-keuangan.pages.pengajuan-form-non-pbj.show', [
            'title' => 'Detail Pengajuan Form Non PBJ',
            'item' => $item
        ]);
    }
}
