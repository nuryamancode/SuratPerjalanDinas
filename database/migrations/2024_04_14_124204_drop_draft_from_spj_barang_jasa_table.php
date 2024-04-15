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
        Schema::table('spj_barang_jasa', function (Blueprint $table) {
            $table->dropColumn('file');
            $table->string('via')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('spj_barang_jasa', function (Blueprint $table) {
            $table->dropColumn('via');
            $table->string('file')->nullable();
        });
    }
};
