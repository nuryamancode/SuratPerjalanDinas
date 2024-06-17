<?php

namespace App\Http\Controllers\Pengadministrasiumum;

use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use App\Models\Surat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SuratTugasController extends Controller
{
    public function index()
    {
        $items = Surat::latest()->get();
        return view('pengadministrasi-umum.pages.surat.index', [
            'title' => 'Surat',
            'items' => $items
        ]);
    }

    public function create()
    {
        $data_karyawan = Karyawan::whereHas('user', function ($q) {
            $q->whereHas('roles', function ($role) {
                $role->whereIn('name', ['Supir']);
            });
        })->orderBy('nama', 'ASC')->get();
        $data_pelaksana = Karyawan::orderBy('nama', 'ASC')->get();
        return view('pengadministrasi-umum.pages.surat.create', [
            'title' => 'Tambah Surat',
            'data_karyawan' => $data_karyawan,
            'data_pelaksana' => $data_pelaksana,
        ]);
    }

    public function store()
    {
        request()->validate([
            'nomor_surat' => ['required', 'unique:surat,nomor_surat'],
            'file' => ['required', 'mimes:pdf', 'max:2048'],
            'lampiran.*' => 'mimes:pdf|max:2048',
            'pelaksana' => ['required', 'array'],
        ]);

        DB::beginTransaction();
        try {
            $data_req = request()->only(['nomor_surat', 'maksud_perjalanan_dinas', 'lama_hari', 'tanggal_mulai', 'tanggal_sampai', 'tempat_berangkat', 'tempat_tujuan']);
            $data_supir = request()->only(['nomor_surat', 'maksud_perjalanan_dinas', 'lama_hari', 'tanggal_mulai', 'tanggal_sampai', 'tempat_berangkat', 'tempat_tujuan', 'no_surat_jalan_dinas', 'tanggal_surat_jalan', 'supir_karyawan_id', 'uraian_tugas', 'lama_hari_tugas', 'mulai_tanggal_tugas', 'sampai_tanggal_tugas']);

            if (request('antar') == 1) {
                // jemput
                $data = $data_supir;
                $data['antar'] = 1;
            } else {
                $data = $data_req;
                $data['antar'] = 0;
            }
            // dd($data);
            $data['file'] = request()->file('file')->store('surat', 'public');
            if (request('lampiran_surat_tugas')) {
                $data['lampiran_surat_tugas'] = request()->file('lampiran_surat_tugas')->store('surat-tugas-supir', 'public');
            }
            $data_lampiran = request()->file('lampiran');
            $data_pelaksana = request('pelaksana');
            $data['pembuat_user_id'] = auth()->id();
            $data['status'] = 'Belum Didisposisikan';
            $data['jenis_surat'] = 'tugas';
            $data['asal_surat'] = 'Pengadministrasi Umum';
            $surat = Surat::create($data);

            // create lampiran
            if (!empty($data_lampiran)) {
                foreach ($data_lampiran as $lampiran) {
                    $surat->lampiran()->create([
                        'file' => $lampiran->store('surat-lampiran', 'public')
                    ]);
                }
            }

            // create pelaksana
            if (!empty($data_pelaksana)) {
                foreach ($data_pelaksana as $pelaksana) {
                    $surat->pelaksana()->create([
                        'karyawan_id' => $pelaksana
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('pengadministrasi-umum.surat.index')->with('success', 'Surat berhasil ditambahkan.');
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
            // return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function show($id)
    {
        $item = Surat::where('id', $id)->firstOrFail();
        return view('pengadministrasi-umum.pages.surat.show', [
            'title' => 'Detail Surat',
            'item' => $item
        ]);
    }

    public function edit($id)
    {
        $item = Surat::where('id', $id)->firstOrFail();
        $data_karyawan = Karyawan::whereHas('user', function ($q) {
            $q->whereHas('roles', function ($role) {
                $role->whereNotIn('name', ['Supir']);
            });
        })->orderBy('nama', 'ASC')->get();
        return view('pengadministrasi-umum.pages.surat.edit', [
            'title' => 'Edit Surat',
            'item' => $item,
            'data_karyawan' => $data_karyawan,
            'selectedKaryawan' => $item->pelaksana->pluck('karyawan.id')->toArray()
        ]);
    }

    public function update($id)
    {
        request()->validate([
            'nomor_surat' => 'required|unique:surat,nomor_surat,' . $id . ',id',
            'file' => ['mimes:pdf', 'max:2048'],
            // 'lampiran.*' => 'mimes:pdf|max:2048',
            'pelaksana' => ['required', 'array'],
        ]);

        DB::beginTransaction();
        try {
            $item = Surat::where('id', $id)->firstOrFail();
            $data_req = request()->only(['nomor_surat', 'maksud_perjalanan_dinas', 'lama_hari', 'tanggal_mulai', 'tanggal_sampai', 'tempat_berangkat', 'tempat_tujuan']);
            $data_supir = request()->only(['nomor_surat', 'maksud_perjalanan_dinas', 'tanggal_mulai', 'lama_hari', 'lama_hari_tugas', 'tanggal_sampai', 'tempat_berangkat', 'tempat_tujuan', 'no_surat_jalan_dinas', 'tanggal_surat_jalan', 'supir_karyawan_id', 'uraian_tugas', 'mulai_tanggal_tugas', 'sampai_tanggal_tugas']);

            if ($item) {
                // jemput
                $data = $data_supir;
            } else {
                $data = $data_req;
            }

            if (request()->file('file')) {
                if ($item->file)
                    Storage::disk('public')->delete($item->file);
                $data['file'] = request()->file('file')->store('surat', 'public');
            }
            if (request()->file('lampiran_surat_tugas')) {
                if ($item->file)
                    Storage::disk('public')->delete($item->file);
                $data['file'] = request()->file('lampiran_surat_tugas')->store('surat-tugas', 'public');
            }
            $data_lampiran = request()->file('lampiran');
            $data_pelaksana = request('pelaksana');
            $item->update($data);

            // create lampiran
            if (!empty($data_lampiran)) {
                foreach ($data_lampiran as $lampiran) {
                    $item->lampiran()->create([
                        'file' => $lampiran->store('surat-lampiran', 'public')
                    ]);
                }
            }

            // create pelaksana
            if (!empty($data_pelaksana)) {
                // hapus pelaksana
                $item->pelaksana()->delete();
                foreach ($data_pelaksana as $pelaksana) {
                    $item->pelaksana()->create([
                        'karyawan_id' => $pelaksana
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('pengadministrasi-umum.surat.index')->with('success', 'Surat berhasil diupdate.');
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
            // return redirect()->back()->with('error', $th->getMessage());s
        }
    }

    public function destroy($id)
    {

        DB::beginTransaction();
        try {
            $item = Surat::where('id', $id);
            $item->delete();
            DB::commit();
            return redirect()->route('pengadministrasi-umum.surat.index')->with('success', 'Surat berhasil dihapus.');
        } catch (\Throwable $th) {
            DB::rollBack();
            // throw $th;
            return redirect()->back()->with('error', 'Surat Tidak bisa dihapus, dikarenakan berada di transaksi lain.');
        }
    }

    public function detail()
    {
        if (request()->ajax()) {
            $surat = Surat::find(request('surat_id'));
            return response()->json($surat);
        }
    }
}
