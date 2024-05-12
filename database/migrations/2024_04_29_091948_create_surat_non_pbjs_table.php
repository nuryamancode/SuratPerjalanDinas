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
        Schema::create('surat_non_pbj', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->string('perihal');
            $table->string('nomor_surat');
            $table->string('nomor_agenda');
            $table->string('status');
            $table->date('tanggal')->nullable();
            $table->foreignId('karyawan_id')->constrained('karyawan')->cascadeOnDelete();
            $table->integer('acc_karyawan_id')->nullable();
            $table->integer('acc_wadir2')->nullable();
            $table->integer('acc_ppk')->nullable();
            $table->integer('acc_pengusul')->nullable();
            $table->integer('verifikasi_pengusul')->nullable();
            $table->text('keterangan_ppk')->nullable();
            $table->integer('verifikasi_wadir1')->nullable();
            $table->integer('verifikasi_wadir2')->nullable();
            $table->string('file');
            $table->integer('verifikasi_kabag')->nullable();
            $table->text('keterangan_wadir2')->nullable();
            $table->integer('is_arsip')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_non_pbj');
    }
};
