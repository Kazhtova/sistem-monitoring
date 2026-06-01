<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Teknisi') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-8 flex flex-wrap items-center gap-4">
                <form action="{{ route('teknisi.dashboard.accept') }}" method="GET" class="flex flex-1 items-center gap-3 max-w-2xl">
                    <div class="relative flex-1 md:max-w-md">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </span>
                        <input type="text" name="search" value="{{ request('search') }}" 
                               placeholder="Cari Dosen Atau Mahasiswa..." 
                               class="pl-10 w-full rounded-xl border-gray-200 shadow-sm focus:border-gray-500 focus:ring-gray-500 text-sm transition-all">
                    </div>
                    
                    <select name="sort" onchange="this.form.submit()" 
                            class="rounded-xl border-gray-200 shadow-sm focus:border-gray-600 text-sm font-medium text-gray-600">
                        <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                        <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Terlama</option>
                    </select>

                    <button type="submit" class="bg-gray-700 hover:bg-gray-900 text-white px-6 py-2 rounded-xl text-sm font-semibold transition-all shadow-sm">
                        Filter
                    </button>
                    
                    @if(request('search') || request('sort'))
                        <a href="{{ route('teknisi.dashboard.accept') }}" class="text-base text-gray-500 hover:text-gray-900 transition-colors font-black">
                            Reset
                        </a>
                    @endif
                </form>
                <div style="margin-left: 174px;">
                    {{ $readRequest->links() }}
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">
                @foreach($readRequest as $index => $data_request)
                    <div class="group bg-white rounded-3xl shadow-sm border border-gray-100 hover:shadow-2xl hover:-translate-y-2 transition-all duration-500 overflow-hidden flex flex-col h-full">
                        
                        <div class="relative h-64 w-full bg-gray-50 overflow-hidden" id="foto-container-{{ $data_request->id_request }}">
                            @if($data_request->foto_bukti)
                                <img id="img-{{ $data_request->id_request }}" 
                                     src="{{ asset('storage/' . $data_request->foto_bukti) }}" 
                                     class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110 cursor-pointer"
                                     onclick="bukaModal(this.src)">
                            @else
                                <div id="placeholder-{{ $data_request->id_request }}" 
                                     class="w-full h-full flex flex-col items-center justify-center text-gray-300">
                                    <svg class="w-16 h-16 mb-2 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    <span class="text-xs uppercase tracking-tighter font-bold opacity-40">No Photos Available</span>
                                </div>
                            @endif
                            <div class="absolute top-5 left-5">
                                <span class="bg-black/60 backdrop-blur-md px-4 py-1.5 rounded-full text-xs font-black text-white shadow-lg">
                                    #{{ ($readRequest->currentPage() - 1) * $readRequest->perPage() + $loop->iteration }}
                                </span>
                            </div>
                        </div>

                        <div class="p-8 flex-1 flex flex-col">
                            <div class="mb-6">
                                <h3 class="text-sm uppercase tracking-[0.2em] text-gray-600 font-black mb-2">{{ $data_request->software }}</h3>
                                <p class="text-2xl font-black text-gray-900 leading-tight mb-2">Student: {{ $data_request->mahasiswa->nama_mahasiswa }}</p>
                                <p class="text-base text-gray-900 font-semibold italic mb-1">Dosen: {{ $data_request->dosen_ta }}</p>
                                <p class="text-base text-gray-950 font-black italic">No Telp: {{ $data_request->no_hp }}</p>
                            </div>

                            <div class="space-y-4 mb-8 bg-gray-50 p-5 rounded-2xl">
    
                                <div class="flex items-center justify-between items-center gap-2 text-sm w-full">
                                    <div class="text-gray-400 font-bold uppercase tracking-widest text-sm w-20">Mulai</div>
                                    <div class="text-base font-black text-gray-800 tabular-nums text-right">
                                        {{ \Carbon\Carbon::parse($data_request->tanggal_mulai)->format('d M, H:i') }}
                                    </div>
                                </div>

                                <div class="flex items-center justify-between items-center gap-2 text-sm w-full">
                                    <div class="text-gray-400 font-bold uppercase tracking-widest text-sm w-20">Selesai</div>
                                    <div id="waktu-selesai-teknisi-{{ $data_request->id_request }}" 
                                        class="text-base font-black text-gray-800 tabular-nums transition-all duration-300 text-right">
                                        {{ \Carbon\Carbon::parse($data_request->perkiraan_selesai)->format('d M, H:i') }}
                                    </div>
                                </div>

                            </div>

                            <div class="mt-auto pt-6 flex gap-4">
                                <form id="form-reject-{{ $data_request->id_request }}" 
                                    action="{{ route('teknisi.cancel.request', $data_request->id_request) }}" 
                                    method="POST" class="flex-1">
                                    @csrf
                                    @method('PATCH')
                                    <button type="button" 
                                            class="w-full py-4 px-4 rounded-2xl text-sm font-black text-red-500 bg-red-50 hover:bg-red-100 transition-all active:scale-95" 
                                            onclick="confirmDelete('{{ $data_request->id_request }}')">
                                        CANCEL
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div id="modalGambar" class="fixed inset-0 z-[999] hidden bg-gray-900/90 backdrop-blur-xl flex items-center justify-center p-8" onclick="tutupModal()">
        <div class="relative max-w-5xl w-full flex justify-center">
            <button class="absolute -top-12 right-0 text-white text-5xl font-light hover:text-red-500 transition-colors">&times;</button>
            <img id="gambarUtuh" class="max-w-full max-h-[85vh] rounded-3xl shadow-2xl object-contain border-8 border-white/5" onclick="event.stopPropagation()">
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
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Ya",
        cancelButtonText: "Batal"
    }).then((result) => {
        // Jika pengguna menekan tombol "Ya"
        if (result.isConfirmed) {
            // Jalankan submit form secara manual berdasarkan ID
            document.getElementById('form-reject-' + id).submit();
        }
    });
}

    document.addEventListener('DOMContentLoaded', function () {
        window.Echo.channel('foto-channel')
        .listen('.FotoView', (e) => {
            const container = document.getElementById('foto-container-' + e.id_request)

            if(container){
                const newImageUrl = '/storage/' + e.path

                let existingImg = document.getElementById('img-' + e.id_request)
                let placeholder = document.getElementById('placeholder-' + e.id_request)

                if(existingImg){
                    existingImg.src = newImageUrl
                } else{ 
                    if(placeholder){
                        placeholder.remove()
                    }

                    const newImg = document.createElement('img')
                    newImg.id = 'img-' + e.id_request
                    newImg.src = newImageUrl
                    newImg.className = 'w-full h-full object-cover transition-transform duration-700 group-hover:scale-110 cursor-pointer'

                    newImg.onclick = function (){
                        bukaModal(this.src)
                    }

                    container.insertBefore(newImg, container.firstChild)
                }
            }
        })

        window.Echo.channel('teknisi-channel')
        .listen('.WaktuUpdated', (e) => {
            let waktuTarget = document.getElementById('waktu-selesai-teknisi-' + e.id_request)

            if(waktuTarget) {
                waktuTarget.innerText = e.waktu_baru
                
                waktuTarget.classList.add('text-violet-600')
    
                setTimeout(() => {
                    waktuTarget.classList.remove('text-violet-600')
                }, 1000)
            }

        })
    })
    </script>
</x-app-layout>