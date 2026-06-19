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
        Schema::create('analytics_events', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('session_id', 255)->index();
            $table->string('event_type', 50)->index(); // page_view, click, conversion, custom
            $table->string('event_name', 255);
            $table->json('event_data')->nullable();
            $table->string('page_url', 500)->nullable();
            $table->string('page_title', 255)->nullable();
            $table->text('user_agent')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->string('referrer', 500)->nullable();
            $table->string('device_type', 50)->nullable(); // desktop, mobile, tablet
            $table->string('browser', 50)->nullable();
            $table->string('os', 50)->nullable();
            $table->string('country', 2)->nullable();
            $table->string('city', 100)->nullable();
            $table->unsignedBigInteger('experiment_id')->nullable();
            $table->string('experiment_variant', 100)->nullable();
            $table->decimal('conversion_value', 10, 2)->nullable();
            $table->timestamp('timestamp')->useCurrent();

            $table->timestamps();

            // Indexes for performance
            $table->index(['event_type', 'timestamp']);
            $table->index(['user_id', 'timestamp']);
            $table->index(['experiment_id', 'timestamp']);
            $table->index(['session_id', 'timestamp']);

            // Foreign keys
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('experiment_id')->references('id')->on('experiments')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('analytics_events');
    }
};
