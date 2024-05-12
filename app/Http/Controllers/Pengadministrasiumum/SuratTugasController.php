<?php

namespace App\Http\Controllers\Pengadministrasiumum;

use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use App\Models\Surat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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
        return view('pengadministrasi-umum.pages.surat.create', [
            'title' => 'Tambah Surat',
            'data_karyawan' => Karyawan::orderBy('nama', 'ASC')->get()
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
            $data_req = request()->only(['nomor_surat', 'tanggal_surat', 'maksud_perjalanan_dinas', 'tanggal_mulai', 'tanggal_sampai', 'tempat_berangkat', 'tempat_tujuan']);
            $data_supir = request()->only(['nomor_surat', 'tanggal_surat', 'maksud_perjalanan_dinas', 'tanggal_mulai', 'tanggal_sampai', 'tempat_berangkat', 'tempat_tujuan', 'no_surat_jalan_dinas', 'tanggal_surat_jalan', 'supir_karyawan_id', 'uraian_tugas', 'mulai_tanggal_tugas', 'sampai_tanggal_tugas']);

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
            // if (request('lampiran_surat_tugas')) {
            //     $datauuid['lampiran_surat_tugas'] = request()->file('lampiran_surat_tugas')->store('surat-tugas-supir', 'public');
            // }
            $data_lampiran = request()->file('lampiran');
            $data_pelaksana = request('pelaksana');
            $data[''] = \Str::uuid();
            $data['pembuat_user_id'] = auth()->id();
            $data['status'] = 'Belum Didisposisikan';
            $data['jenis_surat'] = 'tugas';
            $data['asal_surat'] = 'Pengadministrasi Umum';
            $surat  = Surat::create($data);

            // create lampiran
            if (!empty($data_lampiran)) {
                foreach ($data_lampiran as $lampiran) {
                    $surat->lampiran()->create([
                        'uuid' => \Str::uuid(),
                        'file' => $lampiran->store('surat-lampiran', 'public')
                    ]);
                }
            }

            // create pelaksana
            if (!empty($data_pelaksana)) {
                foreach ($data_pelaksana as $pelaksana) {
                    $surat->pelaksana()->create([
                        'id' => \Str::uuid(),
                        'karyawan_id' => $pelaksana
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('pengadministrasi-umum.surat.index')->with('success', 'Surat berhasil ditambahkan.');
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function show($uuid)
    {
        $item = Surat::where('id', $uuid)->firstOrFail();
        return view('pengadministrasi-umum.pages.surat.show', [
            'title' => 'Detail Surat',
            'item' => $item
        ]);
    }

    public function edit($uuid)
    {
        $item = Surat::where('uuid', $uuid)->firstOrFail();
        return view('pengadministrasi-umum.pages.surat.edit', [
            'title' => 'Edit Surat',
            'item' => $item,
            'data_karyawan' => Karyawan::orderBy('nama', 'ASC')->get(),
            'selectedKaryawan' => $item->pelaksana->pluck('karyawan.id')->toArray()
        ]);
    }

    public function update($uuid)
    {
        request()->validate([
            'nomor_surat' => 'required|unique:surat,nomor_surat,' . $uuid . ',uuid',
            'file' => ['mimes:pdf', 'max:2048'],
            // 'lampiran.*' => 'mimes:pdf|max:2048',
            'pelaksana' => ['required', 'array'],
        ]);

        DB::beginTransaction();
        try {
            $item = Surat::where('uuid', $uuid)->firstOrFail();
            $data_req = request()->only(['nomor_surat', 'tanggal_surat', 'maksud_perjalanan_dinas', 'tanggal_mulai', 'tanggal_sampai', 'tempat_berangkat', 'tempat_tujuan']);
            $data_supir = request()->only(['nomor_surat', 'tanggal_surat', 'maksud_perjalanan_dinas', 'tanggal_mulai', 'tanggal_sampai', 'tempat_berangkat', 'tempat_tujuan', 'no_surat_jalan_dinas', 'tanggal_surat_jalan', 'supir_karyawan_id', 'uraian_tugas', 'mulai_tanggal_tugas', 'sampai_tanggal_tugas']);

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
            // $data_lampiran = request()->file('lampiran');
            $data_pelaksana = request('pelaksana');
            $item->update($data);

            // create lampiran
            // if (!empty($data_lampiran)) {
            //     foreach ($data_lampiran as $lampiran) {
            //         $item->lampiran()->create([
            //             'uuid' => \Str::uuid(),
            //             'file' => $lampiran->store('surat-lampiran', 'public')
            //         ]);
            //     }
            // }

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
            return redirect()->route('pengadministrasi-umum.surat.index')->with('success', 'Surat berhasil diupdate.');
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
            $item = Surat::where('uuid', $uuid);
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
