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
        Schema::create('pengajuan_cuti_tahunans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->date('tgl_pengajuan')->notNullable();
            $table->date('tgl_mulai')->notNullable();
            $table->date('tgl_selesai')->notNullable();
            $table->integer('lama_cuti')->notNullable();
            $table->string('alasan', 255)->notNullable();
            $table->string('catatan', 255)->nullable();
            $table->string('alamat_saat_cuti', 255)->notNullable();
            $table->string('no_hp_cuti', 15)->notNullable();
            $table->string('masa_kerja')->notNullable();
            $table->integer('no_surat')->nullable();
            $table->boolean('is_katimker')->default(false);
            $table->boolean('is_kabag')->default(false);
            $table->timestamps(); 

            // foreign key jika user_id berhubungan dengan tabel users
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan_cuti_tahunans');
    }
};
