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
        Schema::create('surat_non_pbj_pengusul', function (Blueprint $table) {
            $table->id();
            $table->foreignId('surat_non_pbj_id')->constrained('surat_non_pbj')->cascadeOnDelete();
            $table->foreignId('pengusul_id')->constrained('karyawan')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_non_pbj_pengusul');
    }
};
