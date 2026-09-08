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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->bigInteger('nip')->unique();
            $table->string('e_mail')->nullable();
            $table->string('password'); 
            $table->enum('role', ['user', 'admin', 'kepalatimkerja', 'kepalabagian', 'kepalabalai','widyaiswara']);
            $table->timestamp('nip_verified_at')->nullable();
            $table->string('no_hp', 15)->nullable();
            $table->string('jabatan', 50)->nullable();
            $table->string('signature')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('nip')->primary();  // Ensure this matches the type of `nip` in 'users' table
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();  // If this is session ID, 'string' is correct
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};

