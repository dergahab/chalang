<?php

namespace Database\Seeders;

use App\Models\Banner;
use Illuminate\Database\Seeder;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Banner::create([
            'title' => 'Welcome to Our Company',
            'description' => 'We provide the best services for your business',
            'image' => 'banner.jpg',
        ]);
    }
} 