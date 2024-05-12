<?php

namespace Database\Seeders;

use App\Models\TahapanPbj;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TahapanPbjSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TahapanPbj::create(['nama' => 'Menerima Usulan dari User']);
        TahapanPbj::create(['nama' => 'Klarifikasi Awal HPS']);
        TahapanPbj::create(['nama' => 'Penentuan HPS']);
        TahapanPbj::create(['nama' => 'Tayangan Simpel']);
        TahapanPbj::create(['nama' => 'Dokumen Pengadaan']);
        TahapanPbj::create(['nama' => 'Undangan Penyedia']);
        TahapanPbj::create(['nama' => 'Berita Acara Evaluasi']);
        TahapanPbj::create(['nama' => 'Berita Acara Klarifikasi Dan Negosiasi Teknis Dan Biaya']);
        TahapanPbj::create(['nama' => 'Berita Acara Hasil Pengadaan Langsung (BAHPL)']);
        TahapanPbj::create(['nama' => 'Penetapan Pemenang Pengadaan Barang/Jasa']);
        TahapanPbj::create(['nama' => 'Pengumuman Penetapan Pengadaan Barang/Jasa']);
        TahapanPbj::create(['nama' => 'Kontrak Penyedia']);
        TahapanPbj::create(['nama' => 'Pelaksanaan Pekerjaan']);
        TahapanPbj::create(['nama' => 'Berita Acara Serah Terima Pekerjaan']);
        TahapanPbj::create(['nama' => 'Berita Acara Pembayaran']);
        TahapanPbj::create(['nama' => 'Pembayaran']);
        TahapanPbj::create(['nama' => 'Selesai']);
    }
}
