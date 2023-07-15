<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceContentOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_content_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('servis_content_id')->constrained();
            $table->string('title_az')->nullable();
            $table->string('title_en')->nullable();
            $table->text('content_az')->nullable();
            $table->text('content_en')->nullable();
            $table->string('icon');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('service_content_options');
    }
}
