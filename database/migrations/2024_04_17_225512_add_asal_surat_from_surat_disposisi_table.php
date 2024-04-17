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
        Schema::table('disposisi', function (Blueprint $table) {
            $table->dropColumn('acc_tujuan_karyawan_id');
            $table->string('nomor_agenda')->nullable();
            $table->string('perihal')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('disposisi', function (Blueprint $table) {
            $table->dropColumn('nomor_agenda');
            $table->dropColumn('perihal');
        });
    }
};
