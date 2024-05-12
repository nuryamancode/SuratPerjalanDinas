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
        Schema::create('surat', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pembuat_user_id')->constrained('users');
            $table->string('status');
            $table->string('jenis_surat');
            $table->text('maksud_perjalanan_dinas')->nullable();
            $table->date('tanggal_mulai')->nullable();
            $table->date('tanggal_sampai')->nullable();
            $table->string('tempat_berangkat')->nullable();
            $table->string('tempat_tujuan')->nullable();
            $table->string('no_surat_jalan_dinas')->nullable();
            $table->integer('antar')->nullable();
            $table->date('tanggal_surat_jalan')->nullable();
            $table->foreignId('supir_karyawan_id')->nullable()->constrained('karyawan')->nullOnDelete();
            $table->string('lampiran_surat_tugas')->nullable();
            $table->string('uraian_tugas')->nullable();
            $table->date('mulai_tanggal_tugas')->nullable();
            $table->date('sampai_tanggal_tugas')->nullable();
            $table->string('asal_surat')->nullable();
            $table->timestamps();
        });

        Schema::create('lampiran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('surat_id')->constrained('surat')->cascadeOnDelete();
            $table->string('file');
            $table->integer('nilai')->nullable();
            $table->string('keterangan')->nullable();
            $table->timestamps();
        });

        Schema::create('pelaksana', function (Blueprint $table) {
            $table->id();
            $table->foreignId('surat_id')->constrained('surat')->cascadeOnDelete();
            $table->string('status')->nullable();
            $table->string('keterangan')->nullable();
            $table->foreignId('karyawan_id')->nullable()->constrained('karyawan')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelaksana');
        Schema::dropIfExists('lampiran');
        Schema::dropIfExists('surat');
    }
};
