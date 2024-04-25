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
        Schema::table('form_non_pbj_spj', function (Blueprint $table) {
            $table->integer('acc_ppk')->default(0);
            $table->text('keterangan_ppk')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('form_non_pbj_spj', function (Blueprint $table) {
            $table->dropColumn('acc_ppk');
            $table->dropColumn('keterangan_ppk');
        });
    }
};
