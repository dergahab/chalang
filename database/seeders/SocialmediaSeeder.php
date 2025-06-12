<?php

namespace Database\Seeders;

use App\Models\Socialmedia;
use Illuminate\Database\Seeder;

class SocialmediaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Socialmedia::create([
            'name' => 'Facebook',
            'link' => 'https://facebook.com',
            'icon' => 'fab fa-facebook-f',
        ]);
    }
}
