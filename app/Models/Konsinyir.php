<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Konsinyir extends Model
{
    protected $table = 'konsinyir';

    protected $fillable = [
        'mahasiswa_id',
        'tanggal_mulai',
        'lama_hari',
        'keterangan',
        'diinput_oleh',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    public function penginput()
    {
        return $this->belongsTo(User::class, 'diinput_oleh');
    }

    public function getTanggalSelesaiAttribute(): \Carbon\Carbon
    {
        // Konsinyir 1 hari = mulai & selesai hari yang sama
        return $this->tanggal_mulai->copy()->addDays(max(0, $this->lama_hari - 1));
    }

    public function getStatusAttribute(): string
    {
        return now()->startOfDay()->lte($this->tanggal_selesai) ? 'aktif' : 'selesai';
    }
}
