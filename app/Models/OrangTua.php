<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OrangTua extends Model
{
    use HasFactory;

    protected $table = 'orang_tua';

    /**
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'no_hp',
        'alamat',
    ];

    /**
     * The user account associated with this parent.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The children (santri) associated with this parent.
     */
    public function santri(): HasMany
    {
        return $this->hasMany(Santri::class, 'orang_tua_id');
    }
}

