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
        Schema::create('cu_status_admin_kabals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cu_status_user_admin_id');
            $table->enum('status', ['disetujui', 'belum disetujui', 'perubahan', 'ditangguhkan', 'ditolak']);
            $table->string('catatan', 100)->nullable();
            $table->timestamps();

            $table->foreign('cu_status_user_admin_id', 'fk_adminkabal_useradmin')
                ->references('id')
                ->on('cu_status_user_admins')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cu_status_admin_kabals');
    }
};
