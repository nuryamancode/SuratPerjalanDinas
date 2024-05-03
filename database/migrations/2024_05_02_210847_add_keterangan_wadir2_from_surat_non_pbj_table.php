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
            $table->text('keterangan_wadir2')->nullable();
            $table->dropColumn('verifikasi_wadir2');
            $table->dropColumn('acc_pengusul');
            $table->dropColumn('acc_karyawan_id');
            $table->dropColumn('verifikasi_pengusul');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('surat_non_pbj', function (Blueprint $table) {
            $table->dropColumn('keterangan_wadir2');
            $table->text('verifikasi_wadir2')->nullable();
            $table->text('acc_pengusul')->nullable();
            $table->text('acc_karyawan_id')->nullable();
            $table->text('verifikasi_pengusul')->nullable();
        });
    }
};
