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
        Schema::create('uang_muka_barangjasa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengajuan_barang_jasa_id')->constrained('pengajuan_barang_jasa')->cascadeOnDelete();
            $table->bigInteger('nominal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('uang_muka_barangjasa');
    }
};
