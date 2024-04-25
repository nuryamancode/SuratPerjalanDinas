<?php

namespace App\Http\Controllers\Timppk;

use App\Http\Controllers\Controller;
use App\Models\FormNonPbj;
use Illuminate\Http\Request;

class FormNonPbjController extends Controller
{
    public function index()
    {
        $items = FormNonPbj::with('uang_muka1')->whereHas('uang_muka1', function ($q) {
            $q->where('karyawan_id', auth()->user()->karyawan->id);
        })->latest()->get();
        return view('timppk.pages.form-non-pbj.index', [
            'title' => 'Pengajuan Form Non PBJ',
            'items' => $items
        ]);
    }
}
