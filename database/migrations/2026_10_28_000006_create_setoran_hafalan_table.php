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
        Schema::create('setoran_hafalan', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('santri_id')->constrained('santri')->cascadeOnDelete();
            $table->foreignId('surah_id')->constrained('surah')->cascadeOnDelete();
            $table->string('jenis'); // 'ziyadah', 'murajaah'
            $table->unsignedInteger('ayat_mulai');
            $table->unsignedInteger('ayat_selesai');
            $table->string('nilai'); // 'Mumtaz', 'Jayyid', 'Mengulang'
            $table->text('catatan')->nullable();
            $table->date('tanggal_setoran');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('setoran_hafalan');
    }
};

