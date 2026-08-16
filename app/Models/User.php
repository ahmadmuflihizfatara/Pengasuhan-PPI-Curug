<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    // Konstanta role
    const ROLE_TARUNA   = 'taruna';
    const ROLE_PENGASUH = 'pengasuh';
    const ROLE_ADMIN    = 'admin';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'nama_panggilan',
        'email',
        'password',
        'no_telepon',
        'jabatan',
        'prodi',
        'foto',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
    ];

    // =====================
    // Role Helper Methods
    // =====================

    public function mahasiswa()
    {
        return $this->hasOne(Mahasiswa::class);
    }

    public function isTaruna(): bool
    {
        return $this->role === self::ROLE_TARUNA;
    }

    public function isPengasuh(): bool
    {
        return $this->role === self::ROLE_PENGASUH;
    }

    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    /**
     * Cek apakah user punya izin edit (pengasuh atau admin)
     */
    public function canEdit(): bool
    {
        return in_array($this->role, [self::ROLE_PENGASUH, self::ROLE_ADMIN]);
    }

    /**
     * Cek apakah user bisa mengatur akun taruna dan setting sistem
     */
    public function canManageSystem(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    /**
     * Label tampilan role
     */
    public function getRoleLabelAttribute(): string
    {
        return match($this->role) {
            self::ROLE_TARUNA   => 'Taruna',
            self::ROLE_PENGASUH => 'Pengasuh',
            self::ROLE_ADMIN    => 'Admin',
            default             => ucfirst($this->role),
        };
    }

    /**
     * Badge color untuk role
     */
    public function getRoleBadgeColorAttribute(): string
    {
        return match($this->role) {
            self::ROLE_TARUNA   => '#38a169', // green
            self::ROLE_PENGASUH => '#3182ce', // blue
            self::ROLE_ADMIN    => '#764ba2', // purple
            default             => '#888',
        };
    }
}
