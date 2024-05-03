<?php

namespace App\Http\Controllers\Timppk;

use App\Http\Controllers\Controller;
use App\Models\SuratNonPbj;
use App\Models\SuratNonPbjSpj;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SuratNonPbjSpjController extends Controller
{
    public function index($uuid)
    {
        $suratNonPbj = SuratNonPbj::where('uuid', $uuid)->firstOrFail();
        return view('timppk.pages.surat-non-pbj-spj.create', [
            'title' => 'Pengajuan Form Non PBJ',
            'suratNonPbj' => $suratNonPbj
        ]);
    }

    public function store()
    {
        request()->validate([
            'untuk_pembayaran' => ['required'],
            'surat_non_pbj_uuid' => ['required']
        ]);

        DB::beginTransaction();
        try {
            $data_perincian_biaya = request('perincian_biaya');
            $data_nominal = request('nominal');
            $data_keterangan = request('keterangan');
            $data_file = request('file');


            // dd(request()->all());
            $suratNonPbj = SuratNonPbj::where('uuid', request('surat_non_pbj_uuid'))->firstOrFail();
            // cek spj
            if ($suratNonPbj->spj) {
                // update spj
            } else {
                // create spj
                $spj = $suratNonPbj->spj()->create([
                    'uuid' => \Str::uuid(),
                    'untuk_pembayaran' => request('untuk_pembayaran'),
                    'status' => 0
                ]);

                foreach ($data_perincian_biaya as $key => $perincian) {
                    // harus ada isi
                    if ($perincian && isset($data_nominal[$key]) && isset($data_file[$key])) {
                        $spj->details()->create([
                            'uuid' => \Str::uuid(),
                            'perincian_biaya' => $perincian,
                            'nominal' => $data_nominal[$key],
                            'keterangan' => $data_keterangan[$key],
                            'file' => $data_file[$key]->store('spj-detail', 'public')
                        ]);
                    }
                }
            }

            DB::commit();
            return redirect()->route('timppk.surat-non-pbj.index')->with('success', 'SPJ Berhasil dibuat.');
        } catch (\Throwable $th) {
            throw $th;
            DB::rollBack();
            return redirect()->route('timppk.surat-non-pbj.index')->with('error', $th->getMessage());
        }
    }

    public function show($uuid)
    {
        $suratNonPbj = SuratNonPbjSpj::where('uuid', $uuid)->firstOrFail();
        return view('timppk.pages.surat-non-pbj-spj.show', [
            'title' => 'Pengajuan Form Non PBJ',
            'suratNonPbj' => $suratNonPbj
        ]);
    }
}
