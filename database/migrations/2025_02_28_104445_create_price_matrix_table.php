<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('price_matrix', function (Blueprint $table) {
            $table->id();
            $table->decimal('min_volume', 12, 4); // Minimum volume range
            $table->decimal('max_volume', 12, 4); // Maximum volume range
            $table->decimal('price', 12, 2);      // Delivery price
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('price_matrix');
    }
};
