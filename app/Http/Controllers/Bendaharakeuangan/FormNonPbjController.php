<?php

namespace App\Http\Controllers\Bendaharakeuangan;

use App\Http\Controllers\Controller;
use App\Models\FormNonPbj;
use Illuminate\Http\Request;

class FormNonPbjController extends Controller
{
    public function index()
    {
        $items = FormNonPbj::with('uang_muka1')->latest()->get();
        return view('bendahara-keuangan.pages.form-non-pbj.index', [
            'title' => 'Pengajuan Form Non PBJ',
            'items' => $items
        ]);
    }

    public function arsip($uuid)
    {
        $item = FormNonPbj::where('uuid', $uuid)->firstOrFaiL();
        $item->update([
            'is_arsip' => 1
        ]);

        return redirect()->back()->with('success', 'Form Non PBJ berhasil diarsipkan.');
    }
}
