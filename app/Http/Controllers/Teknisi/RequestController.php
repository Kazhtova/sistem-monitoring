<?php

namespace App\Http\Controllers\Teknisi;

use App\Events\ComputerView;
use App\Events\RequestStatusUpdated;
use App\Http\Controllers\Controller;
use App\Models\Request as ModelsRequest;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Kreait\Firebase\Messaging\CloudMessage;

class RequestController extends Controller
{
    public function listRequest(Request $request){
    //     $id_teknisi = auth()->guard('teknisi')->user()->id_teknisi;
    
    // $readRequest = ModelsRequest::where('id_teknisi', $id_teknisi)
    //                             ->latest()
    //                             ->get();
    /** @var \App\Models\Teknisi $user */
    $user = auth()->guard('teknisi')->user();

    session(['has_opened_request_list' => true]);

    $query = $user
            ->request()
            ->with('mahasiswa')
            ->whereNotIn('status', ['setuju', 'tolak', 'selesai']);

    if($request->filled('search')){
        $search = $request->search;
        $query->where(function($q) use ($search){
            $q->where('dosen_ta', 'like', "%{$search}%")
            ->orWhereHas('mahasiswa', function($mq) use ($search){
                $mq->where('nama_mahasiswa', 'like', "%{$search}%");
            });
        });
    }

    $sort = $request->input('sort', 'latest');
    if($sort === 'oldest'){
        $query->oldest();
    }else{
        $query->latest();
    }
                             
    $readRequest = $query->paginate(2)->withQueryString();    
    
    return view('teknisi.dashboard-teknisi', compact('readRequest'));
    }

    public function listAccept(Request $request) {
    /** @var \App\Models\Teknisi $user */
    $user = auth()->guard('teknisi')->user();

    $query = $user->request()
                        ->with('mahasiswa')
                        ->where('status', '=', 'setuju');

    if($request->filled('search')){
        $search = $request->search;
        $query->where(function($q) use ($search){
            $q->where('dosen_ta', 'like', "%{$search}%")
            ->orWhereHas('mahasiswa', function($mq) use ($search){
                $mq->where('nama_mahasiswa', 'like', "%{$search}%");
            });
        });
    }

    $sort = $request->input('sort', 'latest');
    if($sort === 'oldest'){
        $query->oldest();
    }else{
        $query->latest();
    }

    $readRequest = $query->paginate(3)->withQueryString();

    return view('teknisi.accept-dashboard', compact('readRequest'));
    }

    public function acceptRequest(int $id) {
        // Mengambil data request beserta relasi mahasiswa menggunakan findOrFail 
        $request = ModelsRequest::with('mahasiswa', 'komputer')->findOrFail($id); 

        DB::transaction(function () use ($request) {
                $request->update([
            'status'     => 'setuju' 
            ]);
        });

        $idLab = $request->komputer->id_laboratorium;
        
        ComputerView::dispatch($request->id_komputer, $idLab);

        RequestStatusUpdated::dispatch($request->id_request, $request->status, $request->id_mahasiswa);

        $mahasiswa = $request->mahasiswa; 

        // Validasi keberadaan mahasiswa dan fcm_token di database 
        if ($mahasiswa && $mahasiswa->fcm_token) { 
            try {
                $messaging = app('firebase.messaging'); 

                // Bangun pesan menggunakan fromArray universal yang divalidasi Google FCM v1 [cite: 50]
                $message = CloudMessage::fromArray([
                    'token'        => $mahasiswa->fcm_token, // Menargetkan token mahasiswa [cite: 50]
                    'notification' => [
                        'title' => 'Request Disetujui! 🎉', 
                        'body'  => "Request Software '{$request->software}' telah disetujui oleh teknisi.", 
                    ],
                    'webpush' => [ 
                        'notification' => [ 
                            'title'        => 'Request Disetujui! 🎉', 
                            'body'         => "Request Software '{$request->software}' telah disetujui oleh teknisi.", 
                            'icon'         => '/favicon.ico', 
                            'click_action' => '/mahasiswa/dashboard-mahasiswa', 
                        ],
                        'headers' => [ 
                            'Urgency' => 'high', // Prioritas tinggi untuk menembus Doze Mode Android 
                        ]
                    ],
                    'data' => [
                        'id_request' => (string) $request->id_request, // Memastikan id_request berupa string 
                        'type'       => 'request_accepted', 
                        'title'      => 'Request Disetujui! 🎉', 
                        'body'       => "Request Software '{$request->software}' telah disetujui oleh teknisi.",
                    ],
                ]);

                // Eksekusi pengiriman data [cite: 57]
                $messaging->send($message); 
                
                // PERBAIKAN: Menggunakan nama kolom id_mahasiswa yang benar [cite: 58]
                Log::info("FCM Notification Successfully Sent to Student ID: {$mahasiswa->id_mahasiswa}"); 
                
            } catch (\Exception $e) { 
                // Pencatatan log error kritis jika komunikasi gateway luar terputus [cite: 58]
                Log::error('FCM Notification Failed: ' . $e->getMessage()); 
            }
        } 

        ActivityLogger::log(
        action: 'ACCEPT_REQUEST',
        subject: $request,
        description: "Teknisi menyetujui request perbaikan dari Mahasiswa: {$request->mahasiswa->nama_mahasiswa} (PC: {$request->id_komputer})",
        properties: [
            'id_komputer' => $request->id_komputer,
            'software'    => $request->software,
            'status_baru' => 'setuju'
            ]
        );
            
            return redirect()->back()->with('success', 'Request Disetujui'); 
        }

    public function rejectRequest(int $id){
        $request = ModelsRequest::findOrFail($id);
        DB::transaction(function () use ($request) {
            $request->update([
            'status'     => 'tolak' 
            ]);
        });

        RequestStatusUpdated::dispatch($request->id_request, $request->status, $request->id_mahasiswa);

        ActivityLogger::log(
        action: 'REJECT_REQUEST',
        subject: $request,
        description: "Teknisi menolak request perbaikan PC {$request->id_komputer}.",
        properties: [
            'status_baru'      => 'tolak'
            ]
        );

        return redirect()->back()->with('reject', 'Request Ditolak');
    }

    public function cancleRequest(int $id){
        $request = ModelsRequest::findOrFail($id);  
        $request->update([
           'status'     => 'selesai', 
        ]);

        RequestStatusUpdated::dispatch($request->id_request, $request->status, $request->id_mahasiswa);

        ActivityLogger::log(
        action: 'COMPLETE_REQUEST',
        subject: $request,
        description: "Teknisi menandai perbaikan Software {$request->software} pada PC {$request->id_komputer} telah SELESAI.",
        properties: [
            'id_komputer' => $request->id_komputer,
            'status_baru' => 'selesai'
            ]
        );

        return redirect()->back()->with('success', 'Request Dibatalkan');
    }
}