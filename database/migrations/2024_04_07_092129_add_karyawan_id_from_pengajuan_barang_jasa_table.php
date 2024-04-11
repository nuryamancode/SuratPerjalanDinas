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
        Schema::table('pengajuan_barang_jasa', function (Blueprint $table) {
            $table->foreignId('karyawan_id')->nullable()->constrained('karyawan')->cascadeOnDelete();
            $table->integer('acc_karyawan')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengajuan_barang_jasa', function (Blueprint $table) {
            $table->dropConstrainedForeignId('karyawan_id');
            $table->dropColumn('acc_karyawan');
        });
    }
};
