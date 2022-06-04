<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Roles;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Roles::create([
            'name' => 'mainadmin',
            'guard_name' => 'web'
        ]);
        Roles::create([
            'name' => 'admin',
            'guard_name' => 'web'
        ]);
        Roles::create([
            'name' => 'user',
            'guard_name' => 'web'
        ]);
        Roles::create([
            'name' => 'surveiyor',
            'guard_name' => 'web'
        ]);
    }
}
