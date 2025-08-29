<?php

namespace Database\Seeders;

use App\Models\Profile;
use Illuminate\Database\Seeder;

class ProfileSeeder extends Seeder
{
    public function run(): void
    {
        Profile::firstOrCreate([], [
            'name'  => 'Your Name',
            'bio'   => 'Short bio about you. Replace from Admin > Profile.',
            'email' => 'you@example.com',
            'phone' => '+1 (555) 123-4567',
            'socials' => [
                'github'   => 'https://github.com/your-user',
                'linkedin' => 'https://linkedin.com/in/your-profile',
            ],
        ]);
    }
}
