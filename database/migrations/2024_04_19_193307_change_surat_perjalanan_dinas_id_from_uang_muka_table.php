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
        Schema::table('uang_muka', function (Blueprint $table) {
            $table->dropConstrainedForeignId('surat_perjalanan_dinas_id');
            $table->foreignId('spd_detail_id')->nullable()->constrained('surat_perjalanan_dinas_detail');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('uang_muka', function (Blueprint $table) {
            $table->dropConstrainedForeignId('spd_detail_id');
            $table->foreignId('surat_perjalanan_dinas_id')->nullable()->constrained('surat_perjalanan_dinas');
        });
    }
};
