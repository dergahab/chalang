<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('export_schedules', function (Blueprint $table) {
            $table->id();
            $table->string('model_type', 100)->comment('Model adi');
            $table->string('format', 10)->default('csv')->comment('Export format');
            $table->string('frequency', 20)->comment('Frequency: daily, weekly, monthly');
            $table->json('filters')->nullable()->comment('Filterler');
            $table->string('email_to')->nullable()->comment('Email bildirimleri');
            $table->timestamp('last_run_at')->nullable();
            $table->timestamp('next_run_at')->nullable();
            $table->boolean('is_active')->default(true);
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('status', 20)->default('pending');
            $table->string('last_file_name', 255)->nullable();
            $table->text('error_message')->nullable();
            $table->timestamps();

            $table->index(['model_type', 'status']);
            $table->index(['is_active', 'next_run_at']);
            $table->index('user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('export_schedules');
    }
};