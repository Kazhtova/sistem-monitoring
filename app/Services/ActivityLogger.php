<?php

namespace App\Services;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model; // 🌟 1. TAMBAHKAN IMPORT INI
use Illuminate\Support\Facades\Request; // 🌟 TAMBAHKAN INI

class ActivityLogger
{
    /**
     * Catat aktivitas user ke dalam tabel activity_logs
     *
     * @param string $action
     * @param Model|null $subject
     * @param string $description
     * @param array|null $properties
     * @return void
     */
    // 🌟 2. TAMBAHKAN "?Model" DI DEPAN $subject
    public static function log(string $action, ?Model $subject = null, string $description = '', ?array $properties = null): void
    {
        $causer = null;
        $causer_name = 'System';

        // Deteksi cerdas siapa yang sedang login (Teknisi atau Mahasiswa)
        if (Auth::guard('teknisi')->check()) {
            $causer = Auth::guard('teknisi')->user();
            $causer_name = $causer->nama_teknisi;
        } elseif (Auth::guard('mahasiswa')->check()) {
            $causer = Auth::guard('mahasiswa')->user();
            $causer_name = $causer->nama;
        }

        ActivityLog::create([
            'causer_type'  => $causer ? get_class($causer) : null,
            'causer_id'    => $causer ? $causer->getAuthIdentifier() : null,
            'causer_name'  => $causer_name,
            'action'       => $action,
            
            'subject_type' => $subject ? get_class($subject) : null,
            'subject_id'   => $subject ? $subject->getKey() : null,
            
            'description'  => $description,
            'properties'   => $properties,
            'ip_address'   => Request::ip(),
            'user_agent'   => Request::userAgent(),
        ]);
    }
}