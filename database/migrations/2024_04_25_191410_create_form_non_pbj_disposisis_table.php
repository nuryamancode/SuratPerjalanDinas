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
        Schema::create('form_non_pbj_disposisi', function (Blueprint $table) {
            $table->id();
            $table->string('no_surat')->nullable();
            $table->string('no_agenda')->nullable();
            $table->foreignId('form_non_pbj_id')->constrained('form_non_pbj')->cascadeOnDelete();
            $table->string('tipe_disposisi');
            $table->text('catatan_disposisi');
            $table->foreignId('asal_surat_id')->constrained('karyawan')->cascadeOnDelete();
            $table->string('perihal')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_non_pbj_disposisi');
    }
};
