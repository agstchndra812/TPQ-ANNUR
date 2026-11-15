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
        Schema::create('surah', function (Blueprint $table): void {
            $table->id();
            $table->unsignedInteger('nomor_surah');
            $table->string('nama_surah');
            $table->unsignedInteger('jumlah_ayat');
            $table->unsignedInteger('juz');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surah');
    }
};

