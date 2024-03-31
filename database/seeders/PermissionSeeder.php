<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create([
            'name' => 'Dashboard'
        ]);

        Permission::create([
            'name' => 'Role Index'
        ]);
        Permission::create([
            'name' => 'Role Create'
        ]);
        Permission::create([
            'name' => 'Role Edit'
        ]);
        Permission::create([
            'name' => 'Role Delete'
        ]);

        Permission::create([
            'name' => 'Permission Index'
        ]);
        Permission::create([
            'name' => 'Permission Create'
        ]);
        Permission::create([
            'name' => 'Permission Edit'
        ]);
        Permission::create([
            'name' => 'Permission Delete'
        ]);

        Permission::create([
            'name' => 'User Index'
        ]);
        Permission::create([
            'name' => 'User Create'
        ]);
        Permission::create([
            'name' => 'User Edit'
        ]);
        Permission::create([
            'name' => 'User Delete'
        ]);

        Permission::create([
            'name' => 'Karyawan Index'
        ]);
        Permission::create([
            'name' => 'Karyawan Create'
        ]);
        Permission::create([
            'name' => 'Karyawan Edit'
        ]);
        Permission::create([
            'name' => 'Karyawan Delete'
        ]);

        Permission::create([
            'name' => 'Jabatan Index'
        ]);
        Permission::create([
            'name' => 'Jabatan Create'
        ]);
        Permission::create([
            'name' => 'Jabatan Edit'
        ]);
        Permission::create([
            'name' => 'Jabatan Delete'
        ]);
        Permission::create([
            'name' => 'TTE Index'
        ]);
        Permission::create([
            'name' => 'Golongan Index'
        ]);
        Permission::create([
            'name' => 'Golongan Create'
        ]);
        Permission::create([
            'name' => 'Golongan Edit'
        ]);
        Permission::create([
            'name' => 'Golongan Delete'
        ]);
        Permission::create([
            'name' => 'Permohonan Surat Perjalanan Dinas Index'
        ]);
        Permission::create([
            'name' => 'Permohonan Surat Perjalanan Dinas Create'
        ]);
        Permission::create([
            'name' => 'Permohonan Surat Perjalanan Dinas Edit'
        ]);
        Permission::create([
            'name' => 'Permohonan Surat Perjalanan Dinas Delete'
        ]);
        Permission::create([
            'name' => 'Permohonan Surat Perjalanan Dinas Show'
        ]);

        Permission::create([
            'name' => 'Surat Perjalanan Dinas Index'
        ]);
        Permission::create([
            'name' => 'Surat Perjalanan Dinas Create'
        ]);
        Permission::create([
            'name' => 'Surat Perjalanan Dinas Edit'
        ]);
        Permission::create([
            'name' => 'Surat Perjalanan Dinas Delete'
        ]);
        Permission::create([
            'name' => 'Surat Perjalanan Dinas Show'
        ]);
        Permission::create([
            'name' => 'Surat Perjalanan Dinas Supir'
        ]);
        Permission::create([
            'name' => 'Surat Perjalanan Dinas Generate'
        ]);
        Permission::create([
            'name' => 'Surat Perjalanan Dinas Verifikasi'
        ]);
        Permission::create([
            'name' => 'Surat Perjalanan Dinas By Karyawan'
        ]);


        Permission::create([
            'name' => 'Surat Pertanggung Jawaban Index'
        ]);
        Permission::create([
            'name' => 'Surat Pertanggung Jawaban Create'
        ]);
        Permission::create([
            'name' => 'Surat Pertanggung Jawaban Edit'
        ]);
        Permission::create([
            'name' => 'Surat Pertanggung Jawaban Delete'
        ]);
        Permission::create([
            'name' => 'Surat Pertanggung Jawaban Show'
        ]);
        Permission::create([
            'name' => 'Surat Pertanggung Jawaban Verifikasi'
        ]);
        Permission::create([
            'name' => 'Surat Pertanggung Jawaban By Karyawan'
        ]);

        Permission::create([
            'name' => 'Surat Index'
        ]);
        Permission::create([
            'name' => 'Surat Create'
        ]);
        Permission::create([
            'name' => 'Surat Edit'
        ]);
        Permission::create([
            'name' => 'Surat Delete'
        ]);
        Permission::create([
            'name' => 'Surat Show'
        ]);

        Permission::create([
            'name' => 'Disposisi Index'
        ]);
        Permission::create([
            'name' => 'Disposisi Create'
        ]);
        Permission::create([
            'name' => 'Disposisi Edit'
        ]);
        Permission::create([
            'name' => 'Disposisi Delete'
        ]);

        Permission::create([
            'name' => 'Uang Muka Index'
        ]);
        Permission::create([
            'name' => 'Uang Muka Create'
        ]);
        Permission::create([
            'name' => 'Uang Muka Edit'
        ]);
        Permission::create([
            'name' => 'Uang Muka Delete'
        ]);

        Permission::create([
            'name' => 'Surat Pertanggung Jawaban Arsip Index'
        ]);
        Permission::create([
            'name' => 'Surat Pertanggung Jawaban Arsip Create'
        ]);
        Permission::create([
            'name' => 'Surat Pertanggung Jawaban Arsip Delete'
        ]);
    }
}
