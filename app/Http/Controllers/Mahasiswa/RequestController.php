<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Request as ModelsRequest;
use Illuminate\Http\Request;

class RequestController extends Controller
{
    public function viewRequest(){
        return view('mahasiswa.input-request-mahasiswa');
    }
    public function sendRequest(Request $request){
        $request->validate([
            'dosen_ta'          => 'required|string',
            'software'          => 'required|string',
            'no_hp'             => 'required|numeric',
            'tanggal_mulai'     => 'required|date',
            'perkiraan_selesai' => 'required|date|after:tanggal_mulai',
            'catatan'           => 'nullable|string',
            'foto_bukti'        => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'id_teknisi'        => 'required|exists:teknisi,id_teknisi',
            'id_mahasiswa'      => 'required|exists:mahasiswa,id_mahasiswa',
            'id_komputer'       => 'required|exists:komputer,id_komputer' 
        ]);

        $activeRequest = ModelsRequest::where('id_mahasiswa', $request->id_mahasiswa)->whereIn('status', ['pending', 'setuju'])->count();

        if($activeRequest >=3){
            return redirect()->back()->withInput()->with('error', 'Limit, You Already 3 Active Request');
        }

        if($request->hasFile('foto_bukti')){
            $file = $request->file('foto_bukti');
            $nama_file = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('uploads', $nama_file, 'public'); 
        }

        ModelsRequest::create([
            'dosen_ta'              => $request->dosen_ta,
            'software'              => $request->software,
            'no_hp'                 => $request->no_hp,
            'tanggal_mulai'         => $request->tanggal_mulai,
            'perkiraan_selesai'     => $request->perkiraan_selesai,
            'catatan'               => $request->catatan,
            'foto_bukti'            => $path,
            'id_teknisi'            => $request->id_teknisi,
            'id_mahasiswa'          => $request->id_mahasiswa,
            'id_komputer'           => $request->id_komputer
        ]);

        return redirect()->route('dashboard.mahasiswa')->with('success', 'Request Has Been Sent');
    } 
    
    public function readRequest(){
        
        $user = auth()->guard('mahasiswa')->user();

        $readRequest = $user->request()
                                    ->with('teknisi')
                                    ->latest()
                                    ->get();

        return view('mahasiswa.dashboard-mahasiswa', compact('readRequest'));
    }
}