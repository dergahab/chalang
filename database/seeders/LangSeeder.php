<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $languages = [
            [
                'country' => 'Azerbaijan',
                'lang' => 'az',
            ],
            [
                'country' => 'English',
                'lang' => 'en',
            ],
            [
                'country' => 'Russia',
                'lang' => 'ru',
            ],
        ];

        foreach ($languages as $language) {
            DB::table('langs')->updateOrInsert(
                ['lang' => $language['lang']],
                $language
            );
        }
    }
}
