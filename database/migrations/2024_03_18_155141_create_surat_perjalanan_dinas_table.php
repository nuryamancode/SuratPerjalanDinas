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
        Schema::create('surat_perjalanan_dinas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('surat_id')->constrained('surat')->onDelete('cascade');
            $table->string('tipe')->nullable();
            $table->string('status')->nullable();
            $table->text('instruksi')->nullable();
            $table->integer('verifikasi_wadir2')->default(0);
            $table->boolean('validasi_pemberangkatan')->default(0);
            $table->integer('acc_ppk')->default(0);
            $table->text('keterangan_acc_ppk')->nullable();
            $table->integer('verifikasi_ppk')->default(0);
            $table->boolean('is_arsip')->default(0);
            $table->foreignId('validasi_karyawan_id')->nullable()->constrained('karyawan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_perjalanan_dinas');
    }
};
