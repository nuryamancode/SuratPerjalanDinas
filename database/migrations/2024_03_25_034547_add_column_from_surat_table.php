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
        Schema::table('surat', function (Blueprint $table) {
            $table->string('no_agenda')->nullable();
            $table->date('tanggal_surat')->nullable();
            $table->string('asal_surat')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('surat', function (Blueprint $table) {
            $table->dropColumn('no_agenda');
            $table->dropColumn('tanggal_surat');
            $table->dropColumn('asal_surat');
        });
    }
};
