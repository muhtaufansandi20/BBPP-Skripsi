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
        Schema::create('log_edit_kcts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_kuota_cuti_tahunan')->constrained('kuota_cuti_tahunan')->onDelete('cascade');
            $table->date('date_edit');
            $table->time('time_edit');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_edit_kcts');
    }
};
