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
            'address' => '123 Main Street, City',
            'phone' => '+1234567890',
            'mail' => 'contact@example.com',
        ]);
    }
}
