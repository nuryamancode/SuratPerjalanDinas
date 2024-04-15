<?php

namespace App\Http\Controllers\Pelaksanabelanja;

use App\Http\Controllers\Controller;
use App\Models\PengajuanBarangJasa;
use App\Models\SpjBarangJasa;
use App\Models\SpjBarangJasaDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PengajuanFormNonPbjSpjDetailController extends Controller
{
    public function create()
    {
        $spj = SpjBarangJasa::where('uuid', request('spj_uuid'))->firstOrFail();
        return view('pelaksana-belanja.pages.pengajuan-form-non-pbj-spj-detail.create', [
            'title' => 'Buat SPJ',
            'spj' => $spj
        ]);
    }

    public function edit($uuid)
    {
        $item = SpjBarangJasaDetail::where('uuid', $uuid)->firstOrFail();
        return view('pelaksana-belanja.pages.pengajuan-form-non-pbj-spj-detail.edit', [
            'title' => 'Edit Detail SPJ',
            'item' => $item
        ]);
    }

    public function store()
    {

        request()->validate([
            'perincian_biaya' => ['required'],
            'nominal' => ['required', 'numeric'],
            'file' => ['required', 'file', 'max:2048']
        ]);


        $data = request()->all();
        $spj = SpjBarangJasa::where('uuid', request('spj_uuid'))->firstOrFail();
        $data['uuid'] = \Str::uuid();
        $data['file'] = request()->file('file')->store('spj-detail', 'public');
        $data['spj_barang_jasa_id'] = $spj->id;
        SpjBarangJasaDetail::create($data);


        // return redirect()->route('pelaksana-belanja.pengajuan-form-non-pbj.show', [
        //     'pengajuan_uuid' => $spj->pelaksanaFormNonPbj->pengajuan->uuid
        // ])->with('success', 'Detail SPJ berhasil ditambahkan.');

        return redirect()->route('pelaksana-belanja.pengajuan-form-non-pbj-spj.index', [
            'pengajuan_uuid' => $spj->pelaksanaFormNonPbj->pengajuan->uuid
        ])->with('success', 'Detail SPJ berhasil ditambahkan.');
    }

    public function update($uuid)
    {

        request()->validate([
            'perincian_biaya' => ['required'],
            'nominal' => ['required', 'numeric'],
            'file' => ['file', 'max:2048']
        ]);

        $item = SpjBarangJasaDetail::where('uuid', $uuid)->firstOrFail();
        $data = request()->only(['perincian_biaya', 'nominal', 'keterangan']);
        if (request()->file('file')) {
            Storage::disk('public')->delete($item->file);
            $data['file'] = request()->file('file')->store('spj-detail', 'public');
        }
        $item->update($data);
        return redirect()->route('pelaksana-belanja.pengajuan-form-non-pbj-spj.index', [
            'pengajuan_uuid' => $item->spjFormNonPbj->pelaksanaFormNonPbj->pengajuan->uuid
        ])->with('success', 'Detail SPJ berhasil diupdate.');
    }

    public function destroy($uuid)
    {
        $item = SpjBarangJasaDetail::where('uuid', $uuid)->firstOrFail();
        $pengajuan_uuid = $item->spjFormNonPbj->pelaksanaFormNonPbj->pengajuan->uuid;
        $item->delete();
        return redirect()->route('pelaksana-belanja.pengajuan-form-non-pbj-spj.index', [
            'pengajuan_uuid' => $pengajuan_uuid
        ])->with('success', 'Detail SPJ berhasil dihapus.');
    }
}
