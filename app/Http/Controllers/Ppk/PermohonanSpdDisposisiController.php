<?php

namespace App\Http\Controllers\Ppk;

use App\Http\Controllers\Controller;
use App\Models\Disposisi;
use App\Models\Karyawan;
use App\Models\SuratPerjalananDinas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PermohonanSpdDisposisiController extends Controller
{
    public function index($id)
    {
        $permohonan = SuratPerjalananDinas::where('id', $id)->firstOrFail();
        $items = Disposisi::where('surat_perjalanan_dinas_id', $permohonan->id)->where('pembuat_karyawan_id_2', auth()->user()->karyawan->id)->latest()->get();
        return view('ppk.pages.permohonan-spd-disposisi.index', [
            'title' => 'Permohonan SPD Disposisi',
            'items' => $items,
            'permohonan' => $permohonan
        ]);
    }
    public function create()
    {
        $data_karyawan = Karyawan::whereHas('user', function ($q) {
            $q->whereHas('roles', function ($role) {
                $role->whereIn('name', ['Pengelola Keuangan', 'Bendahara Keuangan']);
            });
        })->orderBy('nama', 'ASC')->get();
        $permohonan_spd_uuid = request('permohonan_spd_uuid');
        $permohonan = SuratPerjalananDinas::where('id', $permohonan_spd_uuid)->firstOrFail();
        return view('ppk.pages.permohonan-spd-disposisi.create', [
            'title' => 'Permohonan SPD Disposisi',
            'permohonan' => $permohonan,
            'data_karyawan' => $data_karyawan
        ]);
    }

    public function store()
    {
        request()->validate([
            'teruskan_ke' => ['required']
        ]);
        DB::beginTransaction();
        try {
            $permohonan_spd_uuid = request('permohonan_spd_uuid');
            $permohonan = SuratPerjalananDinas::where('id', $permohonan_spd_uuid)->firstOrFail();
            $data_tujuan = request('teruskan_ke');
            if (!empty($data_tujuan)) {
                $permohonan->disposisis()->update([
                    'pembuat_karyawan_id_2' => auth()->user()->karyawan->id,
                    'tujuan_karyawan_id_2' => $data_tujuan,
                    'tipe_2' => request('tipe'),
                    'catatan_2' => request('catatan'),
                    'perihal_2' => request('perihal')
                ]);
            }

            $permohonan->update([
                'status' => 'Menunggu Bendahara Keuangan Membuatkan SPD',
                'acc_ppk' => 1,
            ]);

            DB::commit();
            return redirect()->route('ppk.permohonan-spd-disposisi.index', $permohonan_spd_uuid)->with('success', 'Disposisi Berhasil disimpan.');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function destroy($id)
    {
        $item = Disposisi::findOrFail($id);
        $item->delete();
        return redirect()->back()->with('success', 'Disposisi Berhasil Dihapus.');
    }

    public function print($spd_uuid)
    {
        $spd = SuratPerjalananDinas::where('id', $spd_uuid)->firstOrFail();
        // dd($spd->disposisi);
        return view('ppk.pages.permohonan-spd-disposisi.print', [
            'title' => 'Cetak Disposisi',
            'spd' => $spd
        ]);
    }
}
