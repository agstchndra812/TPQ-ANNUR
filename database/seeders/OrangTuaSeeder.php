<?php

namespace Database\Seeders;

use App\Models\OrangTua;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class OrangTuaSeeder extends Seeder
{
    /**
     * Seed sample orang tua (parents) - ONE parent account for demo.
     */
    public function run(): void
    {
        // Parent - Bapak Santri
        $parentUser = User::updateOrCreate(
            ['email' => 'budi.rahman@gmail.com'],
            [
                'name' => 'Budi Rahman',
                'password' => Hash::make('ortu123'),
                'role' => 'parent',
            ]
        );

        OrangTua::updateOrCreate(
            ['user_id' => $parentUser->id],
            [
                'no_hp' => '081234567890',
                'alamat' => 'Jl. Merdeka No. 45, Kelurahan Baranangsiang, Kecamatan Bogor Timur, Kota Bogor 16143',
            ]
        );

        $this->command->info('✓ Parent created: budi.rahman@gmail.com / ortu123');
    }
}
