<?php

use App\Models\Subcompound;
use Illuminate\Database\Seeder;

class SubcompoundSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Subcompound::create([
            'name' => 'Subcompound 1',
            'description' => 'This is a subcompound.',
        ]);
    }
} 