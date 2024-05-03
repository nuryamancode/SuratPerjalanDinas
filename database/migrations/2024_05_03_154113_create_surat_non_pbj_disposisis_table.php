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
        Schema::create('surat_non_pbj_disposisi', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('surat_non_pbj_id')->constrained('surat_non_pbj')->cascadeOnDelete();
            $table->string('tipe');
            $table->text('catatan');
            $table->foreignId('pembuat_karyawan_id')->constrained('karyawan')->cascadeOnDelete();
            $table->foreignId('tujuan_karyawan_id')->constrained('karyawan')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_non_pbj_disposisi');
    }
};
