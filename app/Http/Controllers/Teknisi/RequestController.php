<?php

namespace App\Http\Controllers\Teknisi;

use App\Http\Controllers\Controller;
use App\Models\Request as ModelsRequest;
use Illuminate\Http\Request;

class RequestController extends Controller
{
    public function listRequest(Request $request){
    //     $id_teknisi = auth()->guard('teknisi')->user()->id_teknisi;
    
    // $readRequest = ModelsRequest::where('id_teknisi', $id_teknisi)
    //                             ->latest()
    //                             ->get();
    /** @var \App\Models\Teknisi $user */
    $user = auth()->guard('teknisi')->user();

    $query = $user
            ->request()
            ->with('mahasiswa')
            ->whereNotIn('status', ['setuju', 'tolak']);

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

    public function acceptRequest(int $id){
        $request = ModelsRequest::findOrFail($id);
        $request->update([
           'status'     => 'setuju' 
        ]);

        return redirect()->back()->with('success', 'Request Disetujui');
    }

    public function rejectRequest(int $id){
        $request = ModelsRequest::findOrFail($id);
        $request->update([
           'status'     => 'tolak' 
        ]);

        return redirect()->back()->with('reject', 'Request Ditolak');
    }

    public function cancleRequest(int $id){
        $request = ModelsRequest::findOrFail($id);
        $request->update([
           'status'     => 'selesai', 
        ]);

        return redirect()->back()->with('success', 'Request Dibatalkan');
    }
}