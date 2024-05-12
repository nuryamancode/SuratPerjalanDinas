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
        Schema::create('form_non_pbj_spj', function (Blueprint $table) {
            $table->id();
            $table->integer('acc_ppk')->default(0);
            $table->text('keterangan_ppk')->nullable();
            $table->foreignId('form_non_pbj_id')->constrained('form_non_pbj')->cascadeOnDelete();
            $table->string('untuk_pembayaran');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_non_pbj_spj');
    }
};
