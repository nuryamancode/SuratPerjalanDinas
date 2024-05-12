<?php

namespace App\Http\Controllers\Wakildirekturii;

use App\Http\Controllers\Controller;
use App\Models\Jabatan;
use App\Models\Karyawan;
use App\Models\PengajuanBarangJasa;
use App\Models\PengajuanBarangJasaDisposisi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengajuanPbjDisposisiController extends Controller
{
    public function index($id)
    {
        $pengajuan = PengajuanBarangJasa::pbj()->where('id', $id)->firstOrFail();
        $items = PengajuanBarangJasaDisposisi::where('pbj_id', $pengajuan->id)->latest()->get();
        return view('wakil-direktur-ii.pages.pengajuan-pbj-disposisi.index', [
            'title' => 'Pengajuan PBJ Disposisi',
            'items' => $items,
            'pengajuan' => $pengajuan
        ]);
    }
    public function create($id)
    {
        $role = 'Pejabat Pembuat Komitmen';
        $data_karyawan = Karyawan::whereHas('user.roles', function ($query) use ($role) {
            $query->where('name', $role);
        })->get();
        $item = PengajuanBarangJasa::pbj()->where('id', $id)->firstOrFail();
        $data = [
            'title' => 'Pengajuan PBJ Disposisi',
            'item' => $item,
            'data_karyawan' => $data_karyawan,
        ];
        return view('wakil-direktur-ii.pages.pengajuan-pbj-disposisi.create', $data);
    }
    public function detail()
    {
        if (request()->ajax()) {
            $pbj = PengajuanBarangJasaDisposisi::find(request('pbj_id'));
            return response()->json($pbj);
        }
    }

    public function store($id)
    {

        DB::beginTransaction();
        try {
            $pengajuan  = PengajuanBarangJasa::pbj()->where('id', $id)->firstOrFail();
            $pengajuan->disposisi_pbj()->create([
                'pbj_id' => $pengajuan->id,
                'catatan_disposisi_1' => request('catatan_disposisi'),
                'teruskan_ke_1' => request('teruskan_ke'),
                'pembuat_disposisi_1' => auth()->user()->karyawan->id,
            ]);

            $pengajuan->update([
                'status_surat' => 'Menunggu Persetujuan PPK',
                'acc_wadir2' => '1'
            ]);

            DB::commit();
            return redirect()->route('wakil-direktur-ii.pengajuan-pbj-disposisi.index', $pengajuan->id)->with('success', 'Disposisi Berhasil disimpan.');
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

    public function stosdhshre($id)
    {
        request()->validate([
            'tujuan_karyawan_id' => ['array', 'min:1'],
            'tujuan_karyawan_id.*' => ['required']
        ]);

        DB::beginTransaction();
        try {
            $pengajuan  = PengajuanBarangJasa::pbj()->where('id', $id)->firstOrFail();
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

            $pengajuan->update([
                'status' => 'Pemeriksaan PPK'
            ]);

            DB::commit();
            return redirect()->route('wakil-direktur-ii.pengajuan-pbj-disposisi.index', $pengajuan->uuid)->with('success', 'Disposisi Berhasil disimpan.');
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
