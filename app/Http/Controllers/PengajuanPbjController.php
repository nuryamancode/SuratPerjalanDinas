<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\PengajuanBarangJasa;
use App\Models\PengajuanBarangJasaDisposisi;
use App\Models\PengajuanPbj;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengajuanPbjController extends Controller
{
    public function index()
    {
        if (auth()->user()->getPermissions('Pengajuan PBJ Acc')) {
            $items = PengajuanBarangJasa::pbj()->accKaryawan()->latest()->get();
        } else {
            $items = PengajuanBarangJasa::pbj()->latest()->get();
        }
        return view('pages.pengajuan-pbj.index', [
            'title' => 'Pengajuan PBJ',
            'items' => $items
        ]);
    }

    public function create()
    {
        $data_karyawan = Karyawan::orderBy('nama', 'ASC')->get();
        return view('pages.pengajuan-pbj.create', [
            'title' => 'Tambah Pengajuan PBj',
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
            'tujuan_karyawan_id' => ['required']
        ]);

        DB::beginTransaction();
        try {
            $data = request()->only(['nomor_surat', 'perihal', 'no_agenda', 'tanggal', 'nomor_agenda', 'tujuan_karyawan_id']);
            $data_pelaksana = request('pelaksana');
            $data['uuid'] = \Str::uuid();
            // $data['pembuat_karyawan_id'] = auth()->id();
            $data['status'] = 'Belum Didisposisikan';
            $data['jenis'] = 'pbj';
            $item  = PengajuanBarangJasa::pbj()->create($data);

            // create pelaksana
            if (!empty($data_pelaksana)) {
                foreach ($data_pelaksana as $pelaksana) {
                    $item->pelaksana()->create([
                        'uuid' => \Str::uuid(),
                        'karyawan_id' => $pelaksana
                    ]);
                }
            }

            // create disposisi
            // PengajuanBarangJasaDisposisi::create([
            //     'pembuat_karyawan_id' => auth()->user()->karyawan->id,
            //     'tujuan_karyawan_id' => request('tujuan_karyawan_id'),
            //     'type' =>
            // ])

            DB::commit();
            return redirect()->route('pengajuan-pbj.show', $item->uuid)->with('success', 'Pengajuan PBJ berhasil ditambahkan.');
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function show($uuid)
    {
        $item = PengajuanBarangJasa::pbj()->where('id', $uuid)->firstOrFail();
        return view('pages.pengajuan-pbj.show', [
            'title' => 'Detail Pengajuan PBJ',
            'item' => $item
        ]);
    }

    public function edit($uuid)
    {
        $item = PengajuanBarangJasa::pbj()->where('id', $uuid)->firstOrFail();
        return view('pages.pengajuan-pbj.edit', [
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
            return redirect()->route('pengajuan-pbj.index')->with('success', 'Pengajuan PBJ berhasil diupdate.');
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
            return redirect()->route('pengajuan-pbj.index')->with('success', 'Pengajuan PBJ berhasil dihapus.');
        } catch (\Throwable $th) {
            DB::rollBack();
            // throw $th;
            return redirect()->back()->with('error', 'Surat Tidak bisa dihapus, dikarenakan berada di transaksi lain.');
        }
    }
    public function disposisi_create($uuid)
    {
        $data_karyawan = Karyawan::orderBy('nama', 'ASC')->get();
        $item = PengajuanBarangJasa::pbj()->where('uuid', $uuid)->firstOrFail();
        return view('pages.pengajuan-pbj.disposisi', [
            'title' => 'Pengajuan PBJ Disposisi',
            'item' => $item,
            'data_karyawan' => $data_karyawan
        ]);
    }

    public function disposisi_store($uuid)
    {
        request()->validate([
            'tujuan_karyawan_id' => ['required'],
            'tipe' => ['required']
        ]);
        DB::beginTransaction();
        try {
            $item = PengajuanBarangJasa::pbj()->where('uuid', $uuid)->firstOrFail();
            if ($item->disposisi && $item->disposisi->tujuan_karyawan_id == auth()->user()->karyawan->id) {
                $item->disposisi->update([
                    'acc_tujuan_karyawan_id' => 1
                ]);
            }
            $item->disposisi()->create([
                'tujuan_karyawan_id' => request('tujuan_karyawan_id'),
                'tipe' => request('tipe'),
                'pembuat_karyawan_id' => auth()->user()->karyawan->id,
                'catatan' => request('catatan')
            ]);
            DB::commit();
            return redirect()->route('pengajuan-pbj.index',)->with('success', 'Disposisi Pengajuan PBJ Berhasi Diupdate');
        } catch (\Throwable $th) {
            throw $th;
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function verifikasi()
    {
        request()->validate([
            'pengajuan_pbj_uuid' => ['required'],
            'status' => ['required', 'in:1,2']
        ]);


        DB::beginTransaction();
        try {
            $item = PengajuanBarangJasa::pbj()->where('uuid', request('pengajuan_pbj_uuid'))->firstOrFail();
            $item->update([
                'acc_karyawan' => request('status'),
                'karyawan_id' => auth()->user()->karyawan->id
            ]);
            DB::commit();
            return redirect()->route('pengajuan-pbj.index')->with('success', 'Permohonan PBJ berhasil ditanggapi.');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function acc_wadir2()
    {
        request()->validate([
            'pengajuan_pbj_uuid' => ['required'],
            'status' => ['required', 'in:1,2']
        ]);


        DB::beginTransaction();
        try {
            $item = PengajuanBarangJasa::pbj()->where('uuid', request('pengajuan_pbj_uuid'))->firstOrFail();
            $item->update([
                'acc_wadir2' => request('status')
            ]);
            DB::commit();
            return redirect()->route('pengajuan-pbj.index')->with('success', 'Permohonan PBJ berhasil ditanggapi.');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function acc_ppk()
    {
        request()->validate([
            'pengajuan_pbj_uuid' => ['required'],
            'status' => ['required', 'in:1,2']
        ]);


        DB::beginTransaction();
        try {
            $item = PengajuanBarangJasa::pbj()->where('uuid', request('pengajuan_pbj_uuid'))->firstOrFail();
            $item->update([
                'acc_ppk' => request('status')
            ]);
            DB::commit();
            return redirect()->route('pengajuan-pbj.index')->with('success', 'Permohonan PBJ berhasil ditanggapi.');
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
