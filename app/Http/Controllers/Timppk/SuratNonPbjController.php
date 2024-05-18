<?php

namespace App\Http\Controllers\Timppk;

use App\Http\Controllers\Controller;
use App\Models\SuratNonPbj;
use App\Models\SuratNonPbjUangMuka;
use Illuminate\Http\Request;

class SuratNonPbjController extends Controller
{
    public function index()
    {
        $items = SuratNonPbjUangMuka::where('karyawan_id', auth()->user()->karyawan->id)->latest()->get();
        return view('timppk.pages.surat-non-pbj.index', [
            'title' => 'Surat Non PBJ',
            'items' => $items
        ]);
    }

    public function show($id){
        $item = SuratNonPbjUangMuka::where('id', $id)->firstOrFail();
        return view('timppk.pages.surat-non-pbj.show', [
            'title' => 'Detail Surat Non PBJ',
            'item' => $item
        ]);
    }
}
