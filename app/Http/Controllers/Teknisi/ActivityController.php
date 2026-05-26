<?php

namespace App\Http\Controllers\Teknisi;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Request as ModelsRequest;
use Illuminate\Support\Facades\Auth;

class ActivityController extends Controller
{
    public function activityLogs()
    {
        $id_teknisi_login = Auth::guard('teknisi')->id();

        // 2. Ambil list ID Request yang ditugaskan/ditangani oleh Teknisi ini
        $relatedRequestIds = ModelsRequest::where('id_teknisi', $id_teknisi_login)
                                            ->pluck('id_request');

        // 3. 🌟 AMBIL LOG DARI DUA SISI (TEKNISI & REQUEST MAHASISWA)
        $logs = ActivityLog::where(function ($query) use ($id_teknisi_login, $relatedRequestIds) {
            
            // SISI A: Semua aktivitas yang dilakukan OLEH Teknisi ini sendiri (sebagai Causer)
            $query->where(function ($q) use ($id_teknisi_login) {
                $q->where('causer_type', 'App\Models\Teknisi') // Sesuaikan namespace model Teknisi-mu
                  ->where('causer_id', $id_teknisi_login);
            })
            
            // SISI B: ATAU semua aktivitas yang terjadi PADA Request yang ditangani teknisi ini (oleh Mahasiswa)
            ->orWhere(function ($q) use ($relatedRequestIds) {
                $q->where('subject_type', ModelsRequest::class)
                  ->whereIn('subject_id', $relatedRequestIds);
            });

        })
        ->latest()
        ->paginate(15);

        return view('teknisi.activity-dashboard', compact('logs'));
    }
}