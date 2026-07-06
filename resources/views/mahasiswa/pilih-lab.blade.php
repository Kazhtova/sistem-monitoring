<x-apps-layout>
        <x-slot name="header">
            <div class="flex justify-between items-center">
                <h2 class="font-bold text-2xl text-gray-800 tracking-tight">
                    {{ __('Choose - Lab') }}
                </h2>
            </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-8 text-center">
                <h1 class="font-extrabold text-4xl text-gray-800 uppercase tracking-widest">
                    {{ __('Select Laboratory') }}
                </h1>
                <p class="text-lg text-gray-500 mt-2">Please select the laboratory where the computer you wish to use is located.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($daftarLab as $lab)
                    <a href="{{ route('mahasiswa.request.mahasiswa', ['id' => $lab->id_laboratorium]) }}" 
                    class="bg-white py-14 px-8 rounded-[2rem] shadow-sm border border-gray-100 hover:shadow-2xl hover:border-slate-400 hover:-translate-y-2 hover:scale-[1.02] transition-all duration-300 flex flex-col items-center justify-center text-center group min-h-[260px]">
                        
                        <div class="w-20 h-20 bg-slate-50 rounded-3xl flex items-center justify-center mb-6 group-hover:bg-slate-800 transition-colors duration-300 shadow-inner">
                            <svg class="w-10 h-10 text-slate-700 group-hover:text-white transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>

                        <h3 class="text-2xl font-black text-slate-800 group-hover:text-slate-900 transition-colors tracking-tight">
                            {{ $lab->nama_lab }}
                        </h3>
                        
                        <p class="mt-3 text-sm font-medium text-slate-400 group-hover:text-slate-500 transition-colors">
                            Tap To Enter
                        </p>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</x-apps-layout>