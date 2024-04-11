<?php

namespace App\Http\Controllers;

use App\Models\PengajuanBarangJasa;
use App\Models\UangMukaBarangjasa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengajuanFormNonPbjUangMukaController extends Controller
{
    public function index()
    {
        if (request('pengajuan_form_non_pbj_id')) {
            $items = UangMukaBarangjasa::with('barang_jasa')->where('pengajuan_form_non_pbj_id', request('pengajuan_form_non_pbj_id'))->latest()->get();
        } else {
            $items = UangMukaBarangjasa::with('barang_jasa')->latest()->get();
        }
        $data_pengajuan_form_non_pbj = PengajuanBarangJasa::formNonPbj()->formNonPbjAccAll()->latest()->get();
        return view('pages.pengajuan-form-non-pbj-uang-muka.index', [
            'title' => 'Uang Muka',
            'items' => $items,
            'data_pengajuan_form_non_pbj' => $data_pengajuan_form_non_pbj
        ]);
    }

    public function create()
    {
        $data_pengajuan_form_non_pbj = PengajuanBarangJasa::formNonPbj()->formNonPbjAccAll()->latest()->get();
        return view('pages.pengajuan-form-non-pbj-uang-muka.create', [
            'title' => 'Tambah Uang Muka',
            'data_pengajuan_form_non_pbj' => $data_pengajuan_form_non_pbj
        ]);
    }

    public function store()
    {
        request()->validate([
            'pengajuan_barang_jasa_id' => ['required'],
            'nominal' => ['required']
        ]);

        DB::beginTransaction();
        try {
            $data = request()->only(['pengajuan_barang_jasa_id', 'nominal']);
            // cek uang muka
            $cek = UangMukaBarangjasa::where('pengajuan_barang_jasa_id', request('pengajuan_barang_jasa_id'))->count();
            if ($cek > 0) {
                return redirect()->back()->with('error', 'Uang Muka sebelumnya sudah didistribusikan.');
            }
            UangMukaBarangjasa::create($data);
            DB::commit();
            return redirect()->route('pengajuan-form-non-pbj.uang-muka.index')->with('success', 'Uang Muka berhasil ditambahkan.');
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return redirect()->route('pengajuan-form-non-pbj.uang-muka.index')->with('error', $th->getMessage());
        }
    }

    public function edit($id)
    {
        $item = UangMukaBarangjasa::findOrFail($id);
        return view('pages.pengajuan-form-non-pbj-uang-muka.edit', [
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
            $item = UangMukaBarangjasa::findOrFail($id);
            $data = request()->only(['nominal']);
            $item->update($data);
            DB::commit();
            return redirect()->route('pengajuan-form-non-pbj.uang-muka.index')->with('success', 'Uang Muka berhasil diupdate.');
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return redirect()->route('pengajuan-form-non-pbj.uang-muka.index')->with('error', $th->getMessage());
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $item = UangMukaBarangjasa::findOrFail($id);
            $item->delete();
            DB::commit();
            return redirect()->route('pengajuan-form-non-pbj.uang-muka.index')->with('success', 'Uang Muka berhasil dihapus.');
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return redirect()->route('pengajuan-form-non-pbj.uang-muka.index')->with('error', $th->getMessage());
        }
    }
}
