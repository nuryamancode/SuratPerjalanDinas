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
        Schema::create('surat_pertanggung_jawaban', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('spd_detail_id')->constrained('surat_perjalanan_dinas_detail')->cascadeOnDelete();
            $table->string('file');
            $table->integer('status');
            $table->timestamps();
        });
        Schema::create('surat_pertanggung_jawaban_detail', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('spj_id')->constrained('surat_pertanggung_jawaban')->cascadeOnDelete();
            $table->string('perincian_biaya');
            $table->bigInteger('nominal');
            $table->text('keterangan')->nullable();
            $table->string('file');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_pertanggung_jawaban_detail');
        Schema::dropIfExists('surat_pertanggung_jawaban');
    }
};
