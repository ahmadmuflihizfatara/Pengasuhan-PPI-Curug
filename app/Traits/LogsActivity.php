<?php

namespace App\Traits;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

trait LogsActivity
{
    /**
     * Catat aktivitas ke tabel activity_logs.
     *
     * @param  string       $modul        poin | acara | surat
     * @param  string       $aksi         tambah | hapus | ubah | buat | update | selesai | tolak | setujui
     * @param  string       $deskripsi    Kalimat singkat menjelaskan aktivitas
     * @param  array        $detail       Data tambahan (opsional) yang disimpan sebagai JSON
     * @param  object|null  $subject      Model Eloquent yang menjadi subyek (opsional)
     */
    protected function logActivity(
        string  $modul,
        string  $aksi,
        string  $deskripsi,
        array   $detail  = [],
        ?object $subject = null
    ): void {
        $user = Auth::user();

        ActivityLog::create([
            'user_id'      => $user?->id,
            'user_name'    => $user?->name ?? 'Sistem',
            'user_role'    => $user?->role ?? '-',
            'modul'        => $modul,
            'aksi'         => $aksi,
            'deskripsi'    => $deskripsi,
            'detail'       => empty($detail) ? null : $detail,
            'subject_type' => $subject ? get_class($subject) : null,
            'subject_id'   => $subject?->id,
            'ip_address'   => Request::ip(),
        ]);
    }
}
