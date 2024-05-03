<?php

namespace App\Http\Controllers\Timppk;

use App\Http\Controllers\Controller;
use App\Models\SuratNonPbjSpj;
use App\Models\SuratNonPbjSpjDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SuratNonPbjSpjDetailController extends Controller
{
    public function create()
    {
        $spj = SuratNonPbjSpj::where('uuid', request('spj_uuid'))->firstOrFail();
        return view('timppk.pages.surat-non-pbj-spj-detail.create', [
            'title' => 'Buat Detail SPJ',
            'spj' => $spj
        ]);
    }

    public function store()
    {
        request()->validate([
            'perincian_biaya' => ['required'],
            'nominal' => ['required'],
            'file' => ['required', 'file', 'mimes:pdf']
        ]);
        $spj = SuratNonPbjSpj::where('uuid', request('spj_uuid'))->firstOrFail();
        $data = request()->all();
        $data['file'] = request()->file('file')->store('spj-detail', 'public');
        $data['uuid'] = \Str::uuid();
        $spj->details()->create($data);
        return redirect()->route('timppk.surat-non-pbj-spj.show', $spj->uuid)->with('success', 'Biaya SPJ berhasil ditambahkan.');
    }

    public function edit($uuid)
    {
        $item = SuratNonPbjSpjDetail::where('uuid', $uuid)->firstOrFail();
        return view('timppk.pages.surat-non-pbj-spj-detail.edit', [
            'title' => 'Edit SPJ',
            'item' => $item
        ]);
    }

    public function update($uuid)
    {
        request()->validate([
            'perincian_biaya' => ['required'],
            'nominal' => ['required'],
            'file' => ['file', 'mimes:pdf']
        ]);
        $item = SuratNonPbjSpjDetail::where('uuid', $uuid)->firstOrFail();

        $data = request()->all();
        if (request()->file('file')) {
            Storage::disk('public')->delete($item->file);
            $data['file'] = request()->file('file')->store('spj-detail', 'public');
        }
        $item->update($data);
        return redirect()->route('timppk.surat-non-pbj-spj.show', $item->surat_non_pbj_spj->uuid)->with('success', 'Biaya SPJ berhasil diupdate.');
    }

    public function destroy($uuid)
    {
        $item = SuratNonPbjSpjDetail::where('uuid', $uuid)->firstOrFail();
        $spj_uuid = $item->surat_non_pbj_spj->uuid;
        Storage::disk('public')->delete($item->file);
        $item->delete();
        return redirect()->route('timppk.surat-non-pbj-spj.show', $spj_uuid)->with('success', 'Biaya SPJ berhasil dihapus.');
    }
}
