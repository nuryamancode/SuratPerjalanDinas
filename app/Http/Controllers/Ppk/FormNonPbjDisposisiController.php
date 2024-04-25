<?php

namespace App\Http\Controllers\Ppk;

use App\Http\Controllers\Controller;
use App\Models\FormNonPbj;
use App\Models\FormNonPbjDisposisi;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FormNonPbjDisposisiController extends Controller
{
    public function index($uuid)
    {
        $formNonPbj = FormNonPbj::where('uuid', $uuid)->firstOrFail();
        $items = FormNonPbjDisposisi::where('form_non_pbj_id', $formNonPbj->id)->latest()->get();
        return view('ppk.pages.form-non-pbj-disposisi.index', [
            'title' => 'Pengajuan Form Non PBJ Disposisi',
            'items' => $items,
            'formNonPbj' => $formNonPbj
        ]);
    }
    public function create($uuid)
    {
        $data_karyawan = Karyawan::orderBy('nama', 'ASC')->get();
        $item = FormNonPbj::where('uuid', $uuid)->firstOrFail();
        return view('ppk.pages.form-non-pbj-disposisi.create', [
            'title' => 'Pengajuan PBJ Disposisi',
            'item' => $item,
            'data_karyawan' => $data_karyawan
        ]);
    }

    public function store($pengajuan_uuid)
    {
        request()->validate([
            'tujuan_karyawan_id' => ['required'],
        ]);

        DB::beginTransaction();
        try {
            $pengajuan  = FormNonPbj::where('uuid', $pengajuan_uuid)->firstOrFail();
            $pengajuan->disposisis()->create([
                'uuid' => \Str::uuid(),
                'pembuat_karyawan_id' => auth()->user()->karyawan->id,
                'tujuan_karyawan_id' => request('tujuan_karyawan_id'),
                'tipe' => request('tipe'),
                'catatan' => request('catatan'),
                'nomor_agenda' => request('nomor_agenda'),
                'perihal' => request('perihal'),
            ]);

            DB::commit();
            return redirect()->route('ppk.form-non-pbj-disposisi.index', $pengajuan->uuid)->with('success', 'Disposisi Berhasil disimpan.');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function destroy($id)
    {
        $item = FormNonPbjDisposisi::findOrFail($id);
        $item->delete();
        return redirect()->back()->with('success', 'Disposisi Berhasil Dihapus.');
    }
}
