<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Events\FotoView;
use App\Events\RequestCreated;
use App\Events\WaktuUpdated;
use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\Komputer;
use App\Models\Laboratorium;
use App\Models\Mahasiswa;
use App\Models\Request as ModelsRequest;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class RequestController extends Controller
{

    public function viewCard(int $id){
        $dataRequest = ModelsRequest::findOrFail($id);

        return view('mahasiswa.upload-foto', compact('dataRequest'));
    }

    public function viewRequest(Request $request, $id = null){

        if(empty($id)){
            $daftarLab = Laboratorium::orderBy('id_laboratorium', 'asc')->get();
            return view('mahasiswa.pilih-lab', compact('daftarLab'));
        }

        $labChoose = Laboratorium::findOrFail($id);

        $daftarDosen = Dosen::orderBy('nama_dosen', 'asc')->get();

        $komputerAvailable = Komputer::where('id_laboratorium', $id)
            ->orderByRaw('LENGTH(nama_komputer) ASC')
            ->orderBy('nama_komputer', 'asc')
            ->get()
            ->map(function ($item) {
                $item->nama_komputer = preg_replace_callback('/\d+/', function ($matches) {
                    return str_pad($matches[0], 2, '0', STR_PAD_LEFT);
                }, $item->nama_komputer);
                
                return $item;
            });
    
        return view('mahasiswa.input-request-mahasiswa', ['komputerTersedia' => $komputerAvailable, 'labId' => $id, 'labTerpilih' => $labChoose, 'daftarDosen' => $daftarDosen]);
    }

    public function showProfile(Mahasiswa $mahasiswa)
    {
        /** @var \App\Models\Mahasiswa $user */
        $user = auth()->guard('mahasiswa')->user();

        $readRequest = $user->requests()
                                ->with('teknisi')
                                ->latest()
                                ->get();

        return view('profile.profile', compact('mahasiswa', 'readRequest'));
    }

    public function sendRequest(Request $request){
        $request->validate([
            'nama_mahasiswa'    => 'required|string',
            'dosen_ta'          => 'required|string',
            'software'          => 'required|string',
            'no_hp'             => 'required|numeric',
            'tanggal_mulai'     => 'required|date',
            'perkiraan_selesai' => 'required|date|after:tanggal_mulai',
            'catatan'           => 'nullable|string',
            'foto_bukti'        => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'id_teknisi'        => 'required|exists:teknisi,id_teknisi',
            'id_laboratorium'   => 'required|exists:laboratorium,id_laboratorium',
            'nrp'               => 'required|exists:mahasiswa,nrp',
            'id_komputer'       => 'required|exists:komputer,id_komputer'
        ]);

        $bentrok = ModelsRequest::where('id_komputer', $request->id_komputer)
            ->where('status', 'setuju')
            ->where(function ($query) use ($request) {
                $query->where('tanggal_mulai', '<=', $request->perkiraan_selesai)
                      ->where('perkiraan_selesai', '>=', $request->tanggal_mulai);
            })
            ->first(); 

        if ($bentrok) {
            \Carbon\Carbon::setLocale('id'); 
            $waktuMulai = \Carbon\Carbon::parse($bentrok->tanggal_mulai)->translatedFormat('l, d M Y - H:i:s');
            $waktuSelesai = \Carbon\Carbon::parse($bentrok->perkiraan_selesai)->translatedFormat('l, d M Y - H:i:s');
            
            return redirect()->back()->withInput()->withErrors([
                'tanggal_mulai' => "Gagal! Komputer ini sedang aktif digunakan mulai {$waktuMulai} sampai {$waktuSelesai}. Silakan ajukan request di luar jam tersebut."
            ]);
        }

        $activeRequest = ModelsRequest::where('nrp', $request->nrp)->whereIn('status', ['pending', 'setuju'])->count();

        if($activeRequest >= 3){
            return redirect()->back()->withInput()->with('error', 'Limit, You Already have 3 Active Requests');
        }

        $newRequest = ModelsRequest::create([
            'nama_mahasiswa'        => $request->nama_mahasiswa,
            'dosen_ta'              => $request->dosen_ta,
            'software'              => $request->software,
            'no_hp'                 => $request->no_hp,
            'tanggal_mulai'         => $request->tanggal_mulai,
            'perkiraan_selesai'     => $request->perkiraan_selesai,
            'catatan'               => $request->catatan,
            'id_teknisi'            => $request->id_teknisi,
            'id_laboratorium'       => $request->id_laboratorium,
            'nrp'                   => $request->nrp,
            'id_komputer'           => $request->id_komputer
        ]);

        dispatch(function () use ($newRequest) {
            ActivityLogger::log(
                action: 'CREATE_REQUEST',
                subject: $newRequest,
                description: "Mahasiswa membuat request perbaikan baru untuk PC: {$newRequest->id_komputer} (Software: {$newRequest->software})",
                properties: [
                    'id_komputer' => $newRequest->id_komputer,
                    'software'    => $newRequest->software,
                    'dosen_ta'    => $newRequest->dosen_ta
                ]
            );
        })->afterResponse();

        broadcast(new RequestCreated($newRequest))->toOthers();

        return redirect()->route('mahasiswa.dashboard.mahasiswa')->with('success', 'Request Has Been Sent');
    }
    
    public function uploadImage(Request $request, int $id){
        $request->validate([
           'foto_bukti'        => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $dataRequest = ModelsRequest::with('komputer')->findOrFail($id);
        $fotoLama = $dataRequest->foto_bukti;

         $path = null;

        if($request->hasFile('foto_bukti')){
            
            if ($dataRequest->foto_bukti && Storage::disk('public')->exists($dataRequest->foto_bukti)){
                Storage::disk('public')->delete($dataRequest->foto_bukti);
            }
        
            $file = $request->file('foto_bukti');
            $nama_file = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('uploads', $nama_file, 'public'); 
            
            $dataRequest->update([
                'foto_bukti'    => $path,
            ]);

            dispatch(function () use ($dataRequest, $fotoLama, $path) {
                ActivityLogger::log(
                    action: 'UPLOAD_PHOTO',
                    subject: $dataRequest,
                    description: "Mahasiswa mengunggah foto bukti baru untuk request PC: {$dataRequest->komputer->nama_komputer}",
                    properties: [
                        'foto_lama' => $fotoLama,
                        'foto_baru' => $path
                    ]
                );
            })->afterResponse();
    
            broadcast(new FotoView($dataRequest->id_request, $path, $dataRequest->nrp))->toOthers();
    
            return redirect()->back()->with('success', 'Photo uploaded successfully!');
        }
            
        return redirect()->back();
    }
    
    public function readRequest(){
        /** @var \App\Models\Mahasiswa $user */
        $user = auth()->guard('mahasiswa')->user();

        $readRequest = $user->requests()
                                ->with(['teknisi', 'laboratorium'])
                                ->whereIn('status', ['pending', 'setuju'])
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
                'message' => 'Student FCM Token successfully updated.'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Invalid student session.'
        ], 401);
    }

    public function extendTime(Request $request, int $id){
        $request->validate([
            'perkiraan_selesai'     => 'required|date|after:now'
        ]);

        $dataRequest = ModelsRequest::findOrFail($id);

        $waktuLama = $dataRequest->perkiraan_selesai;

        $dataRequest->update([
                'perkiraan_selesai'     => $request->perkiraan_selesai
        ]);

        dispatch(function () use ($dataRequest, $waktuLama, $request) {
            ActivityLogger::log(
                action: 'EXTEND_TIME',
                subject: $dataRequest,
                description: "Mahasiswa mengubah perkiraan selesai pada PC: {$dataRequest->komputer->nama_komputer}",
                properties: [
                    'waktu_lama' => $waktuLama,
                    'waktu_baru' => $request->perkiraan_selesai
                ]
            );
        })->afterResponse();

        $waktuBaru = \Carbon\Carbon::parse($request->perkiraan_selesai)->format('Y-m-d H:i:s');

        broadcast(new WaktuUpdated($dataRequest->id_request, $waktuBaru))->toOthers();

        return redirect()->back()->with('success', 'Estimated completion time successfully extended.');
    }

    public function listPc(Request $request)
    {
        $search = $request->input('search');
        $filterLab = $request->input('lab');
        $filterStatus = $request->input('status');

        $query = Komputer::whereHas('laboratorium')->with(['laboratorium.teknisi', 'requests']);

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

        $query->orderBy(
            Laboratorium::select('nama_lab')
                ->whereColumn('laboratorium.id_laboratorium', 'komputer.id_laboratorium')
                ->limit(1), 
            'asc'
        )
        ->orderByRaw('LENGTH(nama_komputer) ASC')
        ->orderBy('nama_komputer', 'asc');

        $pc = $query->paginate(15)->appends($request->query());

        $pc->through(function ($item) {
            $item->nama_komputer = preg_replace_callback('/\d+/', function ($matches) {
                return str_pad($matches[0], 2, '0', STR_PAD_LEFT);
            }, $item->nama_komputer);
            
            return $item;
        });

        $labs = Laboratorium::get();

        return view('mahasiswa.list-pc', compact('pc', 'labs'));
    }
}