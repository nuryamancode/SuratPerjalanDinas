<?php

namespace App\Http\Controllers\Bendaharakeuangan;

use App\Http\Controllers\Controller;
use App\Models\FormNonPbj;
use App\Models\FormNonPbjUangMuka;
use App\Models\User;
use Illuminate\Http\Request;

class FormNonPbjUangMukaController extends Controller
{
    public function index($form_non_pbj_uuid)
    {
        $formNonPbj = FormNonPbj::with('uang_muka1')->where('uuid', $form_non_pbj_uuid)->firstOrFail();
        $data_tim_ppk = User::role('Tim PPK')->get();
        // dd($formNonPbj->uang_muka1);
        return view('bendahara-keuangan.pages.form-non-pbj-uang-muka.index', [
            'title' => 'Surat Perjalanan Dinas',
            'formNonPbj' => $formNonPbj,
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

        $formNonPbj = FormNonPbj::where('uuid', request('form_non_pbj_uuid'))->firstOrFail();
        if ($formNonPbj->uang_muka1) {
            $formNonPbj->uang_muka1()->update($data);
        } else {
            $formNonPbj->uang_muka1()->create($data);
            $formNonPbj->update([
                'status' => 'Proses Melaksanakan Belanja'
            ]);
        }

        return redirect()->route('bendahara-keuangan.form-non-pbj.index', $formNonPbj->uuid)->with('success', 'Uang Muka berhasil disimpan.');
    }
}
