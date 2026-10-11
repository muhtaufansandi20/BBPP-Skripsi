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
        Schema::create('lampirans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_pengajuan_cuti');
            $table->string('nama_doc', 255);
            $table->string('file_path', 255);
            $table->timestamp('uploaded_at')->useCurrent();
            $table->text('description')->nullable();
            $table->timestamps();

            $table->foreign('id_pengajuan_cuti')->references('id')->on('pengajuan_cuti_umums')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lampirans');
    }
};
