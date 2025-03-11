<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('delivery_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->cascadeOnDelete(); // Links to users table
            $table->foreignId('sender_id')->constrained('customers')->cascadeOnDelete(); // Sender in customers table
            $table->foreignId('receiver_id')->constrained('customers')->cascadeOnDelete(); // Receiver in customers table
            
            // Sender Information
            $table->enum('sender_type', ['individual', 'company']); // Aligned with customer_type
            $table->string('sender_name');
            $table->string('sender_company_name')->nullable();
            $table->string('sender_mobile');
            $table->string('sender_email')->nullable();
            $table->string('sender_street');
            $table->string('sender_city');
            $table->string('sender_province');
            $table->string('sender_zip');
            $table->string('drop_off_branch');

            // Receiver Information
            $table->enum('receiver_type', ['individual', 'company']); // Aligned with customer_type
            $table->string('receiver_name');
            $table->string('receiver_company_name')->nullable();
            $table->string('receiver_mobile');
            $table->string('receiver_email')->nullable();
            $table->string('receiver_street');
            $table->string('receiver_city');
            $table->string('receiver_province');
            $table->string('receiver_zip');
            $table->string('pick_up_branch');

            // Package and Payment Details
            $table->json('packages'); // Stores package details
            $table->enum('payment_method', ['cash', 'card']);
            $table->decimal('total_price', 10, 2);

            // Request Status
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('delivery_requests');
    }
};
