<?php

namespace Database\Seeders;

use App\Models\Contact;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Contact::create([
            'mail' => 'example@mail.com',
            'phone' => '+994000000000',
            'address' => 'Mars',
        ]);
    }
}
