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
        Schema::create('spj_pelaksana_dinas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('spd_id')->nullable()->constrained('spd_pelaksana_dinas');
            $table->string('file');
            $table->integer('acc_ppk')->default(0);
            $table->foreignId('pembuat_spj')->constrained('karyawan')->nullable();
            $table->integer('status_spj')->default(0);
            $table->text('keterangan_ppk')->nullable();
            $table->timestamps();
        });
        Schema::create('spj_supir', function (Blueprint $table) {
            $table->id();
            $table->foreignId('spd_id')->nullable()->constrained('spd_supir');
            $table->string('file');
            $table->integer('acc_ppk')->default(0);
            $table->foreignId('pembuat_spj')->constrained('karyawan')->nullable();
            $table->integer('status_spj')->default(0);
            $table->text('keterangan_ppk')->nullable();
            $table->timestamps();
        });
        Schema::create('spj_pelaksana_dinas_detail', function (Blueprint $table) {
            $table->id();
            $table->foreignId('spj_id')->constrained('spj_pelaksana_dinas')->cascadeOnDelete();
            $table->string('perincian_biaya');
            $table->bigInteger('nominal');
            $table->text('keterangan')->nullable();
            $table->string('file');
            $table->timestamps();
        });
        Schema::create('spj_supir_detail', function (Blueprint $table) {
            $table->id();
            $table->foreignId('spj_id')->constrained('spj_supir')->cascadeOnDelete();
            $table->string('perincian_biaya');
            $table->bigInteger('nominal');
            $table->text('keterangan')->nullable();
            $table->string('file');
            $table->timestamps();
        });
        // Schema::create('surat_pertanggung_jawaban_detail', function (Blueprint $table) {
        //     $table->id();
        //     $table->uuid('uuid')->unique();
        //     $table->foreignId('spj_id')->constrained('surat_pertanggung_jawaban')->cascadeOnDelete();
        //     $table->string('perincian_biaya');
        //     $table->bigInteger('nominal');
        //     $table->text('keterangan')->nullable();
        //     $table->string('file');
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spj_pelaksana_dinas');
        Schema::dropIfExists('spj_supir');
        Schema::dropIfExists('spj_pelaksana_dinas_detail');
        Schema::dropIfExists('spj_supir_detail');
    }
};
