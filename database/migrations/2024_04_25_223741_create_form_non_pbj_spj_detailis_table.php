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
        Schema::create('form_non_pbj_spj_detail', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('form_non_pbj_spj_id')->constrained('form_non_pbj_spj')->cascadeOnDelete();
            $table->string('perincian_biaya');
            $table->bigInteger('nominal');
            $table->string('file');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_non_pbj_spj_detail');
    }
};
