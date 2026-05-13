<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Teknisi') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
                        
                        <form action="{{ route('dashboard.request') }}" method="GET" class="flex flex-1 items-center gap-3 max-w-full">
                            
                            <div class="flex-1 min-w-[200px] md:max-w-xl transition-all duration-300">
                                <input type="text" 
                                    name="search" value="{{ request('search') }}" 
                                    placeholder="Cari dosen atau mahasiswa..." 
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-gray-600 focus:ring-gray-600 text-sm py-2">
                            </div>
                            
                            <select name="sort" onchange="this.form.submit()" 
                                    class="rounded-md border-gray-300 shadow-sm focus:border-gray-600 focus:ring-gray-600 text-sm">
                                <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                                <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Terlama</option>
                            </select>

                            <button type="submit" class="bg-gray-700 text-white px-6 py-2 rounded-md hover:bg-gray-900 text-sm font-bold transition-colors">
                                Cari
                            </button>

                            @if(request('search') || request('sort'))
                                <a href="{{ route('dashboard.request') }}" class="text-base text-gray-500 hover:text-gray-900 transition-colors font-black">
                                    Reset
                                </a>
                            @endif
                        </form>

                        <div class="flex-shrink-0">
                            {{ $readRequest->links() }}
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-2 gap-6">
                        @foreach($readRequest as $index => $data_request)
                            <div class="aspect-square bg-white border border-gray-200 rounded-lg shadow-sm p-4 flex flex-col justify-between mt-2 overflow-hidden">
                                
                                <div class="overflow-y-auto pr-1 flex flex-col h-full"> 
                                    
                                    <div class="w-full mb-3 bg-gray-100 rounded-md overflow-hidden shrink-0" style="height: 340px;">
                                        @if($data_request->foto_bukti)
                                            <img src="{{ asset('storage/' . $data_request->foto_bukti) }}" 
                                                 alt="Bukti" 
                                                 class="w-full h-full object-cover cursor-pointer hover:opacity-100 transition-opacity duration-200"
                                                 onclick="bukaModal('{{ asset('storage/' . $data_request->foto_bukti) }}')">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-gray-400 text-[10px] font-bold tracking-widest">
                                                NO IMAGE
                                            </div>
                                        @endif
                                    </div>

                                    <div class="flex justify-between items-start mb-3 shrink-0">
                                        <span class="bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-0.5 rounded">{{ ($readRequest->currentPage() - 1) * $readRequest->perPage() + $loop->iteration }}</span>
                                        <span class="text-xs" style="font-weight: bold;">{{ $data_request->created_at->diffForHumans() }}</span>
                                    </div>
                                    
                                    <p class="text-sm mt-1 shrink-0"><span style="font-family:'Times New Roman', Times, serif; font-size: x-large;">Mahasiswa: </span><span style="font-family:Georgia, 'Times New Roman', Times, serif; font-weight: bold; font-size: large;">{{ $data_request->mahasiswa->nama_mahasiswa }}</span></p>
                                    <p class="text-sm mt-1 shrink-0"><span style="font-family:'Times New Roman', Times, serif; font-size: x-large;">Dosen: </span><span style="font-family:Georgia, 'Times New Roman', Times, serif; font-weight: bold; font-size: large;">{{ $data_request->dosen_ta }}</span></p>
                                    <p class="text-gray-900 truncate shrink-0"><span style="font-family:'Times New Roman', Times, serif; font-size: large;">Software: </span><span style="font-size: medium; font-weight: 900;">{{ $data_request->software }}</span></p>
                                </div>
                                
                                <div class="mt-4 pt-4 border-t border-gray-100 flex justify-between items-center shrink-0">
                                    <div class="text-sm text-gray-800">
                                        <p style="font-size: larger; font-weight: 800;"><span style="font-weight: 500;">Start: </span>{{ \Carbon\Carbon::parse($data_request->tanggal_mulai)->format('d M h:i A') }}</p>
                                        <p style="font-size: larger; font-weight: 800;"><span style="font-weight: 500;">End: </span>{{ \Carbon\Carbon::parse($data_request->perkiraan_selesai)->format('d M h:i A') }}</p>
                                    </div>
                                    
                                    <div class="flex items-center gap-2">
                                        <form action="{{ route('reject.request', $data_request->id_request) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-6 rounded-lg transition duration-150 ease-in-out text-xs">
                                                Tolak
                                            </button>
                                        </form>

                                        <form action="{{ route('accept.request', $data_request->id_request) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition duration-150 ease-in-out text-xs">
                                                Setuju
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
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
            Swal.fire({
                title: 'Berhasil',
                text: "{{ session('success') }}",
                icon: 'success',
                confirmButtonColor: '#4f46e5'
            })
        </script>
    @endif

    @if(session('reject'))
        <script>
            Swal.fire({
                title: 'Berhasil',
                text: "{{ session('reject') }}",
                icon: 'success',
                iconColor: '#ef4444',
                confirmButtonColor: '#4f46e5'
            })
        </script>
    @endif

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