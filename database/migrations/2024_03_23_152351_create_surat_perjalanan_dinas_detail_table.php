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
        Schema::create('surat_perjalanan_dinas_detail', function (Blueprint $table) {
            $table->id();
            $table->foreignId('surat_perjalanan_dinas_id')->constrained('surat_perjalanan_dinas')->cascadeOnDelete();
            $table->foreignId('karyawan_id')->constrained('karyawan');
            $table->string('tingkat_biaya')->nullable();
            $table->string('maksud_perjalanan_dinas')->nullable();
            $table->string('alat_angkut')->nullable();
            $table->string('tempat_berangkat')->nullable();
            $table->string('tempat_tujuan')->nullable();
            $table->string('lama_perjalanan')->nullable();
            $table->date('tanggal_berangkat')->nullable();
            $table->date('tanggal_harus_kembali')->nullable();
            $table->string('pembebasan_anggaran')->nullable();
            $table->string('instansi')->nullable();
            $table->string('mata_anggaran_kegiatan')->nullable();
            $table->string('keterangan_lain_lain')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_perjalanan_dinas_detail');
    }
};
