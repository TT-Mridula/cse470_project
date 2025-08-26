<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@skillstacker.test'],
            [
                'name' => 'Site Admin',
                'password' => Hash::make('Password123!'), // change later
                'is_admin' => true,
            ]
        );
    }
}
