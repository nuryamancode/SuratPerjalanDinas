<?php

namespace App\Http\Controllers;

use App\Models\Surat;
use App\Models\SuratPerjalananDinas;
use Illuminate\Http\Request;

class SuratPerjalananDinasController extends Controller
{
    public function index()
    {
        $items = SuratPerjalananDinas::latest()->get();
        return view('pages.surat-perjalanan-dinas.index', [
            'title' => 'Surat Perjalanan Dinas',
            'items' => $items
        ]);
    }

    public function create()
    {
        $data_surat = Surat::latest()->get();
        return view('pages.surat-perjalanan-dinas.create', [
            'title' => 'Tambah Surat Perjalanan Dinas',
            'data_surat' => $data_surat
        ]);
    }

    public function store()
    {
        request()->validate([
            'surat_id' => ['required']
        ]);

        $data = request()->only(['surat_id']);
        SuratPerjalananDinas::create($data);
        return redirect()->route('surat-perjalanan-dinas.index')->with('success', 'Surat Perjalanan Dinas berhasil diajukan.');
    }

    public function disposisi_single($id)
    {
        $item = Surat::findOrFail($id);
        return view('pages.surat-perjalanan-dinas.disposisi-single', [
            'title' => 'Disposisi Single Surat Perjalanan Dinas',
            'item' => $item
        ]);
    }
}
