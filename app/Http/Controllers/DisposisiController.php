<?php

namespace App\Http\Controllers;

use App\Models\Disposisi;
use App\Models\SuratPerjalananDinas;
use Illuminate\Http\Request;

class DisposisiController extends Controller
{
    public function index($surat_perjalanan_dinas_id)
    {
        $spd = SuratPerjalananDinas::with('disposisi')->findOrFail($surat_perjalanan_dinas_id);
        return view('pages.disposisi.index', [
            'title' => 'Disposisi',
            'spd' => $spd
        ]);
    }

    public function store()
    {
        request()->validate([
            'surat_perjalanan_dinas_id' => ['required']
        ]);

        $data = request()->only(['surat_perjalanan_dinas_id', 'catatan']);
        Disposisi::create([
            'surat_perjalanan_dinas_id' => request('surat_perjalanan_dinas_id'),
            'catatan' => request('catatan')
        ]);

        return redirect()->back()->with('success', 'Disposisi berhasil dibuat');
    }
}
