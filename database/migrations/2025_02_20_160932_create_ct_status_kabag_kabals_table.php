<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ct_status_kabag_kabals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_ct_status_katimker_kabag');
            $table->enum('status', ['disetujui', 'belum disetujui', 'perubahan', 'ditangguhkan', 'ditolak']);
            $table->string('catatan', 100)->nullable();
            $table->timestamps();

            // Foreign key ke tabel ct_status_katimker_kabags
            $table->foreign('id_ct_status_katimker_kabag')->references('id')->on('ct_status_katimker_kabags')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ct_status_kabag_kabals');
    }
};
