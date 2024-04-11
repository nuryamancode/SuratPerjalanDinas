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
        Schema::create('spj_barang_jasa', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('pengajuan_barang_jasa_pelaksana_id')->constrained('pengajuan_barang_jasa_pelaksana')->cascadeOnDelete();
            $table->string('file');
            $table->integer('status');
            $table->timestamps();
        });
        Schema::create('spj_barang_jasa_detail', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('spj_barang_jasa_id')->constrained('spj_barang_jasa')->cascadeOnDelete();
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
        Schema::dropIfExists('spj_barang_jasa');
    }
};
