<?php

namespace App\Http\Controllers\Pengadministrasiumum;

use App\Http\Controllers\Controller;
use App\Models\FormNonPbj;
use App\Models\Karyawan;
use App\Models\PengajuanBarangJasa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengajuanFormNonPbjController extends Controller
{
    public function index()
    {
        $items = FormNonPbj::where('pengusul_karyawan_id', auth()->user()->karyawan->id)->latest()->get();
        return view('pengadministrasi-umum.pages.pengajuan-form-non-pbj.index', [
            'title' => 'Pengajuan Non PBJ Formulir',
            'items' => $items
        ]);
    }

    public function create()
    {
        return view('pengadministrasi-umum.pages.pengajuan-form-non-pbj.create', [
            'title' => 'Tambah Pengajuan Non PBJ Formulir',
        ]);
    }

    public function store()
    {
        request()->validate([
            'form_file' => ['required', 'file', 'mimes:pdf'],
        ]);

        DB::beginTransaction();
        try {
            if (request()->file('form_file')) {
                $formulir = request()->file('form_file')->store('formulir_non_pbj', 'public');
            }
            FormNonPbj::create([
                'file' => $formulir,
                'pengusul_karyawan_id' => auth()->user()->karyawan->id,
                'status' => 'Pemeriksaan PPK'
            ]);

            DB::commit();
            return redirect()->route('pengadministrasi-umum.pengajuan-form-non-pbj.index')->with('success', 'Pengajuan Form Non PBJ berhasil ditambahkan.');
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function show($id)
    {
        $item = FormNonPbj::where('id', $id)->firstOrFail();
        return view('pengadministrasi-umum.pages.pengajuan-form-non-pbj.show', [
            'title' => 'Detail Pengajuan Form Non PBJ',
            'item' => $item
        ]);
    }

    public function edit($id)
    {
        $item = FormNonPbj::where('id', $id)->firstOrFail();
        return view('pengadministrasi-umum.pages.pengajuan-form-non-pbj.edit', [
            'title' => 'Edit Pengajuan Form Non PBJ',
            'item' => $item,
        ]);
    }

    public function update($id)
    {
        request()->validate([
            'form_file' => ['required', 'file', 'mimes:pdf'],
        ]);

        DB::beginTransaction();
        try {
            if (request()->file('form_file')) {
                $formulir = request()->file('form_file')->store('formulir_non_pbj', 'public');
            }
            $form = FormNonPbj::where('id', $id)->firstOrFail();
            $form->update([
                'file' => $formulir,
                'pengusul_karyawan_id' => auth()->user()->karyawan->id,
                'status' => 'Pemeriksaan PPK',
                'acc_ppk' => 0,
                'keterangan_ppk' => null,
            ]);

            DB::commit();
            return redirect()->route('pengadministrasi-umum.pengajuan-form-non-pbj.index')->with('success', 'Pengajuan Form Non PBJ berhasil diupdate.');
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    // public function destroy($uuid)
    // {

    //     DB::beginTransaction();
    //     try {
    //         $item = PengajuanBarangJasa::formNonPbj()->where('uuid', $uuid)->first();
    //         $item->delete();
    //         DB::commit();
    //         return redirect()->route('pengadministrasi-umum.pengajuan-form-non-pbj.index')->with('success', 'Pengajuan Form Non PBJ berhasil dihapus.');
    //     } catch (\Throwable $th) {
    //         DB::rollBack();
    //         // throw $th;
    //         return redirect()->back()->with('error', 'Surat Tidak bisa dihapus, dikarenakan berada di transaksi lain.');
    //     }
    // }
}
