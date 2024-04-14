<?php

namespace App\Http\Controllers\Bendaharakeuangan;

use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use App\Models\SuratPerjalananDinasDetail;
use App\Models\SuratPerjalananDinasDetailSupir;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SpdDetailSupirController extends Controller
{
    public function index()
    {
        $spd_detail = SuratPerjalananDinasDetail::where('uuid', request('spd_detail_uuid'))->firstOrFail();
        $items = SuratPerjalananDinasDetailSupir::where('spd_detail_id', $spd_detail->id)->get();
        $selectedKaryawan = $items->pluck('karyawan_id');
        $data_karyawan = Karyawan::orderBy('nama', 'ASC')->get();
        return view('bendahara-keuangan.pages.spd-detail-supir.index', [
            'title' => 'Supir Data',
            'selectedKaryawan' => $selectedKaryawan,
            'data_karyawan' => $data_karyawan,
            'spd_detail' => $spd_detail
        ]);
    }

    public function update($spd_detail_uuid)
    {
        $spd_detail = SuratPerjalananDinasDetail::where('uuid', $spd_detail_uuid)->firstOrFail();
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
            return redirect()->route('bendahara-keuangan.spd.index', [
                'spd_uuid' => $spd_detail->surat_perjalanan_dinas->uuid
            ])->with('success', 'Supier berhasil ditambahkan.');
        } catch (\Throwable $th) {
            throw $th;
            DB::rollBack();
            return redirect()->route('bendahara-keuangan.spd.index', [
                'spd_uuid' => $spd_detail->surat_perjalanan_dinas->uuid
            ])->with('error', $th->getMessage());
        }
    }
}
