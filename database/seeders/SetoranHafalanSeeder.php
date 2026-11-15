<?php

namespace Database\Seeders;

use App\Models\Santri;
use App\Models\SetoranHafalan;
use App\Models\Surah;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class SetoranHafalanSeeder extends Seeder
{
    /**
     * Seed realistic setoran hafalan data.
     */
    public function run(): void
    {
        // Get santri
        $farhan = Santri::where('nis', '2024001')->first(); // Al-Qur'an
        $aisyah = Santri::where('nis', '2025002')->first(); // Jilid 4
        $zaki = Santri::where('nis', '2026003')->first();   // Jilid 1
        $fatimah = Santri::where('nis', '2024005')->first(); // Al-Qur'an
        $abdullah = Santri::where('nis', '2025006')->first(); // Jilid 5

        $count = 0;

        // Farhan (Al-Qur'an) - Hafal juz 30, lagi hafal An-Naba' dan An-Nazi'at
        if ($farhan) {
            // An-Naba' (30 hari lalu - sudah hafal)
            $anNaba = Surah::where('nomor_surah', 78)->first();
            if ($anNaba) {
                SetoranHafalan::create([
                    'santri_id' => $farhan->id,
                    'surah_id' => $anNaba->id,
                    'jenis' => 'ziyadah',
                    'ayat_mulai' => 1,
                    'ayat_selesai' => 20,
                    'tanggal_setoran' => Carbon::today()->subDays(30),
                    'nilai' => 'Mumtaz',
                    'catatan' => 'Sangat lancar, makharijul huruf tepat.',
                ]);

                SetoranHafalan::create([
                    'santri_id' => $farhan->id,
                    'surah_id' => $anNaba->id,
                    'jenis' => 'ziyadah',
                    'ayat_mulai' => 21,
                    'ayat_selesai' => 40,
                    'tanggal_setoran' => Carbon::today()->subDays(25),
                    'nilai' => 'Mumtaz',
                    'catatan' => 'Sempurna, lanjut surah berikutnya.',
                ]);

                // Murajaah An-Naba' (seminggu lalu)
                SetoranHafalan::create([
                    'santri_id' => $farhan->id,
                    'surah_id' => $anNaba->id,
                    'jenis' => 'murajaah',
                    'ayat_mulai' => 1,
                    'ayat_selesai' => 40,
                    'tanggal_setoran' => Carbon::today()->subDays(7),
                    'nilai' => 'Mumtaz',
                    'catatan' => 'Muraja\'ah 1 surah penuh sangat lancar.',
                ]);

                $count += 3;
            }

            // An-Nazi'at (sedang proses)
            $anNaziat = Surah::where('nomor_surah', 79)->first();
            if ($anNaziat) {
                SetoranHafalan::create([
                    'santri_id' => $farhan->id,
                    'surah_id' => $anNaziat->id,
                    'jenis' => 'ziyadah',
                    'ayat_mulai' => 1,
                    'ayat_selesai' => 23,
                    'tanggal_setoran' => Carbon::today()->subDays(3),
                    'nilai' => 'Jayyid Jiddan',
                    'catatan' => 'Bagus, perhatikan mad thobi\'i di ayat 15-18.',
                ]);

                SetoranHafalan::create([
                    'santri_id' => $farhan->id,
                    'surah_id' => $anNaziat->id,
                    'jenis' => 'ziyadah',
                    'ayat_mulai' => 24,
                    'ayat_selesai' => 46,
                    'tanggal_setoran' => Carbon::today()->subDays(1),
                    'nilai' => 'Mumtaz',
                    'catatan' => 'Alhamdulillah selesai 1 surah, lanjutkan!',
                ]);

                $count += 2;
            }
        }

        // Aisyah (Jilid 4) - Hafal surah-surah pendek Juz 30
        if ($aisyah) {
            // Al-Ikhlas
            $alIkhlash = Surah::where('nomor_surah', 112)->first();
            if ($alIkhlash) {
                SetoranHafalan::create([
                    'santri_id' => $aisyah->id,
                    'surah_id' => $alIkhlash->id,
                    'jenis' => 'ziyadah',
                    'ayat_mulai' => 1,
                    'ayat_selesai' => 4,
                    'tanggal_setoran' => Carbon::today()->subDays(10),
                    'nilai' => 'Jayyid Jiddan',
                    'catatan' => 'Bagus, qolqolah di akhir ayat diperjelas lagi.',
                ]);
                $count++;
            }

            // Al-Falaq
            $alFalaq = Surah::where('nomor_surah', 113)->first();
            if ($alFalaq) {
                SetoranHafalan::create([
                    'santri_id' => $aisyah->id,
                    'surah_id' => $alFalaq->id,
                    'jenis' => 'ziyadah',
                    'ayat_mulai' => 1,
                    'ayat_selesai' => 5,
                    'tanggal_setoran' => Carbon::today()->subDays(5),
                    'nilai' => 'Mumtaz',
                    'catatan' => 'Masya Allah, sangat baik! Lanjut An-Nas.',
                ]);
                $count++;
            }

            // An-Nas
            $anNas = Surah::where('nomor_surah', 114)->first();
            if ($anNas) {
                SetoranHafalan::create([
                    'santri_id' => $aisyah->id,
                    'surah_id' => $anNas->id,
                    'jenis' => 'ziyadah',
                    'ayat_mulai' => 1,
                    'ayat_selesai' => 6,
                    'tanggal_setoran' => Carbon::today()->subDays(2),
                    'nilai' => 'Mumtaz',
                    'catatan' => 'Sempurna! Alhamdulillah 3 surah terakhir sudah lancar.',
                ]);
                $count++;
            }
        }

        // Zaki (Jilid 1) - Baru mulai, hafal An-Nas
        if ($zaki) {
            $anNas = Surah::where('nomor_surah', 114)->first();
            if ($anNas) {
                SetoranHafalan::create([
                    'santri_id' => $zaki->id,
                    'surah_id' => $anNas->id,
                    'jenis' => 'ziyadah',
                    'ayat_mulai' => 1,
                    'ayat_selesai' => 6,
                    'tanggal_setoran' => Carbon::today()->subDays(4),
                    'nilai' => 'Jayyid',
                    'catatan' => 'Bagus untuk pemula! Ayat 4-6 diulang lagi ya.',
                ]);
                $count++;
            }
        }

        // Fatimah (Al-Qur'an) - Sedang tahfidz Al-Baqarah
        if ($fatimah) {
            $alBaqarah = Surah::where('nomor_surah', 2)->first();
            if ($alBaqarah) {
                // Ayat 1-20
                SetoranHafalan::create([
                    'santri_id' => $fatimah->id,
                    'surah_id' => $alBaqarah->id,
                    'jenis' => 'ziyadah',
                    'ayat_mulai' => 1,
                    'ayat_selesai' => 20,
                    'tanggal_setoran' => Carbon::today()->subDays(20),
                    'nilai' => 'Mumtaz',
                    'catatan' => 'Masya Allah sangat lancar!',
                ]);

                // Ayat 21-50
                SetoranHafalan::create([
                    'santri_id' => $fatimah->id,
                    'surah_id' => $alBaqarah->id,
                    'jenis' => 'ziyadah',
                    'ayat_mulai' => 21,
                    'ayat_selesai' => 50,
                    'tanggal_setoran' => Carbon::today()->subDays(12),
                    'nilai' => 'Jayyid Jiddan',
                    'catatan' => 'Perhatikan panjang mad di ayat 30-35.',
                ]);

                // Ayat 51-70
                SetoranHafalan::create([
                    'santri_id' => $fatimah->id,
                    'surah_id' => $alBaqarah->id,
                    'jenis' => 'ziyadah',
                    'ayat_mulai' => 51,
                    'ayat_selesai' => 70,
                    'tanggal_setoran' => Carbon::today()->subDays(6),
                    'nilai' => 'Mumtaz',
                    'catatan' => 'Alhamdulillah sangat bagus, terus semangat!',
                ]);

                // Murajaah ayat 1-50
                SetoranHafalan::create([
                    'santri_id' => $fatimah->id,
                    'surah_id' => $alBaqarah->id,
                    'jenis' => 'murajaah',
                    'ayat_mulai' => 1,
                    'ayat_selesai' => 50,
                    'tanggal_setoran' => Carbon::today()->subDays(2),
                    'nilai' => 'Mumtaz',
                    'catatan' => 'Muraja\'ah 50 ayat tetap lancar, luar biasa!',
                ]);

                $count += 4;
            }
        }

        // Abdullah (Jilid 5) - Hafal Juz 30 lengkap
        if ($abdullah) {
            $alKautsar = Surah::where('nomor_surah', 108)->first();
            if ($alKautsar) {
                SetoranHafalan::create([
                    'santri_id' => $abdullah->id,
                    'surah_id' => $alKautsar->id,
                    'jenis' => 'ziyadah',
                    'ayat_mulai' => 1,
                    'ayat_selesai' => 3,
                    'tanggal_setoran' => Carbon::today()->subDays(8),
                    'nilai' => 'Mumtaz',
                    'catatan' => 'Pendek tapi sangat lancar, bagus!',
                ]);
                $count++;
            }

            $alKafirun = Surah::where('nomor_surah', 109)->first();
            if ($alKafirun) {
                SetoranHafalan::create([
                    'santri_id' => $abdullah->id,
                    'surah_id' => $alKafirun->id,
                    'jenis' => 'ziyadah',
                    'ayat_mulai' => 1,
                    'ayat_selesai' => 6,
                    'tanggal_setoran' => Carbon::today()->subDays(4),
                    'nilai' => 'Mumtaz',
                    'catatan' => 'Sempurna, tajwid dan makhroj tepat!',
                ]);
                $count++;
            }
        }

        $this->command->info("✓ {$count} Setoran Hafalan records created (realistic data)");
    }
}
