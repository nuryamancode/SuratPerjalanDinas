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
            $table->dropConstrainedForeignId('pembuat_karyawan_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengajuan_barang_jasa', function (Blueprint $table) {
            $table->foreignId('pembuat_karyawan_id')->nullable()->constrained('karyawan_id');
        });
    }
};
