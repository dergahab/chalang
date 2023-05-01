<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class RollesAllSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        $path = 'database/seeders/sql-files/roles-all.sql';
        $sql = file_get_contents($path);
        DB::unprepared($sql);
        Schema::enableForeignKeyConstraints();
    }
}
