<?php

namespace App\Http\Controllers\Teknisi;

use App\Events\ComputerView;
use App\Events\RequestStatusUpdated;
use App\Http\Controllers\Controller;
use App\Jobs\KirimNotifikasiFcm;
use App\Models\Komputer;
use App\Models\Request as ModelsRequest;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Kreait\Firebase\Messaging\CloudMessage;

class RequestController extends Controller
{
    public function listRequest(Request $request){

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
        $request = ModelsRequest::with('mahasiswa', 'komputer')->findOrFail($id); 

        $request->update(['status' => 'setuju']);

        $idLab = $request->komputer->id_laboratorium;
        
        
        dispatch(function () use ($request, $idLab) {
            
        KirimNotifikasiFcm::dispatch($request->mahasiswa, $request->software, $request->id_request, $request->komputer->nama_komputer);
        ComputerView::dispatch($request->id_komputer, $idLab);
        RequestStatusUpdated::dispatch($request->id_request, $request->status, $request->id_mahasiswa);

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

    })->afterResponse(); 
        
    return redirect()->back()->with('success', 'Request Disetujui'); 
}

    public function rejectRequest(int $id)
{
    $request = ModelsRequest::with('mahasiswa')->findOrFail($id);

    $request->update([
        'status' => 'tolak' 
    ]);

    RequestStatusUpdated::dispatch($request->id_request, $request->status, $request->id_mahasiswa);

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

    return redirect()->back()->with('reject', 'Request Ditolak');
}

    public function cancelRequest(int $id)
    {
    $request = ModelsRequest::findOrFail($id);  
    
    $request->update([
        'status' => 'selesai', 
    ]);

    dispatch(function () use ($request) {
        
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
        
    })->afterResponse(); 

    return redirect()->back()->with('success', 'Perbaikan Telah Selesai Ditangani');
    }

    public function listPc()
{
    // Mengambil komputer yang punya lab, dan lab tersebut punya teknisi
    $user = auth()->guard('teknisi')->user();

    $pc = Komputer::whereHas('laboratorium', function($query) use ($user){
        $query->where('id_teknisi', $user->id_teknisi);
    })->with(['laboratorium.teknisi', 'requests'])->paginate(15);

    return view('teknisi.list-pc', compact('pc'));
}
}