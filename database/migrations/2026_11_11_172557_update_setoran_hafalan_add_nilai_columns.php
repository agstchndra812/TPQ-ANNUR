<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('setoran_hafalan', function (Blueprint $table): void {
            // Drop old columns if they exist
            if (Schema::hasColumn('setoran_hafalan', 'nilai_kelancaran')) {
                $table->dropColumn('nilai_kelancaran');
            }
            if (Schema::hasColumn('setoran_hafalan', 'nilai_tajwid')) {
                $table->dropColumn('nilai_tajwid');
            }
            if (Schema::hasColumn('setoran_hafalan', 'keterangan')) {
                $table->dropColumn('keterangan');
            }
        });

        Schema::table('setoran_hafalan', function (Blueprint $table): void {
            // Add new columns if they don't exist
            if (!Schema::hasColumn('setoran_hafalan', 'nilai')) {
                $table->string('nilai')->default('Mengulang')->after('ayat_selesai'); // 'Mumtaz', 'Jayyid', 'Mengulang'
            }
            if (!Schema::hasColumn('setoran_hafalan', 'catatan')) {
                $table->text('catatan')->nullable()->after('nilai');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('setoran_hafalan', function (Blueprint $table): void {
            if (Schema::hasColumn('setoran_hafalan', 'nilai')) {
                $table->dropColumn('nilai');
            }
            if (Schema::hasColumn('setoran_hafalan', 'catatan')) {
                $table->dropColumn('catatan');
            }
        });

        Schema::table('setoran_hafalan', function (Blueprint $table): void {
            if (!Schema::hasColumn('setoran_hafalan', 'nilai_kelancaran')) {
                $table->string('nilai_kelancaran')->nullable();
            }
            if (!Schema::hasColumn('setoran_hafalan', 'nilai_tajwid')) {
                $table->string('nilai_tajwid')->nullable();
            }
            if (!Schema::hasColumn('setoran_hafalan', 'keterangan')) {
                $table->text('keterangan')->nullable();
            }
        });
    }
};
