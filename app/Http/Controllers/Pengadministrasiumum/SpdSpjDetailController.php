<?php

namespace App\Http\Controllers\Pengadministrasiumum;

use App\Http\Controllers\Controller;
use App\Models\SPJPelaksana;
use App\Models\SPJPelaksanaDetail;
use App\Models\SuratPertanggungJawaban;
use App\Models\SuratPertanggungJawabanDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SpdSpjDetailController extends Controller
{
    public function create()
    {
        $spj = SPJPelaksana::where('id', request('spj_uuid'))->firstOrFail();
        return view('pengadministrasi-umum.pages.spd-spj-detail.create', [
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
        $spj = SPJPelaksana::where('id', request('spj_uuid'))->firstOrFail();
        $data = request()->all();
        $data['file'] = request()->file('file')->store('spj-detail', 'public');
        $spj->details()->create($data);
        return redirect()->route('pengadministrasi-umum.spd-spj.show', $spj->id)->with('success', 'Biaya SPJ berhasil ditambahkan.');
    }


    public function edit($uuid)
    {
        $item = SPJPelaksanaDetail::where('id', $uuid)->firstOrFail();
        return view('pengadministrasi-umum.pages.spd-spj-detail.edit', [
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
        $item = SPJPelaksanaDetail::where('id', $uuid)->firstOrFail();

        $data = request()->all();
        if (request()->file('file')) {
            Storage::disk('public')->delete($item->file);
            $data['file'] = request()->file('file')->store('spj-detail', 'public');
        }
        $item->update($data);
        return redirect()->route('pengadministrasi-umum.spd-spj.show', $item->spj->id)->with('success', 'Biaya SPJ berhasil ditambahkan.');
    }

    public function destroy($uuid)
    {
        $item = SPJPelaksanaDetail::where('id', $uuid)->firstOrFail();
        $spj_uuid = $item->spj->id;
        Storage::disk('public')->delete($item->file);
        $item->delete();
        return redirect()->route('pengadministrasi-umum.spd-spj.show', $spj_uuid)->with('success', 'Biaya SPJ berhasil dihapus.');
    }
}
