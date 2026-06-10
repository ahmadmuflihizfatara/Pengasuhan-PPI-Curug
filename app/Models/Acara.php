<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Acara extends Model
{
    use HasFactory;

    protected $table = 'acara';

    protected $fillable = [
        'nama_acara',
        'tanggal',
        'jam',
        'keterangan',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];
}
