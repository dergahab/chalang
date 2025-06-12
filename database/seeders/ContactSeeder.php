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
            'address' => '123 Main St',
            'phone' => '123-456-7890',
            'email' => 'contact@example.com',
        ]);
    }
}
