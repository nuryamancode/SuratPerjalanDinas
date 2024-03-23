<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
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
        $item = SuratPerjalananDinas::findOrFail($id);
        $data_karyawan = Karyawan::orderBy('nama', 'ASC')->get();
        return view('pages.surat-perjalanan-dinas.disposisi-single', [
            'title' => 'Disposisi Single Surat Perjalanan Dinas',
            'item' => $item,
            'data_karyawan' => $data_karyawan
        ]);
    }
    public function disposisi_single_submit($id)
    {
        request()->validate([
            'disposisi_karyawan_id' => ['required'],
            'tipe' => ['required']
        ]);
        $item = SuratPerjalananDinas::findOrFail($id);
        $item->update([
            'disposisi_karyawan_id' => request('disposisi_karyawan_id'),
            'tipe' => request('tipe'),
            'status' => 'Menunggu Pengecekan TIM PPK'
        ]);

        return redirect()->route('surat-perjalanan-dinas.index')->with('success', 'Disposisi Surat Perjalan Dinas Berhasi Diupdate');
    }

    public function show($id)
    {
        $item = SuratPerjalananDinas::findOrFail($id);
        return view('pages.surat-perjalanan-dinas.show', [
            'title' => 'Detail Surat Perjalanan Dinas',
            'item' => $item
        ]);
    }

    public function acc_tim_ppk()
    {
        $item = SuratPerjalananDinas::findOrFail(request('id'));
        $item->update([
            'acc_tim_ppk' => request('status')
        ]);

        return redirect()->back()->with('success', 'Persetujuan berhasil diupdate.');
    }
}
