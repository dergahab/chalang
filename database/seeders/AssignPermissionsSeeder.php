<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Permission;

class AssignPermissionsSeeder extends Seeder
{
    public function run()
    {
        $user = User::where('email', 'admin@example.com')->first();
        
        if ($user) {
            $permissions = Permission::all();
            $user->syncPermissions($permissions);
            $this->command->info('Permissions synced to admin@example.com');
        } else {
            $this->command->error('User admin@example.com not found');
        }
    }
}
