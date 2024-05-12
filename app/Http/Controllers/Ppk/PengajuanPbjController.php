<?php

namespace App\Http\Controllers\Ppk;

use App\Http\Controllers\Controller;
use App\Models\FormNonPbjDisposisi;
use App\Models\Karyawan;
use App\Models\PengajuanBarangJasa;
use App\Models\PengajuanBarangJasaDisposisi;
use Illuminate\Support\Facades\DB;

class PengajuanPbjController extends Controller
{
    public function index()
    {
        $items = PengajuanBarangJasaDisposisi::where('teruskan_ke_1', auth()->user()->karyawan->id)
        ->orWhereHas('pengajuan_barang_jasa', function ($query) {
            $query->whereHas('pengusul', function ($q) {
                $q->where('pengusul_id', auth()->user()->karyawan->id);
            });
        })
        ->latest()->get();
        $data = [
            'title' => 'Pengajuan PBJ',
            'items' => $items,
        ];

        return view('ppk.pages.pengajuan-pbj.index', $data);
    }

    public function show($id)
    {
        $data_karyawan = Karyawan::orderBy('nama', 'ASC')->get();
        $item = PengajuanBarangJasaDisposisi::where('id', $id)->firstOrFail();
        return view('ppk.pages.pengajuan-pbj.show', [
            'title' => 'Detail Pengajuan PBJ',
            'item' => $item,
            'data_karyawan' => $data_karyawan,
        ]);
    }

    // public function acc($id)
    // {
    //     $item = PengajuanBarangJasaDisposisi::where('id', $id)->firstOrFail();
    //     $item->update([
    //         'acc_ppk' => true,
    //     ]);
    //     return redirect()->back()->with('success', 'Pengajuan Barang Jasa Berhasil di acc.');
    // }

    public function disposisi($id)
    {
        $items = PengajuanBarangJasaDisposisi::where('id', $id)->firstOrFail();
        return view('ppk.pages.pengajuan-pbj-disposisi.index', [
            'title' => 'Pengajuan PBJ Disposisi',
            'items' => $items,
        ]);
    }
    public function edit_disposisi($id)
    {
        $data_karyawan = Karyawan::orderBy('nama', 'ASC')->get();
        $role = 'Tim PPK';
        $data_karyawanrole = Karyawan::whereHas('user.roles', function ($query) use ($role) {
            $query->where('name', $role);
        })->get();
        $items = PengajuanBarangJasaDisposisi::where('id', $id)->firstOrFail();
        return view('ppk.pages.pengajuan-pbj-disposisi.edit', [
            'title' => 'Pengajuan PBJ Disposisi',
            'items' => $items,
            'data_karyawan' => $data_karyawan,
            'data_karyawanrole' => $data_karyawanrole,
        ]);
    }

    public function update_disposisi($id)
    {
        request()->validate([
            'tipe_disposisi' => ['required'],
        ]);
        DB::beginTransaction();
        try {
            $items = PengajuanBarangJasaDisposisi::where('id', $id)->firstOrFail();
            $items->update([
                'tipe_disposisi' => request('tipe_disposisi'),
                'pelaksana_belanja' => request('pelaksana_belanja'),
                'catatan_disposisi_2' => request('catatan_disposisi'),
                'teruskan_ke_2' => request('teruskan_ke'),
                'pembuat_disposisi_2' => auth()->user()->karyawan->id,
            ]);
            $items->pbj()->update([
                'acc_ppk' => '1',
                'status_surat' => 'Menunggu Proses Belanja',
            ]);
            DB::commit();
            return redirect()->route('ppk.pengajuan-pbj-disposisi.index', $items->id)->with('success', 'Disposisi berhasil ditambahkan');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function verifikasi($id)
    {
        $item = PengajuanBarangJasaDisposisi::where('id', $id)->firstOrFail();
        if (!auth()->user()->karyawan->tte_file) {
            return redirect()->route('ppk.tte.index')->with('error', 'Silahkan upload terlebih dahulu TTE nya.');
        }
        if ($item->pengajuan_barang_jasa->acc_ppk != '1') {
            return redirect()->back()->with('error', 'Anda belum menyetujui atau Disposisi kosong.');
        }
        $item->pbj()->update([
            'verifikasi_ppk' => true,
        ]);
        return redirect()->back()->with('success', 'Pengajuan PBJ Berhasil diverifikasi.');
    }

    public function print_disposisi($id)
    {
        $item = PengajuanBarangJasaDisposisi::where('id', $id)->firstOrFail();
        return view('ppk.pages.pengajuan-pbj.print', [
            'title' => 'Cetak Disposisi',
            'item' => $item
        ]);
    }
}
