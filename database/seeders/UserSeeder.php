<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Seed users with different roles - ONE account per role for demo.
     */
    public function run(): void
    {
        // SuperAdmin - Kepala TPQ
        User::updateOrCreate(
            ['email' => 'kepala@tpqannur.com'],
            [
                'name' => 'H. Ahmad Solichin, S.Pd.I',
                'password' => Hash::make('admin123'),
                'role' => 'superadmin',
            ]
        );

        $this->command->info('✓ SuperAdmin created: kepala@tpqannur.com / admin123');

        // Guru - Ustadzah
        User::updateOrCreate(
            ['email' => 'ustadzah.fatimah@tpqannur.com'],
            [
                'name' => 'Ustadzah Fatimah Az-Zahra, S.Pd.I',
                'password' => Hash::make('guru123'),
                'role' => 'guru',
            ]
        );

        $this->command->info('✓ Guru created: ustadzah.fatimah@tpqannur.com / guru123');
    }
}
