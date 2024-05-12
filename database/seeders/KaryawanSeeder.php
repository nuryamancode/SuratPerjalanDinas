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
            'email' => 'bagianumum@gmail.com',
            'password' => bcrypt('password')
        ]);
        $user1->assignRole('Pengadministrasi Umum');
        $user1->karyawan()->create([
            'nama' => 'Pengguna Bagian Umum',
            'nip' => rand(100, 999),
            'jenis_kelamin' => 'Laki-laki',
            'jabatan_id' => Jabatan::where('nama', 'Pengadministrasi Umum')->first()->id,
            'golongan_id' => Golongan::find(1)->id,
        ]);

        $user2 = User::create([
            'email' => 'pengelola@gmail.com',
            'password' => bcrypt('password')
        ]);
        $user2->assignRole('Pengelola Keuangan');
        $user2->karyawan()->create([
            'nama' => 'Pengguna Pengelola Keuangan',
            'nip' => rand(100, 999),
            'jenis_kelamin' => 'Laki-laki',
            'jabatan_id' => Jabatan::where('nama', 'Pengelola Keuangan')->first()->id,
            'golongan_id' => Golongan::find(1)->id,
        ]);

        $user3 = User::create([
            'email' => 'bendahara@gmail.com',
            'password' => bcrypt('password')
        ]);
        $user3->assignRole('Bendahara Keuangan');
        $user3->karyawan()->create([
            'nama' => 'Pengguna Bendahara Keuangan',
            'nip' => rand(100, 999),
            'jenis_kelamin' => 'Laki-laki',
            'jabatan_id' => Jabatan::where('nama', 'Bendahara Keuangan')->first()->id,
            'golongan_id' => Golongan::find(1)->id,
        ]);

        $user4 = User::create([
            'email' => 'ppk@gmail.com',
            'password' => bcrypt('password')
        ]);
        $user4->assignRole('Pejabat Pembuat Komitmen');
        $user4->karyawan()->create([
            'nama' => 'Pengguna Pejabat Pembuat Komitmen',
            'nip' => rand(100, 999),
            'jenis_kelamin' => 'Laki-laki',
            'jabatan_id' => Jabatan::where('nama', 'Pejabat Pembuat Komitmen')->first()->id,
            'golongan_id' => Golongan::find(1)->id,
        ]);
        $user5 = User::create([
            'email' => 'timppk@gmail.com',
            'password' => bcrypt('password')
        ]);
        $user5->assignRole('TIM PPK');
        $user5->karyawan()->create([
            'nama' => 'Pengguna TIM Pejabat Pembuat Komitmen',
            'nip' => rand(100, 999),
            'jenis_kelamin' => 'Laki-laki',
            'jabatan_id' => Jabatan::where('nama', 'TIM Pejabat Pembuat Komitmen')->first()->id,
            'golongan_id' => Golongan::find(1)->id,
        ]);

        $user6 = User::create([
            'email' => 'wadir2@gmail.com',
            'password' => bcrypt('password')
        ]);
        $user6->assignRole('Wakil Direktur II');
        $user6->karyawan()->create([
            'nama' => 'Pengguna Wakil Direktur II',
            'nip' => rand(100, 999),
            'jenis_kelamin' => 'Laki-laki',
            'jabatan_id' => Jabatan::where('nama', 'Wakil Direktur II')->first()->id,
            'golongan_id' => Golongan::find(1)->id,
        ]);
        $user7 = User::create([
            'email' => 'wadir1@gmail.com',
            'password' => bcrypt('password')
        ]);
        $user7->assignRole('Wakil Direktur I');
        $user7->karyawan()->create([
            'nama' => 'Pengguna Wakil Direktur I',
            'nip' => rand(100, 999),
            'jenis_kelamin' => 'Laki-laki',
            'jabatan_id' => Jabatan::where('nama', 'Wakil Direktur I')->first()->id,
            'golongan_id' => Golongan::find(1)->id,
        ]);
        $user8 = User::create([
            'email' => 'kabag@gmail.com',
            'password' => bcrypt('password')
        ]);
        $user8->assignRole('Kepala Bagian');
        $user8->karyawan()->create([
            'nama' => 'Pengguna Kepala Bagian',
            'nip' => rand(100, 999),
            'jenis_kelamin' => 'Laki-laki',
            'jabatan_id' => Jabatan::where('nama', 'Kepala Bagian')->first()->id,
            'golongan_id' => Golongan::find(1)->id,
        ]);
        $user9 = User::create([
            'email' => 'supir@gmail.com',
            'password' => bcrypt('password')
        ]);
        $user9->assignRole('Supir');
        $user9->karyawan()->create([
            'nama' => 'Pengguna Supir',
            'nip' => rand(100, 999),
            'jenis_kelamin' => 'Laki-laki',
            'jabatan_id' => Jabatan::where('nama', 'Supir')->first()->id,
            'golongan_id' => Golongan::find(1)->id,
        ]);
        $user9 = User::create([
            'email' => 'dosen@gmail.com',
            'password' => bcrypt('password')
        ]);
        $user9->assignRole('Karyawan');
        $user9->karyawan()->create([
            'nama' => 'Pengguna Dosen',
            'nip' => rand(100, 999),
            'jenis_kelamin' => 'Laki-laki',
            'jabatan_id' => Jabatan::where('nama', 'Karyawan POLSUB')->first()->id,
            'golongan_id' => Golongan::find(1)->id,
        ]);
    }
}
