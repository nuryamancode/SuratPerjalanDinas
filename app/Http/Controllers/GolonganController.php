<?php

namespace App\Http\Controllers;

use App\Models\Golongan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GolonganController extends Controller
{

    public function index()
    {
        $items = Golongan::orderBy('nama', 'ASC')->get();
        return view('pages.golongan.index', [
            'title' => 'Golongan',
            'items' => $items
        ]);
    }

    public function create()
    {
        return view('pages.golongan.create', [
            'title' => 'Tambah Golongan'
        ]);
    }

    public function store()
    {

        request()->validate([
            'nama' => ['required', 'unique:golongan,nama']
        ]);

        DB::beginTransaction();
        try {
            $data = request()->only(['nama']);
            Golongan::create($data);
            DB::commit();
            return redirect()->route('golongan.index')->with('success', 'Golongan berhasil ditambahkan.');
        } catch (\Throwable $th) {
            DB::rollBack();
            // throw $th;
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function edit($id)
    {
        $item = Golongan::findOrFail($id);
        return view('pages.golongan.edit', [
            'title' => 'Edit Golongan',
            'item' => $item
        ]);
    }

    public function update($id)
    {
        request()->validate([
            'nama' => ['required', 'unique:golongan,nama,' . $id . '']
        ]);

        DB::beginTransaction();
        try {
            $item = Golongan::findOrFail($id);
            $data = request()->only(['nama']);
            $item->update($data);
            DB::commit();
            return redirect()->route('golongan.index')->with('success', 'Golongan berhasil diupdate.');
        } catch (\Throwable $th) {
            DB::rollBack();
            // throw $th;
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function destroy($id)
    {

        DB::beginTransaction();
        try {
            $item = Golongan::findOrFail($id);
            $item->delete();
            DB::commit();
            return redirect()->route('golongan.index')->with('success', 'Golongan berhasil dihapus.');
        } catch (\Throwable $th) {
            DB::rollBack();
            // throw $th;
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
