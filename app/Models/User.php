<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'role'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the associated orang tua profile.
     */
    public function orangTua(): HasOne
    {
        return $this->hasOne(OrangTua::class);
    }

    /**
     * Check if user is superadmin.
     */
    public function isSuperAdmin(): bool
    {
        return $this->role === 'superadmin';
    }

    /**
     * Check if user is guru (teacher).
     */
    public function isGuru(): bool
    {
        return $this->role === 'guru';
    }

    /**
     * Check if user is admin (backward compatibility for guru).
     */
    public function isAdmin(): bool
    {
        return $this->role === 'guru' || $this->role === 'superadmin';
    }

    /**
     * Check if user is parent (orang tua).
     */
    public function isParent(): bool
    {
        return $this->role === 'parent';
    }
}
