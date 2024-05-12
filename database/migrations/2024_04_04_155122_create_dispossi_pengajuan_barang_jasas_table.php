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
        Schema::create('pbj_disposisi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pbj_id')->constrained('pbj');
            $table->string('tipe_disposisi')->nullable();
            $table->text('catatan_disposisi_1')->nullable();
            $table->text('catatan_disposisi_2')->nullable();
            $table->foreignId('teruskan_ke_1')->nullable()->constrained('karyawan')->cascadeOnDelete();
            $table->foreignId('teruskan_ke_2')->nullable()->constrained('karyawan')->cascadeOnDelete();
            $table->foreignId('pelaksana_belanja')->nullable()->constrained('karyawan')->cascadeOnDelete();
            $table->foreignId('pembuat_disposisi_1')->nullable()->constrained('karyawan')->cascadeOnDelete();
            $table->foreignId('pembuat_disposisi_2')->nullable()->constrained('karyawan')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pbj_diposisi');
    }
};
