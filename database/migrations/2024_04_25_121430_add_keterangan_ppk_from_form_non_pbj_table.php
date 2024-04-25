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
        Schema::table('form_non_pbj', function (Blueprint $table) {
            $table->text('keterangan_ppk')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('form_non_pbj', function (Blueprint $table) {
            $table->dropColumn('keterangan_ppk');
        });
    }
};
