<?php

namespace App\Http\Controllers\Wakildirekturii;

use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use App\Models\LampiranPBJ;
use App\Models\PengajuanBarangJasa;
use App\Models\PengajuanBarangJasaDisposisi;
use Illuminate\Http\Request;

class PengajuanPbjController extends Controller
{
    public function index()
    {
        $karyawan = Karyawan::where('user_id', auth()->user()->id)->first();
        $items = PengajuanBarangJasa::pbj()->where(function ($query) {
            $query->where('acc_wadir2', '0')
                ->orWhere('acc_wadir2', '1');
        })->orWhereHas('pengusul', function ($query) use ($karyawan) {
            $query->where('pengusul_id', $karyawan->id);
        })
        ->latest()->get();
        return view('wakil-direktur-ii.pages.pengajuan-pbj.index', [
            'title' => 'Pengajuan PBJ',
            'items' => $items
        ]);
    }


    public function show($id)
    {
        $item = PengajuanBarangJasa::pbj()->where('id', $id)->firstOrFail();
        $lampiran = LampiranPBJ::where('pbj_id', $item->id)->first();
        return view('wakil-direktur-ii.pages.pengajuan-pbj.show', [
            'title' => 'Detail Pengajuan PBJ',
            'item' => $item
        ]);
    }

    public function acc($id)
    {
    //     $item = PengajuanBarangJasa::pbj()->where('id', $id)->firstOrFail();
    //     $item->update([
    //         'acc_wadir2' => 1,
    //     ]);
    //     return redirect()->route('wakil-direktur-ii.pengajuan-pbj-disposisi.create', $item->id)->with('success', 'Pengajuan Barang Jasa Berhasil ditanggapi.');
    // }
    }

    public function tolak($id)
    {
        $item = PengajuanBarangJasa::pbj()->where('id', $id)->firstOrFail();
        $item->update([
            'acc_wadir2' => '2',
            'keterangan_wadir2' => request('keterangan'),
            'status_surat' => 'Persetujuan Ditolak',
        ]);
        return redirect()->back()->with('success', 'Pengajuan Barang Jasa Tidak Berhasil ditanggapi.');
    }

    public function verifikasi($id){
        $item = PengajuanBarangJasa::pbj()->where('id', $id)->firstOrFail();
        if (!auth()->user()->karyawan->tte_file) {
            return redirect()->route('wakil-direktur-ii.tte.index')->with('error','Silahkan upload terlebih dahulu TTE nya.');
        }
        if ($item->acc_wadir2 != '1') {
            return redirect()->back()->with('error','Anda belum menyetujui atau Disposisi kosong.');

        }
        $item->update([
            'verifikasi_wadir2'=> true,
        ]);
        return redirect()->back()->with('success', 'Pengajuan PBJ Berhasil diverifikasi.');
    }

    public function print_disposisi($id)
    {
        $item = PengajuanBarangJasa::where('id', $id)->firstOrFail();
        return view('wakil-direktur-ii.pages.pengajuan-pbj-disposisi.print', [
            'title' => 'Cetak Disposisi',
            'item' => $item
        ]);
    }
}
