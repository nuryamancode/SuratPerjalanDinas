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
        Schema::create('pengajuan_barang_jasa_disposisi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengajuan_barang_jasa_id')->constrained('pengajuan_barang_jasa');
            $table->string('tipe');
            $table->text('catatan')->nullable();
            $table->foreignId('pembuat_karyawan_id')->constrained('karyawan');
            $table->foreignId('tujuan_karyawan_id')->constrained('karyawan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan_barang_jasa_disposisi');
    }
};
