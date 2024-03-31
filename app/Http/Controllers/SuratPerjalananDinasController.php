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
        $data = SuratPerjalananDinasDetail::whereNotNull('id');
        $data_spd = SuratPerjalananDinas::latest();
        if (request('surat_perjalanan_dinas_id')) {
            if (auth()->user()->getPermissions('Surat Perjalanan Dinas Detail By Karyawan')) {
                $data->getByKaryawan();
            }
            $items = $data->where('surat_perjalanan_dinas_id', request('surat_perjalanan_dinas_id'))->latest()->get();
        } else {
            $items = [];
        }
        if (auth()->user()->getPermissions('Surat Perjalanan Dinas By Karyawan')) {
            $data_spd->getByKaryawan();
        }
        $data_surat_perjalanan_dinas = $data_spd->get();

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
        // cek tte
        if (!auth()->user()->karyawan->tte_file) {
            return redirect()->route('tte.index')->with('error', 'Silahkan upload terlebih dahulu TTE nya.');
        }
        $item->update([
            'validasi_pemberangkatan' => 1,
            'validasi_karyawan_id' => auth()->user()->karyawan->id
        ]);

        return redirect()->back()->with('success', 'Surat Perjalanan Dinas Berhasil diverifikasi.');
    }

    public function getById()
    {
        $id = request('spd_id');
        $item = SuratPerjalananDinas::with('surat')->findOrFail(($id));
        return response()->json($item);
    }
}
