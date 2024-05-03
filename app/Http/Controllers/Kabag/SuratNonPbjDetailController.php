<?php

namespace App\Http\Controllers\Kabag;

use App\Http\Controllers\Controller;
use App\Models\SuratNonPbj;
use App\Models\SuratNonPbjDetail;
use Illuminate\Http\Request;

class SuratNonPbjDetailController extends Controller
{
    public function index()
    {
        $suratNonPbj = SuratNonPbj::where('uuid', request('surat_non_pbj_uuid'))->firstOrFail();
        $items = SuratNonPbjDetail::where('surat_non_pbj_id', $suratNonPbj->id)->latest()->get();
        return view('kabag.pages.surat-non-pbj-detail.index', [
            'title' => 'Detail Taksiran',
            'items' => $items,
            'suratNonPbj' => $suratNonPbj
        ]);
    }

    public function create()
    {
        $suratNonPbj = SuratNonPbj::where('uuid', request('surat_non_pbj_uuid'))->firstOrFail();
        return view('kabag.pages.surat-non-pbj-detail.create', [
            'title' => 'Tambah Taksiran',
            'suratNonPbj' => $suratNonPbj
        ]);
    }

    public function store()
    {
        request()->validate([
            'kebutuhan_barang' => ['required'],
            'volume' => ['required'],
            'harga_satuan' => ['required'],
            'jumlah' => ['required']
        ]);

        $data = request()->all();
        $data['uuid'] = \Str::uuid();
        // dd($data);
        $suratNonPbj = SuratNonPbj::findOrFail(request('surat_non_pbj_id'));
        SuratNonPbjDetail::create($data);
        return redirect()->route('kabag.surat-non-pbj-detail.index', [
            'surat_non_pbj_uuid' => $suratNonPbj->uuid
        ])->with('success', 'Taksiran berhasil ditambahkan.');
    }


    public function edit($uuid)
    {
        $item = SuratNonPbjDetail::where('uuid', $uuid)->firstOrFail();
        return view('kabag.pages.surat-non-pbj-detail.edit', [
            'title' => 'Tambah Taksiran',
            'item' => $item
        ]);
    }

    public function update($uuid)
    {
        request()->validate([
            'kebutuhan_barang' => ['required'],
            'volume' => ['required'],
            'harga_satuan' => ['required'],
            'jumlah' => ['required']
        ]);

        $data = request()->all();
        $item = SuratNonPbjDetail::where('uuid', $uuid)->firstOrFail();
        $item->update($data);
        return redirect()->route('kabag.surat-non-pbj-detail.index', [
            'surat_non_pbj_uuid' => $item->surat_non_pbj->uuid
        ])->with('success', 'Taksiran berhasil diupdate.');
    }

    public function destroy($id)
    {
        $item = SuratNonPbjDetail::findOrFail($id);
        $surat_non_pbj_uuid = $item->surat_non_pbj->uuid;
        $item->delete();
        return redirect()->route('kabag.surat-non-pbj-detail.index', [
            'surat_non_pbj_uuid' => $surat_non_pbj_uuid
        ])->with('success', 'Taksiran berhasil dihapus.');
    }
}
