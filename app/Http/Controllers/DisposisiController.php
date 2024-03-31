<?php

namespace App\Http\Controllers;

use App\Models\Disposisi;
use App\Models\Karyawan;
use App\Models\SuratPerjalananDinas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DisposisiController extends Controller
{
    public function index($id)
    {
        $item = SuratPerjalananDinas::findOrFail($id);
        $data_karyawan = Karyawan::orderBy('nama', 'ASC')->get();
        return view('pages.disposisi.index', [
            'title' => 'Disposisi Surat Perjalanan Dinas',
            'item' => $item,
            'data_karyawan' => $data_karyawan
        ]);
    }
    public function store($id)
    {
        request()->validate([
            'tujuan_karyawan_id' => ['required'],
            'tipe' => ['required']
        ]);
        DB::beginTransaction();
        try {
            $item = SuratPerjalananDinas::findOrFail($id);
            $item->disposisi->update([
                'acc_tujuan_karyawan_id' => 1
            ]);
            $item->disposisi()->create([
                'tujuan_karyawan_id' => request('tujuan_karyawan_id'),
                'tipe' => request('tipe'),
                'pembuat_karyawan_id' => auth()->user()->karyawan->id,
                'catatan' => request('catatan')
            ]);
            DB::commit();
            return redirect()->route('permohonan-surat-perjalanan-dinas.index',)->with('success', 'Disposisi Surat Perjalan Dinas Berhasi Diupdate');
        } catch (\Throwable $th) {
            throw $th;
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function acc()
    {
        $item = SuratPerjalananDinas::findOrFail(request('surat_perjalanan_dinas_id'));
        $item->disposisi()->update([
            'acc_tujuan_karyawan_id' => request('status')
        ]);

        return redirect()->back()->with('success', 'Persetujuan berhasil diupdate.');
    }
}
