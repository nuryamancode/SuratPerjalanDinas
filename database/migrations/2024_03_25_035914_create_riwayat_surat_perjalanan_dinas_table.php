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
        Schema::create('riwayat_surat_perjalanan_dinas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('surat_perjalanan_dinas_id')->constrained('surat_perjalanan_dinas')->cascadeOnDelete();
            $table->foreignId('pengirim_karyawan_id')->constrained('karyawan');
            $table->foreignId('tujuan_karyawan_id')->constrained('karyawan');
            $table->integer('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_surat_perjalanan_dinas');
    }
};
