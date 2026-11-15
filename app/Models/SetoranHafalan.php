<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SetoranHafalan extends Model
{
    use HasFactory;

    protected $table = 'setoran_hafalan';

    /**
     * @var list<string>
     */
    protected $fillable = [
        'santri_id',
        'surah_id',
        'jenis',
        'ayat_mulai',
        'ayat_selesai',
        'nilai',
        'catatan',
        'tanggal_setoran',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'tanggal_setoran' => 'date',
        ];
    }

    /**
     * Santri who submitted the memorization.
     */
    public function santri(): BelongsTo
    {
        return $this->belongsTo(Santri::class, 'santri_id');
    }

    /**
     * Surah that was memorized.
     */
    public function surah(): BelongsTo
    {
        return $this->belongsTo(Surah::class, 'surah_id');
    }
}

