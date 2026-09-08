<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('cu_status_user_admins', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_pengajuan_cuti_umum');
            $table->enum('status', ['disetujui', 'belum disetujui', 'perubahan', 'ditangguhkan', 'ditolak']);
            $table->string('catatan', 100)->nullable();
            $table->timestamps();

            // Foreign key to pengajuan_cuti_umums table
            $table->foreign('id_pengajuan_cuti_umum', 'fk_useradmin_pengajuan')
                ->references('id')
                ->on('pengajuan_cuti_umums')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cu_status_user_admins');
    }
};
