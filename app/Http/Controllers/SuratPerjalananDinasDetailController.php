<?php

namespace App\Http\Controllers;

use App\Models\SuratPerjalananDinasDetail;
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
}
