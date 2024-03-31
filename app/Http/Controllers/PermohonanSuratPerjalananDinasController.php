<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\RiwayatSuratPerjalananDinas;
use App\Models\Surat;
use App\Models\SuratPerjalananDinas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PermohonanSuratPerjalananDinasController extends Controller
{
    public function index()
    {
        $data = SuratPerjalananDinas::notActive();
        if (auth()->user()->getPermissions('Permohonan Surat Perjalanan Dinas By Karyawan')) {
            $data->whereHas('disposisi', function ($q) {
                $q->where('pembuat_karyawan_id', auth()->user()->karyawan->id)->orWhere('tujuan_karyawan_id', auth()->user()->karyawan->id);
            });
        }
        $items = $data->latest()->get();
        return view('pages.permohonan-surat-perjalanan-dinas.index', [
            'title' => 'Surat Perjalanan Dinas',
            'items' => $items
        ]);
    }

    public function create()
    {
        $data_surat = Surat::isNotUsed()->latest()->get();
        $data_karyawan = Karyawan::orderBy('nama', 'ASC')->get();
        return view('pages.permohonan-surat-perjalanan-dinas.create', [
            'title' => 'Tambah Surat Perjalanan Dinas',
            'data_surat' => $data_surat,
            'data_karyawan' => $data_karyawan
        ]);
    }

    public function store()
    {
        request()->validate([
            'surat_id' => ['required']
        ]);

        DB::beginTransaction();

        try {
            $data = request()->only(['surat_id', 'instruksi', 'tipe']);
            $spd = SuratPerjalananDinas::notActive()->create($data);
            // create disposisi
            $spd->disposisi()->create([
                'pembuat_karyawan_id' => auth()->user()->karyawan->id,
                'tujuan_karyawan_id' => request('tujuan_karyawan_id'),
                'catatan' => request('catatan'),
                'tipe' => request('tipe'),
            ]);
            // create histori
            RiwayatSuratPerjalananDinas::create([
                'surat_perjalanan_dinas_id' => $spd->id,
                'pengirim_karyawan_id' => auth()->user()->karyawan->id,
                'tujuan_karyawan_id' => request('tujuan_karyawan_id'),
                'status' => 1
            ]);

            DB::commit();
            return redirect()->route('permohonan-surat-perjalanan-dinas.index')->with('success', 'Surat Perjalanan Dinas berhasil diajukan.');
        } catch (\Throwable $th) {
            throw $th;
            DB::rollBack();
        }
    }

    public function show($id)
    {
        $item = SuratPerjalananDinas::notActive()->findOrFail($id);
        return view('pages.permohonan-surat-perjalanan-dinas.show', [
            'title' => 'Detail Surat Perjalanan Dinas',
            'item' => $item
        ]);
    }
}
