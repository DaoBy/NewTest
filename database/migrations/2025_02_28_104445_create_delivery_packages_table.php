<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('delivery_packages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('delivery_request_id')->constrained()->cascadeOnDelete();
            $table->text('description');
            $table->decimal('height', 8, 2);
            $table->decimal('width', 8, 2);
            $table->decimal('length', 8, 2);
            $table->decimal('weight', 8, 2);
            $table->integer('quantity');
            $table->decimal('volume', 12, 4); // Precomputed volume (Height × Width × Length)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('delivery_packages');
    }
};
