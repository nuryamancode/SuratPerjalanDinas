<?php

namespace App\Http\Controllers\Wakildirekturi;

use App\Http\Controllers\Controller;
use App\Models\SuratPerjalananDinasDetail;
use App\Models\SuratPertanggungJawaban;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SpdSpjController extends Controller
{
    public function create()
    {
        $spd_detail = SuratPerjalananDinasDetail::where('uuid', request('spd_detail_uuid'))->firstOrFail();
        return view('wakil-direktur-i.pages.spd-spj.create', [
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
            return redirect()->route('wakil-direktur-i.spd.index')->with('success', 'Surat Pertanggung Jawaban Berhasil dibuat.');
        } catch (\Throwable $th) {
            throw $th;
            DB::rollBack();
            return redirect()->route('wakil-direktur-i.spd.index')->with('error', $th->getMessage());
        }
    }

    public function show($uuid)
    {
        $item = SuratPertanggungJawaban::where('uuid', $uuid)->firstOrFail();
        return view('wakil-direktur-i.pages.spd-spj.show', [
            'title' => 'Detail SPJ Perjalanan Dinas',
            'item' => $item
        ]);
    }
}
