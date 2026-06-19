<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('import_histories', function (Blueprint $table) {
            $table->id();
            $table->string('model_type', 100)->comment('Model adı');
            $table->string('file_name', 255)->nullable()->comment('Fayl adı');
            $table->integer('total_rows')->default(0)->comment('Cəmi sətir');
            $table->integer('created_rows')->default(0)->comment('Yaradılan');
            $table->integer('updated_rows')->default(0)->comment('Yenilənən');
            $table->integer('failed_rows')->default(0)->comment('Xətalı');
            $table->string('status', 20)->default('pending')->comment('Status: pending,processing,completed,failed');
            $table->text('errors')->nullable()->comment('Xətalar siyahısı');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('ip_address', 45)->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->json('meta')->nullable();
            $table->timestamps();
            
            $table->index(['model_type', 'status']);
            $table->index('user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('import_histories');
    }
};