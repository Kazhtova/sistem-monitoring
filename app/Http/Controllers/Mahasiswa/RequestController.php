<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Events\RequestCreated;
use App\Http\Controllers\Controller;
use App\Models\Komputer;
use App\Models\Laboratorium;
use App\Models\Request as ModelsRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RequestController extends Controller
{
    public function viewRequest(Request $request, $id = null){

        if(empty($id)){
            $daftarLab = Laboratorium::orderBy('nama_lab', 'asc')->get();
            return view('mahasiswa.pilih-lab', compact('daftarLab'));
        }

        $labChoose = Laboratorium::findOrFail($id);

        $komputerUse = ModelsRequest::where('status', 'setuju')->pluck('id_komputer');

        $komputerAvailable = Komputer::whereNotIn('id_komputer', $komputerUse)->where('id_laboratorium', $id)->orderBy('nama_komputer', 'asc')->get();
    
        return view('mahasiswa.input-request-mahasiswa', ['komputerTersedia' => $komputerAvailable, 'labId' => $id, 'labTerpilih'   => $labChoose]);
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
            'id_komputer'       => ['required', 'exists:komputer,id_komputer', Rule::unique('request', 'id_komputer')->where(fn ($query) => $query->where('status', 'setuju'))]
        ]);

        $activeRequest = ModelsRequest::where('id_mahasiswa', $request->id_mahasiswa)->whereIn('status', ['pending', 'setuju'])->count();

        if($activeRequest >=3){
            return redirect()->back()->withInput()->with('error', 'Limit, You Already 3 Active Request');
        }

        $path = null;

        if($request->hasFile('foto_bukti')){
            $file = $request->file('foto_bukti');
            $nama_file = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('uploads', $nama_file, 'public'); 
        }

        $newRequest = ModelsRequest::create([
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

        broadcast(new RequestCreated($newRequest))->toOthers();

        return redirect()->route('mahasiswa.dashboard.mahasiswa')->with('success', 'Request Has Been Sent');
    } 
    
    public function readRequest(){
        /** @var \App\Models\Mahasiswa $user */
        $user = auth()->guard('mahasiswa')->user();

        $readRequest = $user->requests()
                                ->with('teknisi')
                                ->latest()
                                ->get();

        return view('mahasiswa.dashboard-mahasiswa', compact('readRequest'));
    }

    public function updateFcmToken(Request $request)
    {
        $request->validate([
            'fcm_token' => 'required|string'
        ]);

        /** @var \App\Models\Mahasiswa $user */
        $user = auth()->guard('mahasiswa')->user();
        
        if ($user) {
            $user->update([
                'fcm_token' => $request->fcm_token
            ]);

            return response()->json([
                'success' => true,
                'message' => 'FCM Token mahasiswa berhasil diperbarui.'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Sesi mahasiswa tidak valid.'
        ], 401);
    }
}