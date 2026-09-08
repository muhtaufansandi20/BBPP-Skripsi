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
        Schema::create('hari_liburs', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal')->unique(); // Kita jadikan unik agar tidak ada duplikasi tanggal
            $table->string('nama'); // Menyimpan nama hari libur/kegiatan
            $table->enum('tipe', ['libur_nasional', 'blackout']); // Sesuai dengan opsi di form Anda
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hari_liburs');
    }
};