<?php
declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            PermissionSeeder::class,
            LangSeeder::class,
            UserSeeder::class,
            BannerSeeder::class,
            AboutSeeder::class,
            ContactSeeder::class,
            PortfolioSeeder::class,
            AbstrakSeeder::class,
            ContentTextSeeder::class,
        ]);
    }
}
