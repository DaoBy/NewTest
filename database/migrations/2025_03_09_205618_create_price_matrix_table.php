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
        Schema::create('price_matrix', function (Blueprint $table) {
            $table->id();
            $table->decimal('base_fee', 10, 2)->default(500);
            $table->decimal('volume_rate', 10, 2)->default(50);
            $table->decimal('weight_rate', 10, 2)->default(20);
            $table->decimal('package_rate', 10, 2)->default(10);
            $table->timestamps();
        });
        
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('price_matrix');
    }
};
