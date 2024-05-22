<?php

namespace App\Http\Controllers\Timppk;

use App\Http\Controllers\Controller;
use App\Models\FormNonPbj;
use App\Models\FormNonPbjSpj;
use App\Models\FormNonPbjSpjDetaili;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FormNonPbjSpjDetailController extends Controller
{
    public function create($id)
    {
        $spj = FormNonPbj::where('id', $id)->firstOrFail();
        return view('timppk.pages.form-non-pbj-spj-detail.create', [
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
        $from = FormNonPbj::where('id', $id)->firstOrFail();
        $spj = FormNonPbjSpj::where('form_non_pbj_id', $from->id)->firstOrFail();
        $data = request()->all();
        $data['file'] = request()->file('file')->store('spj-detail', 'public');
        $spj->details()->create($data);
        return redirect()->route('timppk.form-non-pbj-spj.show', $spj->formNonPbj->id)->with('success', 'Biaya SPJ berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $item = FormNonPbjSpjDetaili::where('id', $id)->firstOrFail();
        return view('timppk.pages.form-non-pbj-spj-detail.edit', [
            'title' => 'Edut SPJ',
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
        $item = FormNonPbjSpjDetaili::where('id', $id)->firstOrFail();

        $data = request()->all();
        if (request()->file('file')) {
            Storage::disk('public')->delete($item->file);
            $data['file'] = request()->file('file')->store('spj-detail', 'public');
        }
        $item->update($data);
        return redirect()->route('timppk.form-non-pbj-spj.show', $item->formNonPbjSpj->formNonPbj->id)->with('success', 'Biaya SPJ berhasil diupdate.');
    }

    public function destroy($id)
    {
        $item = FormNonPbjSpjDetaili::where('id', $id)->firstOrFail();
        $spj_id = $item->formNonPbjSpj->formNonPbj->id;
        Storage::disk('public')->delete($item->file);
        $item->delete();
        return redirect()->route('timppk.form-non-pbj-spj.show', $spj_id)->with('success', 'Biaya SPJ berhasil dihapus.');
    }
}
