<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('telegram_notification_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subscriber_id')->nullable()->constrained('telegram_subscribers')->nullOnDelete();
            $table->string('chat_id', 50);
            $table->string('type', 60)->default('general')->comment('contact_form, system_alert, test, bulk, scheduled...');
            $table->text('message_preview')->nullable()->comment('İlk 200 simvol');
            $table->enum('status', ['sent', 'failed', 'pending'])->default('pending');
            $table->text('error_message')->nullable();
            $table->unsignedTinyInteger('attempts')->default(0);
            $table->timestamp('sent_at')->nullable();
            $table->timestamps();

            $table->index(['status', 'created_at']);
            $table->index(['chat_id', 'type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('telegram_notification_logs');
    }
};
