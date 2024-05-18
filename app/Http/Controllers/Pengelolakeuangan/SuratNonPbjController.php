<?php

namespace App\Http\Controllers\Pengelolakeuangan;

use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use App\Models\SuratNonPbj;
use Illuminate\Http\Request;

class SuratNonPbjController extends Controller
{
    public function index()
    {
        $items = SuratNonPbj::whereHas("disposisi_snpbj", function ($q) {
            $q->where("teruskan_ke_2", auth()->user()->karyawan->id);
        })->where('verifikasi_ppk', 1)->latest()->get();
        return view('pengelola-keuangan.pages.surat-non-pbj.index', [
            'title' => 'Pengajuan Surat Non PBJ',
            'items' => $items
        ]);
    }

    public function show($id)
    {
        $data_karyawans = Karyawan::whereHas('user', function ($q) {
            $q->whereHas('roles', function ($role) {
                $role->where('name', 'Tim PPK');
            });
        })->latest()->get();
        $item = SuratNonPbj::where('id', $id)->firstOrFail();
        return view('pengelola-keuangan.pages.surat-non-pbj.show', [
            'title' => 'Detail Pengajuan Surat Non PBJ',
            'item' => $item,
            'data_karyawans' => $data_karyawans,
        ]);
    }
    public function store_tanggapi($id)
    {
        $item = SuratNonPbj::where('id', $id)->firstOrFail();
        $item->uang_muka()->create([
            'karyawan_id' => request('teruskan_ke'),
            'nominal' => request('uang_muka'),
            'acc_bendahara' => 1,
        ]);
        $item->update([
            'status_surat' => 'Sudah Di Distribusikan',
        ]);
        return redirect()->route('pengelola-keuangan.surat-non-pbj.index')->with('success', 'Disposisi Berhasil ditanggapi.');
    }
}
