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
            'nama' => 'Pelaksana Perjalanan Dinas'
        ]);
        Jabatan::create([
            'nama' => 'Bendahara Keuangan'
        ]);
        Jabatan::create([
            'nama' => 'Pejabat Pembuat Komitmen'
        ]);
        Jabatan::create([
            'nama' => 'Wakil DIrektur II'
        ]);
    }
}
