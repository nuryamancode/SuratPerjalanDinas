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
        Schema::create('form_non_pbj', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('file');
            $table->foreignId('pengusul_karyawan_id')->constrained('karyawan');
            $table->string('status');
            $table->integer('acc_ppk')->default(0);
            $table->bigInteger('uang_muka')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_non_pbj');
    }
};
