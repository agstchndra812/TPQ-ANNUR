<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Surah extends Model
{
    use HasFactory;

    protected $table = 'surah';

    /**
     * @var list<string>
     */
    protected $fillable = [
        'nomor_surah',
        'nama_surah',
        'jumlah_ayat',
        'juz',
    ];

    /**
     * Get setoran records referencing this surah.
     */
    public function setoranHafalan(): HasMany
    {
        return $this->hasMany(SetoranHafalan::class, 'surah_id');
    }
}

