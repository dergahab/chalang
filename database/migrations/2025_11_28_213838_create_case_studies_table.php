<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCaseStudiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('case_studies', function (Blueprint $table) {
            $table->id();
            $table->string('cover_image')->nullable();
            $table->json('kpi_data')->nullable();
            $table->json('gallery_images')->nullable();
            $table->boolean('in_main')->default(false);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('case_study_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('case_study_id')->constrained()->onDelete('cascade');
            $table->string('locale')->index();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('problem')->nullable();
            $table->text('solution')->nullable();
            $table->text('result')->nullable();
            $table->string('category')->nullable();
            
            $table->unique(['case_study_id', 'locale']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('case_study_translations');
        Schema::dropIfExists('case_studies');
    }
}
