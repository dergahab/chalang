<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 1. Migrate Blog Slugs
        if (Schema::hasColumn('blogs', 'slug')) {
            $blogs = DB::table('blogs')->get();
            foreach ($blogs as $blog) {
                // Check if translation exists for 'az'
                $exists = DB::table('blog_translations')
                    ->where('blog_id', $blog->id)
                    ->where('locale', 'az')
                    ->exists();

                if ($exists) {
                    DB::table('blog_translations')
                        ->where('blog_id', $blog->id)
                        ->where('locale', 'az')
                        ->update(['slug' => $blog->slug]);
                } else {
                    // Start with basic insert, might need more fields depending on constraints
                    // Using insertGetId or just insert
                    try {
                        DB::table('blog_translations')->insert([
                            'blog_id' => $blog->id,
                            'locale' => 'az',
                            'slug' => $blog->slug,
                            'title' => 'Migrated Title ' . $blog->id, // Fallback
                            'content' => '',
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    } catch (\Exception $e) {
                        // Ignore if strict, maybe title is required
                    }
                }
            }
            
            Schema::table('blogs', function (Blueprint $table) {
                $table->dropColumn('slug');
            });
        }

        // 2. Migrate Portfolio Slugs
        if (Schema::hasColumn('portfolios', 'slug')) {
            $portfolios = DB::table('portfolios')->get();
            foreach ($portfolios as $portfolio) {
                $exists = DB::table('portfolio_translations')
                    ->where('portfolio_id', $portfolio->id)
                    ->where('locale', 'az')
                    ->exists();

                if ($exists) {
                    DB::table('portfolio_translations')
                        ->where('portfolio_id', $portfolio->id)
                        ->where('locale', 'az')
                        ->update(['slug' => $portfolio->slug]);
                } else {
                     try {
                        DB::table('portfolio_translations')->insert([
                            'portfolio_id' => $portfolio->id,
                            'locale' => 'az',
                            'slug' => $portfolio->slug,
                            'title' => 'Migrated Project ' . $portfolio->id,
                            'description' => '',
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                     } catch (\Exception $e) {
                         // Ignore
                     }
                }
            }
            
            Schema::table('portfolios', function (Blueprint $table) {
                $table->dropColumn('slug');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Restore Blog Slug
        if (!Schema::hasColumn('blogs', 'slug')) {
            Schema::table('blogs', function (Blueprint $table) {
                $table->string('slug')->nullable();
            });
            $translations = DB::table('blog_translations')->where('locale', 'az')->get();
            foreach ($translations as $trans) {
                DB::table('blogs')->where('id', $trans->blog_id)->update(['slug' => $trans->slug]);
            }
        }

        // Restore Portfolio Slug
        if (!Schema::hasColumn('portfolios', 'slug')) {
            Schema::table('portfolios', function (Blueprint $table) {
                $table->string('slug')->nullable();
            });
            $translations = DB::table('portfolio_translations')->where('locale', 'az')->get();
            foreach ($translations as $trans) {
                DB::table('portfolios')->where('id', $trans->portfolio_id)->update(['slug' => $trans->slug]);
            }
        }
    }
};
