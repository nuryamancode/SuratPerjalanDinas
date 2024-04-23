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
        Schema::table('pengajuan_barang_jasa_pelaksana', function (Blueprint $table) {
            $table->integer('is_penanggung_jawab')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengajuan_barang_jasa_pelaksana', function (Blueprint $table) {
            $table->dropColumn('is_penanggung_jawab');
        });
    }
};
