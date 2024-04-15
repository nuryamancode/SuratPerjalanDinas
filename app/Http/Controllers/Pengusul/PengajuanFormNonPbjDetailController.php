<?php

namespace App\Http\Controllers\Pengusul;

use App\Http\Controllers\Controller;
use App\Models\PengajuanBarangJasa;
use App\Models\PengajuanBarangJasaDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengajuanFormNonPbjDetailController extends Controller
{
    public function create()
    {
        $pengajuan_pbj = PengajuanBarangJasa::where('uuid', request('pengajuan_pbj_uuid'))->firstOrFail();
        return view('pengusul.pages.pengajuan-form-non-pbj-detail.create', [
            'title' => 'Pengajuan Form Non PBJ Detail',
            'pengajuan_pbj' => $pengajuan_pbj
        ]);
    }

    public function store()
    {
        request()->validate([
            'kebutuhan_barang' => ['required'],
            'volume' => ['required'],
            'satuan' => ['required'],
            'harga_satuan' => ['required'],
            'jumlah' => ['required'],
        ]);
        $item = PengajuanBarangJasa::where('uuid', request('pengajuan_pbj_uuid'))->firstOrFail();
        DB::beginTransaction();
        try {
            $data = request()->all();
            $data['uuid'] = \Str::uuid();
            $item->details()->create($data);
            DB::commit();

            return redirect()->route('pengusul.pengajuan-form-non-pbj.show', $item->uuid)->with('success', 'Detail Pengajuan PBJ Berhasil Ditambahkan.');
        } catch (\Throwable $th) {
            throw $th;
            DB::rollBack();
        }
    }

    public function edit($uuid)
    {
        $item = PengajuanBarangJasaDetail::where('uuid', $uuid)->firstOrFail();
        return view('pengusul.pages.pengajuan-form-non-pbj-detail.edit', [
            'title' => 'Pengajuan PBJ Detail',
            'item' => $item
        ]);
    }

    public function update($uuid)
    {
        request()->validate([
            'kebutuhan_barang' => ['required'],
            'volume' => ['required'],
            'satuan' => ['required'],
            'harga_satuan' => ['required'],
            'jumlah' => ['required'],
        ]);
        $item = PengajuanBarangJasaDetail::where('uuid', $uuid)->firstOrFail();
        DB::beginTransaction();
        try {
            $data = request()->all();
            $data['total_harga'] = request('harga_satuan') * request('jumlah');
            $item->update($data);
            DB::commit();

            return redirect()->route('pengusul.pengajuan-form-non-pbj.show', $item->pengajuan_barang_jasa->uuid)->with('success', 'Detail Pengajuan PBJ Berhasil Diupdate.');
        } catch (\Throwable $th) {
            throw $th;
            DB::rollBack();
        }
    }

    public function destroy($uuid)
    {
        $item = PengajuanBarangJasaDetail::where('uuid', $uuid)->firstOrFail();
        DB::beginTransaction();
        try {
            $item->delete();
            DB::commit();

            return redirect()->route('pengusul.pengajuan-form-non-pbj.show', $item->pengajuan_barang_jasa->uuid)->with('success', 'Detail Pengajuan PBJ Berhasil Dihapus.');
        } catch (\Throwable $th) {
            throw $th;
            DB::rollBack();
        }
    }
}
