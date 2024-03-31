<?php

namespace App\Http\Controllers;

use App\Models\SuratPerjalananDinasDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SuratPerjalananDinasDetailController extends Controller
{
    public function edit($id)
    {
        $item = SuratPerjalananDinasDetail::findOrFail($id);
        return view('pages.surat-perjalanan-dinas-detail.edit', [
            'title' => 'Edit Data',
            'item' => $item
        ]);
    }

    public function update($id)
    {
        $item = SuratPerjalananDinasDetail::findOrFail($id);
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

        return redirect()->route('surat-perjalanan-dinas.index', [
            'surat_perjalanan_dinas_id' => $item->surat_perjalanan_dinas_id
        ])->with('success', 'Surat perjalanan dinas berhasil diupdate.');
    }

    public function getById()
    {
        if (request()->ajax()) {
            $item = SuratPerjalananDinasDetail::findOrFail(request('spd_detail_id'));
            return $item;
        }
    }
}
