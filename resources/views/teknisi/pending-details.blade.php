<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-slate-900 tracking-tight">
                {{ __('Details - Pending Request') }}
            </h2>
            <a href="{{ route('teknisi.dashboard.request') }}" 
               class="inline-flex items-center px-4 py-2 bg-white rounded-xl shadow-sm border border-gray-200 hover:border-slate-300 hover:bg-slate-50 text-sm font-bold text-gray-600 hover:text-slate-600 transition-all duration-300 group">
                <svg class="w-4 h-4 mr-2 text-gray-400 group-hover:text-slate-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                
                <div class="px-8 py-6 border-b border-slate-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <div class="flex items-center gap-4">
                        <div>
                            <h3 class="text-xl font-bold text-slate-900">{{ $data->mahasiswa->nama }}</h3>
                            <p class="text-sm font-medium text-slate-500 mt-0.5">Mahasiswa &bull; ID: 19876554</p>
                        </div>
                    </div>
                    
                    <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-[12px] font-black tracking-widest bg-slate-100 text-slate-900 uppercase">
                        Pending Review
                    </span>
                </div>

                <div class="p-8 grid grid-cols-1 lg:grid-cols-12 gap-10">
                    
                    <div class="col-span-1 lg:col-span-7 space-y-7">
                        
                        <div class="flex items-start gap-4">
                            <div class="mt-0.5 text-slate-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-[12px] font-bold tracking-widest text-slate-500 uppercase mb-1">Komputer</p>
                                <p class="text-base font-bold text-slate-900">{{ $data->komputer->nama_komputer }}</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="mt-0.5 text-slate-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2M5 21H3m4 0h10M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-[12px] font-bold tracking-widest text-slate-500 uppercase mb-1">Laboratorium</p>
                                <p class="text-base font-bold text-slate-900">{{ $data->laboratorium->nama_lab }}</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="mt-0.5 text-slate-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 14l9-5-9-5-9 5 9 5z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path></svg>
                            </div>
                            <div>
                                <p class="text-[12px] font-bold tracking-widest text-slate-500 uppercase mb-1">Dosen</p>
                                <p class="text-base font-bold text-slate-900">{{ $data->dosen_ta }}</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="mt-0.5 text-slate-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                            </div>
                            <div>
                                <p class="text-[12px] font-bold tracking-widest text-slate-500 uppercase mb-2">Software</p>
                                <div class="flex flex-wrap gap-2">
                                    @php
                                        $softwareList = array_map('trim', explode(',', $data->software));
                                    @endphp

                                    @foreach($softwareList as $software)
                                        @if(!empty($software))
                                            <span class="px-3 py-1 bg-slate-100/80 text-slate-700 text-sm font-bold rounded-lg border border-slate-200/50">
                                                {{ $software }}
                                            </span>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="mt-0.5 text-slate-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            </div>
                            <div>
                                <p class="text-[12px] font-bold tracking-widest text-slate-500 uppercase mb-1">Contact</p>
                                <p class="text-base font-bold text-slate-900">{{ $data->no_hp }}</p>
                            </div>
                        </div>

                    </div>

                    <div class="col-span-1 lg:col-span-5">
                        <div class="bg-slate-50/50 rounded-2xl border border-slate-100 p-7 h-full">
                            <h4 class="text-[12px] font-bold tracking-widest text-slate-700 uppercase mb-6">Waktu Request</h4>
                            
                            <div class="relative">
                                <div class="absolute left-[7px] top-3 bottom-12 w-[2px] bg-slate-200 rounded-full"></div>
                                
                                @php
                                    $mulai = \Carbon\Carbon::parse($data->tanggal_mulai);
                                    $selesai = \Carbon\Carbon::parse($data->perkiraan_selesai);

                                    $diff = $mulai->diff($selesai);
                                    $durasi = [];
                                    
                                    if ($diff->d > 0) $durasi[] = $diff->d . 'd';  
                                    if ($diff->h > 0) $durasi[] = $diff->h . 'h'; 
                                    if ($diff->i > 0) $durasi[] = $diff->i . 'm'; 
                                    
                                    $stringDurasi = implode(' ', $durasi) ?: '0m';
                                @endphp

                                <div class="space-y-8">
                                    
                                    <div class="relative pl-7">
                                        <div class="absolute left-0 top-1.5 w-4 h-4 rounded-full bg-slate-400 ring-4 ring-slate-50 z-10"></div>
                                        <p class="text-[12px] font-bold tracking-widest text-slate-500 uppercase mb-1">Mulai</p>
                                        
                                        <p class="text-xl font-bold text-slate-900 mb-0.5">{{ $mulai->format('d M Y') }}</p>
                                        
                                        <p class="text-base font-medium text-slate-500">{{ $mulai->format('H:i') }} WIB</p>
                                    </div>

                                    <div class="relative pl-7">
                                        <div class="absolute left-0 top-1.5 w-4 h-4 rounded-full bg-slate-50 border-2 border-slate-400 ring-4 ring-slate-50 z-12"></div>
                                        <p class="text-[12px] font-bold tracking-widest text-slate-500 uppercase mb-1">Estimasi Selesai</p>
                                        
                                        <p class="text-xl font-bold text-slate-900 mb-0.5">{{ $selesai->format('d M Y') }}</p>

                                        <p class="text-base font-medium text-slate-500">{{ $selesai->format('H:i') }} WIB</p>
                                        
                                        <p class="text-sm font-medium text-slate-500 pt-1">Duration: {{ $stringDurasi }}</p>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="px-8 pb-8 pt-2 flex justify-end gap-4">
                    
                    <form action="{{ route('teknisi.reject.request', $data->id_request) }}" method="POST" class="m-0">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 bg-white border border-rose-300 text-rose-500 text-sm font-bold rounded-xl hover:bg-rose-100 hover:border-rose-400 transition-colors shadow-sm active:scale-95">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                            Tolak
                        </button>
                    </form>

                    <form action="{{ route('teknisi.accept.request', $data->id_request) }}" method="POST" class="m-0">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 bg-slate-600 border border-transparent text-white text-sm font-bold rounded-xl hover:bg-slate-700 transition-colors shadow-sm active:scale-95">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M4.5 12.75l6 6 9-13.5"></path></svg>
                            Setujui
                        </button>
                    </form>

                </div>

            </div>
            
        </div>
    </div>
</x-app-layout>