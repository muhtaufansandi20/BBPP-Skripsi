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
        Schema::create('cu_status_kabag_kabals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cu_status_katimker_kabag_id');
            $table->enum('status', ['disetujui', 'belum disetujui', 'perubahan', 'ditangguhkan', 'ditolak']);
            $table->string('catatan', 100)->nullable();
            $table->timestamps();
        
            $table->foreign('cu_status_katimker_kabag_id', 'fk_kabalkabag_katimkerkabag')
                ->references('id')
                ->on('cu_status_katimker_kabags')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cu_status_kabag_kabals');
    }
};
