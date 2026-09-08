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
        Schema::create('status_cuti_tahunans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_cuti_tahunan');
            $table->enum('status', ['dibatalkan','diajukan']);
            $table->string('catatan', 255)->nullable();
            $table->timestamps();

            // Foreign key ke tabel pengajuan_cuti_tahunan
            $table->foreign('id_cuti_tahunan')->references('id')->on('pengajuan_cuti_tahunans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('status_cuti_tahunans');
    }
};
