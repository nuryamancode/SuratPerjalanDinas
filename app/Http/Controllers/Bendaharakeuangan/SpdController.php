<?php

namespace App\Http\Controllers\Bendaharakeuangan;

use App\Http\Controllers\Controller;
use App\Models\SuratPerjalananDinas;
use App\Models\SuratPerjalananDinasDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SpdController extends Controller
{
    public function index()
    {
        $spd_uuid = request('spd_uuid');
        $items = SuratPerjalananDinasDetail::whereHas('surat_perjalanan_dinas', function ($q) use ($spd_uuid) {
            $q->where('id', $spd_uuid);
        })->latest()->get();

        $spd = SuratPerjalananDinas::where('id', request('spd_uuid'))->first();
        $data_permohonan = SuratPerjalananDinas::accPpk()->latest()->get();
        return view('bendahara-keuangan.pages.spd.index', [
            'title' => 'Surat Perjalanan Dinas',
            'items' => $items,
            'data_permohonan' => $data_permohonan,
            'spd' => $spd
        ]);
    }

    public function store()
    {
        request()->validate([
            'permohonan_spd_uuid' => ['required']
        ]);
        DB::beginTransaction();
        try {
            $permohonan = SuratPerjalananDinas::where('id', request('permohonan_spd_uuid'))->firstOrFail();
            // dd($permohonan->surat);

            if ($permohonan) {
                $data_pelaksana = $permohonan->surat->pelaksana;
                if (count($data_pelaksana) < 1) {
                    return redirect()->back()->with('error', 'Tidak terdapat pelaksana.');
                }
                // create spd
                if ($data_pelaksana) {
                    foreach ($data_pelaksana as $pelaksana) {
                        SuratPerjalananDinasDetail::create([
                            'surat_perjalanan_dinas_id' => $permohonan->id,
                            'karyawan_id' => $pelaksana->karyawan->id
                        ]);
                    }
                }

                // update spd
                // $permohonan->update([
                //     'status' => 1
                // ]);
            }
            DB::commit();

            return redirect()->back()->with('success', 'Surat Perjalanan Dinas Berhasil dibuat.');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getById()
    {
        if (request()->ajax()) {
            $item = SuratPerjalananDinasDetail::findOrFail(request('spd_detail_id'));
            return $item;
        }
    }
}
