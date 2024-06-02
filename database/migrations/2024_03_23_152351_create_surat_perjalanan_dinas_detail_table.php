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
        Schema::create('spd_pelaksana_dinas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('surat_perjalanan_dinas_id')->constrained('surat_perjalanan_dinas')->cascadeOnDelete();
            $table->string('tingkat_biaya')->nullable();
            $table->string('maksud_perjalanan_dinas')->nullable();
            $table->string('alat_angkut')->nullable();
            $table->string('tempat_berangkat')->nullable();
            $table->string('tempat_tujuan')->nullable();
            $table->string('lama_perjalanan')->nullable();
            $table->date('tanggal_berangkat')->nullable();
            $table->string('pembebanan_anggaran')->nullable();
            $table->string('instansi')->nullable();
            $table->string('mata_anggaran_kegiatan')->nullable();
            $table->string('keterangan_lain_lain')->nullable();
            $table->string('dikeluarkan_di')->nullable();
            $table->integer('verifikasi_ppk')->default(0);
            $table->timestamps();
        });
        Schema::create('spd_supir', function (Blueprint $table) {
            $table->id();
            $table->foreignId('surat_perjalanan_dinas_id')->constrained('surat_perjalanan_dinas')->cascadeOnDelete();
            $table->string('tingkat_biaya')->nullable();
            $table->string('maksud_perjalanan_dinas')->nullable();
            $table->string('alat_angkut')->nullable();
            $table->string('tempat_berangkat')->nullable();
            $table->string('tempat_tujuan')->nullable();
            $table->string('lama_perjalanan')->nullable();
            $table->date('tanggal_berangkat')->nullable();
            $table->string('pembebanan_anggaran')->nullable();
            $table->string('instansi')->nullable();
            $table->string('mata_anggaran_kegiatan')->nullable();
            $table->string('keterangan_lain_lain')->nullable();
            $table->string('dikeluarkan_di')->nullable();
            $table->integer('verifikasi_ppk')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spd_pelaksana_dinas');
        Schema::dropIfExists('spd_supir');
    }
};
