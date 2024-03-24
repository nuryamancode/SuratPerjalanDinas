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
        Schema::create('disposisi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('surat_perjalanan_dinas_id')->constrained('surat_perjalanan_dinas');
            $table->string('tipe');
            $table->text('catatan')->nullable();
            $table->foreignId('pembuat_karyawan_id')->constrained('karyawan');
            $table->foreignId('tujuan_karyawan_id')->constrained('karyawan');
            $table->timestamps();
        });
        Schema::create('disposisi_detail', function (Blueprint $table) {
            $table->id();
            $table->foreignId('disposisi_id')->constrained('disposisi')->cascadeOnDelete();
            $table->foreignId('tujuan_karyawan_id')->constrained('karyawan');
            $table->foreignId('pembuat_karyawan_id')->constrained('karyawan');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('disposisi_detail');
        Schema::dropIfExists('disposisi');
    }
};
