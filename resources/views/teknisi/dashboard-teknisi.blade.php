<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Teknisi') }}
        </h2>
    </x-slot>

    <div class="py-4 bg-gray-50 min-h-screen">
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

                    <button type="submit" class="inline-flex items-center px-6 py-2.5 bg-gray-400 hover:bg-gray-600 text-white text-sm font-semibold rounded-xl transition duration-200 shadow-md shadow-indigo-100">
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
                    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col overflow-hidden group">
                        
                        <div class="p-6 flex flex-col flex-grow">
                            <div class="flex justify-between items-center mb-5 pb-4 border-b border-gray-50">
                                <span class="text-xs font-black text-gray-400 uppercase tracking-widest">
                                    #{{ ($readRequest->currentPage() - 1) * $readRequest->perPage() + $loop->iteration }}
                                </span>
                                <span class="text-[10px] uppercase font-bold tracking-wider text-gray-800 bg-gray-50 px-2 py-1 rounded">
                                    {{ $data_request->created_at->diffForHumans() }}
                                </span>
                            </div>

                            <div class="mb-5">
                                <h3 class="text-lg font-bold text-gray-900 leading-tight mb-1">Student: {{ $data_request->mahasiswa->nama_mahasiswa }}</h3>
                                <p class="text-sm text-violet-950 font-medium">Dosen: {{ $data_request->dosen_ta }}</p>
                                <h4 class="text-lg font-bold text-gray-900 leading-tight mt-1">PC: Komputer {{ $data_request->komputer->id_komputer }}</h4>
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

                            <div class="space-y-2 border-l-2 border-indigo-100 pl-4 mb-8">
                                <div class="flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full bg-green-500"></span>
                                    <p class="text-sm text-gray-700 font-bold"><span class="font-bold">Start:</span> {{ \Carbon\Carbon::parse($data_request->tanggal_mulai)->format('d M, H:i') }}</p>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full bg-red-500"></span>
                                    <p class="text-sm text-gray-600">
                                        <span class="font-bold">End:</span> 
                                        <span id="waktu-selesai-teknisi-{{ $data_request->id_request }}" class="font-bold text-gray-700 tabular-nums transition-all duration-300">
                                            {{ \Carbon\Carbon::parse($data_request->perkiraan_selesai)->format('d M, H:i') }}
                                        </span>
                                    </p>
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

    @vite(['resources/js/app.js'])
    <script type="module">
        let currentTeknisiId = "{{ auth()->guard('teknisi')->id() }}";

        window.Echo.channel('teknisi-channel')
        .listen('.WaktuUpdated', (e) => {
            let waktuTarget = document.getElementById('waktu-selesai-teknisi-' + e.id_request);

            if(waktuTarget){
                waktuTarget.innerText = e.waktu_baru;
                waktuTarget.classList.add('text-violet-600');

                setTimeout(() => {
                    waktuTarget.classList.remove('text-violet-600');
                }, 1000);
            }
        });
    </script>
</x-app-layout>