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
        // Schema::table('disposisi', function (Blueprint $table) {
        //     $table->dropConstrainedForeignId('surat_perjalanan_dinas_id');
        //     $table->dropColumn('surat_perjalanan_dinas_id');
        // });
        Schema::table('disposisi', function (Blueprint $table) {
            $table->foreignId('surat_perjalanan_dinas_id')->constrained('surat_perjalanan_dinas')->cascadeOnDelete()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::table('disposisi', function (Blueprint $table) {
        //     // Tambahkan kembali cascadeOnDelete() di sini
        //     $table->foreignId('surat_perjalanan_dinas_id')->constrained('surat_perjalanan_dinas')->cascadeOnDelete()->change();
        // });
    }
};
