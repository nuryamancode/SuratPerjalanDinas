<?php

namespace App\Http\Controllers\Bendaharakeuangan;

use App\Http\Controllers\Controller;
use App\Models\SuratNonPbj;
use App\Models\User;
use Illuminate\Http\Request;

class SuratNonPbjUangMukaController extends Controller
{
    public function index($form_non_pbj_uuid)
    {
        $suratNonPbj = SuratNonPbj::with('uang_muka')->where('uuid', $form_non_pbj_uuid)->firstOrFail();
        $data_tim_ppk = User::role('Tim PPK')->get();
        // dd($suratNonPbj->uang_muka1);
        return view('bendahara-keuangan.pages.surat-non-pbj-uang-muka.index', [
            'title' => 'Surat Non PBJ Uang Muka',
            'suratNonPbj' => $suratNonPbj,
            'data_tim_ppk' => $data_tim_ppk
        ]);
    }

    public function store()
    {
        request()->validate([
            'karyawan_id' => ['required'],
            'nominal' => ['required']
        ]);

        $data = request()->only(['karyawan_id', 'nominal']);
        $suratNonPbj = SuratNonPbj::where('uuid', request('surat_non_pbj_uuid'))->firstOrFail();
        if ($suratNonPbj->uang_muka) {
            $suratNonPbj->uang_muka()->update($data);
        } else {
            $suratNonPbj->uang_muka()->create($data);
            $suratNonPbj->update([
                'status' => 'Proses Melaksanakan Belanja'
            ]);
        }

        return redirect()->route('bendahara-keuangan.surat-non-pbj.index')->with('success', 'Uang Muka berhasil disimpan.');
    }
}
