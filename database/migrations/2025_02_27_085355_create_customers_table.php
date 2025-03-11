<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id(); // Unique customer ID (for both registered and walk-ins)
            $table->foreignId('user_id')->nullable()->unique()->constrained()->onDelete('cascade');
            $table->string('name'); // Full name for both registered and walk-in customers
            $table->string('mobile')->nullable(); // Aligned with DeliveryRequest 'sender_mobile'
            $table->string('email')->nullable(); // Optional for walk-ins
            $table->string('street')->nullable(); // Address details
            $table->string('city')->nullable();
            $table->string('province')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('company_name')->nullable(); // For B2B customers
            $table->boolean('is_system')->default(false); // Identifies walk-ins (true = walk-in customer)
            $table->timestamps(); // Created at and updated at timestamps
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
