<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create([
            'name' => 'Admin'
        ]);
        $pa = Role::create([
            'name' => 'Pengadministrasi Umum'
        ]);
        $pa->givePermissionTo(['Dashboard', 'Surat Index', 'Surat Create', 'Surat Edit', 'Surat Delete', 'Permohonan Surat Perjalanan Dinas Index', 'Permohonan Surat Perjalanan Dinas Create', 'Permohonan Surat Perjalanan Dinas Edit', 'Permohonan Surat Perjalanan Dinas Delete', 'Permohonan Surat Perjalanan Dinas Show']);
        $kabag = Role::create([
            'name' => 'Kepala Bagian'
        ]);
        $kabag->givePermissionTo(['Dashboard', 'Surat Index', 'Surat Create', 'Surat Edit', 'Surat Delete', 'Permohonan Surat Perjalanan Dinas Index', 'Permohonan Surat Perjalanan Dinas Create', 'Permohonan Surat Perjalanan Dinas Edit', 'Permohonan Surat Perjalanan Dinas Delete', 'Permohonan Surat Perjalanan Dinas Show']);
        $karyawan = Role::create([
            'name' => 'Karyawan'
        ]);
        $karyawan->givePermissionTo(['Dashboard', 'Surat Perjalanan Dinas Index', 'Surat Perjalanan Dinas By Karyawan', 'Surat Pertanggung Jawaban Index', 'Surat Pertanggung Jawaban By Karyawan']);

        $bendahara = Role::create([
            'name' => 'Bendahara Keuangan'
        ]);
        $bendahara->givePermissionTo(['Dashboard', 'Permohonan Surat Perjalanan Dinas Index', 'Surat Perjalanan Dinas Create', 'Surat Perjalanan Dinas Index', 'Surat Pertanggung Jawaban Arsip Index', 'Surat Pertanggung Jawaban Create', 'Surat Pertanggung Jawaban Delete', 'Uang Muka Index', 'Uang Muka Create', 'Uang Muka Edit', 'Uang Muka Delete']);
        $pengelola = Role::create([
            'name' => 'Pengelola Keuangan'
        ]);
        $pengelola->givePermissionTo(['Dashboard', 'Permohonan Surat Perjalanan Dinas Index', 'Surat Perjalanan Dinas Create', 'Surat Perjalanan Dinas Index', 'Surat Pertanggung Jawaban Arsip Index', 'Surat Pertanggung Jawaban Create', 'Surat Pertanggung Jawaban Delete', 'Uang Muka Index', 'Uang Muka Create', 'Uang Muka Edit', 'Uang Muka Delete']);

        $ppk = Role::create([
            'name' => 'Pejabat Pembuat Komitmen'
        ]);
        $ppk->givePermissionTo(['Dashboard', 'Permohonan Surat Perjalanan Dinas Show', 'Disposisi Index', 'Disposisi Create', 'Disposisi Edit', 'Disposisi Delete', 'Surat Perjalanan Dinas Verifikasi', 'Surat Pertanggung Jawaban Index', 'Surat Pertanggung Jawaban Show', 'Surat Pertanggung Jawaban Verifikasi']);
        $timppk = Role::create([
            'name' => 'Tim PPK'
        ]);
        $timppk->givePermissionTo(['Dashboard', 'Permohonan Surat Perjalanan Dinas Show', 'Disposisi Index', 'Disposisi Create', 'Disposisi Edit', 'Disposisi Delete', 'Surat Perjalanan Dinas Verifikasi', 'Surat Pertanggung Jawaban Index', 'Surat Pertanggung Jawaban Show', 'Surat Pertanggung Jawaban Verifikasi']);

        $wadir2 = Role::create([
            'name' => 'Wakil Direktur II'
        ]);
        $wadir2->givePermissionTo(['Dashboard', 'Disposisi Index', 'Disposisi Create']);

        $wadir1 = Role::create([
            'name' => 'Wakil Direktur I'
        ]);
        $wadir1->givePermissionTo(['Dashboard', 'Disposisi Index', 'Disposisi Create']);
        $supir = Role::create([
            'name' => 'Supir'
        ]);
        $supir->givePermissionTo(['Dashboard', 'Disposisi Index', 'Disposisi Create']);
    }
}
