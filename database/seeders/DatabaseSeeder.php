<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
// use Database\Seeders\AdminUserSeeder; // optional import (same namespace)

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // keep or remove this sample user as you wish
        // \App\Models\User::factory()->create([
        //     'name'  => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        
        $this->call([
            AdminUserSeeder::class,
        ]);
    }
}
