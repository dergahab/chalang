<?php

namespace Database\Seeders;

use App\Models\Pcategory;
use Illuminate\Database\Seeder;

class PcategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Pcategory::create([
            'name' => 'Category 1',
        ]);
    }
} 