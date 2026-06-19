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
        Schema::create('experiment_results', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('experiment_id');
            $table->unsignedBigInteger('variant_id');
            $table->string('session_id'); // User session identifier
            $table->string('user_id')->nullable(); // If user is logged in
            $table->string('event_type'); // 'view', 'click', 'conversion', 'custom'
            $table->string('event_name')->nullable(); // Specific event name
            $table->json('event_data')->nullable(); // Additional event data
            $table->string('page_url')->nullable(); // Current page URL
            $table->json('user_agent')->nullable(); // Browser/device info
            $table->string('ip_address')->nullable();
            $table->timestamp('occurred_at');

            $table->foreign('experiment_id')->references('id')->on('experiments')->onDelete('cascade');
            $table->foreign('variant_id')->references('id')->on('experiment_variants')->onDelete('cascade');
            $table->index(['experiment_id', 'variant_id']);
            $table->index(['session_id', 'experiment_id']);
            $table->index('event_type');
            $table->index('occurred_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('experiment_results');
    }
};
