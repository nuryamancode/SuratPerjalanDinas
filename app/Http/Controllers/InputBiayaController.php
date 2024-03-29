<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InputBiayaController extends Controller
{
    public function index()
    {
        $spd_detail_id = request('surat_perjalanan_dinas_detail_id');
    }
}
