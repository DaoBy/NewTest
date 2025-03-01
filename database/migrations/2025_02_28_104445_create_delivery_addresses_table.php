<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('delivery_addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('delivery_request_id')->constrained()->cascadeOnDelete();
            $table->enum('type', ['sender', 'receiver']);
            $table->string('first_name');
            $table->string('last_name');
            $table->string('company_name')->nullable(); // For company-type customers
            $table->string('mobile');
            $table->string('street');
            $table->string('city');
            $table->string('province');
            $table->string('zip');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('delivery_addresses');
    }
};
