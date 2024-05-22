<?php

namespace App\Http\Controllers\Bendaharakeuangan;

use App\Http\Controllers\Controller;
use App\Models\FormNonPbj;
use App\Models\PengajuanBarangJasa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengajuanFormNonPbjController extends Controller
{
    public function index()
    {
        $items = FormNonPbj::where('pengusul_karyawan_id' , auth()->user()->karyawan->id)->latest()->get();
        return view('bendahara-keuangan.pages.pengajuan-form-non-pbj.index', [
            'title' => 'Pengajuan Form Non PBJ',
            'items' => $items
        ]);
    }

    public function create(){
        return view('bendahara-keuangan.pages.pengajuan-form-non-pbj.create', [
            'title'=> 'Pengajuan Form Non PBJ'
        ]);
    }
    public function store()
    {
        request()->validate([
            'form_file' => ['required', 'file', 'mimes:pdf'],
        ]);

        DB::beginTransaction();
        try {
            if (request()->file('form_file')) {
                $formulir = request()->file('form_file')->store('formulir_non_pbj', 'public');
            }
            $item  = FormNonPbj::create([
                'file'=> $formulir,
                'pengusul_karyawan_id'=> auth()->user()->karyawan->id,
                'status'=> 'Pemeriksaan PPK'
            ]);

            DB::commit();
            return redirect()->route('bendahara-keuangan.pengajuan-form-non-pbj.index', $item->id)->with('success', 'Pengajuan Form Non PBJ berhasil ditambahkan.');
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }


    public function show($id)
    {
        $item = FormNonPbj::where('id', $id)->firstOrFail();
        return view('bendahara-keuangan.pages.pengajuan-form-non-pbj.show', [
            'title' => 'Detail Pengajuan Form Non PBJ',
            'item' => $item
        ]);
    }
}
