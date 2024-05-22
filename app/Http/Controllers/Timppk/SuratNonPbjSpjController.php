<?php

namespace App\Http\Controllers\Timppk;

use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use App\Models\SuratNonPbj;
use App\Models\SuratNonPbjSpj;
use App\Models\SuratNonPbjUangMuka;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class SuratNonPbjSpjController extends Controller
{
    public function index($id)
    {
        $suratNonPbj = SuratNonPbjUangMuka::where('id', $id)->firstOrFail();
        return view('timppk.pages.surat-non-pbj-spj.create', [
            'title' => 'Pengajuan Form Non PBJ',
            'suratNonPbj' => $suratNonPbj
        ]);
    }

    public function store()
    {
        request()->validate([
            'untuk_pembayaran' => ['required'],
        ]);

        DB::beginTransaction();
        try {
            $data_perincian_biaya = request('perincian_biaya');
            $data_nominal = request('nominal');
            $data_keterangan = request('keterangan');
            $data_file = request('file');


            // dd(request()->all());
            $suratNonPbj = SuratNonPbj::where('id', request('surat_non_pbj_uuid'))->firstOrFail();
            // cek spj
            if ($suratNonPbj->spj) {
                // update spj
            } else {
                // create spj
                $spj = $suratNonPbj->spj()->create([
                    'untuk_pembayaran' => request('untuk_pembayaran'),
                    'status_spj' => 'SPJ Terkirim Ke Pejabat Pembuat Komitmen',
                    'pembuat_id' => auth()->user()->karyawan->id
                ]);
                $suratNonPbj->update([
                    'status_surat' => 'SPJ Terkirim Ke Pejabat Pembuat Komitmen',
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
            return redirect()->route('timppk.surat-non-pbj.index')->with('success', 'SPJ Berhasil dibuat.');
        } catch (Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function show($id)
    {
        $suratNonPbj = SuratNonPbjUangMuka::where('id', $id)->firstOrFail();
        return view('timppk.pages.surat-non-pbj-spj.show', [
            'title' => 'Pengajuan Form Non PBJ',
            'suratNonPbj' => $suratNonPbj
        ]);
    }

    public function print($id)
    {
        $item = SuratNonPbjSpj::where('id', $id)->firstOrFail();
        $bendahara = Karyawan::whereHas('user', function ($user) {
            $user->role('Bendahara Keuangan');
        })->firstOrFail();
        $ppk = Karyawan::whereHas('user', function ($user) {
            $user->role('Pejabat Pembuat Komitmen');
        })->firstOrFail();
        return view('ppk.pages.surat-non-pbj-spj.print', [
            'title' => 'Cetak Kwitansi',
            'item' => $item,
            'bendahara' => $bendahara,
            'ppk' => $ppk,
        ]);
    }
}
