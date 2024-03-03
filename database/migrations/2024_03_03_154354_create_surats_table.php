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
        Schema::create('surat', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('perihal');
            $table->string('nomor_surat');
            $table->string('file');
            $table->foreignId('pembuat_user_id')->constrained('users');
            $table->string('status');
            $table->string('jenis_surat');
            $table->string('tanggapan_dari')->nullable();
            $table->string('keterangan')->nullable();
            $table->string('untuk_pembayaran')->nullable();
            $table->timestamps();
        });

        Schema::create('lampiran', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('surat_id')->constrained('surat')->cascadeOnDelete();
            $table->string('file');
            $table->integer('nilai')->nullable();
            $table->string('keterangan')->nullable();
            $table->timestamps();
        });

        Schema::create('pelaksana', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('surat_id')->constrained('surat')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('status')->nullable();
            $table->string('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelaksana');
        Schema::dropIfExists('lampiran');
        Schema::dropIfExists('surat');
    }
};
