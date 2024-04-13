<?php

namespace App\Http\Controllers\Wakildirekturii;

use App\Http\Controllers\Controller;
use App\Models\Disposisi;
use App\Models\Karyawan;
use App\Models\SuratPerjalananDinas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PermohonanSpdDisposisiController extends Controller
{
    public function index()
    {
        $permohonan_spd_uuid = request('permohonan_spd_uuid');
        $permohonan = SuratPerjalananDinas::where('uuid', $permohonan_spd_uuid)->firstOrFail();
        $items = Disposisi::where('surat_perjalanan_dinas_id', $permohonan->id)->where('pembuat_karyawan_id', auth()->user()->karyawan->id)->latest()->get();
        return view('wakil-direktur-ii.pages.permohonan-spd-disposisi.index', [
            'title' => 'Permohonan SPD Disposisi',
            'items' => $items,
            'permohonan' => $permohonan
        ]);
    }
    public function create()
    {
        $data_karyawan = Karyawan::orderBy('nama', 'ASC')->get();
        $permohonan_spd_uuid = request('permohonan_spd_uuid');
        $permohonan = SuratPerjalananDinas::where('uuid', $permohonan_spd_uuid)->firstOrFail();
        return view('wakil-direktur-ii.pages.permohonan-spd-disposisi.create', [
            'title' => 'Permohonan SPD Disposisi',
            'permohonan' => $permohonan,
            'data_karyawan' => $data_karyawan
        ]);
    }

    public function store()
    {
        request()->validate([
            'tujuan_karyawan_id' => ['array', 'min:1'],
            'tujuan_karyawan_id.*' => ['required']
        ]);

        DB::beginTransaction();
        try {
            $permohonan_spd_uuid = request('permohonan_spd_uuid');
            $permohonan = SuratPerjalananDinas::where('uuid', $permohonan_spd_uuid)->firstOrFail();
            $data_tujuan = request('tujuan_karyawan_id');
            if ($data_tujuan) {
                foreach ($data_tujuan as $tujuan) {
                    // cek terlebih dahulu datanya sudah ada atau belum
                    $cek = Disposisi::where([
                        'surat_perjalanan_dinas_id' => $permohonan->uuid,
                        'tujuan_karyawan_id' => $tujuan,
                        'pembuat_karyawan_id' => auth()->user()->karyawan->id
                    ])->count();

                    if ($cek < 1) {
                        $permohonan->disposisis()->create([
                            'pembuat_karyawan_id' => auth()->user()->karyawan->id,
                            'tujuan_karyawan_id' => $tujuan,
                            'tipe' => request('tipe'),
                            'catatan' => request('catatan')
                        ]);
                    }
                }
            }

            DB::commit();
            return redirect()->route('wakil-direktur-ii.permohonan-spd-disposisi.index', [
                'permohonan_spd_uuid' => $permohonan->uuid
            ])->with('success', 'Disposisi Berhasil disimpan.');
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
}
