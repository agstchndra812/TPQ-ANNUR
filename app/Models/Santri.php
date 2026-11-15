<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Santri extends Model
{
    use HasFactory;

    protected $table = 'santri';

    /**
     * @var list<string>
     */
    protected $fillable = [
        'orang_tua_id',
        'nis',
        'nama_lengkap',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'jilid_kelas',
        'status_aktif',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'tanggal_lahir' => 'date',
            'status_aktif' => 'boolean',
        ];
    }

    /**
     * The parent associated with the santri.
     */
    public function orangTua(): BelongsTo
    {
        return $this->belongsTo(OrangTua::class, 'orang_tua_id');
    }

    /**
     * Attendance records for the santri.
     */
    public function presensi(): HasMany
    {
        return $this->hasMany(Presensi::class, 'santri_id');
    }

    /**
     * Memorization records for the santri.
     */
    public function setoranHafalan(): HasMany
    {
        return $this->hasMany(SetoranHafalan::class, 'santri_id');
    }
}

