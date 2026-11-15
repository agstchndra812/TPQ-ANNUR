<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create SuperAdmin user if doesn't exist
        User::firstOrCreate(
            ['email' => 'superadmin@tpq.com'],
            [
                'name' => 'Super Administrator',
                'password' => Hash::make('superadmin123'),
                'role' => 'superadmin',
            ]
        );

        $this->command->info('SuperAdmin created successfully!');
        $this->command->info('Email: superadmin@tpq.com');
        $this->command->info('Password: superadmin123');
    }
}
