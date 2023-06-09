<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Dergah',
            'email' => 'admin@chalang.com',
            'email_verified_at' => now(),
            'type' => 'admin',
            'password' => '$2y$10$Kxz7EBy7kTkDSQhdzK6ZKuq1xJfJ2Gt3f1ItOmWUpVum0LCh4wBMK', // 123123
            'remember_token' => Str::random(10),
        ]);
    }
}
