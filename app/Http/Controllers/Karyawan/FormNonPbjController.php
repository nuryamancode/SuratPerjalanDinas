<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\FormNonPbj;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FormNonPbjController extends Controller
{
    public function index()
    {
        $items = FormNonPbj::where('pengusul_karyawan_id', auth()->user()->karyawan->id)->latest()->get();
        return view('karyawan.pages.form-non-pbj.index', [
            'title' => 'Form Non PBJ',
            'items' => $items
        ]);
    }

    public function create()
    {
        return view('karyawan.pages.form-non-pbj.create', [
            'title' => 'Tambah Pengajuan Form Non PBj',
        ]);
    }

    public function store()
    {
        request()->validate([
            'file' => ['required', 'file']
        ]);

        DB::beginTransaction();
        try {
            FormNonPbj::create([
                'uuid' => \Str::uuid(),
                'file' => request()->file('file')->store('form-non-pbj', 'public'),
                'status' => 'Menunggu Pemeriksaan PPK',
                'pengusul_karyawan_id' => auth()->user()->karyawan->id
            ]);
            DB::commit();
            return redirect()->route('karyawan.form-non-pbj.index')->with('success', 'Pengajuan Form Non PBJ berhasil ditambahkan.');
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function show($uuid)
    {
        $item = FormNonPbj::where('uuid', $uuid)->firstOrFail();
        return view('karyawan.pages.form-non-pbj.show', [
            'title' => 'Detail Pengajuan Form Non PBJ',
            'item' => $item
        ]);
    }

    public function edit($uuid)
    {
        $item = PengajuanBarangJasa::formNonPbj()->where('uuid', $uuid)->firstOrFail();
        return view('karyawan.pages.form-non-pbj.edit', [
            'title' => 'Edit Pengajuan Form Non PBJ',
            'item' => $item,
            'data_karyawan' => Karyawan::orderBy('nama', 'ASC')->get(),
            'selectedKaryawan' => $item->pelaksana->pluck('karyawan.id')->toArray()
        ]);
    }

    public function update($uuid)
    {
        request()->validate([
            'nomor_surat' => 'required|unique:surat,nomor_surat,' . $uuid . ',uuid',
            'perihal' => ['required'],
            'pelaksana' => ['required', 'array'],
        ]);

        DB::beginTransaction();
        try {
            $data = request()->only(['nomor_surat', 'perihal', 'nomor_agenda', 'tanggal_surat']);
            $item = PengajuanBarangJasa::formNonPbj()->where('uuid', $uuid)->firstOrFail();
            $data_lampiran = request()->file('lampiran');
            $data_pelaksana = request('pelaksana');
            $item->update($data);

            // create pelaksana
            if (!empty($data_pelaksana)) {
                // hapus pelaksana
                $item->pelaksana()->delete();
                foreach ($data_pelaksana as $pelaksana) {
                    $item->pelaksana()->create([
                        'uuid' => \Str::uuid(),
                        'karyawan_id' => $pelaksana
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('karyawan.form-non-pbj.index')->with('success', 'Pengajuan Form Non PBJ berhasil diupdate.');
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function destroy($uuid)
    {

        DB::beginTransaction();
        try {
            $item = PengajuanBarangJasa::formNonPbj()->where('uuid', $uuid)->first();
            $item->delete();
            DB::commit();
            return redirect()->route('karyawan.form-non-pbj.index')->with('success', 'Pengajuan Form Non PBJ berhasil dihapus.');
        } catch (\Throwable $th) {
            DB::rollBack();
            // throw $th;
            return redirect()->back()->with('error', 'Surat Tidak bisa dihapus, dikarenakan berada di transaksi lain.');
        }
    }
}
