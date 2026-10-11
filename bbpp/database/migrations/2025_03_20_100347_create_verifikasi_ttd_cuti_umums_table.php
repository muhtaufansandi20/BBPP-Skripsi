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
        Schema::create('verifikasi_ttd_cuti_umums', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pengajuan_cuti_umum_id');
            $table->boolean('ttd_kabag')->default(false);
            $table->boolean('ttd_kabalai')->default(false);
            $table->timestamp('tanggal_ttd_kabag')->nullable();
            $table->timestamp('tanggal_ttd_kabalai')->nullable();
            $table->timestamps();
            
            $table->foreign('pengajuan_cuti_umum_id')
                    ->references('id')
                    ->on('pengajuan_cuti_umums')
                    ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('verifikasi_ttd_cuti_umums');
    }
};
