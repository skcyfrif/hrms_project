<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if the admin user already exists before inserting
        if (!DB::table('users')->where('email', 'admin@gmail.com')->exists()) {
            DB::table('users')->insert([
                'name'     => 'Admin',
                'username' => 'admin',
                'email'    => 'admin@gmail.com',
                'password' => Hash::make('111'),
                'role'     => 'admin',
                'status'   => 'active'
            ]);
        }

        // Check if the agent user already exists before inserting
        if (!DB::table('users')->where('email', 'agent@gmail.com')->exists()) {
            DB::table('users')->insert([
                'name'     => 'Agent',
                'username' => 'agent',
                'email'    => 'agent@gmail.com',
                'password' => Hash::make('111'),
                'role'     => 'agent',
                'status'   => 'active'
            ]);
        }

        // Check if the user already exists before inserting
        if (!DB::table('users')->where('email', 'user@gmail.com')->exists()) {
            DB::table('users')->insert([
                'name'     => 'User',
                'username' => 'user',
                'email'    => 'user@gmail.com',
                'password' => Hash::make('111'),
                'role'     => 'user',
                'status'   => 'active'
            ]);
        }
    }
}
