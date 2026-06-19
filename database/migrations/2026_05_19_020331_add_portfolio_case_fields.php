<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPortfolioCaseFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('portfolio_translations', function (Blueprint $table) {
            $table->string('short_description', 255)->nullable()->after('description');
            $table->text('problem')->nullable()->after('short_description');
            $table->text('solution')->nullable()->after('problem');
            $table->text('result')->nullable()->after('solution');
        });
    }

    public function down()
    {
        Schema::table('portfolio_translations', function (Blueprint $table) {
            $table->dropColumn(['short_description', 'problem', 'solution', 'result']);
        });
    }
}
