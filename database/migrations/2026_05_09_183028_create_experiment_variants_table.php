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
        Schema::create('experiment_variants', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('experiment_id');
            $table->string('name'); // e.g., "Control", "Variant A", "Variant B"
            $table->string('key')->unique(); // e.g., "control", "variant_a"
            $table->text('description')->nullable();
            $table->json('configuration'); // Variant-specific settings
            $table->decimal('traffic_weight', 5, 2)->default(0.00); // Distribution weight
            $table->boolean('is_control')->default(false); // Is this the control variant
            $table->timestamps();

            $table->foreign('experiment_id')->references('id')->on('experiments')->onDelete('cascade');
            $table->unique(['experiment_id', 'key']);
            $table->index('experiment_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('experiment_variants');
    }
};
