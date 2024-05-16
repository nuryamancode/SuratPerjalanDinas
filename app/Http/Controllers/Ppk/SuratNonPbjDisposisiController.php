<?php

namespace App\Http\Controllers\Ppk;

use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use App\Models\PengajuanBarangJasa;
use App\Models\PengajuanBarangJasaDisposisi;
use App\Models\SuratNonPbj;
use App\Models\SuratNonPbjDisposisi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SuratNonPbjDisposisiController extends Controller
{
    public function index($id)
    {
        $items = SuratNonPbjDisposisi::where('id', $id)->latest()->get();
        return view('ppk.pages.surat-non-pbj-disposisi.index', [
            'title' => 'Pengajuan Surat Non PBJ Disposisi',
            'items' => $items,
        ]);
    }
    public function create($id)
    {
        $data_karyawan = Karyawan::orderBy('nama', 'ASC')->get();
        $data_karyawanrole = Karyawan::whereHas('user.roles', function ($query) {
            $query->whereIn('name', ['Bendahara Keuangan', 'Pengelola Keuangan']);
        })->get();
        $item = SuratNonPbjDisposisi::where('id', $id)->firstOrFail();
        return view('ppk.pages.surat-non-pbj-disposisi.create', [
            'title' => 'Pengajuan PBJ Disposisi',
            'item' => $item,
            'data_karyawan' => $data_karyawan,
            'data_karyawanrole' => $data_karyawanrole,
        ]);
    }

    public function store($id)
    {
        request()->validate([
            'tipe_disposisi' => ['required'],
        ]);
        DB::beginTransaction();
        try {
            $items = SuratNonPbjDisposisi::where('id', $id)->firstOrFail();
            $items->update([
                'tipe_disposisi_2' => request('tipe_disposisi'),
                'catatan_disposisi_2' => request('catatan_disposisi'),
                'teruskan_ke_2' => request('teruskan_ke'),
                'pembuat_disposisi_2' => auth()->user()->karyawan->id,
            ]);
            $items->surat_non_pbj()->update([
                'acc_ppk' => '1',
                'status_surat' => 'Menunggu Proses Belanja',
            ]);
            DB::commit();
            return redirect()->route('ppk.surat-non-pbj-disposisi.index', $items->id)->with('success', 'Disposisi berhasil ditambahkan');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function destroy($id)
    {
        $item = SuratNonPbjDisposisi::findOrFail($id);
        $item->delete();
        return redirect()->back()->with('success', 'Disposisi Berhasil Dihapus.');
    }
}
