<?php

namespace App\Http\Controllers\Ppk;

use App\Http\Controllers\Controller;
use App\Models\PengajuanBarangJasa;
use App\Models\ProsesPbj;
use App\Models\TahapanPbj;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengajuanPbjProsesController extends Controller
{
    public function index()
    {
        $items = ProsesPbj::whereHas('pbj', function ($q) {
            $q->where('uuid', request('pbj_uuid'));
        })->latest()->get();
        $pbj = PengajuanBarangJasa::pbj()->where('uuid', request('pbj_uuid'))->firstOrFail();
        return view('ppk.pages.pengajuan-pbj-proses.index', [
            'title' => 'Proses PBJ',
            'items' => $items,
            'pbj' => $pbj
        ]);
    }

    public function create()
    {
        $pbj = PengajuanBarangJasa::pbj()->where('uuid', request('pbj_uuid'))->firstOrFail();
        $data_tahapan = TahapanPbj::latest()->get();
        return view('ppk.pages.pengajuan-pbj-proses.create', [
            'title' => 'Tambah Proses PBJ',
            'pbj' => $pbj,
            'data_tahapan' => $data_tahapan
        ]);
    }

    public function store()
    {
        request()->validate([
            'tahapan_pbj_id' => ['required']
        ]);

        $pbj = PengajuanBarangJasa::pbj()->where('uuid', request('pbj_uuid'))->firstOrFail();
        // cek
        $cekProses = ProsesPbj::where('pengajuan_barang_jasa_id', $pbj->id)->where('tahapan_pbj_id', request('tahapan_pbj_id'));
        if ($cekProses->count() > 0) {
            return redirect()->back()->with('error', 'Tahapan Tersebut sudah ada di database.');
        }
        DB::beginTransaction();
        try {
            $data = request()->all();
            $data['pengajuan_barang_jasa_id'] = $pbj->id;
            $data['karyawan_id'] = auth()->user()->karyawan->id;
            ProsesPbj::create($data);
            DB::commit();
            return redirect()->route('ppk.pengajuan-pbj-proses.index', [
                'pbj_uuid' =>  $pbj->uuid
            ])->with('success', 'Proses PBJ berhasil ditambahkan.');
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function destroy($id)
    {

        DB::beginTransaction();
        try {
            $item = ProsesPbj::findOrFail($id);
            $pbj_uuid = $item->pbj->uuid;
            $item->delete();
            DB::commit();
            return redirect()->back()->with('success', 'Proses PBJ berhasil dihapus.');
        } catch (\Throwable $th) {
            DB::rollBack();
            // throw $th;
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
