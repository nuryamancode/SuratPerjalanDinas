<?php

namespace App\Http\Controllers\Supir;

use App\Http\Controllers\Controller;
use App\Models\SPDSupir;
use App\Models\SPJSupir;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SpdSPJController extends Controller
{
    public function index()
    {
        $items = SPJSupir::whereHas('supir', function ($qu) {
            $qu->where('pembuat_spj', auth()->user()->karyawan->id);
        })->latest()->get();
        return view('supir.pages.spd-spj.index', [
            'title' => 'Surat Pertanggung Jawaban SPD',
            'items' => $items,
            // 'data_permohonan' => $data_permohonan
        ]);
    }
    public function create()
    {
        $spdpelaksana = SPDSupir::where('id', request('spd_id'))->firstOrFail();
        return view('supir.pages.spd-spj.create', [
            'title' => 'Buat SPJ Perjalanan Dinas',
            'spdpelaksana' => $spdpelaksana
        ]);
    }

    public function store()
    {
        request()->validate([
            'draft' => ['required', 'mimes:pdf'],
            'spd_id' => ['required']
        ]);

        DB::beginTransaction();
        try {
            $data_perincian_biaya = request('perincian_biaya');
            $data_nominal = request('nominal');
            $data_keterangan = request('keterangan');
            $data_file = request('file');

            $spd_detail = SPDSupir::where('id', request('spd_id'))->firstOrFail();
            // cek spj
            if ($spd_detail->spj) {
                // update spj
            } else {
                // create spj
                $spj = $spd_detail->spj()->create([
                    'file' => request()->file('draft')->store('spj', 'public'),
                    'pembuat_spj' => auth()->user()->karyawan->id,
                ]);

                foreach ($data_perincian_biaya as $key => $perincian) {
                    // harus ada isi
                    if ($perincian && isset($data_nominal[$key]) && isset($data_file[$key])) {
                        $spj->details()->create([
                            'perincian_biaya' => $perincian,
                            'nominal' => $data_nominal[$key],
                            'keterangan' => $data_keterangan[$key],
                            'file' => $data_file[$key]->store('spj-detail', 'public')
                        ]);
                    }
                }
            }

            DB::commit();
            return redirect()->route('supir.spd.index')->with('success', 'Surat Pertanggung Jawaban Berhasil dibuat.');
        } catch (\Throwable $th) {
            throw $th;
            // DB::rollBack();
            // return redirect()->route('karyawan.spd.index')->with('error', $th->getMessage());
        }
    }

    public function kirim_ulang($uuid)
    {

        $item = SPJSupir::where('id', $uuid)->firstOrFail();
        $item->update([
            'acc_ppk' => 0,
            'status_spj' => 0,
        ]);

        $item->spd->spd->update([
            'status' => 'Menunggu Persetujuan SPJ',

        ]);
        return redirect()->back()->with('success', 'Surat Pertanggung Jawaban Berhasil dikirim ulang.');
    }

    public function show($uuid)
    {
        $item = SPJSupir::where('id', $uuid)->firstOrFail();
        return view('supir.pages.spd-spj.show', [
            'title' => 'Detail SPJ Perjalanan Dinas',
            'item' => $item
        ]);
    }

    public function print($uuid)
    {
        $spj = SPJSupir::where('id', $uuid)->firstOrFail();
        $bendahara = User::role('Bendahara Keuangan')->first();
        $ppk = User::role('Pejabat Pembuat Komitmen')->first();
        // dd($ppk);
        return view('supir.pages.spd-spj.print', [
            'title' => 'Cetak SPJ Perjalanan Dinas',
            'spj' => $spj,
            'bendahara' => $bendahara,
            'ppk' => $ppk
        ]);
    }
}
