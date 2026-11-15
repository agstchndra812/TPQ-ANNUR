<?php

namespace Database\Seeders;

use App\Models\Presensi;
use App\Models\Santri;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class PresensiSeeder extends Seeder
{
    /**
     * Seed realistic presensi for last 14 days.
     */
    public function run(): void
    {
        $allSantri = Santri::all();
        
        if ($allSantri->isEmpty()) {
            $this->command->warn('⚠ No santri found. Skipping presensi seeding.');
            return;
        }

        $today = Carbon::today();
        $count = 0;

        // Generate presensi untuk 14 hari terakhir
        for ($i = 0; $i < 14; $i++) {
            $date = $today->copy()->subDays($i);

            // Skip Minggu (TPQ libur)
            if ($date->isSunday()) {
                continue;
            }

            foreach ($allSantri as $santri) {
                $status = 'Hadir';
                $keterangan = null;

                // Buat variasi realistis
                
                // Muhammad Farhan Rahman - rajin, sesekali izin
                if ($santri->nis === '2024001') {
                    if ($i === 5) {
                        $status = 'Izin';
                        $keterangan = 'Pemeriksaan dokter gigi';
                    }
                }
                
                // Aisyah Putri Rahman - kadang sakit
                elseif ($santri->nis === '2025002') {
                    if ($i === 2) {
                        $status = 'Sakit';
                        $keterangan = 'Demam dan batuk';
                    } elseif ($i === 3) {
                        $status = 'Sakit';
                        $keterangan = 'Masih batuk';
                    }
                }
                
                // Ahmad Zaki Rahman - anak kecil, kadang rewel
                elseif ($santri->nis === '2026003') {
                    if ($i === 7) {
                        $status = 'Izin';
                        $keterangan = 'Ikut orang tua ke luar kota';
                    }
                }
                
                // Fatimah Azzahra - rajin sekali
                elseif ($santri->nis === '2024005') {
                    // Selalu hadir, tidak ada absen
                }
                
                // Abdullah Al-Hakim
                elseif ($santri->nis === '2025006') {
                    if ($i === 9) {
                        $status = 'Sakit';
                        $keterangan = 'Flu';
                    }
                }
                
                // Khadijah Ramadhani
                elseif ($santri->nis === '2025007') {
                    if ($i === 4) {
                        $status = 'Alpa';
                    }
                }
                
                // Umar Faruq - kadang telat/skip
                elseif ($santri->nis === '2026008') {
                    if ($i === 6) {
                        $status = 'Izin';
                        $keterangan = 'Acara keluarga';
                    } elseif ($i === 12) {
                        $status = 'Alpa';
                    }
                }
                
                // Maryam Humaira - masih kecil, kadang ga mood
                elseif ($santri->nis === '2026009') {
                    if ($i === 8) {
                        $status = 'Izin';
                        $keterangan = 'Belum enak badan';
                    }
                }

                Presensi::updateOrCreate(
                    [
                        'santri_id' => $santri->id,
                        'tanggal' => $date->toDateString(),
                    ],
                    [
                        'status' => $status,
                        'keterangan' => $keterangan,
                    ]
                );

                $count++;
            }
        }

        $this->command->info("✓ {$count} Presensi records created for last 14 days (excluding Sundays)");
    }
}
