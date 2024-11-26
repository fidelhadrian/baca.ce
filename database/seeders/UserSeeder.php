<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Creating a Superadmin User
        User::updateOrCreate(
            ['personal_id' => 'superadmin001'],
            [
                'name' => 'Super Admin',
                'personal_id' => 'superadmin001',
                'password' => Hash::make('superadmin123'),
                'role_id' => 1, // Assuming 1 represents the Superadmin role
            ]
        );

        // Creating an Admin User
        User::updateOrCreate(
            ['personal_id' => 'admin001'],
            [
                'name' => 'Admin User',
                'personal_id' => 'admin001',
                'password' => Hash::make('admin123'),
                'role_id' => 2, // Assuming 2 represents the Admin role
            ]
        );
    }
}