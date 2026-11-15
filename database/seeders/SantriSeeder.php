<?php

namespace Database\Seeders;

use App\Models\OrangTua;
use App\Models\Santri;
use Illuminate\Database\Seeder;

class SantriSeeder extends Seeder
{
    /**
     * Seed realistic santri data.
     */
    public function run(): void
    {
        // Get parent
        $parent = OrangTua::whereHas('user', function ($q) {
            $q->where('email', 'budi.rahman@gmail.com');
        })->first();

        if (!$parent) {
            $this->command->error('❌ Parent not found! Run OrangTuaSeeder first.');
            return;
        }

        // Santri 1 - Anak pertama (sudah bisa baca Al-Qur'an)
        Santri::updateOrCreate(
            ['nis' => '2024001'],
            [
                'orang_tua_id' => $parent->id,
                'nama_lengkap' => 'Muhammad Farhan Rahman',
                'jenis_kelamin' => 'L',
                'tempat_lahir' => 'Bogor',
                'tanggal_lahir' => '2015-03-15',
                'jilid_kelas' => "Al-Qur'an",
                'status_aktif' => true,
            ]
        );

        $this->command->info('✓ Santri created: Muhammad Farhan Rahman (Al-Qur\'an)');

        // Santri 2 - Anak kedua (masih jilid)
        Santri::updateOrCreate(
            ['nis' => '2025002'],
            [
                'orang_tua_id' => $parent->id,
                'nama_lengkap' => 'Aisyah Putri Rahman',
                'jenis_kelamin' => 'P',
                'tempat_lahir' => 'Bogor',
                'tanggal_lahir' => '2017-08-22',
                'jilid_kelas' => 'Jilid 4',
                'status_aktif' => true,
            ]
        );

        $this->command->info('✓ Santri created: Aisyah Putri Rahman (Jilid 4)');

        // Santri 3 - Anak ketiga (masih pemula)
        Santri::updateOrCreate(
            ['nis' => '2026003'],
            [
                'orang_tua_id' => $parent->id,
                'nama_lengkap' => 'Ahmad Zaki Rahman',
                'jenis_kelamin' => 'L',
                'tempat_lahir' => 'Bogor',
                'tanggal_lahir' => '2019-11-05',
                'jilid_kelas' => 'Jilid 1',
                'status_aktif' => true,
            ]
        );

        $this->command->info('✓ Santri created: Ahmad Zaki Rahman (Jilid 1)');

        // Tambahan santri lain untuk data yang lebih lengkap (tanpa parent - untuk testing admin)
        $otherSantriData = [
            [
                'nis' => '2024005',
                'nama_lengkap' => 'Fatimah Azzahra',
                'jenis_kelamin' => 'P',
                'tempat_lahir' => 'Bogor',
                'tanggal_lahir' => '2015-06-10',
                'jilid_kelas' => "Al-Qur'an",
            ],
            [
                'nis' => '2025006',
                'nama_lengkap' => 'Abdullah Al-Hakim',
                'jenis_kelamin' => 'L',
                'tempat_lahir' => 'Bogor',
                'tanggal_lahir' => '2016-09-18',
                'jilid_kelas' => 'Jilid 5',
            ],
            [
                'nis' => '2025007',
                'nama_lengkap' => 'Khadijah Ramadhani',
                'jenis_kelamin' => 'P',
                'tempat_lahir' => 'Bogor',
                'tanggal_lahir' => '2017-04-25',
                'jilid_kelas' => 'Jilid 3',
            ],
            [
                'nis' => '2026008',
                'nama_lengkap' => 'Umar Faruq',
                'jenis_kelamin' => 'L',
                'tempat_lahir' => 'Bogor',
                'tanggal_lahir' => '2018-12-12',
                'jilid_kelas' => 'Jilid 2',
            ],
            [
                'nis' => '2026009',
                'nama_lengkap' => 'Maryam Humaira',
                'jenis_kelamin' => 'P',
                'tempat_lahir' => 'Bogor',
                'tanggal_lahir' => '2019-02-28',
                'jilid_kelas' => 'Jilid 1',
            ],
        ];

        foreach ($otherSantriData as $data) {
            Santri::updateOrCreate(
                ['nis' => $data['nis']],
                array_merge($data, [
                    'orang_tua_id' => null,
                    'status_aktif' => true,
                ])
            );
        }

        $this->command->info('✓ 5 additional Santri created (without parent)');
    }
}
