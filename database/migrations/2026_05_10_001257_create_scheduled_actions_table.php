<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('scheduled_actions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('name');
            $table->string('action'); // bulk_delete, bulk_activate, bulk_deactivate, etc.
            $table->string('model_type'); // App\Models\Service, etc.
            $table->json('entity_ids'); // Array of entity IDs
            $table->json('filters')->nullable(); // WHERE conditions
            $table->string('status')->default('pending'); // pending, running, completed, failed, cancelled
            $table->timestamp('scheduled_at'); // When to execute
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->unsignedInteger('processed_count')->default(0);
            $table->unsignedInteger('success_count')->default(0);
            $table->unsignedInteger('failed_count')->default(0);
            $table->json('results')->nullable();
            $table->text('error_message')->nullable();
            $table->boolean('is_recurring')->default(false);
            $table->string('recurring_pattern')->nullable(); // daily, weekly, monthly
            $table->timestamp('next_run_at')->nullable();
            $table->timestamps();

            $table->index('status');
            $table->index('scheduled_at');
            $table->index('user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('scheduled_actions');
    }
};