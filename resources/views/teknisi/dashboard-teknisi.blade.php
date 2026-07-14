<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-black text-2xl text-gray-900 tracking-tight">
                    {{ __('Pending List') }}
                </h2>
            </div>
        </div>
    </x-slot>

   <div class="py-8 bg-slate-50/50 min-h-screen">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-6 bg-white p-5 rounded-2xl shadow-sm border border-slate-200">
            
            <form action="{{ route('teknisi.dashboard.request') }}" method="GET" class="flex flex-1 flex-wrap items-center gap-4">
                
                <div class="relative w-full md:w-80">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" 
                        placeholder="Cari dosen atau mahasiswa..." 
                        class="pl-11 w-full rounded-xl border-slate-200 bg-slate-50/50 shadow-sm outline-none focus:bg-white focus:border-slate-500 focus:ring-slate-500 text-sm py-2.5 transition-all duration-300">
                </div>

                <select name="lab" onchange="this.form.submit()" 
                    class="rounded-xl border-slate-200 text-sm shadow-sm bg-slate-50/50 text-slate-600 outline-none focus:bg-white focus:ring-1 focus:ring-slate-500 focus:border-slate-500 transition-all duration-300">
                    <option value="all">Semua Lab</option>
                    @foreach($daftarLab as $lab)
                        <option value="{{ $lab->id_laboratorium }}" {{ request('lab') == $lab->id_laboratorium ? 'selected' : '' }}>
                            {{ $lab->nama_lab }}
                        </option>
                    @endforeach
                </select>
                
                <select name="sort" onchange="this.form.submit()" 
                    class="rounded-xl border-slate-200 text-sm shadow-sm bg-slate-50/50 text-slate-600 outline-none focus:bg-white focus:ring-1 focus:ring-slate-500 focus:border-slate-500 transition-all duration-300">
                    <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                    <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Terlama</option>
                </select>

                <button type="submit" class="inline-flex items-center justify-center bg-slate-900 hover:bg-slate-800 text-white px-6 py-2.5 rounded-xl text-sm font-bold tracking-wide transition-all duration-300 shadow-sm active:scale-95">
                    Cari
                </button>

                @if(request('search') || request('sort'))
                    <a href="{{ route('teknisi.dashboard.request') }}" class="text-sm font-semibold text-slate-400 hover:text-red-500 transition-colors flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        Reset
                    </a>
                @endif
            </form>

            <div id="request-container" class="flex-shrink-0 w-full md:w-auto flex justify-end">
            </div>
        </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50/50 border-b border-gray-100">
                                <th class="py-4 px-6 text-xs font-bold text-gray-900 uppercase tracking-wider w-16">No</th>
                                <th class="py-4 px-6 text-xs font-bold text-gray-900 uppercase tracking-wider">Student</th>
                                <th class="py-4 px-6 text-xs font-bold text-gray-900 uppercase tracking-wider">Komputer</th>
                                <th class="py-4 px-6 text-xs font-bold text-gray-900 uppercase tracking-wider">Lab</th>
                                <th class="py-4 px-6 text-xs font-bold text-gray-900 uppercase tracking-wider text-center">Actions</th>
                            </tr>
                        </thead>
                        
                        <tbody id="request-table-body" class="divide-y divide-gray-100">
                            @forelse($readRequest as $index => $data_request)
                                <tr class="hover:bg-gray-50/50 transition-colors duration-150">
                                    <td class="py-4 px-6 text-sm font-medium text-gray-400">
                                        {{ ($readRequest->currentPage() - 1) * $readRequest->perPage() + $loop->iteration }}
                                    </td>
                                    
                                    <td class="py-4 px-6">
                                        <div class="flex flex-col">
                                            <span class="text-sm font-bold text-gray-900">
                                                {{ $data_request->mahasiswa->nama }}
                                            </span>
                                        </div>
                                    </td>
                                    
                                    <td class="py-4 px-6 text-sm font-medium text-gray-600">
                                        {{ $data_request->komputer->nama_komputer }}
                                    </td>
                                    
                                    <td class="py-4 px-6 text-sm font-medium text-gray-600">
                                        {{ $data_request->laboratorium->nama_lab }}
                                    </td>
                                    
                                    <td class="py-4 px-6">
                                        <div class="flex items-center justify-center gap-2">
                                            <form action="{{ route('teknisi.reject.request', $data_request->id_request) }}" method="POST" class="m-0">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="px-4 py-1.5 text-xs font-semibold text-red-600 bg-transparent border border-red-300 rounded-md hover:bg-red-100 hover:border-red-400 transition-colors duration-200">
                                                    Tolak
                                                </button>
                                            </form>

                                            <form action="{{ route('teknisi.accept.request', $data_request->id_request) }}" method="POST" class="m-0">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="px-4 py-1.5 text-xs font-semibold text-white bg-slate-700 border border-transparent rounded-md hover:bg-slate-900 transition-colors duration-200 shadow-sm">
                                                    Setujui
                                                </button>
                                            </form>

                                            <a href="{{ route('teknisi.pending.details', $data_request->id_request) }}" 
                                            class="inline-block px-4 py-1.5 text-xs font-semibold text-violet-600 bg-transparent border border-violet-200 rounded-md hover:bg-violet-100 hover:border-violet-300 transition-colors duration-200 text-center">
                                                Details
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr id="empty-state-row">
                                    <td colspan="5" class="py-8 text-center text-gray-400 text-sm font-medium">
                                        Tidak ada request yang masuk saat ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($readRequest->hasPages())
                    <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/30">
                        {{ $readRequest->links() }}
                    </div>
                @endif
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