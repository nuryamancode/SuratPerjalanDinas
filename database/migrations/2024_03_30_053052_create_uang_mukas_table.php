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
            $table->foreignId('spd_pelaksana_dinas_id')->nullable()->constrained('spd_pelaksana_dinas');
            $table->foreignId('spd_supir_id')->nullable()->constrained('spd_supir');
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
