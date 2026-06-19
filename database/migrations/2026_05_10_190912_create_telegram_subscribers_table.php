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
        Schema::create('telegram_subscribers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('chat_id')->nullable()->unique();
            $table->string('username')->nullable();
            $table->string('verification_code', 10)->nullable()->unique();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_silent')->default(false);
            $table->json('notification_settings')->nullable(); // JSON stores toggles like: {"order_created": true, "critical_stock": false}
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('telegram_subscribers');
    }
};
