<?php

namespace App\Http\Controllers\Pengelolakeuangan;

use App\Http\Controllers\Controller;
use App\Models\FormNonPbj;
use App\Models\FormNonPbjDisposisi;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PermohonanBelanjaDisposisiController extends Controller
{
    public function index($id)
    {
        $data_karyawans = Karyawan::whereHas('user', function ($q) {
            $q->whereHas('roles', function ($role) {
                $role->where('name', 'Tim PPK');
            });
        })->latest()->get();
        $items = FormNonPbjDisposisi::where('id', $id)->latest()->get();
        return view('pengelola-keuangan.pages.permohonan-belanja-disposisi.index', [
            'title' => 'Permohonan Belanja Form Non PBJ',
            'items' => $items,
            'data_karyawans' => $data_karyawans,
        ]);
    }
    public function show($id)
    {
        $item = FormNonPbjDisposisi::where('id',$id)->firstOrFail();
        return view('pengelola-keuangan.pages.permohonan-belanja-disposisi.show', [
            'title' => 'Detail Permohonan Belanja Form Non PBJ',
            'item' => $item
        ]);
    }

    public function tanggapi($id)
    {
        request()->validate([
            'nominal' => ['required']
        ]);

        DB::beginTransaction();
        try {
            $form = FormNonPbj::where('id', $id)->firstOrFail();
            $form->uang_muka1()->create([
                'karyawan_id' => request('karyawan_id'),
                'nominal'=> request('nominal'),
            ]);
            $form->update(['status'=> 'Dikirim Ke TIM PPK']);
            DB::commit();
            return redirect()->route('bendahara-keuangan.permohonan-belanja.index')->with('success', 'Uang Muka berhasil disubmit.');
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return redirect()->route('bendahara-keuangan.permohonan-belanja.index')->with('error', $th->getMessage());
        }
    }
}
