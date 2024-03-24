<?php

namespace App\Http\Controllers;

use App\Models\Surat;
use App\Models\SuratPerjalananDinas;
use Illuminate\Http\Request;

class PermohonanSuratPerjalananDinasController extends Controller
{
    public function index()
    {
        $items = SuratPerjalananDinas::notActive()->latest()->get();
        return view('pages.permohonan-surat-perjalanan-dinas.index', [
            'title' => 'Surat Perjalanan Dinas',
            'items' => $items
        ]);
    }

    public function create()
    {
        $data_surat = Surat::latest()->get();
        return view('pages.permohonan-surat-perjalanan-dinas.create', [
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
        SuratPerjalananDinas::notActive()->create($data);
        return redirect()->route('permohonan-surat-perjalanan-dinas.index')->with('success', 'Surat Perjalanan Dinas berhasil diajukan.');
    }

    public function show($id)
    {
        $item = SuratPerjalananDinas::notActive()->findOrFail($id);
        return view('pages.permohonan-surat-perjalanan-dinas.show', [
            'title' => 'Detail Surat Perjalanan Dinas',
            'item' => $item
        ]);
    }
}
