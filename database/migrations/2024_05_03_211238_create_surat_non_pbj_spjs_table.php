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
        Schema::create('surat_non_pbj_spj', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('surat_non_pbj_id')->constrained('surat_non_pbj')->cascadeOnDelete();
            $table->string('untuk_pembayaran');
            $table->integer('acc_ppk')->default(0);
            $table->text('keterangan_ppk')->nullable();
            $table->timestamps();
        });
        Schema::create('surat_non_pbj_spj_detail', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('surat_non_pbj_spj_id')->constrained('surat_non_pbj_spj')->cascadeOnDelete();
            $table->string('perincian_biaya');
            $table->bigInteger('nominal');
            $table->string('file');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_non_pbj_spj_detail');
        Schema::dropIfExists('surat_non_pbj_spj');
    }
};
