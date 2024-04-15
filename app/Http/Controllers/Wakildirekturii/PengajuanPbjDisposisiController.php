<?php

namespace App\Http\Controllers\Wakildirekturii;

use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use App\Models\PengajuanBarangJasa;
use App\Models\PengajuanBarangJasaDisposisi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengajuanPbjDisposisiController extends Controller
{
    public function index($uuid)
    {
        $pengajuan = PengajuanBarangJasa::pbj()->where('uuid', $uuid)->firstOrFail();
        $items = PengajuanBarangJasaDisposisi::where('pengajuan_barang_jasa_id', $pengajuan->id)->latest()->get();
        return view('wakil-direktur-ii.pages.pengajuan-pbj-disposisi.index', [
            'title' => 'Pengajuan PBJ Disposisi',
            'items' => $items,
            'pengajuan' => $pengajuan
        ]);
    }
    public function create($uuid)
    {
        $data_karyawan = Karyawan::orderBy('nama', 'ASC')->get();
        $item = PengajuanBarangJasa::pbj()->where('uuid', $uuid)->firstOrFail();
        return view('wakil-direktur-ii.pages.pengajuan-pbj-disposisi.create', [
            'title' => 'Pengajuan PBJ Disposisi',
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
            $pengajuan  = PengajuanBarangJasa::pbj()->where('uuid', $pengajuan_uuid)->firstOrFail();
            $data_tujuan = request('tujuan_karyawan_id');
            if ($data_tujuan) {
                foreach ($data_tujuan as $tujuan) {
                    $pengajuan->disposisis()->create([
                        'pembuat_karyawan_id' => auth()->user()->karyawan->id,
                        'tujuan_karyawan_id' => $tujuan,
                        'tipe' => request('tipe'),
                        'catatan' => request('catatan')
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('wakil-direktur-ii.pengajuan-pbj-disposisi.index', $pengajuan->uuid)->with('success', 'Disposisi Berhasil disimpan.');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function destroy($id)
    {
        $item = PengajuanBarangJasaDisposisi::findOrFail($id);
        $item->delete();
        return redirect()->back()->with('success', 'Disposisi Berhasil Dihapus.');
    }
}
