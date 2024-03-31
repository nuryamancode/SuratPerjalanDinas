<?php

namespace App\Http\Controllers;

use App\Models\SuratPerjalananDinas;
use App\Models\UangMuka;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UangMukaController extends Controller
{
    public function index()
    {
        if (request('surat_perjalanan_dinas_id')) {
            $items = UangMuka::where('surat_perjalanan_dinas_id', request('surat_perjalanan_dinas_id'))->latest()->get();
        } else {
            $items = UangMuka::latest()->get();
        }
        $data_surat_perjalanan_dinas = SuratPerjalananDinas::acc()->latest()->get();
        return view('pages.uang-muka.index', [
            'title' => 'Uang Muka',
            'items' => $items,
            'data_surat_perjalanan_dinas' => $data_surat_perjalanan_dinas
        ]);
    }

    public function create()
    {
        $data_surat_perjalanan_dinas = SuratPerjalananDinas::acc()->latest()->get();
        return view('pages.uang-muka.create', [
            'title' => 'Tambah Uang Muka',
            'data_surat_perjalanan_dinas' => $data_surat_perjalanan_dinas
        ]);
    }

    public function store()
    {
        request()->validate([
            'surat_perjalanan_dinas_id' => ['required'],
            'nominal' => ['required']
        ]);

        DB::beginTransaction();
        try {
            $data = request()->only(['surat_perjalanan_dinas_id', 'nominal']);
            // cek uang muka
            $cek = UangMuka::where('surat_perjalanan_dinas_id', request('surat_perjalanan_dinas_id'))->count();
            if ($cek > 0) {
                return redirect()->back()->with('error', 'Uang Muka sebelumnya sudah didistribusikan.');
            }
            UangMuka::create($data);
            DB::commit();
            return redirect()->route('uang-muka.index')->with('success', 'Uang Muka berhasil ditambahkan.');
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return redirect()->route('uang-muka.index')->with('error', $th->getMessage());
        }
    }

    public function edit($id)
    {
        $item = UangMuka::findOrFail($id);
        return view('pages.uang-muka.edit', [
            'title' => 'Tambah Uang Muka',
            'item' => $item
        ]);
    }


    public function update($id)
    {
        request()->validate([
            'nominal' => ['required']
        ]);

        DB::beginTransaction();
        try {
            $item = UangMuka::findOrFail($id);
            $data = request()->only(['nominal']);
            $item->update($data);
            DB::commit();
            return redirect()->route('uang-muka.index')->with('success', 'Uang Muka berhasil diupdate.');
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return redirect()->route('uang-muka.index')->with('error', $th->getMessage());
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $item = UangMuka::findOrFail($id);
            $item->delete();
            DB::commit();
            return redirect()->route('uang-muka.index')->with('success', 'Uang Muka berhasil dihapus.');
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return redirect()->route('uang-muka.index')->with('error', $th->getMessage());
        }
    }
}
