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
    Schema::create('venue_facilities', function (Blueprint $table) {
        $table->foreignId('venue_id')
            ->constrained()
            ->onDelete('cascade');

        $table->foreignId('facility_id')
            ->constrained()
            ->onDelete('cascade');

        $table->primary(['venue_id', 'facility_id']);
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('venue_facilities');
    }
};
