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
        Schema::table('users', function (Blueprint $table) {
            $table->dropConstrainedForeignId('jabatan_id');
            $table->dropConstrainedForeignId('golongan_id');
            $table->dropColumn('role');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('jabatan_id')->nullable()->constrained('jabatan');
            $table->foreignId('golongan_id')->nullable()->constrained('golongan');
            $table->string('role')->nullable();
        });
    }
};
