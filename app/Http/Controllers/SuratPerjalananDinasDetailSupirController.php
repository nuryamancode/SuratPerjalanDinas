<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\SuratPerjalananDinasDetail;
use App\Models\SuratPerjalananDinasDetailSupir;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SuratPerjalananDinasDetailSupirController extends Controller
{
    public function index()
    {
        $spd_detail = SuratPerjalananDinasDetail::findOrFail(request('surat_perjalanan_dinas_detail_id'));
        $items = SuratPerjalananDinasDetailSupir::where('spd_detail_id', $spd_detail->id)->get();
        $selectedKaryawan = $items->pluck('karyawan_id');
        $data_karyawan = Karyawan::orderBy('nama', 'ASC')->get();
        return view('pages.surat-perjalanan-dinas-supir.index', [
            'title' => 'Supir Data',
            'selectedKaryawan' => $selectedKaryawan,
            'data_karyawan' => $data_karyawan,
            'spd_detail' => $spd_detail
        ]);
    }

    public function update($spd_detail_id)
    {
        $spd_detail = SuratPerjalananDinasDetail::findOrFail($spd_detail_id);
        $data_supir = request('karyawan_id');
        DB::beginTransaction();
        try {
            if (!empty($data_supir)) {
                // delete semua, dan bikin yang baru
                $spd_detail->supir()->delete();
                foreach ($data_supir as $supir) {
                    $spd_detail->supir()->create([
                        'karyawan_id' => $supir
                    ]);
                }
            } else {
                // hapus supir
                $spd_detail->supir()->delete();
            }

            DB::commit();
            return redirect()->route('surat-perjalanan-dinas.index', [
                'surat_perjalanan_dinas_id' => $spd_detail->surat_perjalanan_dinas->id
            ])->with('success', 'Supier berhasil ditambahkan.');
        } catch (\Throwable $th) {
            throw $th;
            DB::rollBack();
            return redirect()->route('surat-perjalanan-dinas.index', [
                'surat_perjalanan_dinas_id' => $spd_detail->surat_perjalanan_dinas->id
            ])->with('error', $th->getMessage());
        }
    }
}
