<?php

namespace App\Http\Controllers;

use App\Models\SuratPertanggungJawaban;
use App\Models\SuratPertanggungJawabanDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SuratPertanggungJawabanDetailController extends Controller
{
    public function create()
    {
        $spj = SuratPertanggungJawaban::where('id', request('spj_id'))->firstOrFail();
        return view('pages.surat-pertanggung-jawaban-detail.create', [
            'title' => 'Buat SPJ',
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

        $data = request()->all();
        $data['file'] = request()->file('file')->store('spj-detail', 'public');
        $data['spj_id'] = request('spj_id');
        $data['uuid'] = \Str::uuid();
        SuratPertanggungJawabanDetail::create($data);
        $spj = SuratPertanggungJawaban::findOrFail(request('spj_id'));
        return redirect()->route('surat-pertanggung-jawaban.show', $spj->uuid)->with('success', 'Biaya SPJ berhasil ditambahkan.');
    }


    public function edit($uuid)
    {
        $item = SuratPertanggungJawabanDetail::where('uuid', $uuid)->firstOrFail();
        return view('pages.surat-pertanggung-jawaban-detail.edit', [
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
        $item = SuratPertanggungJawabanDetail::where('uuid', $uuid)->firstOrFail();

        $data = request()->all();
        if (request()->file('file')) {
            Storage::disk('public')->delete($item->file);
            $data['file'] = request()->file('file')->store('spj-detail', 'public');
        }
        $item->update($data);
        return redirect()->route('surat-pertanggung-jawaban.show', $item->spj->uuid)->with('success', 'Biaya SPJ berhasil ditambahkan.');
    }

    public function destroy($uuid)
    {
        $item = SuratPertanggungJawabanDetail::where('uuid', $uuid)->firstOrFail();
        $spj_uuid = $item->spj->uuid;
        Storage::disk('public')->delete($item->file);
        $item->delete();
        return redirect()->route('surat-pertanggung-jawaban.show', $spj_uuid)->with('success', 'Biaya SPJ berhasil dihapus.');
    }
}
