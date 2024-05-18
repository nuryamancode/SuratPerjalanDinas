<?php

namespace App\Http\Controllers\Bendaharakeuangan;

use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use App\Models\SuratNonPbj;
use App\Models\SuratNonPbjSpj;
use App\Models\SuratNonPbjUangMuka;
use Illuminate\Http\Request;

class SuratNonPbjController extends Controller
{
    public function index()
    {
        $items = SuratNonPbj::whereHas('disposisi_snpbj', function ($q) {
            $q->where('teruskan_ke_2', auth()->user()->karyawan->id);
        })->where('verifikasi_ppk', 1)->latest()->get();
        return view('bendahara-keuangan.pages.surat-non-pbj.index', [
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
        return view('bendahara-keuangan.pages.surat-non-pbj.show', [
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
        return redirect()->route('bendahara-keuangan.surat-non-pbj.index')->with('success', 'Disposisi Berhasil ditanggapi.');
    }

    public function submit_arsip($uuid)
    {
        $item = SuratNonPbj::where('acc_ppk', 1)->where('uuid', $uuid)->firstOrFail();

        $item->update([
            'is_arsip' => 1
        ]);

        return redirect()->back()->with('success', 'Surat Non PBJ berhasil diarsipkan.');
    }


    public function arsip_index()
    {
        $filter = request('pilih_pbj');
        if ($filter == 'surat_non_pbj') {
            $items = SuratNonPbj::where('is_arsip', 1)->latest()->get();
            $data = [
                'title' => 'Pengajuan Surat Non PBJ',
                'items' => $items,
                'filter' => $filter,
            ];
        } elseif ($filter == 'form_non_pbj') {
            $items = SuratNonPbj::where('is_arsip', 1)->latest()->get();
            $data = [
                'title' => 'Pengajuan Surat Non PBJ',
                'items' => $items,
                'filter' => $filter,
            ];
        } else {
            $data = [
                'title' => 'Pengajuan Surat Non PBJ',
                'filter' => $filter
            ];
        }
        return view('bendahara-keuangan.pages.surat-non-pbj.arsip', $data);
    }

    public function arsip_spj($id)
    {
        $item = SuratNonPbjSpj::where('acc_ppk', 1)->where('id', $id)->firstOrFail();
        return view('bendahara-keuangan.pages.surat-non-pbj.arsip-spj', [
            'title' => 'Detail Pengajuan Surat Non PBJ',
            'item' => $item
        ]);
    }
}
