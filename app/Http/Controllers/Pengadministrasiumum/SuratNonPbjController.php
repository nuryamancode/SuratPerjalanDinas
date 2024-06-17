<?php

namespace App\Http\Controllers\Pengadministrasiumum;

use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use App\Models\SuratNonPbj;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SuratNonPbjController extends Controller
{
    public function index()
    {
        $items = SuratNonPbj::latest()->get();
        return view('pengadministrasi-umum.pages.surat-non-pbj.index', [
            'title' => 'Pengajuan Surat Non PBJ',
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
        return view('pengadministrasi-umum.pages.surat-non-pbj.create', [
            'title' => 'Tambah Pengajuan Surat Non PBj',
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
            $data['uuid'] = Str::uuid();
            if (request()->file('file')) {
                $data['file'] = request()->file('file')->store('surat-non-pbj', 'public');
            }
            // $data['pembuat_karyawan_id'] = auth()->id();
            $karyawan =  Karyawan::find(request('karyawan_id'));
            if ($karyawan->user->getRoleNames()->first() === 'Kabag') {
                $diteruskan = 'Kabag';
            } else {
                $diteruskan = 'Wakil Direktur I';
            }
            $data['status'] = 'Menunggu Tanda Tangan ' . $diteruskan;
            $data['jenis'] = 'pbj';
            $item  = SuratNonPbj::create($data);

            // create pengusul
            if (!empty($data_pengusul)) {
                foreach ($data_pengusul as $pengusul) {
                    $item->pengusul()->create([
                        'uuid' => Str::uuid(),
                        'karyawan_id' => $pengusul
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('pengadministrasi-umum.surat-non-pbj.show', $item->uuid)->with('success', 'Pengajuan Surat Non PBJ berhasil ditambahkan.');
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function show($uuid)
    {
        $item = SuratNonPbj::where('uuid', $uuid)->firstOrFail();
        return view('pengadministrasi-umum.pages.surat-non-pbj.show', [
            'title' => 'Detail Pengajuan Surat Non PBJ',
            'item' => $item
        ]);
    }

    public function edit($uuid)
    {
        $item = SuratNonPbj::where('uuid', $uuid)->firstOrFail();
        return view('pengadministrasi-umum.pages.surat-non-pbj.edit', [
            'title' => 'Edit Pengajuan Surat Non PBJ',
            'item' => $item,
            'data_karyawan' => Karyawan::orderBy('nama', 'ASC')->get(),
            'selectedKaryawan' => $item->pengusul->pluck('karyawan.id')->toArray()
        ]);
    }

    public function update($uuid)
    {
        request()->validate([
            'nomor_surat' => 'required|unique:surat,nomor_surat,' . $uuid . ',uuid',
            'perihal' => ['required'],
            'pengusul' => ['required', 'array'],
        ]);

        DB::beginTransaction();
        try {
            $data = request()->only(['nomor_surat', 'perihal', 'nomor_agenda', 'tanggal_surat']);
            $item = SuratNonPbj::where('uuid', $uuid)->firstOrFail();
            $data_pengusul = request('pengusul');
            $item->update($data);

            // create pengusul
            if (!empty($data_pengusul)) {
                // hapus pengusul
                $item->pengusul()->delete();
                foreach ($data_pengusul as $pengusul) {
                    $item->pengusul()->create([
                        'uuid' => Str::uuid(),
                        'karyawan_id' => $pengusul
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('pengadministrasi-umum.surat-non-pbj.index')->with('success', 'Pengajuan Surat Non PBJ berhasil diupdate.');
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
            $item = SuratNonPbj::where('uuid', $uuid)->first();
            $item->delete();
            DB::commit();
            return redirect()->route('pengadministrasi-umum.surat-non-pbj.index')->with('success', 'Pengajuan Surat Non PBJ berhasil dihapus.');
        } catch (\Throwable $th) {
            DB::rollBack();
            // throw $th;
            return redirect()->back()->with('error', 'Surat Tidak bisa dihapus, dikarenakan berada di transaksi lain.');
        }
    }
}
