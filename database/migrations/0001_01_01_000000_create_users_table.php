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
            $table->id(); // Primary key for authentication
            $table->string('name'); // User's full name
            $table->string('email')->unique(); // Unique email for login
            $table->string('password'); // Hashed password
            $table->enum('role', ['customer', 'admin', 'collector', 'staff', 'driver'])->default('customer'); // User roles
            $table->boolean('is_active')->default(true); // Account activation status
            $table->timestamp('email_verified_at')->nullable(); // For email verification
            $table->rememberToken(); // For "remember me" functionality
            $table->timestamps(); // Created at and updated at timestamps
        });
        
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary(); // Email used to identify token owner
            $table->string('token'); // Reset token
            $table->timestamp('created_at')->nullable(); // Token creation time
        });
        
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary(); // Session ID
            $table->foreignId('user_id')->nullable()->index(); // Links to authenticated users (nullable for guests)
            $table->string('ip_address', 45)->nullable(); // User's IP address
            $table->text('user_agent')->nullable(); // Information about the user's browser/device
            $table->longText('payload'); // Session data
            $table->integer('last_activity')->index(); // Tracks session activity
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
