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
        Schema::create('ct_status_user_admins', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_pengajuan_cuti_tahunan');
            $table->enum('status', ['disetujui', 'belum disetujui', 'perubahan', 'ditangguhkan', 'ditolak']);
            $table->string('catatan', 100)->nullable();
            $table->timestamps();

            // Foreign key ke tabel pengajuan cuti tahunans
            $table->foreign('id_pengajuan_cuti_tahunan')->references('id')->on('pengajuan_cuti_tahunans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ct_status_user_admins');
    }
    
};
