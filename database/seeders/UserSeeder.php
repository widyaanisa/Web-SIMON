<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'username' => 'test',
            'password' => bcrypt('test'),
            'nama_pengguna' => 'siapa',
            'email' => 'test@mail.com',
            'role' => 'user',
        ]);
        
        $mainadmin = User::create([
            'username' => 'mainadmin',
            'password' => bcrypt('mainadmin'),
            'nama_pengguna' => 'MainAdmin',
            'email' => 'mainadmin@mail.com',
            'role' => 'mainadmin',
        ]);

        // $mainadmin->assignRole('mainadmin');

        $admin = User::create([
            'username' => 'admin',
            'password' => bcrypt('admin'),
            'nama_pengguna' => 'Admin',
            'email' => 'admin@mail.com',
            'role' => 'admin',
        ]);

        // $admin->assignRole('admin');

        $user = User::create([
            'username' => 'user',
            'password' => bcrypt('user'),
            'nama_pengguna' => 'User',
            'email' => 'user@mail.com',
            'role' => 'user',
        ]);
     


        // $user->assignRole('user');

        $surveiyor = User::create([
            'username' => 'surveiyor',
            'password' => bcrypt('surveiyor'),
            'nama_pengguna' => 'Surveiyor',
            'email' => 'surveiyor@mail.com',
            'role' => 'surveiyor',
        ]);

        // $surveiyor->assignRole('surveiyor');

    }
}
