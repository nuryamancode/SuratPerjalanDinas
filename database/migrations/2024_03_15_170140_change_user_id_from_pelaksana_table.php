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
        Schema::table('pelaksana', function (Blueprint $table) {
            $table->dropConstrainedForeignId('user_id');
            $table->foreignId('karyawan_id')->nullable()->constrained('karyawan')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pelaksana', function (Blueprint $table) {
            $table->dropConstrainedForeignId('karyawan_id');
            $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnDelete();
        });
    }
};
