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
            'name' => 'superadmin'
        ]);

        Role::create([
            'name' => 'admin'
        ]);

        Role::create([
            'name' => 'Pengadministrasi Umum'
        ]);

        Role::create([
            'name' => 'Pelaksana Perjalanan Dinas'
        ]);

        Role::create([
            'name' => 'Bendahara Keuangan'
        ]);

        Role::create([
            'name' => 'Pejabat Pembuat Komitmen'
        ]);
        Role::create([
            'name' => 'Wakil Direktur II'
        ]);
    }
}
