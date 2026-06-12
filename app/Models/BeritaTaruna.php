<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class BeritaTaruna extends Model
{
    use HasFactory;

    protected $table = 'berita_taruna';

    protected $fillable = [
        'user_id',
        'judul',
        'slug',
        'kategori',
        'ringkasan',
        'konten',
        'gambar',
        'is_published',
        'is_pinned',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'is_pinned'    => 'boolean',
    ];

    // =====================
    // Boot – auto-generate slug
    // =====================
    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = self::generateUniqueSlug($model->judul);
            }
        });

        static::updating(function ($model) {
            if ($model->isDirty('judul')) {
                $model->slug = self::generateUniqueSlug($model->judul, $model->id);
            }
        });
    }

    private static function generateUniqueSlug(string $judul, ?int $exceptId = null): string
    {
        $base = Str::slug($judul);
        $slug = $base;
        $i    = 1;

        $query = self::where('slug', $slug);
        if ($exceptId) {
            $query->where('id', '!=', $exceptId);
        }

        while ($query->exists()) {
            $slug  = $base . '-' . $i++;
            $query = self::where('slug', $slug);
            if ($exceptId) {
                $query->where('id', '!=', $exceptId);
            }
        }

        return $slug;
    }

    // =====================
    // Relasi
    // =====================

    public function penulis(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // =====================
    // Scope
    // =====================

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopePinned($query)
    {
        return $query->where('is_pinned', true);
    }

    // =====================
    // Accessor
    // =====================

    /**
     * Warna badge kategori
     */
    public function getKategoriColorAttribute(): string
    {
        return match ($this->kategori) {
            'pengumuman' => '#e53e3e',
            'prestasi'   => '#d69e2e',
            'kegiatan'   => '#38a169',
            'informasi'  => '#3182ce',
            default      => '#667eea',
        };
    }

    public function getKategoriBgColorAttribute(): string
    {
        return match ($this->kategori) {
            'pengumuman' => '#fff0f0',
            'prestasi'   => '#fffff0',
            'kegiatan'   => '#e6fff5',
            'informasi'  => '#ebf8ff',
            default      => '#eef0ff',
        };
    }

    public function getKategoriLabelAttribute(): string
    {
        return match ($this->kategori) {
            'pengumuman' => 'Pengumuman',
            'prestasi'   => 'Prestasi',
            'kegiatan'   => 'Kegiatan',
            'informasi'  => 'Informasi',
            default      => 'Lainnya',
        };
    }

    public function getKategoriIconAttribute(): string
    {
        return match ($this->kategori) {
            'pengumuman' => 'fa-bullhorn',
            'prestasi'   => 'fa-trophy',
            'kegiatan'   => 'fa-flag',
            'informasi'  => 'fa-info-circle',
            default      => 'fa-newspaper',
        };
    }

    /**
     * Ringkasan otomatis jika tidak diisi
     */
    public function getRingkasanAutoAttribute(): string
    {
        if ($this->ringkasan) {
            return $this->ringkasan;
        }
        return Str::limit(strip_tags($this->konten), 150);
    }

    /**
     * Waktu relatif
     */
    public function getWaktuRelatifAttribute(): string
    {
        return $this->created_at->locale('id')->diffForHumans();
    }

    /**
     * Gradient warna berdasarkan kategori (untuk card tanpa gambar)
     */
    public function getCardGradientAttribute(): string
    {
        return match ($this->kategori) {
            'pengumuman' => 'linear-gradient(135deg, #f093fb, #f5576c)',
            'prestasi'   => 'linear-gradient(135deg, #f6d365, #fda085)',
            'kegiatan'   => 'linear-gradient(135deg, #43e97b, #38f9d7)',
            'informasi'  => 'linear-gradient(135deg, #4facfe, #00f2fe)',
            default      => 'linear-gradient(135deg, #667eea, #764ba2)',
        };
    }

    public static function kategoriList(): array
    {
        return ['pengumuman', 'prestasi', 'kegiatan', 'informasi', 'lainnya'];
    }
}
