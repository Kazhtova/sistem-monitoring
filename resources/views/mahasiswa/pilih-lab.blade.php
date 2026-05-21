<x-apps-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-8 text-center">
                <h2 class="font-extrabold text-2xl text-gray-800 uppercase tracking-widest">
                    {{ __('Pilih Laboratorium') }}
                </h2>
                <p class="text-sm text-gray-500 mt-2">Silakan pilih laboratorium tempat komputer yang ingin digunakan</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                @foreach($daftarLab as $lab)
                    <a href="{{ route('mahasiswa.request.mahasiswa', ['id' => $lab->id_laboratorium]) }}" 
                       class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 hover:shadow-xl hover:border-indigo-500 hover:scale-[1.02] transition-all duration-300 block text-center group">
                        
                        <div class="w-12 h-12 bg-indigo-50 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:bg-indigo-600 transition-colors duration-300">
                            <svg class="w-6 h-6 text-indigo-600 group-hover:text-white transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>

                        <h3 class="text-lg font-bold text-gray-800 group-hover:text-indigo-600 transition-colors">{{ $lab->nama_lab }}</h3>
                        {{-- <p class="text-xs text-gray-400 mt-2 leading-relaxed">Klik untuk mulai melaporkan kendala perangkat atau software.</p> --}}
                    </a>
                @endforeach
            </div>

        </div>
    </div>
</x-apps-layout>