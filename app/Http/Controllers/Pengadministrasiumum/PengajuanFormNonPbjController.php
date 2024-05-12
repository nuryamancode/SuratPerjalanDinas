<?php

namespace App\Http\Controllers\Pengadministrasiumum;

use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use App\Models\PengajuanBarangJasa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengajuanFormNonPbjController extends Controller
{
    public function index()
    {
        $items = PengajuanBarangJasa::formNonPbj()->latest()->get();
        return view('pengadministrasi-umum.pages.pengajuan-form-non-pbj.index', [
            'title' => 'Pengajuan Non PBJ Formulir',
            'items' => $items
        ]);
    }

    public function create()
    {
        $data_karyawan = Karyawan::orderBy('nama', 'ASC')->get();
        return view('pengadministrasi-umum.pages.pengajuan-form-non-pbj.create', [
            'title' => 'Tambah Pengajuan Non PBJ Formulir',
            'data_karyawan' => $data_karyawan
        ]);
    }

    public function store()
    {
        request()->validate([
            'nomor_surat' => ['required', 'unique:pengajuan_barang_jasa,nomor_surat'],
            'nomor_agenda' => ['required', 'unique:pengajuan_barang_jasa,nomor_agenda'],
            'perihal' => ['required'],
            'pelaksana' => ['required', 'array'],
            // 'tujuan_karyawan_id' => ['required']
        ]);

        DB::beginTransaction();
        try {
            $data = request()->only(['nomor_surat', 'perihal', 'no_agenda', 'tanggal', 'nomor_agenda', 'tujuan_karyawan_id']);
            $data_pelaksana = request('pelaksana');
            $data['uuid'] = \Str::uuid();
            // $data['pembuat_karyawan_id'] = auth()->id();
            $data['status'] = 'Belum Didisposisikan';
            $data['jenis'] = 'formulir non pbj';
            $item  = PengajuanBarangJasa::formNonPbj()->create($data);

            // create pelaksana
            if (!empty($data_pelaksana)) {
                foreach ($data_pelaksana as $pelaksana) {
                    $item->pelaksana()->create([
                        'uuid' => \Str::uuid(),
                        'karyawan_id' => $pelaksana
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('pengadministrasi-umum.pengajuan-form-non-pbj.show', $item->uuid)->with('success', 'Pengajuan Form Non PBJ berhasil ditambahkan.');
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function show($uuid)
    {
        $item = PengajuanBarangJasa::formNonPbj()->where('uuid', $uuid)->firstOrFail();
        return view('pengadministrasi-umum.pages.pengajuan-form-non-pbj.show', [
            'title' => 'Detail Pengajuan Form Non PBJ',
            'item' => $item
        ]);
    }

    public function edit($uuid)
    {
        $item = PengajuanBarangJasa::formNonPbj()->where('uuid', $uuid)->firstOrFail();
        return view('pengadministrasi-umum.pages.pengajuan-form-non-pbj.edit', [
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
            return redirect()->route('pengadministrasi-umum.pengajuan-form-non-pbj.index')->with('success', 'Pengajuan Form Non PBJ berhasil diupdate.');
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
            return redirect()->route('pengadministrasi-umum.pengajuan-form-non-pbj.index')->with('success', 'Pengajuan Form Non PBJ berhasil dihapus.');
        } catch (\Throwable $th) {
            DB::rollBack();
            // throw $th;
            return redirect()->back()->with('error', 'Surat Tidak bisa dihapus, dikarenakan berada di transaksi lain.');
        }
    }
}
