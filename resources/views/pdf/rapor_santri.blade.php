<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Rapor Santri - {{ $santri->nama_lengkap }}</title>
    <style>
        @page {
            margin: 1.5cm 1.5cm 1.5cm 1.5cm;
        }
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 11pt;
            color: #222;
            line-height: 1.35;
        }
        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 5px;
        }
        .header-title {
            text-align: center;
        }
        .header-title h2 {
            margin: 0;
            font-size: 16pt;
            font-weight: bold;
            color: #065f46;
            letter-spacing: 1px;
        }
        .header-title h3 {
            margin: 2px 0;
            font-size: 12pt;
            font-weight: bold;
            color: #111;
        }
        .header-title p {
            margin: 2px 0 0 0;
            font-size: 8.5pt;
            color: #555;
        }
        .kop-line {
            border-top: 2px solid #065f46;
            border-bottom: 0.5px solid #065f46;
            height: 2px;
            margin-top: 8px;
            margin-bottom: 16px;
        }
        .report-title {
            text-align: center;
            font-size: 12pt;
            font-weight: bold;
            text-transform: uppercase;
            text-decoration: underline;
            margin-bottom: 3px;
        }
        .report-subtitle {
            text-align: center;
            font-size: 9.5pt;
            color: #444;
            margin-bottom: 14px;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 14px;
            font-size: 9.5pt;
        }
        .info-table td {
            padding: 3px 4px;
            vertical-align: top;
        }
        .section-heading {
            font-size: 10pt;
            font-weight: bold;
            color: #065f46;
            margin-top: 10px;
            margin-bottom: 4px;
            border-bottom: 1px solid #d1fae5;
            padding-bottom: 2px;
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
            font-size: 9pt;
        }
        .data-table th, .data-table td {
            border: 1px solid #ccc;
            padding: 5px 6px;
            text-align: left;
        }
        .data-table th {
            background-color: #f0fdf4;
            color: #065f46;
            font-weight: bold;
            text-align: center;
        }
        .text-center {
            text-align: center !important;
        }
        .badge-mumtaz {
            font-weight: bold;
            color: #047857;
        }
        .badge-jayyid {
            font-weight: bold;
            color: #0284c7;
        }
        .badge-ulang {
            font-weight: bold;
            color: #d97706;
        }
        .notes-box {
            border: 1px dashed #999;
            background-color: #fafafa;
            padding: 8px 10px;
            font-size: 9pt;
            font-style: italic;
            margin-bottom: 15px;
            min-height: 35px;
        }
        .signature-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
            font-size: 9.5pt;
        }
        .signature-table td {
            text-align: center;
            vertical-align: top;
            width: 33.33%;
        }
        .sign-space {
            height: 60px;
        }
    </style>
</head>
<body>

    <!-- Kop Surat -->
    <table class="header-table">
        <tr>
            <td class="header-title">
                <h2>TPQ ANNUR BOGOR</h2>
                <h3>TAMAN PENDIDIKAN AL-QUR'AN ANNUR</h3>
                <p>Jl. Sukasari No. 10, Bogor Timur, Kota Bogor, Jawa Barat 16142 | Telp/WA: 0812-3456-7890</p>
                <p>Izin Operasional Kemenag: Kd.10.02/4/PP.00.8/042/2021</p>
            </td>
        </tr>
    </table>
    <div class="kop-line"></div>

    <!-- Judul Rapor -->
    <div class="report-title">RAPOR PERKEMBANGAN SANTRI</div>
    <div class="report-subtitle">Periode: {{ $namaBulan }}</div>

    <!-- Identitas Santri -->
    <table class="info-table">
        <tr>
            <td style="width: 18%; font-weight: bold;">Nomor Induk Santri</td>
            <td style="width: 2%;">:</td>
            <td style="width: 35%; font-family: monospace; font-weight: bold;">{{ $santri->nis }}</td>
            
            <td style="width: 18%; font-weight: bold;">Tingkat / Jilid</td>
            <td style="width: 2%;">:</td>
            <td style="width: 25%; font-weight: bold;">{{ $santri->jilid_kelas }}</td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Nama Lengkap</td>
            <td>:</td>
            <td style="font-weight: bold;">{{ $santri->nama_lengkap }}</td>
            
            <td style="font-weight: bold;">Jenis Kelamin</td>
            <td>:</td>
            <td>{{ $santri->jenis_kelamin === 'L' ? 'Laki-laki (Putra)' : 'Perempuan (Putri)' }}</td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Wali Santri</td>
            <td>:</td>
            <td>{{ $santri->orangTua->user->name ?? '-' }}</td>

            <td style="font-weight: bold;">Status Santri</td>
            <td>:</td>
            <td>{{ $santri->status_aktif ? 'Aktif' : 'Non-Aktif' }}</td>
        </tr>
    </table>

    <!-- Bagian A: Rekapitulasi Presensi -->
    <div class="section-heading">A. REKAPITULASI PRESENSI / KEHADIRAN</div>
    <table class="data-table">
        <thead>
            <tr>
                <th>Pertemuan Efektif</th>
                <th>Hadir (H)</th>
                <th>Izin (I)</th>
                <th>Sakit (S)</th>
                <th>Alpa (A)</th>
                <th>Persentase Kehadiran</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="text-center font-bold">{{ $totalHari }} Hari</td>
                <td class="text-center">{{ $totalHadir }}</td>
                <td class="text-center">{{ $totalIzin }}</td>
                <td class="text-center">{{ $totalSakit }}</td>
                <td class="text-center">{{ $totalAlpa }}</td>
                <td class="text-center font-bold" style="color: #065f46;">{{ $persentaseHadir }}%</td>
            </tr>
        </tbody>
    </table>

    <!-- Bagian B: Hafalan Baru (Ziyadah) -->
    <div class="section-heading">B. CAPAIAN HAFALAN BARU (ZIYADAH)</div>
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 15%;">Tanggal</th>
                <th style="width: 25%;">Surah & Ayat</th>
                <th style="width: 15%;">Kelancaran</th>
                <th>Catatan Evaluasi / Tajwid</th>
            </tr>
        </thead>
        <tbody>
            @forelse($setoranZiyadah as $idx => $item)
                <tr>
                    <td class="text-center">{{ $idx + 1 }}</td>
                    <td class="text-center">{{ $item->tanggal_setoran->format('d/m/Y') }}</td>
                    <td>Surah {{ $item->surah->nama_surah }} (Ayat {{ $item->ayat_mulai }}-{{ $item->ayat_selesai }})</td>
                    <td class="text-center">
                        <span class="{{ $item->nilai === 'Mumtaz' ? 'badge-mumtaz' : ($item->nilai === 'Jayyid' ? 'badge-jayyid' : 'badge-ulang') }}">
                            {{ $item->nilai }}
                        </span>
                    </td>
                    <td>{{ $item->catatan ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center" style="color: #888; font-style: italic;">
                        Tidak ada catatan setoran ziyadah pada periode ini.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Bagian C: Pengulangan Hafalan (Muraja'ah) -->
    <div class="section-heading">C. PENGULANGAN HAFALAN (MURAJA'AH)</div>
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 15%;">Tanggal</th>
                <th style="width: 25%;">Surah & Ayat</th>
                <th style="width: 15%;">Kelancaran</th>
                <th>Catatan Evaluasi / Tajwid</th>
            </tr>
        </thead>
        <tbody>
            @forelse($setoranMurajaah as $idx => $item)
                <tr>
                    <td class="text-center">{{ $idx + 1 }}</td>
                    <td class="text-center">{{ $item->tanggal_setoran->format('d/m/Y') }}</td>
                    <td>Surah {{ $item->surah->nama_surah }} (Ayat {{ $item->ayat_mulai }}-{{ $item->ayat_selesai }})</td>
                    <td class="text-center">
                        <span class="{{ $item->nilai === 'Mumtaz' ? 'badge-mumtaz' : ($item->nilai === 'Jayyid' ? 'badge-jayyid' : 'badge-ulang') }}">
                            {{ $item->nilai }}
                        </span>
                    </td>
                    <td>{{ $item->catatan ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center" style="color: #888; font-style: italic;">
                        Tidak ada catatan setoran muraja'ah pada periode ini.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Bagian D: Catatan Umum Pembimbing -->
    <div class="section-heading">D. CATATAN & EVALUASI UMUM PEMBIMBING</div>
    <div class="notes-box">
        Alhamdulillah, ananda menunjukkan semangat yang baik dalam mengikuti pembelajaran Al-Qur'an di TPQ Annur. 
        Mohon kepada orang tua untuk senantiasa mendampingi dan memotivasi ananda dalam mengulang (muraja'ah) hafalan di rumah secara istiqamah.
    </div>

    <!-- Tanda Tangan -->
    <table class="signature-table">
        <tr>
            <td>
                Mengetahui,<br>
                <b>Orang Tua / Wali Santri</b>
                <div class="sign-space"></div>
                ( .................................................. )
            </td>
            <td>
                Bogor, {{ $tanggalCetak }}<br>
                <b>Ustadz Pembimbing</b>
                <div class="sign-space"></div>
                ( <b>Ustadz Abdullah</b> )
            </td>
            <td>
                Menyetujui,<br>
                <b>Kepala TPQ Annur Bogor</b>
                <div class="sign-space"></div>
                ( <b>H. Muhammad Ridwan, S.Pd.I</b> )
            </td>
        </tr>
    </table>

</body>
</html>

