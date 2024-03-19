<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Surat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class SuratController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:Surat Index')->only('index');
        $this->middleware('can:Surat Create')->only(['create', 'store']);
        $this->middleware('can:Surat Edit')->only(['edit', 'update']);
        $this->middleware('can:Surat Delete')->only('destroy');
    }

    public function index()
    {
        $items = Surat::latest()->get();
        return view('pages.surat.index', [
            'title' => 'Surat',
            'items' => $items
        ]);
    }

    public function create()
    {
        return view('pages.surat.create', [
            'title' => 'Tambah Surat',
            'data_karyawan' => Karyawan::orderBy('nama', 'ASC')->get()
        ]);
    }

    public function store()
    {
        request()->validate([
            'nomor_surat' => ['required', 'unique:surat,nomor_surat'],
            'perihal' => ['required'],
            'file' => ['required', 'mimes:pdf', 'max:2048'],
            'lampiran.*' => 'mimes:pdf|max:2048',
            'pelaksana' => ['required', 'array'],
        ]);

        DB::beginTransaction();
        try {
            $data = request()->only(['nomor_surat', 'perihal']);
            $data['file'] = request()->file('file')->store('surat', 'public');
            $data_lampiran = request()->file('lampiran');
            $data_pelaksana = request('pelaksana');
            $data['uuid'] = \Str::uuid();
            $data['pembuat_user_id'] = auth()->id();
            $data['status'] = 'Belum Didisposisikan';
            $data['jenis_surat'] = 'tugas';
            $surat  = Surat::create($data);

            // create lampiran
            if (!empty($data_lampiran)) {
                foreach ($data_lampiran as $lampiran) {
                    $surat->lampiran()->create([
                        'uuid' => \Str::uuid(),
                        'file' => $lampiran->store('surat-lampiran', 'public')
                    ]);
                }
            }

            // create pelaksana
            if (!empty($data_pelaksana)) {
                foreach ($data_pelaksana as $pelaksana) {
                    $surat->pelaksana()->create([
                        'uuid' => \Str::uuid(),
                        'karyawan_id' => $pelaksana
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('surat.index')->with('success', 'Surat berhasil ditambahkan.');
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function show($uuid)
    {
        $item = Surat::where('uuid', $uuid)->firstOrFail();
        return view('pages.surat.show', [
            'title' => 'Detail Surat',
            'item' => $item
        ]);
    }

    public function edit($uuid)
    {
        $item = Surat::where('uuid', $uuid)->firstOrFail();
        return view('pages.surat.edit', [
            'title' => 'Edit Surat',
            'item' => $item,
            'data_karyawan' => Karyawan::orderBy('nama', 'ASC')->get(),
            'selectedKaryawan' => $item->pelaksana->pluck('karyawan.id')->toArray()
        ]);
    }

    public function update($uuid)
    {
        request()->validate([
            'nomor_surat' => 'required|unique:surat,nomor_surat,' . $uuid . ',uuid',
            'perihal' => ['required'],
            'file' => ['mimes:pdf', 'max:2048'],
            'lampiran.*' => 'mimes:pdf|max:2048',
            'pelaksana' => ['required', 'array'],
        ]);

        DB::beginTransaction();
        try {
            $data = request()->only(['nomor_surat', 'perihal']);
            $item = Surat::where('uuid', $uuid)->firstOrFail();
            if (request()->file('file')) {
                if ($item->file)
                    Storage::disk('public')->delete($item->file);
                $data['file'] = request()->file('file')->store('surat', 'public');
            }
            $data_lampiran = request()->file('lampiran');
            $data_pelaksana = request('pelaksana');
            $item->update($data);

            // create lampiran
            if (!empty($data_lampiran)) {
                foreach ($data_lampiran as $lampiran) {
                    $item->lampiran()->create([
                        'uuid' => \Str::uuid(),
                        'file' => $lampiran->store('surat-lampiran', 'public')
                    ]);
                }
            }

            // create pelaksana
            if (!empty($data_pelaksana)) {
                // hapus pelaksana
                $item->pelaksana()->delete();
                foreach ($data_pelaksana as $pelaksana) {
                    $item->pelaksana()->create([
                        'uuid' => \Str::uuid(),
                        'karyawan_id' => $pelaksana
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('surat.index')->with('success', 'Surat berhasil diupdate.');
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function destroy($uuid)
    {

        DB::beginTransaction();
        try {
            $item = Surat::where('uuid', $uuid);
            $item->delete();
            DB::commit();
            return redirect()->route('surat.index')->with('success', 'Surat berhasil dihapus.');
        } catch (\Throwable $th) {
            DB::rollBack();
            // throw $th;
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function detail()
    {
        if (request()->ajax()) {
            $surat = Surat::find(request('surat_id'));
            return response()->json($surat);
        }
    }
}
