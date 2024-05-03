<?php

namespace App\Http\Controllers\Wakildirekturii;

use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use App\Models\SuratNonPbj;
use App\Models\SuratNonPbjDisposisi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SuratNonPbjDisposisiController extends Controller
{
    public function index($uuid)
    {
        $pengajuan = SuratNonPbj::where('uuid', $uuid)->firstOrFail();
        $items = SuratNonPbjDisposisi::where('surat_non_pbj_id', $pengajuan->id)->latest()->get();
        return view('wakil-direktur-ii.pages.surat-non-pbj-disposisi.index', [
            'title' => 'Pengajuan Surat Non PBJ Disposisi',
            'items' => $items,
            'pengajuan' => $pengajuan
        ]);
    }
    public function create($uuid)
    {
        $data_karyawan = Karyawan::orderBy('nama', 'ASC')->get();
        $item = SuratNonPbj::where('uuid', $uuid)->firstOrFail();
        return view('wakil-direktur-ii.pages.surat-non-pbj-disposisi.create', [
            'title' => 'Pengajuan Surat Non PBJ Disposisi',
            'item' => $item,
            'data_karyawan' => $data_karyawan
        ]);
    }

    public function store($pengajuan_uuid)
    {
        request()->validate([
            'tujuan_karyawan_id' => ['array', 'min:1'],
            'tujuan_karyawan_id.*' => ['required']
        ]);

        DB::beginTransaction();
        try {
            $pengajuan  = SuratNonPbj::where('uuid', $pengajuan_uuid)->firstOrFail();
            $data_tujuan = request('tujuan_karyawan_id');
            if ($data_tujuan) {
                foreach ($data_tujuan as $tujuan) {
                    $pengajuan->disposisis()->create([
                        'uuid' => \Str::uuid(),
                        'pembuat_karyawan_id' => auth()->user()->karyawan->id,
                        'tujuan_karyawan_id' => $tujuan,
                        'tipe' => request('tipe'),
                        'catatan' => request('catatan')
                    ]);
                }
            }

            $pengajuan->update([
                'status' => 'Pemeriksaan PPK'
            ]);

            $pengajuan->update([
                'acc_ppk' => 0
            ]);

            DB::commit();
            return redirect()->route('wakil-direktur-ii.surat-non-pbj-disposisi.index', $pengajuan->uuid)->with('success', 'Disposisi Berhasil disimpan.');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function destroy($id)
    {
        $item = SuratNonPbjDisposisi::findOrFail($id);
        $item->delete();
        return redirect()->back()->with('success', 'Disposisi Berhasil Dihapus.');
    }
}
