<?php

namespace App\Http\Controllers\Bendaharakeuangan;

use App\Http\Controllers\Controller;
use App\Models\SuratPerjalananDinasDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SpdDetailController extends Controller
{
    public function edit($uuid)
    {
        $item = SuratPerjalananDinasDetail::where('uuid', $uuid)->firstOrFail();
        return view('bendahara-keuangan.pages.spd-detail.edit', [
            'title' => 'Edit Data',
            'item' => $item
        ]);
    }

    public function update($uuid)
    {
        $item = SuratPerjalananDinasDetail::where('uuid', $uuid)->firstOrFail();
        $data = request()->all();
        if (request('lama_perjalanan')) {
            $data['tanggal_harus_kembali'] = Carbon::parse(request('tanggal_berangkat'))->addDays(request('lama_perjalanan'));
        }
        if (request('jenis') === 'all') {
            // update keseluruhan
            $spd = $item->surat_perjalanan_dinas;
            foreach ($spd->details as $detail) {
                $detail->update($data);
            }
        } else {
            // update satu
            $item->update($data);
        }

        return redirect()->route('bendahara-keuangan.spd.index', [
            'spd_uuid' => $item->surat_perjalanan_dinas->uuid
        ])->with('success', 'Surat perjalanan dinas berhasil diupdate.');
    }
}
