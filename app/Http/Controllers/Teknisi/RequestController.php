<?php

namespace App\Http\Controllers\Teknisi;

use App\Events\ComputerView;
use App\Events\RequestStatusUpdated;
use App\Http\Controllers\Controller;
use App\Jobs\KirimNotifikasiFcm;
use App\Models\Komputer;
use App\Models\Laboratorium;
use App\Models\Request as ModelsRequest;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Kreait\Firebase\Messaging\CloudMessage;

class RequestController extends Controller
{
    public function listPending(Request $request){

    /** @var \App\Models\Teknisi $user */
    $user = auth()->guard('teknisi')->user();

    session(['has_opened_request_list' => true]);

    // 1. Ambil daftar lab yang dikelola oleh teknisi ini untuk dropdown filter
    $daftarLab = Laboratorium::where('id_teknisi', $user->id_teknisi)->get();

    // 2. 🟢 KUNCI MUTLAK: Inisiasi Query dasar yang HANYA memanggil status pending
    $query = $user->request()
            ->with(['mahasiswa', 'komputer', 'laboratorium'])
            ->whereNotIn('status', ['setuju', 'tolak', 'selesai']);

    // 3. Logika Filter Laboratorium (Tersisa)
    if ($request->filled('lab') && $request->lab !== 'all') {
        $query->where('id_laboratorium', $request->lab);
    }

    // 4. Logika Pencarian (Search)
    if($request->filled('search')){
        $search = $request->search;
        $query->where(function($q) use ($search){
            $q->where('dosen_ta', 'like', "%{$search}%")
            ->orWhereHas('mahasiswa', function($mq) use ($search){
                $mq->where('nama', 'like', "%{$search}%");
            });
        });
    }

    // 5. Logika Pengurutan (Sort)
    $sort = $request->input('sort', 'latest');
    if($sort === 'oldest'){
        $query->oldest();
    }else{
        $query->latest();
    }
                             
    $readRequest = $query->paginate(15)->withQueryString();    
    
    return view('teknisi.dashboard-teknisi', compact('readRequest', 'daftarLab'));
    }

    public function listRequest(Request $request) {
    /** @var \App\Models\Teknisi $user */
    $user = auth()->guard('teknisi')->user();

    // 1. Ambil daftar lab untuk dropdown filter
    $daftarLab = Laboratorium::where('id_teknisi', $user->id_teknisi)->get();

    // 2. Kueri Dasar: HANYA panggil yang berstatus setuju, tolak, atau selesai
    $query = $user->request()
            ->with(['mahasiswa', 'komputer', 'laboratorium'])
            ->whereIn('status', ['setuju', 'tolak', 'selesai']);

    // 3. 🟢 FITUR BARU: Filter Status Spesifik
    if ($request->filled('status') && $request->status !== 'all') {
        $query->where('status', $request->status);
    }

    // 4. 🟢 FITUR BARU: Filter Laboratorium
    if ($request->filled('lab') && $request->lab !== 'all') {
        $query->where('id_laboratorium', $request->lab);
    }

    // 5. Logika Search
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('dosen_ta', 'like', "%{$search}%")
              ->orWhere('software', 'like', "%{$search}%")
              ->orWhereHas('mahasiswa', function($mq) use ($search) {
                  $mq->where('nama', 'like', "%{$search}%");
              })              
              ->orWhereHas('komputer', function($kq) use ($search) {
                  $kq->where('nama_komputer', 'like', "%{$search}%");
              });
        });
    }

    // 6. Logika Sort
    $sort = $request->input('sort', 'latest');
    if ($sort === 'oldest') {
        $query->oldest();
    } else {
        $query->latest();
    }
                             
    $readRequest = $query->paginate(15)->withQueryString();    
    
    // Jangan lupa kirim $daftarLab ke View
    return view('teknisi.accept-dashboard', compact('readRequest', 'daftarLab'));
    }

    public function acceptRequest(int $id) {
        $request = ModelsRequest::with('mahasiswa', 'komputer')->findOrFail($id); 

        $isKomputerSedangDipakai = ModelsRequest::where('id_komputer', $request->id_komputer)
                                            ->where('status', 'setuju')
                                            ->exists();

        if ($isKomputerSedangDipakai) {
            return redirect()->back()->with('error', 'Gagal! Komputer ini sedang Running (status SETUJU) pada request lain.');
        }

        $request->update(['status' => 'setuju']);

        $idLab = $request->komputer->id_laboratorium;
        
        dispatch(function () use ($request, $idLab) {
            
        KirimNotifikasiFcm::dispatch($request->mahasiswa, $request->software, $request->id_request, $request->komputer->nama_komputer);
        ComputerView::dispatch($request->id_komputer, $idLab);
        RequestStatusUpdated::dispatch($request->id_request, $request->status, $request->nrp);

        ActivityLogger::log(
            action: 'ACCEPT_REQUEST',
            subject: $request,
            description: "Teknisi menyetujui request perbaikan dari Mahasiswa: {$request->mahasiswa->nama} (PC: {$request->id_komputer})",
            properties: [
                'id_komputer' => $request->id_komputer,
                'software'    => $request->software,
                'status_baru' => 'setuju'
            ]
        );

    })->afterResponse(); 
          
    return redirect()->back()->with('success', 'Request Disetujui'); 
    }

    public function rejectRequest(int $id)
{   
    $request = ModelsRequest::with('mahasiswa')->findOrFail($id);

    $request->update([
        'status' => 'tolak' 
    ]);

    RequestStatusUpdated::dispatch($request->id_request, $request->status, $request->nrp);

    dispatch(function () use ($request) {
        ActivityLogger::log(
            action: 'REJECT_REQUEST',
            subject: $request,
            description: "Teknisi menolak request perbaikan PC {$request->id_komputer}.",
            properties: [
                'status_baru' => 'tolak'
            ]
        );
    })->afterResponse(); 

    return redirect()->route('teknisi.dashboard.request')->with('reject', 'Request Ditolak');
    }

    public function cancelRequest(int $id)
    {
    $request = ModelsRequest::findOrFail($id);  
    
    $request->update([
        'status' => 'selesai', 
    ]);

    dispatch(function () use ($request) {
        
        RequestStatusUpdated::dispatch($request->id_request, $request->status, $request->nrp);

        ActivityLogger::log(
            action: 'COMPLETE_REQUEST',
            subject: $request,
            description: "Teknisi menandai perbaikan Software {$request->software} pada PC {$request->id_komputer} telah SELESAI.",
            properties: [
                'id_komputer' => $request->id_komputer,
                'status_baru' => 'selesai'
            ]
        );
        
    })->afterResponse(); 

    return redirect()->back()->with('success', 'Perbaikan Telah Selesai Ditangani');
    }

    public function listPc(Request $request)
    {
        $user = auth()->guard('teknisi')->user();

        $search = $request->input('search');
        $filterLab = $request->input('lab');
        $filterStatus = $request->input('status');

        $query = Komputer::whereHas('laboratorium', function($q) use ($user) {
            $q->where('id_teknisi', $user->id_teknisi);
        })->with(['laboratorium.teknisi', 'requests']);

        if ($search) {
            $query->where('nama_komputer', 'like', '%' . $search . '%');
        }

        if ($filterLab) {
            $query->where('id_laboratorium', $filterLab);
        }

        if ($filterStatus === 'in_use') {
            $query->whereHas('requests', function($q) {
                $q->where('status', 'setuju');
            });
        } elseif ($filterStatus === 'ready') {
            $query->whereDoesntHave('requests', function($q) {
                $q->where('status', 'setuju');
            });
        }

        $pc = $query->paginate(15)->appends($request->query());

        $labs = Laboratorium::where('id_teknisi', $user->id_teknisi)->get();

        return view('teknisi.list-pc', compact('pc', 'labs'));
    }

    public function viewPendingDetails(int $id){
        
        $data = ModelsRequest::with('mahasiswa', 'komputer')->findOrFail($id);

        return view('teknisi.pending-details', compact('data'));
    }

    public function viewRequestDetails(int $id){
        
        $data = ModelsRequest::with('mahasiswa', 'komputer')->findOrFail($id);

        return view('teknisi.request-details', compact('data'));
    }
}