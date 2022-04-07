<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::create([
            'name' => 'Anda adalah Admin',
            'email' => 'admin@asiifdev.me',
            'password' => bcrypt('123456')
        ]);

        $admin->assignRole('Admin');
        
        $user = User::create([
            'name' => 'Anda User',
            'email' => 'user@asiifdev.me',
            'password' => bcrypt('123456')
        ]);

        $user->assignRole('User');
    }
}
