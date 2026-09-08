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
        Schema::create('tanda_tangans', function (Blueprint $table) {
            $table->id();
            $table->string('role', 50)->notNullable(); // 'kepalabagian' atau 'kepalabalai'
            $table->string('gambar_ttd_path')->notNullable(); // Path to the file
            $table->string('nama_file', 100)->nullable(); // Nama file asli (opsional)
            $table->timestamp('tanggal_upload')->useCurrent();
            $table->timestamps();
            
            $table->unique('role'); // Memastikan hanya ada satu tanda tangan per role
        });;
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tanda_tangans');
    }
};
