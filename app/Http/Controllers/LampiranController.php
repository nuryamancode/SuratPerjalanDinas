<?php

namespace App\Http\Controllers;

use App\Models\Lampiran;
use Illuminate\Http\Request;

class LampiranController extends Controller
{
    public function destroy($uuid)
    {
        $item = Lampiran::where('id', $uuid)->firstOrFail();
        $item->delete();
        return redirect()->back()->with('success', 'Lampiran berhasil dihapus.');
    }
}
