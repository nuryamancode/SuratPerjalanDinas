<?php

namespace App\Http\Controllers\Bendaharakeuangan;

use App\Http\Controllers\Controller;
use App\Models\SuratPerjalananDinasDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SpdDetailUangMukaController extends Controller
{
    public function index()
    {
        $spd_detail = SuratPerjalananDinasDetail::where('uuid', request('spd_detail_uuid'))->firstOrFail();
        return view('bendahara-keuangan.pages.spd-detail-uang-muka.index', [
            'title' => 'Input Uang Muka ',
            'spd_detail' => $spd_detail
        ]);
    }

    public function store()
    {
        request()->validate([
            'nominal' => ['required']
        ]);

        DB::beginTransaction();
        try {
            $spd_detail = SuratPerjalananDinasDetail::where('uuid', request('spd_detail_uuid'))->firstOrFail();
            if ($spd_detail->uang_muka) {
                // update
                $spd_detail->uang_muka()->update([
                    'nominal' => request('nominal')
                ]);
            } else {
                $spd_detail->uang_muka()->create([
                    'nominal' => request('nominal')
                ]);
            }
            DB::commit();
            return redirect()->route('bendahara-keuangan.spd.index', [
                'spd_uuid' => $spd_detail->surat_perjalanan_dinas->uuid
            ])->with('success', 'Uang Muka berhasil disubmit.');
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return redirect()->route('bendahara-keuangan.spd.index', [
                'spd_uuid' => $spd_detail->surat_perjalanan_dinas->uuid
            ])->with('error', $th->getMessage());
        }
    }
}
