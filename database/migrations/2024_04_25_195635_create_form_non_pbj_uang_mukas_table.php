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
        Schema::create('form_non_pbj_uang_muka', function (Blueprint $table) {
            $table->id();
            $table->foreignId('form_non_pbj_id')->constrained('form_non_pbj')->cascadeOnDelete();
            $table->foreignId('karyawan_id')->constrained('karyawan')->cascadeOnDelete();
            $table->bigInteger('nominal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_non_pbj_uang_muka');
    }
};
