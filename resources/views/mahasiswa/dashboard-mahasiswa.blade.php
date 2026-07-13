<x-apps-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-gray-800 tracking-tight">
                {{ __('My Requests') }}
            </h2>
            <div class="bg-slate-200 px-4 py-1 rounded-xl border border-slate-300">
                <span class="text-xs font-black text-slate-950 uppercase tracking-widest">Active Queue: </span>
                <span class="text-sm font-black text-slate-900">{{ $readRequest->count() }}/3</span>
            </div>
        </div>
    </x-slot>

   <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if($readRequest->isEmpty())
                <div class="text-center py-20 bg-white rounded-3xl border border-dashed border-gray-300">
                    <div class="mb-4 flex justify-center">
                        <svg class="w-16 h-16 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-400">There are no active requests yet.</h3>
                    <p class="text-gray-400 text-sm mt-1">Please submit a new service request if necessary.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($readRequest as $index => $request)
                        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden flex flex-col transition-all hover:shadow-xl">
                            
                            <div class="p-6 border-b border-gray-50 flex justify-between items-center">
                                <span class="text-xs font-black text-gray-400 uppercase tracking-widest">#{{ $index + 1 }}</span>
                                
                                <span id="badge-status-{{ $request->id_request }}"
                                    class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider transition-colors duration-300
                                        {{ $request->status == 'pending' ? 'bg-amber-100 text-amber-700' : '' }}
                                        {{ $request->status == 'setuju' ? 'bg-slate-200 text-slate-950' : '' }}
                                        {{ $request->status == 'selesai' ? 'bg-emerald-100 text-emerald-700' : '' }}
                                        {{ $request->status == 'tolak' ? 'bg-red-100 text-red-700' : '' }}">
                                
                                    @if ($request->status == 'pending')
                                        Waiting Agreement
                                    @elseif($request->status == 'setuju')
                                        Running
                                    @elseif($request->status == 'selesai')
                                        Completed
                                    @else
                                        Rejected
                                    @endif
                                
                                </span>
                            </div>
                            <div class="p-8">
                                <h3 class="text-slate-900 text-xs font-black uppercase tracking-widest mb-1">Software: {{ $request->software }}</h3>
                                <p class="text-xl font-black text-gray-900 mb-4">PC: {{ $request->komputer->nama_komputer ?? 'General Service' }}</p>
                                <p class="text-xl font-black text-gray-900 mb-4">Lab: {{ $request->laboratorium->nama_lab ?? 'General Service' }}</p>
                                <p class="text-lg font-black text-gray-900 mb-4">Lecture: {{ $request->dosen_ta ?? 'N/A' }}</p>

                                <div class="grid grid-cols-[1fr_auto_auto] gap-y-3 gap-x-1.5 items-center text-sm w-full mt-2">
    
                                    <div class="flex items-center text-gray-500">
                                        <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        <span class="whitespace-nowrap">Start:</span>
                                    </div>
                                    
                                    <div class="font-bold text-gray-700 tabular-nums whitespace-nowrap">{{ \Carbon\Carbon::parse($request->tanggal_mulai)->format('d M, H:i') }}</div>
                                    
                                    <div class="w-8 h-10 flex-shrink-0"></div>

                                    <div class="flex items-center text-gray-500">
                                        <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        <span class="whitespace-nowrap">Target Completed:</span>
                                    </div>
                                    
                                    <div id="waktu-selesai-{{ $request->id_request }}" class="font-bold text-gray-700 tabular-nums whitespace-nowrap origin-left transition-all duration-300">{{ \Carbon\Carbon::parse($request->perkiraan_selesai)->format('d M, H:i') }}</div>
                                    
                                    <button type="button" 
                                            id="btn-update-waktu-{{ $request->id_request }}"
                                            onclick="bukaModalWaktu('{{ $request->id_request }}', '{{ $request->perkiraan_selesai }}')" 
                                            class="w-8 h-10 flex-shrink-0 flex items-center justify-center text-gray-400 hover:text-slate-600 hover:bg-slate-100 rounded-lg transition-all duration-300 shadow-sm hover:shadow border border-transparent hover:border-slate-100 ml-1.5 {{ $request->status !== 'setuju' ? 'hidden' : '' }}" 
                                            title="Update Estimate Complete">
                                        <svg class="w-5.5 h-5.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                    </button>

                                </div>
                            </div>

                            <div class="mt-auto px-8 py-6 bg-gray-50 flex justify-between items-center gap-3">
                            <div>
                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-tighter">Assigned Technician</p>
                                <p class="text-sm font-bold text-gray-800">{{ $request->teknisi->nama_teknisi }}</p>
                            </div>

                            <div id="upload-container-{{ $request->id_request }}" class="{{ $request->status !== 'setuju' ? 'invisible' : '' }}">
                                <a href="{{ route('mahasiswa.foto.card', ['id' => $request->id_request]) }}" 
                                class="inline-flex items-center justify-center bg-slate-100 hover:bg-slate-200 text-slate-800 p-4 rounded-full shadow-md transition-all duration-300 hover:scale-110" 
                                title="Pindah ke Halaman Upload">    
                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
    
    <div id="modalWaktu" class="fixed inset-0 z-[999] hidden bg-gray-900/90 backdrop-blur-xl flex items-center justify-center p-4" onclick="tutupModalWaktu()">
        <div class="bg-white rounded-3xl shadow-2xl max-w-sm w-full p-8 relative overflow-hidden" onclick="event.stopPropagation()">
            
            <button type="button" onclick="tutupModalWaktu()" class="absolute top-5 right-5 text-gray-300 hover:text-red-500 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>

            <div class="mb-6">
                <div class="w-12 h-12 bg-slate-100 text-slate-600 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h3 class="text-xl font-black text-gray-900">Update Time</h3>
                <p class="text-sm font-medium text-gray-500 mt-1">adjust the time.</p>
            </div>
            
            <form id="formUpdateWaktu" method="POST">
                @csrf
                @method('PATCH')
                <div class="mb-8">
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Estimate Complete (New)</label>
                    <input type="datetime-local" 
                        name="perkiraan_selesai" 
                        id="inputWaktuSelesai" 
                        required 
                        class="w-full rounded-xl border-gray-200 shadow-sm focus:border-slate-500 focus:ring-slate-500 text-sm font-bold text-gray-800 transition-all p-3 bg-gray-50">
                </div>
                
                <div class="flex justify-end gap-3">
                    <button type="button" onclick="tutupModalWaktu()" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-bold rounded-xl transition-colors">Batal</button>
                    <button type="submit" class="px-5 py-2.5 bg-slate-600 hover:bg-slate-700 text-white text-sm font-bold rounded-xl shadow-lg shadow-slate-200 transition-all hover:-translate-y-0.5">Simpan Waktu</button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    @vite(['resources/js/app.js'])
    <script>

        function bukaModalWaktu(idRequest, waktuSaatIni) {
            const modal = document.getElementById('modalWaktu');
            const form = document.getElementById('formUpdateWaktu');
            const inputWaktu = document.getElementById('inputWaktuSelesai');
            
            form.action = `/mahasiswa/update-time-mahasiswa/${idRequest}`; 
            
            if(waktuSaatIni) {
                inputWaktu.value = waktuSaatIni.replace(' ', 'T');
            }
            
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden'; 
        }

        function tutupModalWaktu() {
            const modal = document.getElementById('modalWaktu');
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        document.addEventListener('DOMContentLoaded', function () {
            @if (session('success'))
                Swal.fire({
                    icon: "success",
                    title: "{{ session('success') }}",
                    showConfirmButton: false,
                    timer: 1500
                });
            @endif

            let currentMahasiswaId = @json(optional(auth()->guard('mahasiswa')->user())->nrp);
            if(!currentMahasiswaId) return;

            const initRealtime = () => {
                if(typeof window.Echo !== 'undefined'){
                    window.Echo.channel('mahasiswa.' + currentMahasiswaId)
                    .listen('.StatusUpdated', (e) => {
                        let statusBadge = document.getElementById('badge-status-' + e.id_request);
                        let uploadContainer = document.getElementById('upload-container-' + e.id_request);
                        let waktuSelesaiTarget = document.getElementById('waktu-selesai-' + e.id_request);
                        
                        let tombolUpdateWaktu = document.getElementById('btn-update-waktu-' + e.id_request); 

                        if(waktuSelesaiTarget && e.perkiraan_selesai){
                            waktuSelesaiTarget.innerText = e.perkiraan_selesai;
                            waktuSelesaiTarget.classList.add('text-slate-600', 'scale-110');
                            setTimeout(() => {
                                waktuSelesaiTarget.classList.remove('text-slate-600', 'scale-110');
                            }, 1000);
                        }

                        if(statusBadge){
                            let allClasses = [
                                'bg-amber-100', 'text-amber-700', 
                                'bg-slate-200', 'text-slate-950', 
                                'bg-emerald-100', 'text-emerald-700',
                                'bg-red-100', 'text-red-700'
                            ];
                            statusBadge.classList.remove(...allClasses);

                            switch (e.status){
                                case 'pending':
                                    statusBadge.classList.add('bg-amber-100', 'text-amber-700');
                                    statusBadge.innerText = 'WAITING AGREEMENT';
                                    if(uploadContainer) uploadContainer.classList.add('invisible');
                                    // 🟢 PERBAIKAN: Sembunyikan tombol saat antrean masih pending
                                    if(tombolUpdateWaktu) tombolUpdateWaktu.classList.add('hidden'); 
                                    break;
                                case 'setuju':
                                    statusBadge.classList.add('bg-slate-200', 'text-slate-950');
                                    statusBadge.innerText = 'RUNNING';
                                    if(uploadContainer) uploadContainer.classList.remove('invisible');
                                    // 🟢 PERBAIKAN: Munculkan tombol saat request disetujui
                                    if(tombolUpdateWaktu) tombolUpdateWaktu.classList.remove('hidden'); 
                                    break;
                                case 'selesai':
                                    statusBadge.classList.add('bg-emerald-100', 'text-emerald-700');
                                    statusBadge.innerText = 'COMPLETED';
                                    if(uploadContainer) uploadContainer.classList.add('invisible');
                                    if(tombolUpdateWaktu) tombolUpdateWaktu.classList.add('hidden'); 
                                    break;
                                case 'tolak':
                                    statusBadge.classList.add('bg-red-100', 'text-red-700');
                                    statusBadge.innerText = 'REJECTED';
                                    if(uploadContainer) uploadContainer.classList.add('invisible');
                                    if(tombolUpdateWaktu) tombolUpdateWaktu.classList.add('hidden'); 
                                    break;
                            }
                        }
                    });
                } else {
                    console.warn("⏳ Menunggu Vite memuat Laravel Echo...");
                    setTimeout(initRealtime, 100);
                }
            };

            initRealtime();
        });
    </script>
    @endpush
</x-apps-layout>