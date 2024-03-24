<?php

namespace App\Http\Controllers;

use App\Models\Disposisi;
use App\Models\DisposisiDetail;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DisposisiDetailController extends Controller
{
    public function index()
    {
        $disposisi_id = request('disposisi_id');
        $disposisi = Disposisi::findOrFail($disposisi_id);
        $items = DisposisiDetail::where('disposisi_id', $disposisi_id)->get();
        return view('pages.disposisi-detail.index', [
            'title' => 'Detail Disposisi Surat Perjalanan Dinas',
            'items' => $items,
            'disposisi' => $disposisi
        ]);
    }

    public function create()
    {
        $disposisi_id = request('disposisi_id');
        $disposisi = Disposisi::findOrFail($disposisi_id);
        $data_karyawan = Karyawan::orderBy('nama', 'ASC')->get();
        return view('pages.disposisi-detail.create', [
            'title' => 'Disposisi Surat Perjalanan Dinas',
            'disposisi' => $disposisi,
            'data_karyawan' => $data_karyawan
        ]);
    }

    public function store()
    {
        request()->validate([
            'tujuan_karyawan_id' => ['required']
        ]);
        DB::beginTransaction();
        try {
            $disposisi_id = request('disposisi_id');
            $disposisi = Disposisi::findOrFail($disposisi_id);
            // create
            $disposisi->details()->create([
                'tujuan_karyawan_id' => request('tujuan_karyawan_id'),
                'catatan' => request('catatan'),
                'pembuat_karyawan_id' => auth()->user()->karyawan->id,
            ]);
            DB::commit();
            return redirect()->route('disposisi-detail.index', [
                'disposisi_id' => $disposisi->id
            ])->with('success', 'Disposisi Surat Perjalan Dinas Berhasi Dibuat');
        } catch (\Throwable $th) {
            throw $th;
            DB::rollBack();
            return redirect()->route('disposisi.index', [
                'disposisi_id' => $disposisi->id
            ])->with('error', $th->getMessage());
        }
    }

    public function edit($id)
    {
        $item = DisposisiDetail::findOrFail($id);
        return view('pages.disposisi-detail.edit', [
            'title' => 'Disposisi Surat Perjalanan Dinas',
            'item' => $item
        ]);
    }

    public function update($id)
    {
        $item = DisposisiDetail::findOrFail($id);
        $item->update([
            'catatan' => request('catatan')
        ]);

        return redirect()->route('disposisi-detail.index', [
            'disposisi_id' => $item->disposisi->id
        ])->with('success', 'Disposisi Surat Perjalan Dinas Berhasi Diupdate');
    }

    public function destroy($id)
    {
        $item = DisposisiDetail::findOrFail($id);
        $disposisi_id = $item->disposisi_id;
        $item->delete();

        return redirect()->route('disposisi-detail.index', [
            'disposisi_id' => $disposisi_id
        ])->with('success', 'Disposisi Surat Perjalan Dinas Berhasi Dihapus');
    }
}
