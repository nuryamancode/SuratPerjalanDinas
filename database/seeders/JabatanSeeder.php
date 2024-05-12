<?php

namespace Database\Seeders;

use App\Models\Jabatan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JabatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Jabatan::create([
            'nama' => 'Pengadministrasi Umum'
        ]);
        Jabatan::create([
            'nama' => 'Karyawan POLSUB'
        ]);
        Jabatan::create([
            'nama' => 'Bendahara Keuangan'
        ]);
        Jabatan::create([
            'nama' => 'Pejabat Pembuat Komitmen'
        ]);
        Jabatan::create([
            'nama' => 'TIM Pejabat Pembuat Komitmen'
        ]);
        Jabatan::create([
            'nama' => 'Wakil Direktur II'
        ]);
        Jabatan::create([
            'nama' => 'Wakil Direktur I'
        ]);
        Jabatan::create([
            'nama' => 'Kepala Bagian'
        ]);
        Jabatan::create([
            'nama' => 'Pengelola Keuangan'
        ]);
        Jabatan::create([
            'nama' => 'Supir'
        ]);
    }
}
