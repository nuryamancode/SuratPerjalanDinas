<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Surat;
use App\Models\SuratPerjalananDinas;
use App\Models\SuratPerjalananDinasDetail;
use Illuminate\Http\Request;

class SuratPerjalananDinasController extends Controller
{
    public function index()
    {
        if (request('surat_perjalanan_dinas_id')) {
            $items = SuratPerjalananDinasDetail::where('surat_perjalanan_dinas_id', request('surat_perjalanan_dinas_id'))->latest()->get();
        } else {
            $items = [];
        }
        $data_surat_perjalanan_dinas = SuratPerjalananDinas::latest()->get();
        return view('pages.surat-perjalanan-dinas.index', [
            'title' => 'Surat Perjalanan Dinas',
            'items' => $items,
            'data_surat_perjalanan_dinas' => $data_surat_perjalanan_dinas
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
        $data['status'] = 0;
        SuratPerjalananDinas::create($data);
        return redirect()->route('surat-perjalanan-dinas.index')->with('success', 'Surat Perjalanan Dinas berhasil diajukan.');
    }

    public function show($id)
    {
        $item = SuratPerjalananDinas::findOrFail($id);
        return view('pages.surat-perjalanan-dinas.show', [
            'title' => 'Detail Surat Perjalanan Dinas',
            'item' => $item
        ]);
    }

    public function generate()
    {
        $item = SuratPerjalananDinas::where('id', request('surat_perjalanan_dinas_id'))->firstOrFail();
        if ($item && $item->details) {
            $data_pelaksana = $item->surat->pelaksana;
            // create spd
            if ($data_pelaksana) {
                foreach ($data_pelaksana as $pelaksana) {
                    SuratPerjalananDinasDetail::create([
                        'surat_perjalanan_dinas_id' => $item->id,
                        'karyawan_id' => $pelaksana->karyawan->id
                    ]);
                }
            }

            // update spd
            $item->update([
                'status' => 1
            ]);
        }

        return redirect()->back()->with('success', 'Surat perjalanan dinas berhasil dibuat.');
    }

    public function validasi_pemberangkatan($id)
    {
        $item = SuratPerjalananDinas::findOrFail($id);
        $item->update([
            'validasi_pemberangkatan' => 1,
            'validasi_karyawan_id' => auth()->user()->karyawan->id
        ]);

        return redirect()->back()->with('success', 'Surat Perjalanan Dinas Berhasil divalidasi.');
    }
}
