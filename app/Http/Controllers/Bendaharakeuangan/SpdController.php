<?php

namespace App\Http\Controllers\Bendaharakeuangan;

use App\Http\Controllers\Controller;
use App\Models\SPDPelaksana;
use App\Models\SPDSupir;
use App\Models\SuratPerjalananDinas;
use App\Models\SuratPerjalananDinasDetail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SpdController extends Controller
{
    public function index()
    {
        $items = SPDPelaksana::whereHas('spd', function ($qu) {
            $qu->whereHas('surat', function ($q) {
                $q->whereHas('pelaksana', function ($que) {
                    $que->where('karyawan_id', auth()->user()->karyawan->id);
                });
            });
        })->latest()->get();
        return view('bendahara-keuangan.pages.spd-pelaksana.index', [
            'title' => 'Surat Perjalanan Dinas',
            'items' => $items,
            // 'data_permohonan' => $data_permohonan
        ]);
    }

    public function show($id)
    {
        $item = SPDPelaksana::where('id', $id)->firstOrFail();
        return view('bendahara-keuangan.pages.spd-pelaksana.show', [
            'title' => 'Detail Surat Perjalanan Dinas',
            'item' => $item
        ]);
    }

    public function print($id)
    {
        $items = SPDSupir::where('id', $id)->firstOrFail();
        $ppk = User::role('Pejabat Pembuat Komitmen')->first()->karyawan;
        return view('bendahara-keuangan.pages.spd.print', [
            'title' => 'Cetak SPD Pelaksana Dinas',
            'items' => $items,
            'ppk' => $ppk
        ]);
    }
    public function print_pelaksana($id)
    {
        $item = SPDPelaksana::where('id', $id)->firstOrFail();
        $ppk = User::role('Pejabat Pembuat Komitmen')->first()->karyawan;
        return view('bendahara-keuangan.pages.spd.print-pelaksana', [
            'title' => 'Cetak SPD Pelaksana Dinas',
            'item' => $item,
            'ppk' => $ppk
        ]);
    }

    // public function store()
    // {
    //     request()->validate([
    //         'permohonan_spd_uuid' => ['required']
    //     ]);
    //     DB::beginTransaction();
    //     try {
    //         $permohonan = SuratPerjalananDinas::where('uuid', request('permohonan_spd_uuid'))->firstOrFail();
    //         // dd($permohonan->surat);

    //         if ($permohonan) {
    //             $data_pelaksana = $permohonan->surat->pelaksana;
    //             if (count($data_pelaksana) < 1) {
    //                 return redirect()->back()->with('error', 'Tidak terdapat pelaksana.');
    //             }
    //             // create spd
    //             if ($data_pelaksana) {
    //                 foreach ($data_pelaksana as $pelaksana) {
    //                     SuratPerjalananDinasDetail::create([
    //                         'surat_perjalanan_dinas_id' => $permohonan->id,
    //                         'karyawan_id' => $pelaksana->karyawan->id
    //                     ]);
    //                 }
    //             }

    //             // update spd
    //             $permohonan->update([
    //                 'status' => 1
    //             ]);
    //         }
    //         DB::commit();

    //         return redirect()->back()->with('success', 'Surat Perjalanan Dinas Berhasil dibuat.');
    //     } catch (\Throwable $th) {
    //         throw $th;
    //     }
    // }

    // public function getById()
    // {
    //     if (request()->ajax()) {
    //         $item = SuratPerjalananDinasDetail::findOrFail(request('spd_detail_id'));
    //         return $item;
    //     }
    // }
}
