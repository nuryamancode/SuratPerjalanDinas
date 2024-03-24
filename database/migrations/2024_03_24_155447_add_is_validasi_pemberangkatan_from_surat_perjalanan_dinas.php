<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('surat_perjalanan_dinas', function (Blueprint $table) {
            $table->boolean('validasi_pemberangkatan')->default(0);
            $table->foreignId('validasi_karyawan_id')->nullable()->constrained('karyawan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('surat_perjalanan_dinas', function (Blueprint $table) {
            $table->dropColumn('validasi_pemberangkatan');
            $table->dropConstrainedForeignId('validasi_karyawan_id');
        });
    }
};
