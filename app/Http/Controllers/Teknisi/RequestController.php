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

    $query = auth()->guard('teknisi')->user()
                             ->request()
                             ->with('mahasiswa')
                             ->where('status', '!=', 'setuju');

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

    public function listAccept(){
        $query = auth()->guard('teknisi')->user()
                            ->request()
                            ->with('mahasiswa')
                            ->where('status', '=', 'setuju');
                        
        $readRequest = $query->paginate(2)->withQueryString();

        return view('teknisi.accept-dashboard', compact('readRequest'));
    }

    public function acceptRequest(int $id){
        $request = ModelsRequest::findOrFail($id);
        $request->update([
           'status'     => 'setuju' 
        ]);

        return redirect()->back()->with('success', 'Request Disetujui');
    }
}