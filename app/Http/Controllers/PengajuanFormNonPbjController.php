<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\PengajuanBarangJasa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengajuanFormNonPbjController extends Controller
{
    public function index()
    {
        if (is_pejabatpembuatkomitmen()) {
            $items = PengajuanBarangJasa::where('acc_pengusul', 1)->formNonPbj()->latest()->get();
        } else {
            $items = PengajuanBarangJasa::formNonPbj()->latest()->get();
        }
        return view('pages.pengajuan-form-non-pbj.index', [
            'title' => 'Pengajuan Form Non PBJ',
            'items' => $items
        ]);
    }

    public function create()
    {
        $data_karyawan = Karyawan::orderBy('nama', 'ASC')->get();
        return view('pages.pengajuan-form-non-pbj.create', [
            'title' => 'Tambah Pengajuan Form Non PBj',
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
            return redirect()->route('pengajuan-form-non-pbj.show', $item->uuid)->with('success', 'Pengajuan Form Non PBJ berhasil ditambahkan.');
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function show($uuid)
    {
        $item = PengajuanBarangJasa::formNonPbj()->where('uuid', $uuid)->firstOrFail();
        return view('pages.pengajuan-form-non-pbj.show', [
            'title' => 'Detail Pengajuan Form Non PBJ',
            'item' => $item
        ]);
    }

    public function edit($uuid)
    {
        $item = PengajuanBarangJasa::formNonPbj()->where('uuid', $uuid)->firstOrFail();
        return view('pages.pengajuan-form-non-pbj.edit', [
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
            return redirect()->route('pengajuan-form-non-pbj.index')->with('success', 'Pengajuan Form Non PBJ berhasil diupdate.');
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
            return redirect()->route('pengajuan-form-non-pbj.index')->with('success', 'Pengajuan Form Non PBJ berhasil dihapus.');
        } catch (\Throwable $th) {
            DB::rollBack();
            // throw $th;
            return redirect()->back()->with('error', 'Surat Tidak bisa dihapus, dikarenakan berada di transaksi lain.');
        }
    }
    public function disposisi_create($uuid)
    {
        $data_karyawan = Karyawan::orderBy('nama', 'ASC')->get();
        $item = PengajuanBarangJasa::formNonPbj()->where('uuid', $uuid)->firstOrFail();
        return view('pages.pengajuan-form-non-pbj.disposisi', [
            'title' => 'Pengajuan Form Non PBJ Disposisi',
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
            $item = PengajuanBarangJasa::formNonPbj()->where('uuid', $uuid)->firstOrFail();
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
            return redirect()->route('pengajuan-form-non-pbj.index',)->with('success', 'Disposisi Pengajuan Form Non PBJ Berhasi Diupdate');
        } catch (\Throwable $th) {
            throw $th;
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function verifikasi()
    {
        request()->validate([
            'pengajuan_form_non_pbj_uuid' => ['required'],
            'status' => ['required', 'in:1,2']
        ]);


        DB::beginTransaction();
        try {
            $item = PengajuanBarangJasa::formNonPbj()->where('uuid', request('pengajuan_form_non_pbj_uuid'))->firstOrFail();
            $item->update([
                'acc_karyawan' => request('status'),
                'karyawan_id' => auth()->user()->karyawan->id
            ]);
            DB::commit();
            return redirect()->route('pengajuan-form-non-pbj.index')->with('success', 'Permohonan PBJ berhasil ditanggapi.');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function acc_ppk()
    {
        request()->validate([
            'pengajuan_form_non_pbj_uuid' => ['required'],
            'status' => ['required', 'in:1,2']
        ]);

        DB::beginTransaction();
        try {
            $item = PengajuanBarangJasa::formNonPbj()->where('uuid', request('pengajuan_form_non_pbj_uuid'))->firstOrFail();
            $item->update([
                'acc_ppk' => request('status')
            ]);
            DB::commit();
            return redirect()->route('pengajuan-form-non-pbj.index')->with('success', 'Permohonan PBJ berhasil ditanggapi.');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function acc_pengusul()
    {
        request()->validate([
            'pengajuan_form_non_pbj_uuid' => ['required'],
            'status' => ['required', 'in:1,2']
        ]);

        DB::beginTransaction();
        try {
            $item = PengajuanBarangJasa::formNonPbj()->where('uuid', request('pengajuan_form_non_pbj_uuid'))->firstOrFail();
            $item->update([
                'acc_pengusul' => request('status')
            ]);
            DB::commit();
            return redirect()->route('pengajuan-form-non-pbj.index')->with('success', 'Permohonan Form Non PBJ berhasil ditanggapi.');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getById()
    {
        $item = PengajuanBarangJasa::formNonPbj()->formNonPbjAccAll()->where('id', request('id'))->first();
        return response()->json($item);
    }
}
