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
        $pengajuan = PengajuanBarangJasa::where('id', $id)->firstOrFail();
        $items = PengajuanBarangJasaDisposisi::where('pbj_id', $pengajuan->id)->latest()->get();
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
        $item = PengajuanBarangJasa::where('id', $id)->firstOrFail();
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
            $pengajuan  = PengajuanBarangJasa::suratNonPbj()->where('id', $id)->firstOrFail();
            $teruskan = request('teruskan_ke');
            $data = request()->only(['catatan_disposisi_1', 'tipe_disposisi_1', 'teruskan_ke_1',]);
            $data['pembuat_disposisi_1'] = auth()->user()->karyawan->id;
            $data['pbj_id'] = $pengajuan
            ->id;
            $data['teruskan_ke_1'] = $teruskan;
            PengajuanBarangJasaDisposisi::create($data);
            $karyawan = Karyawan::where('id', $teruskan)->firstOrFail();
            if ($karyawan->jabatan->nama == 'Pejabat Pembuat Komitmen') {
                $jabatan = 'Menunggu Persetujuan PPK';
            }elseif ($karyawan->jabatan->nama == 'Kepala Bagian') {
                $jabatan = 'Menunggu Persetujuan Kepala Bagian';
            }elseif ($karyawan->jabatan->nama == 'Wakil Direktur I') {
                $jabatan = 'Menunggu Persetujuan Wakil Direktur I';
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
