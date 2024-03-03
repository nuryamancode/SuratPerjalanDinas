<?php

namespace App\Http\Controllers;

use App\Models\Lampiran;
use Illuminate\Http\Request;

class LampiranController extends Controller
{
    public function destroy($uuid)
    {
        $item = Lampiran::where('uuid', $uuid)->firstOrFail();
        $item->delete();
        return redirect()->back()->with('success', 'Lampiran berhasil dihapus.');
    }
}
