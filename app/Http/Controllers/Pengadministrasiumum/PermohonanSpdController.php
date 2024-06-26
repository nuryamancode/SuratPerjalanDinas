<?php

namespace App\Http\Controllers\Pengadministrasiumum;

use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use App\Models\RiwayatSuratPerjalananDinas;
use App\Models\Surat;
use App\Models\SuratPerjalananDinas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PermohonanSpdController extends Controller
{
    public function index()
    {
        $items = SuratPerjalananDinas::latest()->get();
        return view('pengadministrasi-umum.pages.permohonan-spd.index', [
            'title' => 'Surat Perjalanan Dinas',
            'items' => $items
        ]);
    }

    public function create()
    {
        $data_surat = Surat::isNotUsed()->latest()->get();
        $data_karyawan = Karyawan::orderBy('nama', 'ASC')->get();
        return view('pengadministrasi-umum.pages.permohonan-spd.create', [
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
            $data = request()->only(['surat_id']);
            // dd($data);
            $data['status'] = 'Menunggu Persetujuan Wakil Direktur II';
            SuratPerjalananDinas::notActive()->create($data);

            DB::commit();
            return redirect()->route('pengadministrasi-umum.permohonan-spd.index')->with('success', 'Surat Perjalanan Dinas berhasil dibuat.');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function show($id)
    {
        $item = SuratPerjalananDinas::notActive()->findOrFail($id);
        return view('pengadministrasi-umum.pages.permohonan-spd.show', [
            'title' => 'Detail Surat Perjalanan Dinas',
            'item' => $item
        ]);
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $item = SuratPerjalananDinas::findOrFail($id);
            $item->delete();
            DB::commit();
            return redirect()->back()->with('success', 'Permohonan Surat Perjalanan Dinas berhasil dihapus.');
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
