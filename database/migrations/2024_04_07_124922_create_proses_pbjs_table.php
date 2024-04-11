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
        Schema::create('proses_pbj', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengajuan_barang_jasa_id')->constrained('pengajuan_barang_jasa');
            $table->foreignId('tahapan_pbj_id')->nullable()->constrained('tahapan_pbj');
            $table->foreignId('karyawan_id')->constrained('karyawan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proses_pbj');
    }
};
