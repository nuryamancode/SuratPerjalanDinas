<?php

namespace App\Http\Controllers\Pengadministrasiumum;

use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use App\Models\PengajuanBarangJasa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengajuanPbjController extends Controller
{
    public function index()
    {
        $items = PengajuanBarangJasa::pbj()->latest()->get();
        return view('pengadministrasi-umum.pages.pengajuan-pbj.index', [
            'title' => 'Pengajuan PBJ',
            'items' => $items
        ]);
    }

    public function create()
    {
        $data_karyawan = Karyawan::orderBy('nama', 'ASC')->get();
        $data_karyawan2 = Karyawan::whereHas('user', function ($q) {
            $q->whereHas('roles', function ($role) {
                $role->whereIn('name', ['Kabag', 'Wakil Direktur I']);
            });
        })->orderBy('nama', 'ASC')->get();
        return view('pengadministrasi-umum.pages.pengajuan-pbj.create', [
            'title' => 'Tambah Pengajuan PBj',
            'data_karyawan' => $data_karyawan,
            'data_karyawan2' => $data_karyawan2,
        ]);
    }

    public function store()
    {
        request()->validate([
            'nomor_surat' => ['required', 'unique:pengajuan_barang_jasa,nomor_surat'],
            'nomor_agenda' => ['required', 'unique:pengajuan_barang_jasa,nomor_agenda'],
            'perihal' => ['required'],
            'pelaksana' => ['required', 'array'],
            'file' => ['file'],
            'karyawan_id' => ['required']
            // 'tujuan_karyawan_id' => ['required']
        ]);

        DB::beginTransaction();
        try {
            $data = request()->only(['nomor_surat', 'perihal', 'no_agenda', 'tanggal', 'nomor_agenda', 'karyawan_id']);
            $data_pengusul = request('pelaksana');
            $data['uuid'] = \Str::uuid();
            if (request()->file('file')) {
                $data['file'] = request()->file('file')->store('pbj', 'public');
            }
            // $data['pembuat_karyawan_id'] = auth()->id();
            $data['status'] = 'Belum Didisposisikan';
            $data['jenis'] = 'pbj';
            $item  = PengajuanBarangJasa::pbj()->create($data);

            // create pengusul
            if (!empty($data_pengusul)) {
                foreach ($data_pengusul as $pengusul) {
                    $item->pengusul()->create([
                        'uuid' => \Str::uuid(),
                        'karyawan_id' => $pengusul
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('pengadministrasi-umum.pengajuan-pbj.show', $item->uuid)->with('success', 'Pengajuan PBJ berhasil ditambahkan.');
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function show($uuid)
    {
        $item = PengajuanBarangJasa::pbj()->where('uuid', $uuid)->firstOrFail();
        return view('pengadministrasi-umum.pages.pengajuan-pbj.show', [
            'title' => 'Detail Pengajuan PBJ',
            'item' => $item
        ]);
    }

    public function edit($uuid)
    {
        $item = PengajuanBarangJasa::pbj()->where('uuid', $uuid)->firstOrFail();
        return view('pengadministrasi-umum.pages.pengajuan-pbj.edit', [
            'title' => 'Edit Pengajuan PBJ',
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
            $item = PengajuanBarangJasa::pbj()->where('uuid', $uuid)->firstOrFail();
            $data_lampiran = request()->file('lampiran');
            $data_pengusul = request('pelaksana');
            $item->update($data);

            // create pelaksana
            if (!empty($data_pengusul)) {
                // hapus pelaksana
                $item->pelaksana()->delete();
                foreach ($data_pengusul as $pelaksana) {
                    $item->pelaksana()->create([
                        'uuid' => \Str::uuid(),
                        'karyawan_id' => $pelaksana
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('pengadministrasi-umum.pengajuan-pbj.index')->with('success', 'Pengajuan PBJ berhasil diupdate.');
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
            $item = PengajuanBarangJasa::pbj()->where('uuid', $uuid)->first();
            $item->delete();
            DB::commit();
            return redirect()->route('pengadministrasi-umum.pengajuan-pbj.index')->with('success', 'Pengajuan PBJ berhasil dihapus.');
        } catch (\Throwable $th) {
            DB::rollBack();
            // throw $th;
            return redirect()->back()->with('error', 'Surat Tidak bisa dihapus, dikarenakan berada di transaksi lain.');
        }
    }
}
