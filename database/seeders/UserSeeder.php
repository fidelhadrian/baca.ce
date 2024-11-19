<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // User: Fadhil Hadrian Azzami (student & admin)
        $user1 = User::create([
            'personal_id' => '21120121130120',
            'name' => 'Fadhil Hadrian Azzami',
            'password' => bcrypt('password123'),
        ]);

        // Tambahkan roles ke tabel pivot menggunakan personal_id
        Role::where('name', 'student')->first()->users()->attach('21120121130120');
        Role::where('name', 'admin')->first()->users()->attach('21120121130120');

        // User: Super Admin
        $user2 = User::create([
            'personal_id' => '18125019112024',
            'name' => 'Super Admin',
            'password' => bcrypt('superadmin123'),
        ]);

        // Tambahkan roles ke tabel pivot menggunakan personal_id
        Role::where('name', 'superadmin')->first()->users()->attach('18125019112024');
    }
}
