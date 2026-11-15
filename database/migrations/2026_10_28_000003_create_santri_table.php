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
        Schema::create('santri', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('orang_tua_id')->nullable()->constrained('orang_tua')->nullOnDelete();
            $table->string('nis')->unique();
            $table->string('nama_lengkap');
            $table->string('jenis_kelamin', 1)->default('L'); // 'L' / 'P'
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('jilid_kelas');
            $table->boolean('status_aktif')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('santri');
    }
};

