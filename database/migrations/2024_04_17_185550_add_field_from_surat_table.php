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
        Schema::table('surat', function (Blueprint $table) {
            $table->text('maksud_perjalanan_dinas')->nullable();
            $table->date('tanggal_mulai')->nullable();
            $table->date('tanggal_sampai')->nullable();
            $table->string('tempat_berangkat')->nullable();
            $table->string('tempat_tujuan')->nullable();
            $table->string('no_surat_jalan_dinas')->nullable();
            $table->integer('antar')->nullable();
            $table->date('tanggal_surat_jalan')->nullable();
            $table->foreignId('supir_karyawan_id')->nullable()->constrained('karyawan')->nullOnDelete();
            $table->string('lampiran_surat_tugas')->nullable();
            $table->string('uraian_tugas')->nullable();
            $table->date('mulai_tanggal_tugas')->nullable();
            $table->date('sampai_tanggal_tugas')->nullable();
            $table->dropColumn('no_agenda');
            $table->dropColumn('perihal');
            $table->dropColumn('asal_surat');
            $table->dropColumn('tanggapan_dari');
            $table->dropColumn('keterangan');
            $table->dropColumn('untuk_pembayaran');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('surat', function (Blueprint $table) {
            $table->dropColumn('maksud_perjalanan_dinas');
            $table->dropColumn('tanggal_mulai');
            $table->dropColumn('tanggal_sampai');
            $table->dropColumn('tempat_berangkat');
            $table->dropColumn('tempat_tujuan');
            $table->dropColumn('no_surat_jalan_dinas');
            $table->dropColumn('antar');
            $table->dropColumn('tanggal_surat_jalan');
            $table->dropColumn('nama_pengemudi');
            $table->dropColumn('uraian_tugas');
            $table->dropColumn('lampiran_surat_tugas');
            $table->dropColumn('mulai_tanggal_tugas');
            $table->dropColumn('sampai_tanggal_tugas');
            $table->string('no_agenda')->nullable();
            $table->string('perihal')->nullable();
            $table->string('asal_surat')->nullable();
            $table->string('tanggapan_dari')->nullable();
            $table->string('keterangan')->nullable();
            $table->string('untuk_pembayaran')->nullable();
        });
    }
};
