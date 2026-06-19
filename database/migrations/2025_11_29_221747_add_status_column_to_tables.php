<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusColumnToTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('blogs', 'status')) {
            Schema::table('blogs', function (Blueprint $table) {
                $table->boolean('status')->default(1)->after('id');
            });
        }

        if (!Schema::hasColumn('services', 'status')) {
            Schema::table('services', function (Blueprint $table) {
                $table->boolean('status')->default(1)->after('id');
            });
        }

        Schema::table('portfolios', function (Blueprint $table) {
            if (!Schema::hasColumn('portfolios', 'status')) {
                $table->boolean('status')->default(1)->after('id');
            }
        });

        // Migrate data and drop old column if exists
        if (Schema::hasColumn('portfolios', 'is_published')) {
            \DB::statement('UPDATE portfolios SET status = is_published');
            Schema::table('portfolios', function (Blueprint $table) {
                $table->dropColumn('is_published');
            });
        }
    }

    public function down()
    {
        if (Schema::hasColumn('blogs', 'status')) {
            Schema::table('blogs', function (Blueprint $table) {
                $table->dropColumn('status');
            });
        }

        if (Schema::hasColumn('services', 'status')) {
            Schema::table('services', function (Blueprint $table) {
                $table->dropColumn('status');
            });
        }

        if (Schema::hasColumn('portfolios', 'status')) {
             Schema::table('portfolios', function (Blueprint $table) {
                $table->boolean('is_published')->default(1);
            });
            \DB::statement('UPDATE portfolios SET is_published = status');
            Schema::table('portfolios', function (Blueprint $table) {
                $table->dropColumn('status');
            });
        }
    }
}
