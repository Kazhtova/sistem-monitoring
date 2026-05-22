<x-apps-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-gray-800 tracking-tight">
                {{ __('My Requests') }}
            </h2>
            <div class="bg-indigo-50 px-4 py-2 rounded-xl border border-indigo-100">
                <span class="text-xs font-black text-gray-950 uppercase tracking-widest">Active Queue: </span>
                <span class="text-sm font-black text-gray-900">{{ $readRequest->count() }}/3</span>
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
                    <h3 class="text-lg font-bold text-gray-400">Belum ada request aktif</h3>
                    <p class="text-gray-400 text-sm mt-1">Silakan buat permintaan layanan baru jika diperlukan.</p>
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
                                        {{ $request->status == 'setuju' ? 'bg-violet-100 text-violet-700' : '' }}
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
                                <h3 class="text-violet-900 text-xs font-black uppercase tracking-widest mb-1">{{ $request->software }}</h3>
                                <p class="text-xl font-black text-gray-900 mb-4">PC: {{ $request->komputer->nama_komputer ?? 'General Service' }}</p>
                                <p class="text-lg font-black text-gray-900 mb-4">Dosen TA: {{ $request->dosen_ta ?? 'N/A' }}</p>

                                <div class="space-y-3">
                                    <div class="flex items-center text-sm">
                                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        <span class="text-gray-500">Mulai: </span>
                                        <span class="ml-auto font-bold text-gray-700">{{ \Carbon\Carbon::parse($request->tanggal_mulai)->format('d M, H:i') }}</span>
                                    </div>
                                    <div class="flex items-center text-sm">
                                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        <span class="text-gray-500">Target Selesai: </span>
                                        <span class="ml-auto font-bold text-gray-700">{{ \Carbon\Carbon::parse($request->perkiraan_selesai)->format('d M, H:i') }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-auto px-8 py-6 bg-gray-50 flex items-center gap-3">
                                <div>
                                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-tighter">Assigned Technician</p>
                                    <p class="text-sm font-bold text-gray-800">{{ $request->teknisi->nama_teknisi }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
    @push('scripts')
    @vite(['resources/js/app.js'])
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            @if (session('success'))
                Swal.fire({
                    icon: "success",
                    title: "{{ session('success') }}",
                    showConfirmButton: false,
                    timer: 1500
                });
            @endif

            let currentMahasiswaId = "{{ auth()->guard('mahasiswa')->user()->id_mahasiswa }}"

            if(typeof window.Echo !== 'undefined'){

                window.Echo.channel('mahasiswa.' + currentMahasiswaId)
                .listen('.StatusUpdated', (e) => {

                    let statusBadge = document.getElementById('badge-status-' + e.id_request)

                    if(statusBadge){
                        let allClasses = [
                            'bg-amber-100', 'text-amber-700', 
                            'bg-violet-100', 'text-violet-700', 
                            'bg-emerald-100', 'text-emerald-700',
                            'bg-red-100', 'text-red-700'
                        ];

                        statusBadge.classList.remove(...allClasses)

                        switch (e.status){
                            case 'pending':
                                statusBadge.classList.add('bg-amber-100', 'text-amber-700')
                                statusBadge.innerText = 'WAITING AGREEMENT'
                                break;
                            case 'setuju':
                                statusBadge.classList.add('bg-violet-100', 'text-violet-700')
                                statusBadge.innerText = 'RUNNING'
                                break;
                            case 'selesai':
                                statusBadge.classList.add('bg-emerald-100', 'text-emerald-700')
                                statusBadge.innerText = 'COMPLETED'
                                break;
                            case 'tolak':
                                statusBadge.classList.add('bg-red-100', 'text-red-700')
                                statusBadge.innerText = 'REJECTED'
                                break;
                        }
                    }
                })
            } else {
                console.error("❌ [ECHO ERROR] Library Echo gagal dimuat. Pastikan Vite (npm run dev) sedang berjalan.");
            }

        });
    </script>
    @endpush
</x-apps-layout>