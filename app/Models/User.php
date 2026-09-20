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
    const ROLE_TARUNA         = 'taruna';
    const ROLE_PENGASUH       = 'pengasuh';
    const ROLE_ADMIN          = 'admin';

    // Akses khusus: diberikan admin ke akun taruna tertentu (bukan role terpisah)
    const AKSES_KASI_INTERNAL = 'kasi_internal';
    const AKSES_POLISI_TARUNA = 'polisi_taruna';

    const DAFTAR_AKSES = [
        self::AKSES_KASI_INTERNAL => [
            'label' => 'Kepala Seksi Internal',
            'ikon'  => 'fa-calendar-check',
            'warna' => '#d97706',
            'ket'   => 'Membuat & mengubah jadwal duty taruna mingguan.',
        ],
        self::AKSES_POLISI_TARUNA => [
            'label' => 'Polisi Taruna',
            'ikon'  => 'fa-user-shield',
            'warna' => '#dc2626',
            'ket'   => 'Mengajukan pelanggaran / pengurangan poin taruna lain.',
        ],
    ];

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
        'akses_khusus',
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
        'akses_khusus'      => 'array',
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

    /** Akses khusus hanya berlaku untuk akun taruna */
    public function hasAkses(string $akses): bool
    {
        return $this->isTaruna() && in_array($akses, $this->akses_khusus ?? []);
    }

    public function isKasiInternal(): bool
    {
        return $this->hasAkses(self::AKSES_KASI_INTERNAL);
    }

    public function isPolisiTaruna(): bool
    {
        return $this->hasAkses(self::AKSES_POLISI_TARUNA);
    }

    /**
     * Akses duty taruna — otomatis: taruna yang terdaftar di duty minggu berjalan.
     * Tidak disimpan di akses_khusus; hilang sendiri saat minggu berganti.
     */
    public function isDutyTaruna(): bool
    {
        if (!$this->isTaruna()) {
            return false;
        }

        // ponytail: cache per instance — dipanggil berkali-kali di navbar/sidebar
        return $this->dutyTarunaCache ??= DutyTaruna::whereDate('minggu_mulai', DutyTaruna::awalMinggu())
            ->whereHas('mahasiswa', fn ($q) => $q->where('user_id', $this->id))
            ->exists();
    }

    private ?bool $dutyTarunaCache = null;

    /**
     * Gating UI/rute yang sifatnya "akses taruna". Dipertahankan agar
     * pemanggil lama tetap jalan — sekarang identik dengan isTaruna().
     */
    public function hasTarunaAccess(): bool
    {
        return $this->isTaruna();
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
            self::ROLE_TARUNA        => 'Taruna',
            self::ROLE_PENGASUH      => 'Pengasuh',
            self::ROLE_ADMIN         => 'Admin',
            default                  => ucfirst($this->role),
        };
    }

    /**
     * Badge color untuk role
     */
    public function getRoleBadgeColorAttribute(): string
    {
        return match($this->role) {
            self::ROLE_TARUNA        => '#38a169', // green
            self::ROLE_PENGASUH      => '#3182ce', // blue
            self::ROLE_ADMIN         => '#764ba2', // purple
            default                  => '#888',
        };
    }
}
