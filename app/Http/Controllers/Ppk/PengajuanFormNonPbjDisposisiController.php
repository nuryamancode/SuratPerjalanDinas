<?php

namespace App\Http\Controllers\Ppk;

use App\Http\Controllers\Controller;
use App\Models\FormNonPbj;
use App\Models\FormNonPbjDisposisi;
use App\Models\Karyawan;
use App\Models\PengajuanBarangJasa;
use App\Models\PengajuanBarangJasaDisposisi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengajuanFormNonPbjDisposisiController extends Controller
{
    public function index($id)
    {
        $pengajuan = FormNonPbj::where('id', $id)->firstOrFail();
        $items = FormNonPbjDisposisi::where('form_non_pbj_id', $pengajuan->id)->latest()->get();
        return view('ppk.pages.form-non-pbj-disposisi.index', [
            'title' => 'Pengajuan Form Non PBJ Disposisi',
            'items' => $items,
            'pengajuan' => $pengajuan
        ]);
    }
    public function create($id)
    {
        $data_karyawan = Karyawan::whereHas('user', function ($q) {
            $q->whereHas('roles', function ($q) {
                $q->whereIn('name', ['Pengelola Keuangan', 'Bendahara Keuangan']);
            });
        })->get();
        $item = FormNonPbj::where('id', $id)->firstOrFail();
        return view('ppk.pages.form-non-pbj-disposisi.create', [
            'title' => 'Pengajuan PBJ Disposisi',
            'item' => $item,
            'data_karyawan' => $data_karyawan
        ]);
    }

    public function store($id)
    {
        request()->validate([
            'tipe_disposisi' => ['required'],
        ]);
        DB::beginTransaction();
        try {
            $items = FormNonPbj::where('id', $id)->firstOrFail();
            $diteruskan = request('teruskan_ke');
            $items->disposisi_form()->create([
                'no_surat' => request('no_surat'),
                'no_agenda' => request('no_agenda'),
                'perihal' => request('perihal'),
                'catatan_disposisi' => request('catatan_disposisi'),
                'tipe_disposisi' => request('tipe_disposisi'),
                'diteruskan_ke' => $diteruskan,
            ]);
            $karyawan = Karyawan::where('id', $diteruskan)->firstOrFail();
            if ($karyawan->jabatan->nama == 'Pengelola Keuangan') {
                $status = 'Pemeriksaan Pengelola Keuangan';
            } elseif ($karyawan->jabatan->nama == 'Bendahara Keuangan') {
                $status = 'Pemeriksaan Bendahara Keuangan';
            }
            $items->update([
                'acc_ppk' => 1,
                'status' => $status,
            ]);
            DB::commit();
            return redirect()->route('ppk.pengajuan-form-non-pbj-disposisi.index', $items->id)->with('success', 'Disposisi berhasil ditambahkan');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function destroy($id)
    {
        $item = PengajuanBarangJasaDisposisi::findOrFail($id);
        $item->delete();
        return redirect()->back()->with('success', 'Disposisi Berhasil Dihapus.');
    }
}
