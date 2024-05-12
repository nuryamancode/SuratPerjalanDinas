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
        Schema::create('pbj', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_surat');
            $table->string('nomor_agenda');
            $table->string('perihal');
            $table->string('dokumen_surat');
            $table->foreignId('diteruskan_ke')->nullable()->constrained('karyawan')->cascadeOnDelete();
            $table->foreignId('asal_surat')->nullable()->constrained('karyawan')->cascadeOnDelete();
            $table->string('status_surat');
            $table->boolean('acc_kabag')->nullable()->default(0);
            $table->string('nilai_taksiran')->nullable();
            $table->boolean('acc_wadir1')->nullable()->default(0);
            $table->enum('acc_wadir2', [0, 1, 2])->nullable()->default(0);
            $table->enum('acc_ppk', [0, 1, 2])->nullable()->default(0);
            $table->boolean('verifikasi_wadir2')->default(0);
            $table->boolean('verifikasi_ppk')->default(0);
            $table->boolean('acc_pengusul')->nullable()->default(0);
            $table->text('keterangan_ppk')->nullable();
            $table->text('keterangan_wadir2')->nullable();
            $table->enum('jenis', ['pbj', 'non pbj surat', 'non pbj formulir']);
            $table->timestamps();
        });
        Schema::create('lampiran_pbj', function (Blueprint $table) {
            $table->id();
            $table->string('file');
            $table->foreignId('pbj_id')->nullable()->constrained('pbj')->cascadeOnDelete();
            $table->timestamps();
        });
        Schema::create('tahapan_pbj', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

        Schema::dropIfExists('pbj');
        Schema::dropIfExists('lampiran_pbj');
    }
};
