<?php

namespace App\Http\Controllers\Timppk;

use App\Http\Controllers\Controller;
use App\Models\SuratNonPbjSpj;
use App\Models\SuratNonPbjSpjDetail;
use App\Models\SuratNonPbjUangMuka;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SuratNonPbjSpjDetailController extends Controller
{
    public function create($id)
    {
        $spj = SuratNonPbjSpj::where('id', $id)->firstOrFail();
        return view('timppk.pages.surat-non-pbj-spj-detail.create', [
            'title' => 'Buat Detail SPJ',
            'spj' => $spj
        ]);
    }

    public function store($id)
    {
        request()->validate([
            'perincian_biaya' => ['required'],
            'nominal' => ['required'],
            'file' => ['required', 'file', 'mimes:pdf']
        ]);
        $spj = SuratNonPbjSpj::where('id', $id)->firstOrFail();
        $data = request()->all();
        $data['file'] = request()->file('file')->store('spj-detail', 'public');
        $spj->details()->create($data);
        return redirect()->route('timppk.surat-non-pbj-spj.show', $spj->suratNonPbj->uang_muka->id)->with('success', 'Biaya SPJ berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $item = SuratNonPbjSpjDetail::where('id', $id)->firstOrFail();
        return view('timppk.pages.surat-non-pbj-spj-detail.edit', [
            'title' => 'Edit SPJ',
            'item' => $item
        ]);
    }

    public function update($id)
    {
        request()->validate([
            'perincian_biaya' => ['required'],
            'nominal' => ['required'],
            'file' => ['file', 'mimes:pdf']
        ]);
        $item = SuratNonPbjSpjDetail::where('id', $id)->firstOrFail();

        $data = request()->all();
        if (request()->file('file')) {
            Storage::disk('public')->delete($item->file);
            $data['file'] = request()->file('file')->store('spj-detail', 'public');
        }
        $item->update($data);
        return redirect()->route('timppk.surat-non-pbj-spj.show', $item->surat_non_pbj_spj->suratNonPbj->uang_muka->id)->with('success', 'Biaya SPJ berhasil diupdate.');
    }

    public function destroy($id)
    {
        $item = SuratNonPbjSpjDetail::where('id', $id)->firstOrFail();
        Storage::disk('public')->delete($item->file);
        $item->delete();
        return redirect()->route('timppk.surat-non-pbj-spj.show', $item->surat_non_pbj_spj->suratNonPbj->uang_muka->id)->with('success', 'Biaya SPJ berhasil dihapus.');
    }

    public function kirim_ulang($id){
        $item = SuratNonPbjSpj::where('id', $id)->firstOrFail();
        if ($item->details->isEmpty()) {
            return redirect()->back()->with('error', 'Detail Biaya Kosong.');
        }
        $item->update([
            'acc_ppk' => '0',
        ]);
        return redirect()->route('timppk.surat-non-pbj-spj.show', $item->suratNonPbj->uang_muka->id)->with('success', 'SPJ Berhasil dikirim.');
    }
}
