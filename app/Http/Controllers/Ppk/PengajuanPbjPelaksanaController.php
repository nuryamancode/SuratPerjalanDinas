<?php

namespace App\Http\Controllers\Ppk;

use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use App\Models\PengajuanBarangJasa;
use App\Models\PengajuanBarangJasaPelaksana;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengajuanPbjPelaksanaController extends Controller
{
    public function index()
    {
        $pbj_uuid = request('pbj_uuid');
        $permohonan = PengajuanBarangJasa::pbj()->where('uuid', $pbj_uuid)->firstOrFail();
        $items = PengajuanBarangJasaPelaksana::where('pengajuan_barang_jasa_id', $permohonan->id)->latest()->get();
        return view('ppk.pages.pengajuan-pbj-pelaksana.index', [
            'title' => 'Pengajuan PBJ Pelaksana',
            'items' => $items,
            'permohonan' => $permohonan
        ]);
    }
    public function create()
    {
        $data_karyawan = Karyawan::whereHas('user', function ($q) {
            $q->whereHas('roles', function ($role) {
                $role->whereIn('name', ['Tim PPK']);
            });
        })->orderBy('nama', 'ASC')->get();
        $pengajuan_uuid = request('pengajuan_uuid');
        $permohonan = PengajuanBarangJasa::pbj()->where('uuid', $pengajuan_uuid)->firstOrFail();
        return view('ppk.pages.pengajuan-pbj-pelaksana.create', [
            'title' => 'Permohonan SPD Disposisi',
            'permohonan' => $permohonan,
            'data_karyawan' => $data_karyawan
        ]);
    }

    public function store()
    {
        request()->validate([
            'karyawan_id' => ['array', 'min:1'],
            'karyawan_id.*' => ['required']
        ]);
        DB::beginTransaction();
        try {
            $pbj_uuid = request('pbj_uuid');
            $permohonan = PengajuanBarangJasa::pbj()->where('uuid', $pbj_uuid)->firstOrFail();
            $data_tujuan = request('karyawan_id');
            if ($data_tujuan) {
                foreach ($data_tujuan as $tujuan) {

                    $cek = PengajuanBarangJasaPelaksana::where('karyawan_id', $tujuan)->count();
                    if ($cek < 1) {
                        $permohonan->pelaksana()->create([
                            'uuid' => \Str::uuid(),
                            'pembuat_karyawan_id' => auth()->user()->karyawan->id,
                            'karyawan_id' => $tujuan
                        ]);
                    }
                }
            }

            $permohonan->update([
                'status' => 'Menunggu Bendahara Keuangan Membuatkan SPD'
            ]);

            DB::commit();
            return redirect()->route('ppk.pengajuan-pbj-pelaksana.index', [
                'pbj_uuid' => $permohonan->uuid
            ])->with('success', 'Disposisi Berhasil disimpan.');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function destroy($id)
    {
        $item = PengajuanBarangJasaPelaksana::findOrFail($id);
        $item->delete();
        return redirect()->back()->with('success', 'Disposisi Berhasil Dihapus.');
    }

    public function setPelaksana($pengajuan_uuid)
    {
        $pengajuan = PengajuanBarangJasa::where('uuid', $pengajuan_uuid)->firstOrFail();
        $pengajuan->pelaksana()->update([
            'is_penanggung_jawab' => 0
        ]);

        $pengajuan->pelaksana()->where('karyawan_id', request('karyawan_id'))->update([
            'is_penanggung_jawab' => 1
        ]);

        return redirect()->back()->with('success', 'Penanggung Jawab berhasil diverifikasi');
    }
}
