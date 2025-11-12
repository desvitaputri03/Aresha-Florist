<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@areshaflorist.com'],
            [
                'name' => 'Admin Aresha Florist',
                'password' => bcrypt('password123'),
                'is_admin' => true,
            ]
        );
    }
}
