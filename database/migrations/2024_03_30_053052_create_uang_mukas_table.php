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
        Schema::create('uang_muka', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('nominal');
            $table->foreignId('spd_detail_id')->nullable()->constrained('surat_perjalanan_dinas_detail');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('uang_muka');
    }
};
