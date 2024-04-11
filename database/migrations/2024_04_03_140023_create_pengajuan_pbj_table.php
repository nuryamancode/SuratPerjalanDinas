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
        Schema::create('pengajuan_barang_jasa', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('perihal');
            $table->string('nomor_surat');
            $table->string('nomor_agenda');
            $table->string('status');
            $table->enum('jenis', ['pbj', 'surat non pbj', 'formulir non pbj']);
            $table->foreignId('pembuat_karyawan_id')->constrained('karyawan');
            $table->date('tanggal');
            $table->timestamps();
        });

        Schema::create('pengajuan_barang_jasa_pelaksana', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('pengajuan_barang_jasa_id')->constrained('pengajuan_barang_jasa')->cascadeOnDelete();
            $table->foreignId('karyawan_id')->constrained('karyawan');
            $table->string('keterangan')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });

        Schema::create('pengajuan_barang_jasa_detail', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('pengajuan_barang_jasa_id')->constrained('pengajuan_barang_jasa')->cascadeOnDelete();
            $table->string('kebutuhan_barang');
            $table->string('volume')->nullable();
            $table->string('satuan');
            $table->bigInteger('harga_satuan');
            $table->integer('jumlah');
            $table->bigInteger('total_harga');
            $table->string('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengajuan_barang_jasa_pelaksana', function (Blueprint $table) {
            $table->dropForeign(['pengajuan_barang_jasa_id']);
        });

        Schema::table('pengajuan_barang_jasa_detail', function (Blueprint $table) {
            $table->dropForeign(['pengajuan_barang_jasa_id']);
        });

        Schema::dropIfExists('pengajuan_barang_jasa');
        Schema::dropIfExists('pengajuan_barang_jasa_pelaksana');
        Schema::dropIfExists('pengajuan_barang_jasa_detail');
    }
};
