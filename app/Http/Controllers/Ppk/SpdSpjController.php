<?php

namespace App\Http\Controllers\Ppk;

use App\Http\Controllers\Controller;
use App\Models\SPJPelaksana;
use App\Models\SPJSupir;
use App\Models\SuratPerjalananDinasDetail;
use App\Models\SuratPertanggungJawaban;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SpdSpjController extends Controller
{
    public function index()
    {
        $filter = request('pilih_filter');
        if ($filter == 'supir') {
            $items = SPJSupir::with('spd')->latest()->get();
            $data = [
                'title' => 'SPJ Perjalanan Dinas Supir',
                'items' => $items,
                'filter' => $filter,
            ];
        } elseif ($filter == 'pelaksana') {
            $items = SPJPelaksana::with('spd')->latest()->get();
            $data = [
                'title' => 'SPJ Perjalanan Dinas Pelaksana Dinas',
                'items' => $items,
                'filter' => $filter,
            ];
        } else {
            $data = [
                'title' => 'SPJ Perjalanan Dinas',
                'filter' => $filter
            ];
        }
        return view('ppk.pages.spd-spj.index', $data);
    }


    public function show($uuid)
    {
        $item = SPJPelaksana::where('id', $uuid)->firstOrFail();
        return view('ppk.pages.spd-spj.show', [
            'title' => 'Detail SPJ Perjalanan Dinas',
            'item' => $item
        ]);
    }
    public function show_supir($uuid)
    {
        $item = SPJSupir::where('id', $uuid)->firstOrFail();
        return view('ppk.pages.spd-spj.show-supir', [
            'title' => 'Detail SPJ Perjalanan Dinas',
            'item' => $item
        ]);
    }
    public function verifikasi_pelaksana($uuid)
    {

        // cek tte
        if (request()->status == 1 && auth()->user()->karyawan->tte_file == NULL) {
            return redirect()->route('ppk.tte.index')->with('error', 'Silahkan upload terlebih dahulu TTE nya.');
        }

        $item = SPJPelaksana::where('id', $uuid)->firstOrFail();
        $item->update([
            'acc_ppk' => 1,
            'status_spj' => 1,
        ]);

        $item->spd->spd()->update([
            'status' => 'Selesai',
            'is_arsip' => '1',

        ]);
        return redirect()->back()->with('success', 'Surat Pertanggung Jawaban Berhasil disetujui.');
    }
    public function verifikasi_supir($uuid)
    {

        // cek tte
        if (request()->status == 1 && auth()->user()->karyawan->tte_file == NULL) {
            return redirect()->route('ppk.tte.index')->with('error', 'Silahkan upload terlebih dahulu TTE nya.');
        }

        $item = SPJSupir::where('id', $uuid)->firstOrFail();
        $item->update([
            'acc_ppk' => 1,
            'status_spj' => 1,
        ]);

        $item->spd->spd->update([
            'status' => 'Selesai',
            'is_arsip' => 1,
        ]);
        return redirect()->back()->with('success', 'Surat Pertanggung Jawaban Berhasil disetujui.');
    }

    public function tolak_pelaksana($uuid)
    {


        $item = SPJPelaksana::where('id', $uuid)->firstOrFail();
        $item->update([
            'acc_ppk' => 2,
            'keterangan_ppk' => request('keterangan'),
            'status_spj' => 2,
        ]);

        $item->spd->spd->update([
            'status' => 'SPD Belum Selesai'
        ]);
        return redirect()->back()->with('success', 'Surat Pertanggung Jawaban Berhasil ditolak.');
    }
    public function tolak_supir($uuid)
    {


        $item = SPJSupir::where('id', $uuid)->firstOrFail();
        $item->update([
            'acc_ppk' => 2,
            'keterangan_ppk' => request('keterangan'),
            'status_spj' => 2,
        ]);

        $item->spd->spd->update([
            'status' => 'SPD Belum Selesai',
        ]);
        return redirect()->back()->with('success', 'Surat Pertanggung Jawaban Berhasil ditolak.');
    }

    public function create()
    {
        $spd_detail = SuratPerjalananDinasDetail::where('uuid', request('spd_detail_uuid'))->firstOrFail();
        return view('ppk.pages.spd-spj.create', [
            'title' => 'Buat SPJ Perjalanan Dinas',
            'spd_detail' => $spd_detail
        ]);
    }

    public function store()
    {
        request()->validate([
            'draft' => ['required', 'mimes:pdf'],
            'spd_detail_uuid' => ['required']
        ]);

        DB::beginTransaction();
        try {
            $data_perincian_biaya = request('perincian_biaya');
            $data_nominal = request('nominal');
            $data_keterangan = request('keterangan');
            $data_file = request('file');

            $spd_detail = SuratPerjalananDinasDetail::where('uuid', request('spd_detail_uuid'))->firstOrFail();
            // cek spj
            if ($spd_detail->spj) {
                // update spj
            } else {
                // create spj
                $spj = $spd_detail->spj()->create([
                    'file' => request()->file('draft')->store('spj', 'public'),
                    'status' => 0
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
            return redirect()->route('ppk.spd-spj.index')->with('success', 'Surat Pertanggung Jawaban Berhasil dibuat.');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    // public function show($uuid)
    // {
    //     $item = SuratPertanggungJawaban::where('uuid', $uuid)->firstOrFail();
    //     return view('ppk.pages.spd-spj.show', [
    //         'title' => 'Detail SPJ Perjalanan Dinas',
    //         'item' => $item
    //     ]);
    // }
}
