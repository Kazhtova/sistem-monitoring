<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-black text-2xl text-gray-900 tracking-tight">
                    {{ __('Accept List') }}
                </h2>
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-slate-50/50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="mb-8 flex flex-col lg:flex-row justify-between items-start lg:items-center bg-white p-5 rounded-2xl shadow-sm border border-slate-200">
                <form action="{{ route('teknisi.dashboard.accept') }}" method="GET" class="flex flex-wrap md:flex-nowrap w-full lg:w-auto flex-1 items-center gap-3">
                    <div class="relative w-full md:w-80 flex-shrink-0">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </span>
                        <input type="text" name="search" value="{{ request('search') }}" 
                               placeholder="Cari Dosen, Mahasiswa, atau Komputer..." 
                               class="pl-11 w-full rounded-xl border border-slate-200 bg-slate-50/50 py-2.5 shadow-sm outline-none focus:bg-white focus:border-slate-500 focus:ring-slate-500 sm:text-sm transition-all duration-300">
                    </div>
                    
                    <!-- 🟢 FITUR BARU: Filter Lab -->
                    <select name="lab" onchange="this.form.submit()" 
                        class="rounded-xl border-slate-200 text-sm shadow-sm bg-slate-50/50 text-slate-600 outline-none focus:bg-white focus:ring-1 focus:ring-slate-500 focus:border-slate-500 transition-all duration-300">
                        <option value="all">Semua Lab</option>
                        @foreach($daftarLab as $lab)
                            <option value="{{ $lab->id_laboratorium }}" {{ request('lab') == $lab->id_laboratorium ? 'selected' : '' }}>
                                {{ $lab->nama_lab }}
                            </option>
                        @endforeach
                    </select>

                    <!-- 🟢 FITUR BARU: Filter Status (Khusus Setuju, Tolak, Selesai) -->
                    <select name="status" onchange="this.form.submit()" 
                        class="rounded-xl border-slate-200 text-sm shadow-sm bg-slate-50/50 text-slate-600 outline-none focus:bg-white focus:ring-1 focus:ring-slate-500 focus:border-slate-500 transition-all duration-300">
                        <option value="all">Semua Status</option>
                        <option value="setuju" {{ request('status') == 'setuju' ? 'selected' : '' }}>Running (Setuju)</option>
                        <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="tolak" {{ request('status') == 'tolak' ? 'selected' : '' }}>Ditolak</option>
                    </select>

                    <select name="sort" onchange="this.form.submit()" 
                            class="rounded-xl border-slate-200 text-sm shadow-sm bg-slate-50/50 text-slate-600 outline-none focus:bg-white focus:ring-1 focus:ring-slate-500 focus:border-slate-500 transition-all duration-300 flex-shrink-0">
                        <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                        <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Terlama</option>
                    </select>

                    <button type="submit" class="bg-slate-900 hover:bg-slate-800 text-white px-6 py-2.5 rounded-xl text-sm font-bold tracking-wide transition-all duration-300 shadow-sm active:scale-95 flex-shrink-0">
                        Cari
                    </button>
                    
                    <!-- 🟢 PERBAIKAN: Tombol Reset akan muncul jika ada aktivitas pada search, sort, lab, ATAU status -->
                    @if(request('search') || request('sort') || request('lab') || request('status'))
                        <a href="{{ route('teknisi.dashboard.accept') }}" class="text-sm text-slate-400 hover:text-red-500 font-semibold transition-colors flex items-center gap-1 flex-shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            Reset
                        </a>
                    @endif
                </form>

                <div class="w-full lg:w-auto flex justify-end">
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse whitespace-nowrap">
                        
                        <thead>
                            <tr class="bg-slate-50/50 border-b border-slate-200">
                                <th class="py-4 px-6 text-xs font-bold text-slate-900 uppercase tracking-wider">Student</th>
                                <th class="py-4 px-6 text-xs font-bold text-slate-900 uppercase tracking-wider">Computer</th>
                                <th class="py-4 px-6 text-xs font-bold text-slate-900 uppercase tracking-wider">Lab</th>
                                <th class="py-4 px-6 text-xs font-bold text-slate-900 uppercase tracking-wider">No Telp</th>
                                <th class="py-4 px-8 text-xs font-bold text-slate-900 uppercase tracking-wider">Status</th>
                                <th class="py-4 px-6 text-xs font-bold text-slate-900 uppercase tracking-wider text-center">Actions</th>
                            </tr>
                        </thead>
                        
                        <tbody class="divide-y divide-slate-100">
                            @forelse($readRequest as $index => $data_request)
                                <tr class="hover:bg-slate-50/50 transition-colors duration-150">
                                    <td class="py-4 px-6">
                                            <div class="flex flex-col">
                                                <span class="text-sm font-bold text-slate-800">
                                                    {{ $data_request->mahasiswa->nama_mahasiswa }}
                                                </span>
                                            </div>
                                        </div>
                                    </td>
                                    
                                    <td class="py-4 px-6 text-sm font-medium text-slate-600">
                                        {{ $data_request->komputer->nama_komputer }}
                                    </td>
                                    
                                    <td class="py-4 px-6 text-sm font-medium text-slate-600">
                                        <div class="whitespace-normal max-w-[150px]">
                                            {{ $data_request->laboratorium->nama_lab }}
                                        </div>
                                    </td>
                                    
                                    <td class="py-4 px-6 text-sm font-medium text-slate-800">
                                        {{ $data_request->no_hp }}
                                    </td>
                                    
                                    <td class="py-4 px-6">
                                        @php
                                            $status = strtolower($data_request->status);
                                            $bgColor = 'bg-slate-100';
                                            $textColor = 'text-slate-600';
                                            $dotColor = 'bg-slate-400';
                                            
                                            if($status == 'setuju' || $status == 'running') {
                                                $bgColor = 'bg-slate-50';
                                                $textColor = 'text-slate-600';
                                                $dotColor = 'bg-slate-900';
                                            } elseif($status == 'pending') {
                                                $bgColor = 'bg-amber-50';
                                                $textColor = 'text-amber-600';
                                                $dotColor = 'bg-amber-500';
                                            }
                                        @endphp

                                        <span id="badge-status-{{ $data_request->id_request }}" class="inline-flex items-center gap-1.5 py-1.5 px-1.5 rounded-full text-xs font-semibold {{ $bgColor }} {{ $textColor }} transition-colors duration-300">
                                            <span class="w-2 h-2 rounded-full {{ $dotColor }}"></span>
                                            {{ $status == 'setuju' ? 'Running' : ucfirst($status) }}
                                        </span>
                                    </td>
                                    
                                    <td class="py-4 px-6">
                                        <div class="flex items-center justify-center gap-3">
                                            <a href="{{ route('teknisi.request.details', $data_request->id_request) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-bold text-slate-600 bg-white border border-slate-200 rounded-lg hover:bg-slate-50 hover:border-slate-300 transition-colors shadow-sm">
                                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                                Details
                                            </a>

                                            <form id="form-reject-{{ $data_request->id_request }}" action="{{ route('teknisi.cancel.request', $data_request->id_request) }}" method="POST" class="m-0"> 
                                                @csrf 
                                                @method('PATCH')
                                                
                                                <!-- 🟢 Tambahkan gap-1.5 pada class button agar ada jarak presisi antara SVG dan Teks -->
                                                <button type="button" 
                                                        onclick="confirmDelete('{{ $data_request->id_request }}')" 
                                                        class="inline-flex items-center gap-1.5 px-4 py-1.5 text-xs font-bold text-white bg-red-500 border border-transparent rounded-lg hover:bg-red-600 transition-colors shadow-sm active:scale-95">
                                                    
                                                    <!-- Ikon Check Circle -->
                                                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    
                                                    Selesaikan Request 
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                    
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-12 text-center">
                                        <div class="flex flex-col items-center justify-center text-slate-400">
                                            <svg class="w-12 h-12 mb-3 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                            <span class="text-sm font-medium">Tidak ada request yang sedang berjalan.</span>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($readRequest->hasPages())
                    <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
                        {{ $readRequest->links() }}
                    </div>
                @endif
            </div>
            
        </div>
    </div>

    <div id="modalGambar" class="fixed inset-0 z-[999] hidden bg-slate-900/95 backdrop-blur-xl flex items-center justify-center p-8 transition-opacity duration-300" onclick="tutupModal()">
        <div class="relative max-w-5xl w-full flex justify-center">
            <button class="absolute -top-12 right-0 text-white/70 text-5xl font-light hover:text-red-500 hover:rotate-90 transition-all duration-300">&times;</button>
            <img id="gambarUtuh" class="max-w-full max-h-[85vh] rounded-3xl shadow-2xl object-contain border border-white/10" onclick="event.stopPropagation()">
        </div>
    </div>

    <script>
        function bukaModal(src) {
            const modal = document.getElementById('modalGambar');
            const gambar = document.getElementById('gambarUtuh');
            gambar.src = src;
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function tutupModal() {
            const modal = document.getElementById('modalGambar');
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        function confirmDelete(id) {
            Swal.fire({
                title: "Ingin Menyelesaikan Request?",
                text: "Anda menyelesaikan Request Yang Sedang Berjalan!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#4f46e5", 
                cancelButtonColor: "#ef4444", 
                confirmButtonText: "Ya, Selesaikan",
                cancelButtonText: "Kembali"
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('form-reject-' + id).submit();
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function () {
            
            // Listener Foto
            window.Echo.channel('foto-channel')
            .listen('.FotoView', (e) => {
                const container = document.getElementById('foto-container-' + e.id_request)

                if(container){
                    const newImageUrl = '/storage/' + e.path
                    let existingImg = document.getElementById('img-' + e.id_request)
                    let placeholder = document.getElementById('placeholder-' + e.id_request)

                    if(existingImg){
                        existingImg.src = newImageUrl
                    } else { 
                        if(placeholder){ placeholder.remove() }

                        const newImg = document.createElement('img')
                        newImg.id = 'img-' + e.id_request
                        newImg.src = newImageUrl
                        newImg.className = 'w-full h-full object-cover transition-transform duration-700 group-hover:scale-105 cursor-pointer'

                        newImg.onclick = function (){ bukaModal(this.src) }
                        container.insertBefore(newImg, container.firstChild)
                    }
                }
            })

            // Listener Waktu Realtime
            window.Echo.channel('teknisi-channel')
            .listen('.WaktuUpdated', (e) => {
                let waktuTarget = document.getElementById('waktu-selesai-teknisi-' + e.id_request)

                if(waktuTarget) {
                    waktuTarget.innerText = e.waktu_baru
                    // Efek kedip saat data berubah
                    waktuTarget.classList.add('text-violet-600')
                    setTimeout(() => {
                        waktuTarget.classList.remove('text-violet-600')
                    }, 1000)
                }
            })
        })
    </script>
</x-app-layout>