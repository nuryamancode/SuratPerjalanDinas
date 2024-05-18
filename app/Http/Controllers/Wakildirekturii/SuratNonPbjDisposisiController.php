<?php

namespace App\Http\Controllers\Wakildirekturii;

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
        $pengajuan = SuratNonPbj::where('id', $id)->firstOrFail();
        $items = SuratNonPbjDisposisi::where('snpbj_id', $pengajuan->id)->latest()->get();
        return view('wakil-direktur-ii.pages.surat-non-pbj-disposisi.index', [
            'title' => 'Pengajuan Surat Non PBJ Disposisi',
            'items' => $items,
            'pengajuan' => $pengajuan
        ]);
    }
    public function create($id)
    {
        $data_karyawan = Karyawan::whereHas('user', function ($q) {
            $q->whereHas('roles', function ($role) {
                $role->whereIn('name', [ 'Kepala Bagian', 'Wakil Direktur I']);
            });
        })->orderBy('nama', 'ASC')->get();
        $role = 'Pejabat Pembuat Komitmen';
        $data_karyawans = Karyawan::whereHas('user.roles', function ($query) use ($role) {
            $query->where('name', $role);
        })->get();
        $item = SuratNonPbj::where('id', $id)->firstOrFail();
        return view('wakil-direktur-ii.pages.surat-non-pbj-disposisi.create', [
            'title' => 'Pengajuan Surat Non PBJ Disposisi',
            'item' => $item,
            'data_karyawan' => $data_karyawan,
            'data_karyawans' => $data_karyawans,
        ]);
    }

    public function store($id)
    {

        DB::beginTransaction();
        try {
            $pengajuan  = SuratNonPbj::where('id', $id)->firstOrFail();
            $teruskan = request('teruskan_ke');
            $pengajuan->disposisi_snpbj()->create([
                'pbj_id' => $pengajuan->id,
                'catatan_disposisi_1' => request('catatan_disposisi_1'),
                'tipe_disposisi_1' => request('tipe_disposisi_1'),
                'teruskan_ke_1' => $teruskan,
                'pembuat_disposisi_1' => auth()->user()->karyawan->id,
            ]);
            $karyawan = Karyawan::where('id', $teruskan)->firstOrFail();
            if ($karyawan->jabatan->nama == 'Pejabat Pembuat Komitmen') {
                $jabatan = 'Menunggu Persetujuan PPK';
            }elseif ($karyawan->jabatan->nama == 'Kepala Bagian') {
                $jabatan = 'Menunggu Proses Taksiran';
            }elseif ($karyawan->jabatan->nama == 'Wakil Direktur I') {
                $jabatan = 'Menunggu Proses Taksiran';
            }
            $pengajuan->update([
                'status_surat' => $jabatan,
                'acc_wadir2' => '1',
            ]);
            DB::commit();
            return redirect()->route('wakil-direktur-ii.surat-non-pbj-disposisi.index', $pengajuan->id)->with('success', 'Disposisi Berhasil disimpan.');
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function edit($id)
    {
        $data_karyawan = Karyawan::whereHas('user', function ($q) {
            $q->whereHas('roles', function ($role) {
                $role->whereIn('name', [ 'Kepala Bagian', 'Wakil Direktur I']);
            });
        })->orderBy('nama', 'ASC')->get();
        $role = 'Pejabat Pembuat Komitmen';
        $data_karyawans = Karyawan::whereHas('user.roles', function ($query) use ($role) {
            $query->where('name', $role);
        })->get();
        $item = SuratNonPbjDisposisi::where('id', $id)->firstOrFail();
        return view('wakil-direktur-ii.pages.surat-non-pbj-disposisi.edit', [
            'title' => 'Pengajuan Surat Non PBJ Disposisi',
            'item' => $item,
            'data_karyawan' => $data_karyawan,
            'data_karyawans' => $data_karyawans,
        ]);
    }

    public function update($id)
    {
        request()->validate([
            'teruskan_ke' => ['required'],
        ]);

        DB::beginTransaction();
        try {
            $pengajuan  = SuratNonPbj::where('id', $id)->firstOrFail();
            $teruskan = request('teruskan_ke');
            $pengajuan->disposisi_snpbj()->update([
                'snpbj_id' => $pengajuan->id,
                'catatan_disposisi_1' => request('catatan_disposisi_1'),
                'tipe_disposisi_1' => request('tipe_disposisi_1'),
                'teruskan_ke_1' => $teruskan,
                'pembuat_disposisi_1' => auth()->user()->karyawan->id,
            ]);
            $karyawan = Karyawan::where('id', $teruskan)->firstOrFail();
            if ($karyawan->jabatan->nama == 'Pejabat Pembuat Komitmen') {
                $jabatan = 'Menunggu Persetujuan PPK';
            }elseif ($karyawan->jabatan->nama == 'Kepala Bagian') {
                $jabatan = 'Menunggu Proses Taksiran';
            }elseif ($karyawan->jabatan->nama == 'Wakil Direktur I') {
                $jabatan = 'Menunggu Proses Taksiran';
            }
            $pengajuan->update([
                'status_surat' => $jabatan,
                'acc_wadir2' => '1',
            ]);
            DB::commit();
            return redirect()->route('wakil-direktur-ii.surat-non-pbj-disposisi.index', $pengajuan->id)->with('success', 'Disposisi Berhasil disimpan.');
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
