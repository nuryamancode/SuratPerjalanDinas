<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TTEController extends Controller
{
    public function index()
    {
        return view('pages.tte.edit', [
            'title' => 'Edit Data'
        ]);
    }

    public function update()
    {
        request()->validate([
            'tte_file' => ['required', 'max:2048', 'mimes:png']
        ]);

        auth()->user()->karyawan()->update([
            'tte_file' => request()->file('tte_file')->store('tte', 'public')
        ]);

        return redirect()->back()->with('success', 'TTE berhasil diupdate.');
    }

    public function destroy()
    {
        if (auth()->user()->karyawan->tte_file) {
            Storage::disk('public')->delete(auth()->user()->karyawan->tte_file);
        }
        auth()->user()->karyawan()->update([
            'tte_file' => NULL
        ]);

        return redirect()->route('tte.index')->with('success', 'TTE berhasil dihapus.');
    }
}
