<?php

namespace App\Http\Controllers;

use App\Models\SuratPerjalananDinas;
use App\Models\SuratPerjalananDinasDetail;
use App\Models\SuratPertanggungJawaban;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SuratPertanggungJawabanController extends Controller
{
    public function index()
    {
        $data = SuratPertanggungJawaban::with('spd_detail');
        // if (auth()->user()->getPermissions('Surat Perjalanan Dinas By Karyawan')) {
        //     $data->getByKaryawan();
        // }
        $items = $data->latest()->get();
        return view('pages.surat-pertanggung-jawaban.index', [
            'title' => 'Surat Pertanggung Jawaban Data',
            'items' => $items
        ]);
    }
    public function create()
    {
        $data_spd_detail = SuratPerjalananDinasDetail::latest();
        if (auth()->user()->getPermissions('Surat Pertanggung Jawaban By Karyawan')) {
            $data_spd_detail->getByKaryawan();
        }
        $data = $data_spd_detail->get();
        return view('pages.surat-pertanggung-jawaban.create', [
            'title' => 'Buat SPJ',
            'data_spd_detail' => $data
        ]);
    }

    public function store()
    {
        request()->validate([
            'draft' => ['required', 'mimes:pdf'],
            'spd_detail_id' => ['required']
        ]);

        DB::beginTransaction();
        try {
            $data_perincian_biaya = request('perincian_biaya');
            $data_nominal = request('nominal');
            $data_keterangan = request('keterangan');
            $data_file = request('file');
            // cek spj
            $cekSpj = SuratPertanggungJawaban::where('spd_detail_id', request('spd_detail_id'))->count();
            if ($cekSpj) {
                return redirect()->route('surat-pertanggung-jawaban.index')->with('error', 'Surat Pertanggung Jawaban sudah ada di database.');
            }
            $spj = SuratPertanggungJawaban::create([
                'uuid' => \Str::uuid(),
                'spd_detail_id' => request('spd_detail_id'),
                'file' => request()->file('draft')->store('spj', 'public'),
                'status' => 0
            ]);

            foreach ($data_perincian_biaya as $key => $perincian) {
                // harus ada isi
                if ($perincian && isset($data_nominal[$key]) && isset($data_file[$key])) {
                    $spj->details()->create([
                        'uuid' => \Str::uuid(),
                        'perincian_biaya' => $perincian,
                        'nominal' => $data_nominal[$key],
                        'keterangan' => $data_keterangan[$key],
                        'file' => $data_file[$key]->store('spj-detail', 'public')
                    ]);
                }
            }
            DB::commit();
            return redirect()->route('surat-pertanggung-jawaban.index')->with('success', 'Surat Pertanggung Jawaban Berhasil dibuat.');
        } catch (\Throwable $th) {
            throw $th;
            DB::rollBack();
            return redirect()->route('surat-pertanggung-jawaban.index')->with('error', $th->getMessage());
        }
    }

    public function edit($uuid)
    {
        $item = SuratPertanggungJawaban::where('uuid', $uuid)->firstOrFail();
        return view('pages.surat-pertanggung-jawaban.edit', [
            'title' => 'Buat SPJ',
            'item' => $item
        ]);
    }

    public function update($uuid)
    {
        request()->validate([
            'draft' => ['mimes:pdf']
        ]);

        DB::beginTransaction();
        try {
            $item = SuratPertanggungJawaban::where('uuid', $uuid)->firstOrFail();
            $data = [];
            if (request()->file('draft')) {
                Storage::disk('public')->delete($item->file);
                $data['file'] = request()->file('draft')->store('spj', 'public');
            }
            $item->update($data);
            DB::commit();
            return redirect()->route('surat-pertanggung-jawaban.index')->with('success', 'Surat Pertanggung Jawaban Berhasil diupdate.');
        } catch (\Throwable $th) {
            throw $th;
            DB::rollBack();
            return redirect()->route('surat-pertanggung-jawaban.index')->with('error', $th->getMessage());
        }
    }

    public function show($uuid)
    {
        $item = SuratPertanggungJawaban::where('uuid', $uuid)->firstOrFail();
        return view('pages.surat-pertanggung-jawaban.show', [
            'title' => 'Detail Surat Pertanggung Jawaban',
            'item' => $item
        ]);
    }

    public function destroy($uuid)
    {
        $item = SuratPertanggungJawaban::where('uuid', $uuid)->firstOrFail();
        if ($item->file)
            Storage::disk('public')->delete($item->file);
        foreach ($item->details as $detail) {
            Storage::disk('public')->delete($detail->file);
        }
        $item->delete();
        return redirect()->route('surat-pertanggung-jawaban.index')->with('success', 'Surat Pertanggung Jawaban Berhasil dihapus.');
    }

    public function verifikasi()
    {
        request()->validate([
            'status' => ['required']
        ]);

        DB::beginTransaction();
        try {
            $item = SuratPertanggungJawaban::where('uuid', request('uuid'))->firstOrFail();
            $item->update([
                'status' => request('status')
            ]);
            DB::commit();
            return redirect()->route('surat-pertanggung-jawaban.index')->with('success', 'Surat Pertanggung Jawaban Berhasil diupdate.');
        } catch (\Throwable $th) {
            throw $th;
            DB::rollBack();
            return redirect()->route('surat-pertanggung-jawaban.index')->with('error', $th->getMessage());
        }
    }
}
