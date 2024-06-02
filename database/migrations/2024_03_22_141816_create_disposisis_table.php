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
            $table->foreignId('surat_perjalanan_dinas_id')->constrained('surat_perjalanan_dinas')->onDelete('cascade');
            $table->string('tipe_1')->nullable();
            $table->text('catatan_1')->nullable();
            $table->foreignId('pembuat_karyawan_id_1')->constrained('karyawan')->nullable();
            $table->foreignId('tujuan_karyawan_id_1')->constrained('karyawan')->nullable();
            $table->string('nomor_agenda_1')->nullable();
            $table->string('perihal_1')->nullable();
            $table->string('tipe_2')->nullable();
            $table->text('catatan_2')->nullable();
            $table->foreignId('pembuat_karyawan_id_2')->constrained('karyawan')->nullable();
            $table->foreignId('tujuan_karyawan_id_2')->constrained('karyawan')->nullable();
            $table->string('nomor_agenda_2')->nullable();
            $table->string('perihal_2')->nullable();
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
