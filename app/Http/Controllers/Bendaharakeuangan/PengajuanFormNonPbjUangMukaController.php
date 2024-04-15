<?php

namespace App\Http\Controllers\Bendaharakeuangan;

use App\Http\Controllers\Controller;
use App\Models\PengajuanBarangJasa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengajuanFormNonPbjUangMukaController extends Controller
{
    public function index()
    {
        $pengajuan = PengajuanBarangJasa::formNonPbj()->where('uuid', request('pengajuan_uuid'))->firstOrFail();
        return view('bendahara-keuangan.pages.pengajuan-form-non-pbj-uang-muka.index', [
            'title' => 'Surat Perjalanan Dinas',
            'pengajuan' => $pengajuan
        ]);
    }

    public function store()
    {
        request()->validate([
            'nominal' => ['required']
        ]);

        DB::beginTransaction();
        try {
            $pengajuan = PengajuanBarangJasa::formNonPbj()->where('uuid', request('pengajuan_uuid'))->firstOrFail();
            if ($pengajuan->uang_muka) {
                // update
                $pengajuan->uang_muka()->update([
                    'nominal' => request('nominal')
                ]);
            } else {
                $pengajuan->uang_muka()->create([
                    'nominal' => request('nominal')
                ]);
            }
            DB::commit();
            return redirect()->route('bendahara-keuangan.pengajuan-form-non-pbj.index')->with('success', 'Uang Muka berhasil disubmit.');
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return redirect()->route('bendahara-keuangan.pengajuan-form-non-pbj.index')->with('error', $th->getMessage());
        }
    }
}
