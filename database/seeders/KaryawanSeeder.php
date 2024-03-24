<?php

namespace Database\Seeders;

use App\Models\Golongan;
use App\Models\Jabatan;
use App\Models\Karyawan;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KaryawanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user1 = User::create([
            'name' => 'Pengadministrasi Umum',
            'email' => 'pengadministrasiumum@gmail.com',
            'password' => bcrypt('password')
        ]);
        $user1->assignRole('Pengadministrasi Umum');
        $user1->karyawan()->create([
            'nama' => 'Pengadministrasi Umum',
            'nip' => rand(100, 999),
            'jenis_kelamin' => 'Laki-laki',
            'jabatan_id' => Jabatan::where('nama', 'Pengadministrasi Umum')->first()->id,
            'golongan_id' => Golongan::find(1)->id,
        ]);

        $user2 = User::create([
            'name' => 'Pelaksana Perjalanan Dinas',
            'email' => 'pelaksanaperjalanandinas@gmail.com',
            'password' => bcrypt('password')
        ]);
        $user2->assignRole('Pelaksana Perjalanan Dinas');
        $user2->karyawan()->create([
            'nama' => 'Pelaksana Perjalanan Dinas',
            'nip' => rand(100, 999),
            'jenis_kelamin' => 'Laki-laki',
            'jabatan_id' => Jabatan::where('nama', 'Pelaksana Perjalanan Dinas')->first()->id,
            'golongan_id' => Golongan::find(1)->id,
        ]);

        $user3 = User::create([
            'name' => 'Bendahara Keuangan',
            'email' => 'bendaharakeuangan@gmail.com',
            'password' => bcrypt('password')
        ]);
        $user3->assignRole('Bendahara Keuangan');
        $user3->karyawan()->create([
            'nama' => 'Bendahara Keuangan',
            'nip' => rand(100, 999),
            'jenis_kelamin' => 'Laki-laki',
            'jabatan_id' => Jabatan::where('nama', 'Bendahara Keuangan')->first()->id,
            'golongan_id' => Golongan::find(1)->id,
        ]);

        $user4 = User::create([
            'name' => 'Pejabat Pembuat Komitmen',
            'email' => 'pejabatpembuatkomitmen@gmail.com',
            'password' => bcrypt('password')
        ]);
        $user4->assignRole('Pejabat Pembuat Komitmen');
        $user4->karyawan()->create([
            'nama' => 'Pejabat Pembuat Komitmen',
            'nip' => rand(100, 999),
            'jenis_kelamin' => 'Laki-laki',
            'jabatan_id' => Jabatan::where('nama', 'Pejabat Pembuat Komitmen')->first()->id,
            'golongan_id' => Golongan::find(1)->id,
        ]);

        $user5 = User::create([
            'name' => 'Wakil Direktur II',
            'email' => 'wakildirekturii@gmail.com',
            'password' => bcrypt('password')
        ]);
        $user5->assignRole('Wakil Direktur II');
        $user5->karyawan()->create([
            'nama' => 'Wakil Direktur II',
            'nip' => rand(100, 999),
            'jenis_kelamin' => 'Laki-laki',
            'jabatan_id' => Jabatan::where('nama', 'Wakil Direktur II')->first()->id,
            'golongan_id' => Golongan::find(1)->id,
        ]);
    }
}
