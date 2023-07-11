<?php

namespace Database\Seeders;

use App\Models\Lang;
use Illuminate\Database\Seeder;

class LangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $langs = ['az' => 'Azərbaycan', 'en' => 'English'];

        foreach ($langs as $lang => $country) {
            Lang::create([
                'lang' => $lang,
                'country' => $country,
            ]);
        }
    }
}
