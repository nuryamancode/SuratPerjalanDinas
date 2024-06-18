<?php

namespace App\Http\Controllers\Wakildirekturii;

use App\Http\Controllers\Controller;
use App\Models\FormNonPbj;
use App\Models\PengajuanBarangJasa;
use App\Models\SuratNonPbj;
use App\Models\SuratPerjalananDinas;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function spd()
    {

        $query = SuratPerjalananDinas::query();

        // Filter berdasarkan bulan
        $filterbulan = request('filter_bulan');
        if ($filterbulan) {
            $query->whereMonth('created_at', $filterbulan);
        }

        // Filter berdasarkan tanggal masuk
        $filterTanggalMasuk = request('filter_tanggal_masuk');
        if ($filterTanggalMasuk) {
            $query->whereDate('created_at', '>=', $filterTanggalMasuk);
        }

        // Filter berdasarkan tanggal selesai
        $filterTanggalSelesai = request('filter_tanggal_selesai');
        if ($filterTanggalSelesai) {
            $query->whereDate('updated_at', '<=', $filterTanggalSelesai);
        }

        $spd = $query->latest()->get();
        $data = [
            'title' => 'Laporan Surat Perjalanan Dinas',
            'spd' => $spd,
            'filterbulan' => $filterbulan,
            'filterTanggalMasuk' => $filterTanggalMasuk,
            'filterTanggalSelesai' => $filterTanggalSelesai,
        ];

        return view('wakil-direktur-ii.pages.laporan.laporan-spd', $data);
    }


    public function form()
    {

        $query = FormNonPbj::query();

        // Filter berdasarkan bulan
        $filterbulan = request('filter_bulan');
        if ($filterbulan) {
            $query->whereMonth('created_at', $filterbulan);
        }

        // Filter berdasarkan tanggal masuk
        $filterTanggalMasuk = request('filter_tanggal_masuk');
        if ($filterTanggalMasuk) {
            $query->whereDate('created_at', '>=', $filterTanggalMasuk);
        }

        // Filter berdasarkan tanggal selesai
        $filterTanggalSelesai = request('filter_tanggal_selesai');
        if ($filterTanggalSelesai) {
            $query->whereDate('updated_at', '<=', $filterTanggalSelesai);
        }

        $spd = $query->latest()->get();
        $data = [
            'title' => 'Laporan Non PBJ Formulir',
            'spd' => $spd,
            'filterbulan' => $filterbulan,
            'filterTanggalMasuk' => $filterTanggalMasuk,
            'filterTanggalSelesai' => $filterTanggalSelesai,
        ];

        return view('wakil-direktur-ii.pages.laporan.laporan-form', $data);
    }
    public function surat()
    {

        $query = SuratNonPbj::query();

        // Filter berdasarkan bulan
        $filterbulan = request('filter_bulan');
        if ($filterbulan) {
            $query->whereMonth('created_at', $filterbulan);
        }

        // Filter berdasarkan tanggal masuk
        $filterTanggalMasuk = request('filter_tanggal_masuk');
        if ($filterTanggalMasuk) {
            $query->whereDate('created_at', '>=', $filterTanggalMasuk);
        }

        // Filter berdasarkan tanggal selesai
        $filterTanggalSelesai = request('filter_tanggal_selesai');
        if ($filterTanggalSelesai) {
            $query->whereDate('updated_at', '<=', $filterTanggalSelesai);
        }

        $spd = $query->latest()->get();
        $data = [
            'title' => 'Laporan Non PBJ Surat',
            'spd' => $spd,
            'filterbulan' => $filterbulan,
            'filterTanggalMasuk' => $filterTanggalMasuk,
            'filterTanggalSelesai' => $filterTanggalSelesai,
        ];

        return view('wakil-direktur-ii.pages.laporan.laporan-surat', $data);
    }
    public function pbj()
    {

        $query = PengajuanBarangJasa::query();

        // Filter berdasarkan bulan
        $filterbulan = request('filter_bulan');
        if ($filterbulan) {
            $query->whereMonth('created_at', $filterbulan);
        }

        // Filter berdasarkan tanggal masuk
        $filterTanggalMasuk = request('filter_tanggal_masuk');
        if ($filterTanggalMasuk) {
            $query->whereDate('created_at', '>=', $filterTanggalMasuk);
        }

        // Filter berdasarkan tanggal selesai
        $filterTanggalSelesai = request('filter_tanggal_selesai');
        if ($filterTanggalSelesai) {
            $query->whereDate('updated_at', '<=', $filterTanggalSelesai);
        }

        $spd = $query->latest()->get();
        $data = [
            'title' => 'Laporan PBJ',
            'spd' => $spd,
            'filterbulan' => $filterbulan,
            'filterTanggalMasuk' => $filterTanggalMasuk,
            'filterTanggalSelesai' => $filterTanggalSelesai,
        ];

        return view('wakil-direktur-ii.pages.laporan.laporan-pbj', $data);
    }


    public function show_spd($id)
    {
        $item = SuratPerjalananDinas::find($id);
        $data = [
            'title' => 'Detail Laporan Surat Perjalanan Dinas',
            'item' => $item,
        ];
        return view('wakil-direktur-ii.pages.laporan.show-spd', $data);
    }
    public function show_form($id)
    {
        $item = FormNonPbj::find($id);
        $data = [
            'title' => 'Detail Laporan Non PBJ Formulir',
            'item' => $item,
        ];
        return view('wakil-direktur-ii.pages.laporan.show-non-pbj-form', $data);
    }
    public function show_surat($id)
    {
        $item = SuratNonPbj::find($id);
        $data = [
            'title' => 'Detail Laporan Non PBJ Surat',
            'item' => $item,
        ];
        return view('wakil-direktur-ii.pages.laporan.show-non-pbj-surat', $data);
    }
}
