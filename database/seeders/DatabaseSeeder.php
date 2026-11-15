<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            SurahSeeder::class,        // 1. Seed 114 Surahs
            UserSeeder::class,         // 2. Seed Users (SuperAdmin, Guru, Parent)
            OrangTuaSeeder::class,     // 3. Seed Orang Tua profiles
            SantriSeeder::class,       // 4. Seed Santri
            PresensiSeeder::class,     // 5. Seed Presensi
            SetoranHafalanSeeder::class, // 6. Seed Setoran Hafalan
        ]);

        $this->command->info('');
        $this->command->info('========================================');
        $this->command->info('✅ Database seeding completed!');
        $this->command->info('========================================');
        $this->command->info('');
        $this->command->info('📋 Login Credentials (Demo Accounts):');
        $this->command->info('');
        $this->command->info('👤 SuperAdmin (Kepala TPQ):');
        $this->command->info('   Email    : kepala@tpqannur.com');
        $this->command->info('   Password : admin123');
        $this->command->info('   Nama     : H. Ahmad Solichin, S.Pd.I');
        $this->command->info('');
        $this->command->info('👨‍🏫 Guru (Ustadzah):');
        $this->command->info('   Email    : ustadzah.fatimah@tpqannur.com');
        $this->command->info('   Password : guru123');
        $this->command->info('   Nama     : Ustadzah Fatimah Az-Zahra, S.Pd.I');
        $this->command->info('');
        $this->command->info('👨‍👩‍👧‍👦 Orang Tua (Wali Santri):');
        $this->command->info('   Email    : budi.rahman@gmail.com');
        $this->command->info('   Password : ortu123');
        $this->command->info('   Nama     : Budi Rahman');
        $this->command->info('   Anak     : 3 santri (Farhan, Aisyah, Zaki)');
        $this->command->info('');
        $this->command->info('📊 Data Summary:');
        $this->command->info('   • 3 Users (1 SuperAdmin, 1 Guru, 1 Parent)');
        $this->command->info('   • 8 Santri total (3 dengan orang tua, 5 tanpa)');
        $this->command->info('   • 114 Surah Al-Qur\'an');
        $this->command->info('========================================');
    }
}
