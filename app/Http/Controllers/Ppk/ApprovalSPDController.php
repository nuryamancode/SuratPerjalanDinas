<?php

namespace App\Http\Controllers\Ppk;

use App\Http\Controllers\Controller;
use App\Models\SPDPelaksana;
use App\Models\SPDSupir;
use App\Models\SuratPerjalananDinas;
use App\Models\User;
use Illuminate\Http\Request;

class ApprovalSPDController extends Controller
{
    public function index()
    {
        $items = SuratPerjalananDinas::with('spd_pelaksana_dinas', 'spd_supir')->latest()->get();
        return view('ppk.pages.approval-permohonan-spd.index', [
            'title' => 'Approval Permohonan SPD',
            'items' => $items,
        ]);
    }

    public function show($id)
    {
        $item = SuratPerjalananDinas::where('id', $id)->firstOrFail();
        return view('ppk.pages.approval-permohonan-spd.show', [
            'title' => 'Detail Permohonan SPD',
            'item' => $item,
        ]);
    }

    public function verifikasi($id)
    {
        $item = SuratPerjalananDinas::where('id', $id)->firstOrFail();
        if (!auth()->user()->karyawan->tte_file) {
            return redirect()->back()->with('error', 'Silahkan upload terlebih dahulu TTE nya.');
        }
        $item->spd_pelaksana_dinas()->update([
            'verifikasi_ppk' => 1,
        ]);
        if ($item->surat->antar == 1) {
            $item->spd_supir()->update([
                'verifikasi_ppk' => 1,
            ]);
        }
        $item->update([
            'status' => 'SPD Sudah Di TTD'
        ]);
        return redirect()->back()->with('success', 'Verifikasi ');
    }
    public function print($id)
    {
        $item = SPDPelaksana::where('id', $id)->firstOrFail();
        $items = SPDSupir::where('id', $id)->firstOrFail();
        $ppk = User::role('Pejabat Pembuat Komitmen')->first()->karyawan;
        return view('bendahara-keuangan.pages.spd.print', [
            'title' => 'Cetak SPD Pelaksana Dinas',
            'item' => $item,
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
}
