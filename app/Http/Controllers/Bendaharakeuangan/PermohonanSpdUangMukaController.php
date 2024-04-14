<?php

namespace App\Http\Controllers\Bendaharakeuangan;

use App\Http\Controllers\Controller;
use App\Models\SuratPerjalananDinas;
use App\Models\UangMuka;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PermohonanSpdUangMukaController extends Controller
{
    public function index()
    {
        $permohonan = SuratPerjalananDinas::where('uuid', request('spd_uuid'))->firstOrFail();
        return view('bendahara-keuangan.pages.spd-uang-muka.index', [
            'title' => 'Surat Perjalanan Dinas',
            'permohonan' => $permohonan
        ]);
    }

    public function store()
    {
        request()->validate([
            'nominal' => ['required']
        ]);

        DB::beginTransaction();
        try {
            $spd = SuratPerjalananDinas::where('uuid', request('spd_uuid'))->firstOrFail();
            if ($spd->uang_muka) {
                // update
                $spd->uang_muka()->update([
                    'nominal' => request('nominal')
                ]);
            } else {
                $spd->uang_muka()->create([
                    'nominal' => request('nominal')
                ]);
            }
            DB::commit();
            return redirect()->route('bendahara-keuangan.permohonan-spd.index')->with('success', 'Uang Muka berhasil disubmit.');
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return redirect()->route('bendahara-keuangan.permohonan-spd.index')->with('error', $th->getMessage());
        }
    }
}
