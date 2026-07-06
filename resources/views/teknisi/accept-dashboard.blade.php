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
            
            <div class="mb-8 flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6 bg-white p-5 rounded-2xl shadow-sm border border-slate-100">
                <form action="{{ route('teknisi.dashboard.accept') }}" method="GET" class="flex flex-wrap md:flex-nowrap w-full lg:w-auto flex-1 items-center gap-3">
                    <div class="relative w-full md:w-80">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </span>
                        <input type="text" name="search" value="{{ request('search') }}" 
                               placeholder="Cari Dosen atau Mahasiswa..." 
                               class="pl-11 w-full rounded-xl border border-slate-200 bg-slate-50/50 shadow-sm outline-none focus:bg-white focus:border-slate-500 focus:ring-slate-500 sm:text-sm transition-all duration-300">
                    </div>
                    
                    <select name="sort" onchange="this.form.submit()" 
                            class="rounded-xl border-slate-200 text-sm shadow-sm bg-slate-50/50 text-slate-600 outline-none focus:bg-white focus:ring-1 focus:ring-slate-500 focus:border-slate-500 transition-all duration-300">
                        <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                        <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Terlama</option>
                    </select>

                    <button type="submit" class="bg-slate-900 hover:bg-slate-800 text-white px-6 py-2.5 rounded-xl text-sm font-bold tracking-wide transition-all duration-300 shadow-sm active:scale-95">
                        Cari
                    </button>
                    
                    @if(request('search') || request('sort'))
                        <a href="{{ route('teknisi.dashboard.accept') }}" class="text-sm text-slate-400 hover:text-red-500 font-semibold transition-colors flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            Reset
                        </a>
                    @endif
                </form>

                <div class="w-full lg:w-auto flex justify-end">
                    {{ $readRequest->links() }}
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                @foreach($readRequest as $index => $data_request)
                    <div class="group bg-white rounded-[24px] shadow-sm border border-slate-200/60 hover:shadow-xl hover:border-slate-200 transition-all duration-300 flex flex-col h-full overflow-hidden">
                        
                        <div class="relative h-52 w-full bg-slate-100 overflow-hidden" id="foto-container-{{ $data_request->id_request }}">
                            @if($data_request->foto_bukti)
                                <img id="img-{{ $data_request->id_request }}" 
                                     src="{{ asset('storage/' . $data_request->foto_bukti) }}" 
                                     class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105 cursor-pointer"
                                     onclick="bukaModal(this.src)"
                                     alt="Bukti Foto">
                            @else
                                <div id="placeholder-{{ $data_request->id_request }}" 
                                     class="w-full h-full flex flex-col items-center justify-center text-slate-400 bg-slate-50">
                                    <svg class="w-10 h-10 mb-2 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    <span class="text-[10px] uppercase tracking-widest font-bold opacity-60">Belum Ada Foto</span>
                                </div>
                            @endif

                            <div class="absolute top-4 left-4 z-10">
                                <span class="bg-white/80 backdrop-blur px-3 py-1.5 rounded-full text-[11px] font-black text-slate-800 shadow-sm border border-white/40">
                                    #{{ ($readRequest->currentPage() - 1) * $readRequest->perPage() + $loop->iteration }}
                                </span>
                            </div>
                            
                                
                            <div class="absolute bottom-4 right-4 z-10">
                                <span
                                    class="inline-flex max-w-[354px] items-center px-3 py-1 text-[10px] font-black tracking-widest text-white uppercase bg-slate-900/75 backdrop-blur-sm border border-white/20 rounded-full shadow-sm cursor-default transition-all duration-300 hover:bg-slate-900 hover:border-white/40"
                                    title="{{ $data_request->software }}">
                                    <span class="block overflow-hidden text-ellipsis whitespace-nowrap">
                                        {{ $data_request->software }}
                                    </span>
                                </span>
                            </div>
                        </div>

                        <div class="p-6 flex-1 flex flex-col">
                            
                            <div class="mb-5">
                                <h3 class="text-xl font-black text-slate-900 leading-tight mb-1 truncate" title="{{ $data_request->mahasiswa->nama_mahasiswa }}">
                                    {{ $data_request->mahasiswa->nama_mahasiswa }}
                                </h3>
                                <p class="text-[11px] font-bold uppercase tracking-widest text-slate-600">Mahasiswa</p>
                            </div>

                            <div class="space-y-3 mb-6">
                                <div class="flex items-center text-base group/item">
                                    <div class="w-7 h-7 rounded-lg bg-slate-50 flex items-center justify-center mr-3 transition-colors group-hover/item:bg-slate-100">
                                        <svg class="w-4 h-4 text-slate-900" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                    </div>
                                    <span class="text-slate-900">PC: <span class="font-bold text-slate-900">{{ $data_request->komputer->id_komputer }}</span></span>
                                </div>
                                <div class="flex items-center text-base group/item">
                                    <div class="w-7 h-7 rounded-lg bg-slate-50 flex items-center justify-center mr-3 transition-colors group-hover/item:bg-slate-100">
                                        <svg class="w-4 h-4 text-slate-900" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                    </div>
                                    <span class="text-slate-900">Dosen: <span class="font-bold text-slate-900 truncate max-w-[130px] inline-block align-bottom">{{ $data_request->dosen_ta }}</span></span>
                                </div>
                                <div class="flex items-center text-base group/item">
                                    <div class="w-7 h-7 rounded-lg bg-slate-50 flex items-center justify-center mr-3 transition-colors group-hover/item:bg-slate-100">
                                        <svg class="w-4 h-4 text-slate-900" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                    </div>
                                    <span class="font-bold text-slate-900">{{ $data_request->no_hp }}</span>
                                </div>
                            </div>

                            <div class="mt-auto bg-slate-50/70 rounded-2xl p-4 border border-slate-200/40 mb-5">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-[11px] font-black text-slate-500 uppercase tracking-widest">Mulai</span>
                                    <span class="text-sm font-bold text-slate-800">
                                        {{ \Carbon\Carbon::parse($data_request->tanggal_mulai)->format('d M, H:i') }}
                                    </span>
                                </div>
                                <div class="w-full h-px bg-slate-200/60 my-2"></div>
                                <div class="flex items-center justify-between">
                                    <span class="text-[11px] font-black text-slate-500 uppercase tracking-widest">Estimasi Selesai</span>
                                    <span id="waktu-selesai-teknisi-{{ $data_request->id_request }}" 
                                          class="text-sm font-black text-slate-900 transition-colors duration-300">
                                        {{ \Carbon\Carbon::parse($data_request->perkiraan_selesai)->format('d M, H:i') }}
                                    </span>
                                </div>
                            </div>

                            <div class="flex gap-3">
                                <form id="form-reject-{{ $data_request->id_request }}" action="{{ route('teknisi.cancel.request', $data_request->id_request) }}" method="POST" class="w-full">
                                    @csrf
                                    @method('PATCH')
                                    
                                    <button type="button" 
                                            class="w-full py-3 px-4 rounded-xl text-sm font-bold text-red-600 bg-red-50 hover:bg-red-600 hover:text-white transition-all duration-300 flex justify-center items-center gap-2 active:scale-95" 
                                            onclick="confirmDelete('{{ $data_request->id_request }}')">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        BATALKAN REQUEST
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
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
                title: "Ingin Membatalkan Request?",
                text: "Anda membatalkan Request Yang Sedang Berjalan!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#4f46e5", 
                cancelButtonColor: "#ef4444", 
                confirmButtonText: "Ya, Batalkan",
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