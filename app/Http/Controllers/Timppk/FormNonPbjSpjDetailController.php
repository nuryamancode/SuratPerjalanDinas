<?php

namespace App\Http\Controllers\Timppk;

use App\Http\Controllers\Controller;
use App\Models\FormNonPbjSpj;
use App\Models\FormNonPbjSpjDetaili;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FormNonPbjSpjDetailController extends Controller
{
    public function create()
    {
        $spj = FormNonPbjSpj::where('uuid', request('spj_uuid'))->firstOrFail();
        return view('timppk.pages.form-non-pbj-spj-detail.create', [
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
        $spj = FormNonPbjSpj::where('uuid', request('spj_uuid'))->firstOrFail();
        $data = request()->all();
        $data['file'] = request()->file('file')->store('spj-detail', 'public');
        $data['uuid'] = \Str::uuid();
        $spj->details()->create($data);
        return redirect()->route('timppk.form-non-pbj-spj.show', $spj->uuid)->with('success', 'Biaya SPJ berhasil ditambahkan.');
    }

    public function edit($uuid)
    {
        $item = FormNonPbjSpjDetaili::where('uuid', $uuid)->firstOrFail();
        return view('timppk.pages.form-non-pbj-spj-detail.edit', [
            'title' => 'Edut SPJ',
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
        $item = FormNonPbjSpjDetaili::where('uuid', $uuid)->firstOrFail();

        $data = request()->all();
        if (request()->file('file')) {
            Storage::disk('public')->delete($item->file);
            $data['file'] = request()->file('file')->store('spj-detail', 'public');
        }
        $item->update($data);
        return redirect()->route('timppk.form-non-pbj-spj.show', $item->formNonPbjSpj->uuid)->with('success', 'Biaya SPJ berhasil diupdate.');
    }

    public function destroy($uuid)
    {
        $item = FormNonPbjSpjDetaili::where('uuid', $uuid)->firstOrFail();
        $spj_uuid = $item->formNonPbjSpj->uuid;
        Storage::disk('public')->delete($item->file);
        $item->delete();
        return redirect()->route('timppk.form-non-pbj-spj.show', $spj_uuid)->with('success', 'Biaya SPJ berhasil dihapus.');
    }
}
