<?php

namespace App\Http\Controllers\Supir;

use App\Http\Controllers\Controller;
use App\Models\SPJSupir;
use App\Models\SPJSupirDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SpdSPJDetailController extends Controller
{
    public function create()
    {
        $spj = SPJSupir::where('id', request('spj_uuid'))->firstOrFail();
        return view('supir.pages.spd-spj-detail.create', [
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
        $spj = SPJSupir::where('id', request('spj_uuid'))->firstOrFail();
        $data = request()->all();
        $data['file'] = request()->file('file')->store('spj-detail', 'public');
        $spj->details()->create($data);
        return redirect()->route('supir.spd-spj.show', $spj->id)->with('success', 'Biaya SPJ berhasil ditambahkan.');
    }

    public function edit($uuid)
    {
        $item = SPJSupirDetail::where('id', $uuid)->firstOrFail();
        return view('supir.pages.spd-spj-detail.edit', [
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
        $item = SPJSupirDetail::where('id', $uuid)->firstOrFail();

        $data = request()->all();
        if (request()->file('file')) {
            Storage::disk('public')->delete($item->file);
            $data['file'] = request()->file('file')->store('spj-detail', 'public');
        }
        $item->update($data);
        return redirect()->route('supir.spd-spj.show', $item->spj->id)->with('success', 'Biaya SPJ berhasil ditambahkan.');
    }

    public function destroy($uuid)
    {
        $item = SPJSupirDetail::where('id', $uuid)->firstOrFail();
        $spj_uuid = $item->spj->id;
        Storage::disk('public')->delete($item->file);
        $item->delete();
        return redirect()->route('supir.spd-spj.show', $spj_uuid)->with('success', 'Biaya SPJ berhasil dihapus.');
    }
}
