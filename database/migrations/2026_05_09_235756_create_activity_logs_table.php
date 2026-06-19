<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('action'); // create, update, delete, restore, export, import, login, logout, etc.
            $table->string('entity_type')->nullable(); // App\Models\Service, etc.
            $table->unsignedBigInteger('entity_id')->nullable();
            $table->json('old_values')->nullable(); // JSON of previous state
            $table->json('new_values')->nullable(); // JSON of new state
            $table->text('description')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->string('user_agent')->nullable();
            $table->string('session_id')->nullable();
            $table->string('method')->nullable(); // GET, POST, PUT, DELETE
            $table->string('route')->nullable();
            $table->unsignedInteger('duration_ms')->nullable(); // Response time
            $table->string('status')->default('success'); // success, failed, pending
            $table->text('error_message')->nullable();
            $table->json('metadata')->nullable(); // Additional data
            $table->timestamp('created_at')->useCurrent();

            $table->index(['entity_type', 'entity_id']);
            $table->index('user_id');
            $table->index('action');
            $table->index('created_at');
            $table->index('session_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};