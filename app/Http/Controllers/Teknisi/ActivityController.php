<?php

namespace App\Http\Controllers\Teknisi;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Komputer;
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

    public function viewKalender(int $id_komputer)
    {
        $komputer = Komputer::findOrFail($id_komputer);
        return view('mahasiswa.kalender-komputer', compact('komputer'));
    }

    public function getJadwalKomputer(int $id_komputer)
    {
        $requests = ModelsRequest::where('id_komputer', $id_komputer)
            ->where(function ($query) {
                
                $query->where('status', 'setuju')
                      ->orWhere(function ($subQuery) {
                          $subQuery->where('status', 'pending')
                                   ->whereDate('tanggal_mulai', '>=', \Carbon\Carbon::today());
                      });
            })
            ->get();

            $events = $requests->map(function ($req) {
            
            $warnaBg = ($req->status === 'setuju') ? '#e11d48' : '#eab308';
            
            return [
                'id'          => $req->id_request,
                'title'       => ($req->status === 'setuju') ? '🔴 Running' : '🟡 Pending',
                'start'       => $req->tanggal_mulai,
                'end'         => $req->perkiraan_selesai,
                'backgroundColor' => $warnaBg,
                'borderColor'     => $warnaBg,
                'textColor'       => '#ffffff',
                'extendedProps' => [
                    'mahasiswa' => $req->nama_mahasiswa,
                    'software'  => $req->software
                ]
            ];
        });

        return response()->json($events);
    }
}