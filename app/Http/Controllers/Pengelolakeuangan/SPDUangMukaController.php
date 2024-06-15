<?php

namespace App\Http\Controllers\Pengelolakeuangan;

use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use App\Models\SPDPelaksana;
use App\Models\SPDSupir;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SPDUangMukaController extends Controller
{
    public function index($id)
    {
        $item = SPDPelaksana::where('id', $id)->firstOrFail();
        $items = SPDSupir::where('id', $id)->firstOrFail();
        return view('pengelola-keuangan.pages.spd-detail-uang-muka.index', [
            'title' => 'Input Uang Muka',
            'item' => $item,
            'items' => $items,
            'selectedKaryawan' => $item->spd->surat->pelaksana->pluck('karyawan.id')->toArray(),
            'data_karyawan' => Karyawan::orderBy('nama', 'ASC')->get(),
        ]);
    }
    public function uang_muka($id)
    {
        $item = SPDPelaksana::where('id', $id)->firstOrFail();
        return view('pengelola-keuangan.pages.spd-detail-uang-muka.pelaksana', [
            'title' => 'Input Uang Muka',
            'item' => $item,
            'selectedKaryawan' => $item->spd->surat->pelaksana->pluck('karyawan.id')->toArray(),
            'data_karyawan' => Karyawan::orderBy('nama', 'ASC')->get(),
        ]);
    }

    public function store()
    {
        request()->validate([
            'nominal_pelaksana' => ['required'],
        ]);

        DB::beginTransaction();
        try {
            $spd_pelaksana = SPDPelaksana::where('id', request('spd_pelaksana'))->firstOrFail();
            $spd_supir = SPDSupir::where('id', request('spd_supir'))->firstOrFail();
            $spd_pelaksana->uang_muka()->create([
                'nominal' => request('nominal_pelaksana')
            ]);
            if ($spd_pelaksana->spd->surat->antar == 1) {
                $spd_supir->uang_muka()->create([
                    'nominal' => request('nominal_supir')
                ]);
            }
            $spd_pelaksana->spd->update([
                'status' => 'Sudah Didistribusikan dan Menunggu Proses Perjalanan Dinas'
            ]);
            DB::commit();
            return redirect()->route('pengelola-keuangan.permohonan-spd.index')->with('success', 'Uang Muka berhasil disubmit.');
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
    public function store_pelaksana()
    {
        request()->validate([
            'nominal_pelaksana' => ['required'],
        ]);

        DB::beginTransaction();
        try {
            $spd_pelaksana = SPDPelaksana::where('id', request('spd_pelaksana'))->firstOrFail();
            $spd_pelaksana->uang_muka()->create([
                'nominal' => request('nominal_pelaksana')
            ]);
            $spd_pelaksana->spd->update([
                'status' => 'Sudah Didistribusikan dan Menunggu Proses Perjalanan Dinas'
            ]);
            DB::commit();
            return redirect()->route('pengelola-keuangan.permohonan-spd.index')->with('success', 'Uang Muka berhasil disubmit.');
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
