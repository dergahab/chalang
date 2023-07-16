<?php

namespace Database\Seeders;

use App\Models\About;
use App\Models\AboutTranslation;
use Illuminate\Database\Seeder;

class AboutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        About::create(['image' => 'default.jpg']);
        AboutTranslation::create([
            'about_id' => 1,
            'title' => 'HAqqimizda',
            'description' => 'asdasdasdasdasd',
            'locale' => 'az'
        ]);
    }
}
