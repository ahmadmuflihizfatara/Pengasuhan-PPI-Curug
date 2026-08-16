<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class DutyTaruna extends Model
{
    protected $table = 'duty_taruna';

    /** Jumlah taruna duty per minggu */
    const JUMLAH_PER_MINGGU = 11;

    protected $fillable = [
        'minggu_mulai',
        'mahasiswa_id',
        'diinput_oleh',
    ];

    protected $casts = [
        'minggu_mulai' => 'date',
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    public function penginput()
    {
        return $this->belongsTo(User::class, 'diinput_oleh');
    }

    /** Senin dari minggu tanggal tsb — kunci periode duty */
    public static function awalMinggu(?Carbon $tanggal = null): Carbon
    {
        return ($tanggal ?? now())->copy()->startOfWeek(Carbon::MONDAY)->startOfDay();
    }

    /** Label periode: "18 — 24 Agustus 2026" */
    public static function labelPeriode(Carbon $mulai): string
    {
        $akhir = $mulai->copy()->addDays(6);

        return $mulai->locale('id')->isoFormat('D MMM') . ' — ' . $akhir->locale('id')->isoFormat('D MMM Y');
    }
}
