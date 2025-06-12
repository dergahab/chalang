<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            ContactSeeder::class,
            SocialmediaSeeder::class,
            StepSeeder::class,
            SubcompoundSeeder::class,
            SubscribeSeeder::class,
            TagSeeder::class,
            PcategorySeeder::class,
            PortfolioSeeder::class,
            PostSeeder::class,
            ServiceSeeder::class,
            SettingSeeder::class,
            TeamSeeder::class,
            TestimonialSeeder::class,
            VideoSeeder::class,
        ]);
    }
}
