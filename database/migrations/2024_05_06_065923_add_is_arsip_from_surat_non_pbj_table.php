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
        Schema::table('surat_non_pbj', function (Blueprint $table) {
            $table->integer('is_arsip')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('surat_non_pbj', function (Blueprint $table) {
            $table->dropColumn('is_arsip');
        });
    }
};
