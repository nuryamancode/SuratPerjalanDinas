<?php

namespace App\Http\Controllers\Timppk;

use App\Http\Controllers\Controller;
use App\Models\SuratNonPbj;
use Illuminate\Http\Request;

class SuratNonPbjController extends Controller
{
    public function index()
    {
        $items = SuratNonPbj::whereHas('uang_muka')->latest()->get();
        return view('timppk.pages.surat-non-pbj.index', [
            'title' => 'Surat Non PBJ',
            'items' => $items
        ]);
    }
}
