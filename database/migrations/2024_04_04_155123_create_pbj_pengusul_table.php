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
        Schema::create('pbj_pengusul', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pbj_id')->constrained('pbj')->cascadeOnDelete();
            $table->foreignId('pengusul_id')->constrained('karyawan')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pbj_pengusul');
    }
};
