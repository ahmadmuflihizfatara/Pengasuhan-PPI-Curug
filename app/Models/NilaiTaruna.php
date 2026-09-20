<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NilaiTaruna extends Model
{
    protected $table = 'nilai_taruna';

    protected $fillable = [
        'mahasiswa_id',
        'semester',
        'ips',
        'samapta',
        'pengasuhan',
        'keterangan',
        'diinput_oleh',
    ];

    protected $casts = [
        'semester'   => 'integer',
        'ips'        => 'float',
        'samapta'    => 'float',
        'pengasuhan' => 'float',
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    public function penginput()
    {
        return $this->belongsTo(User::class, 'diinput_oleh');
    }
}
