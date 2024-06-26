<?php

namespace App\Http\Controllers\Wakildirekturii;

use App\Http\Controllers\Controller;
use App\Models\Disposisi;
use App\Models\Karyawan;
use App\Models\SuratPerjalananDinas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PermohonanSpdDisposisiController extends Controller
{
    public function index()
    {
        $permohonan_spd_uuid = request('permohonan_spd_uuid');
        $permohonan = SuratPerjalananDinas::where('id', $permohonan_spd_uuid)->firstOrFail();
        $items = Disposisi::where('surat_perjalanan_dinas_id', $permohonan->id)->where('pembuat_karyawan_id_1', auth()->user()->karyawan->id)->latest()->get();
        return view('wakil-direktur-ii.pages.permohonan-spd-disposisi.index', [
            'title' => 'Permohonan SPD Disposisi',
            'items' => $items,
            'permohonan' => $permohonan
        ]);
    }
    public function create()
    {
        $ppk = User::role('Pejabat Pembuat Komitmen')->first();
        $data_karyawan = Karyawan::orderBy('nama', 'ASC')->get();
        $permohonan_spd_uuid = request('permohonan_spd_uuid');
        $permohonan = SuratPerjalananDinas::where('id', $permohonan_spd_uuid)->firstOrFail();
        return view('wakil-direktur-ii.pages.permohonan-spd-disposisi.create', [
            'title' => 'Permohonan SPD Disposisi',
            'permohonan' => $permohonan,
            'data_karyawan' => $data_karyawan,
            'ppk' => $ppk
        ]);
    }
    public function edit($id)
    {
        $ppk = User::role('Pejabat Pembuat Komitmen')->first();
        $data_karyawan = Karyawan::orderBy('nama', 'ASC')->get();
        $disposisi = Disposisi::where('id', $id)->firstOrFail();
        return view('wakil-direktur-ii.pages.permohonan-spd-disposisi.edit', [
            'title' => 'Permohonan SPD Disposisi',
            'data_karyawan' => $data_karyawan,
            'ppk' => $ppk,
            'disposisi' => $disposisi,
        ]);
    }

    public function store()
    {
        request()->validate([
            'tujuan_karyawan_id' => ['required'],
            'tipe' => ['required']
        ]);

        DB::beginTransaction();
        try {
            $permohonan_spd_uuid = request('permohonan_spd_uuid');
            $permohonan = SuratPerjalananDinas::where('id', $permohonan_spd_uuid)->firstOrFail();
            $tujuan = request('tujuan_karyawan_id');
            if ($tujuan) {
                // cek terlebih dahulu datanya sudah ada atau belum
                $cek = Disposisi::where([
                    'surat_perjalanan_dinas_id' => $permohonan->id
                ])->count();

                if ($cek < 1) {
                    $permohonan->disposisis()->create([
                        'pembuat_karyawan_id_1' => auth()->user()->karyawan->id,
                        'tujuan_karyawan_id_1' => $tujuan,
                        'tipe_1' => request('tipe'),
                        'catatan_1' => request('catatan'),
                        'nomor_agenda_1' => request('nomor_agenda'),
                        'perihal_1' => request('perihal')
                    ]);
                } else {
                    return redirect()->route('wakil-direktur-ii.permohonan-spd-disposisi.index', [
                        'permohonan_spd_uuid' => $permohonan->id
                    ])->with('error', 'Disposisi tidak bisa dibuatkan lagi.');
                }
            }

            DB::commit();
            return redirect()->route('wakil-direktur-ii.permohonan-spd.index')->with('success', 'Disposisi Berhasil disimpan.');
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function update($id)
    {
        request()->validate([
            'tipe' => ['required']
        ]);

        DB::beginTransaction();
        try {
            $disposisi = Disposisi::where('id', $id)->firstOrFail();
            $tujuan = request('tujuan_karyawan_id');
            $disposisi->update([
                'pembuat_karyawan_id_1' => auth()->user()->karyawan->id,
                'tujuan_karyawan_id_1' => $tujuan,
                'tipe_1' => request('tipe'),
                'catatan_1' => request('catatan'),
                'nomor_agenda_1' => request('nomor_agenda'),
                'perihal_1' => request('perihal')
            ]);
            $disposisi->spd()->update([
                'acc_ppk' => 0,
                'keterangan_acc_ppk' => null,
                'verifikasi_wadir2' => 0,
                'status' => 'Menunggu Persetujuan PPK'
            ]);
            // return redirect()->route('wakil-direktur-ii.permohonan-spd-disposisi.index', [
            //     'permohonan_spd_uuid' => $permohonan->id
            // ])->with('error', 'Disposisi tidak bisa dibuatkan lagi.');

            DB::commit();
            return redirect()->route('wakil-direktur-ii.permohonan-spd.index')->with('success', 'Disposisi Berhasil disimpan.');
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
        return view('wakil-direktur-ii.pages.permohonan-spd-disposisi.print', [
            'title' => 'Cetak Disposisi',
            'spd' => $spd
        ]);
    }
}
