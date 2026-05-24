<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Teknisi') }}
        </h2>
    </x-slot>

    <div class="py-10 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-6 bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <form action="{{ route('teknisi.dashboard.request') }}" method="GET" class="flex flex-1 flex-wrap items-center gap-4">
                    <div class="relative flex-1 min-w-[280px] md:max-w-md">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" 
                            placeholder="Cari dosen atau mahasiswa..." 
                            class="pl-10 w-full rounded-xl border-gray-200 shadow-sm focus:border-gray-500 focus:ring-gray-500 text-sm py-2.5 transition-all">
                    </div>
                    
                    <select name="sort" onchange="this.form.submit()" 
                        class="rounded-xl border-gray-200 shadow-sm focus:border-gray-500 focus:ring-gray-500 text-sm py-2.5 bg-white">
                        <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                        <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Terlama</option>
                    </select>

                    <button type="submit" class="inline-flex items-center px-6 py-2.5 bg-gray-700 hover:bg-gray-900 text-white text-sm font-semibold rounded-xl transition duration-200 shadow-md shadow-indigo-100">
                        Cari
                    </button>

                    @if(request('search') || request('sort'))
                        <a href="{{ route('teknisi.dashboard.request') }}" class="text-md font-semibold text-gray-500 hover:text-gray-700 transition-colors">
                            Reset
                        </a>
                    @endif
                </form>

                <div class="flex-shrink-0">
                    {{ $readRequest->links() }}
                </div>
            </div>

            <div id="request-container" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-2 gap-8">
                @foreach($readRequest as $index => $data_request)
                    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 hover:shadow-xl hover:scale-[1.01] transition-all duration-300 flex flex-col overflow-hidden group">
                        <div class="relative h-64 overflow-hidden bg-gray-100">
                            @if($data_request->foto_bukti)
                                <img src="{{ asset('storage/' . $data_request->foto_bukti) }}" 
                                     alt="Bukti" 
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500 cursor-pointer"
                                     onclick="bukaModal('{{ asset('storage/' . $data_request->foto_bukti) }}')">
                            @else
                                <div class="w-full h-full flex flex-col items-center justify-center text-gray-400 gap-2">
                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    <span class="text-[10px] font-bold tracking-widest uppercase">No Preview Image</span>
                                </div>
                            @endif
                            <div class="absolute top-4 left-4 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-full shadow-sm">
                                <span class="text-xs font-bold text-gray-700">#{{ ($readRequest->currentPage() - 1) * $readRequest->perPage() + $loop->iteration }}</span>
                            </div>
                        </div>

                        <div class="p-6 flex flex-col flex-grow">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900 leading-tight">Mahasiswa: {{ $data_request->mahasiswa->nama_mahasiswa }}</h3>
                                    <p class="text-sm text-violet-950 font-medium">Dosen: {{ $data_request->dosen_ta }}</p>
                                </div>
                                <span class="text-[10px] uppercase font-bold tracking-wider text-gray-800 bg-gray-50 px-2 py-1 rounded">{{ $data_request->created_at->diffForHumans() }}</span>
                            </div>

                            <div class="grid grid-cols-2 gap-4 mb-6">
                                <div class="bg-gray-50 p-3 rounded-2xl">
                                    <p class="text-[10px] uppercase font-bold text-gray-400 mb-1">Software</p>
                                    <p class="text-sm font-bold text-gray-800 truncate">{{ $data_request->software }}</p>
                                </div>
                                <div class="bg-gray-50 p-3 rounded-2xl">
                                    <p class="text-[10px] uppercase font-bold text-gray-400 mb-1">No Telp</p>
                                    <p class="text-sm font-bold text-gray-800">{{ $data_request->no_hp }}</p>
                                </div>
                            </div>

                            <div class="space-y-2 border-l-2 border-indigo-100 pl-4 mb-6">
                                <div class="flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full bg-green-500"></span>
                                    <p class="text-sm text-gray-600"><span class="font-bold" style="font-size: large;">Start:</span> {{ \Carbon\Carbon::parse($data_request->tanggal_mulai)->format('d M, H:i') }}</p>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full bg-red-500"></span>
                                    <p class="text-sm text-gray-600"><span class="font-bold" style="font-size: large;">End:</span> {{ \Carbon\Carbon::parse($data_request->perkiraan_selesai)->format('d M, H:i') }}</p>
                                </div>
                            </div>

                            <div class="mt-auto flex gap-3">
                                <form action="{{ route('teknisi.reject.request', $data_request->id_request) }}" method="POST" class="flex-1">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="w-full bg-white border-2 border-red-500 text-red-500 hover:bg-red-500 hover:text-white font-bold py-2.5 rounded-xl transition duration-200 text-sm">
                                        Tolak
                                    </button>
                                </form>
                                <form action="{{ route('teknisi.accept.request', $data_request->id_request) }}" method="POST" class="flex-1">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="w-full bg-violet-700 hover:bg-violet-900 text-white font-bold py-2.5 rounded-xl transition duration-200 shadow-lg shadow-indigo-100 text-sm">
                                        Setujui
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

    @if(session('success'))
        <script>
            Swal.fire({ title: 'Berhasil', text: "{{ session('success') }}", icon: 'success', confirmButtonColor: '#4f46e5' })
        </script>
    @endif

    @if(session('reject'))
        <script>
            Swal.fire({ title: 'Berhasil', text: "{{ session('reject') }}", icon: 'success', iconColor: '#ef4444', confirmButtonColor: '#4f46e5' })
        </script>
    @endif

{{-- <script type="module">
    Echo.channel('teknisi-channel')
        .listen('.request.new', (e) => {
            const data = e.requestData;
            const id = data.id_request; 

            // 1. Munculkan Notifikasi Toast (Pojok Kanan Atas)
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: 'Request Baru!',
                    text: `Dari: ${data.mahasiswa?.nama_mahasiswa || 'Mahasiswa'}`,
                    icon: 'info',
                    toast: true,
                    position: 'top',
                    showConfirmButton: false,
                    timer: 5000,
                    timerProgressBar: true
                });
            }

            // 2. Bangun URL secara manual untuk tombol aksi
            const acceptUrl = `/teknisi/request-list/accept/${id}`; 
            const rejectUrl = `/teknisi/request-list/reject/${id}`;

            // 3. Fungsi format tanggal JS
            const formatTgl = (dateString) => {
                if(!dateString) return '-';
                const d = new Date(dateString);
                return d.toLocaleDateString('id-ID', { day: '2-digit', month: 'short', hour: '2-digit', minute: '2-digit' }).replace('.', ':');
            };

            const container = document.getElementById('request-container');
            const newCardHtml = `
                <div class="bg-white rounded-3xl shadow-sm border-2 border-indigo-500 hover:shadow-xl transition-all duration-300 flex flex-col overflow-hidden animate-fade-in group">
                    <div class="relative h-64 overflow-hidden bg-gray-100">
                        <img src="/storage/${data.foto_bukti}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                            onclick="bukaModal('/storage/${data.foto_bukti}')">
                        <div class="absolute top-4 left-4 bg-indigo-600 px-3 py-1 rounded-full shadow-sm">
                            <span class="text-xs font-bold text-white tracking-widest">NEW</span>
                        </div>
                    </div>
                    
                    <div class="p-6 flex flex-col flex-grow">
                        <div class="mb-4">
                            <h3 class="text-lg font-bold text-gray-900">${data.mahasiswa?.nama_mahasiswa || 'Mahasiswa'}</h3>
                            <p class="text-sm text-violet-950 font-medium">Dosen: ${data.dosen_ta}</p>
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-6">
                            <div class="bg-gray-50 p-3 rounded-2xl">
                                <p class="text-[10px] uppercase font-bold text-gray-400 mb-1">Software</p>
                                <p class="text-sm font-bold text-gray-800">${data.software}</p>
                            </div>
                            <div class="bg-gray-50 p-3 rounded-2xl">
                                <p class="text-[10px] uppercase font-bold text-gray-400 mb-1">No Telp</p>
                                <p class="text-sm font-bold text-gray-800">${data.no_hp}</p>
                            </div>
                        </div>

                        <div class="space-y-2 border-l-2 border-indigo-100 pl-4 mb-6">
                            <div class="flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-green-500"></span>
                                <p class="text-sm text-gray-600"><span class="font-bold">Start:</span> ${formatTgl(data.tanggal_mulai)}</p>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-red-500"></span>
                                <p class="text-sm text-gray-600"><span class="font-bold">End:</span> ${formatTgl(data.perkiraan_selesai)}</p>
                            </div>
                        </div>

                        <div class="mt-auto flex gap-3">
                            <form action="${rejectUrl}" method="POST" class="flex-1">
                                <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]').content}">
                                <input type="hidden" name="_method" value="PATCH">
                                <button type="submit" class="w-full bg-white border-2 border-red-500 text-red-500 hover:bg-red-500 hover:text-white font-bold py-2.5 rounded-xl transition duration-200 text-sm">
                                    Tolak
                                </button>
                            </form>

                            <form action="${acceptUrl}" method="POST" class="flex-1">
                                <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]').content}">
                                <input type="hidden" name="_method" value="PATCH">
                                <button type="submit" class="w-full bg-violet-700 hover:bg-violet-900 text-white font-bold py-2.5 rounded-xl transition duration-200 shadow-lg text-sm">
                                    Setujui
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            `;
            container.insertAdjacentHTML('afterbegin', newCardHtml);

            const currentCards = container.querySelectorAll('.bg-white.rounded-3xl');

            if(currentCards.length > 2){
                currentCards[currentCards.length - 1].remove()
            }
        });
</script>

    <style>
        @keyframes fadeIn { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }
        .animate-fade-in { animation: fadeIn 0.5s ease-out forwards; }
    </style> --}}

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
    </script>
</x-app-layout>