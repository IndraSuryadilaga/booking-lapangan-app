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
        Schema::create('field_pricing', function (Blueprint $table) {
            $table->id();
            $table->foreignId('field_id')->constrained()->cascadeOnDelete();
            $table->enum('day_type', ['weekday', 'weekend', 'holiday']);
            $table->decimal('price_per_slot', 12, 2);
            $table->timestamps();
            // Ensure a field has only one pricing entry per day type
            $table->unique(['field_id', 'day_type'], 'uq_field_day_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('field_pricings');
    }
};
