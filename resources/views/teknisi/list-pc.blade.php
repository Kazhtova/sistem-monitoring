<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="font-black text-2xl text-gray-900 tracking-tight">
                    {{ __('List - PC') }}
                </h2>
            </div>
        </div>
    </x-slot>

    {{-- WADAH UTAMA: Memiliki min-h-screen untuk latar belakang penuh --}}
    <div class="py-8 bg-slate-50/50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- 1. AREA FILTER --}}
            <div class="mb-8 bg-white p-5 rounded-2xl shadow-sm border border-slate-100">
                <form method="GET" action="{{ route('teknisi.dashboard.pc_list') }}" class="flex flex-wrap items-center gap-3 w-full">
                
                    {{-- 1. Input Pencarian Nama Komputer --}}
                    <div class="relative flex-1 md:w-64 md:flex-none">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" class="block w-full pl-10 pr-3 py-2 border border-slate-200 rounded-xl text-sm bg-slate-50 placeholder-slate-400 focus:outline-none focus:bg-white focus:ring-2 focus:ring-slate-500 focus:border-slate-500 transition-all" placeholder="Cari nama PC...">
                    </div>

                    {{-- 2. Menu Pilihan Filter Laboratorium --}}
                    <select name="lab" class="px-7 ps-4 py-2 border border-slate-200 rounded-xl text-sm bg-slate-50 text-slate-600 focus:outline-none focus:ring-2 focus:ring-slate-500 transition-all">
                        <option value="">Semua Lab</option>
                        @foreach($labs as $lab)
                            <option value="{{ $lab->id_laboratorium }}" {{ request('lab') == $lab->id_laboratorium ? 'selected' : '' }}>
                                {{ $lab->nama_lab }}
                            </option>
                        @endforeach
                    </select>

                    {{-- 3. Menu Pilihan Filter Status --}}
                    <select name="status" class="px-7 ps-4 py-2 border border-slate-200 rounded-xl text-sm bg-slate-50 text-slate-600 focus:outline-none focus:ring-2 focus:ring-slate-500 transition-all">
                        <option value="">Semua Status</option>
                        <option value="ready" {{ request('status') == 'ready' ? 'selected' : '' }}>Ready</option>
                        <option value="in_use" {{ request('status') == 'in_use' ? 'selected' : '' }}>In Use</option>
                        <option value="after_use" {{ request('status') == 'after_use' ? 'selected' : '' }}>After Use</option>
                    </select>

                    {{-- 4. Tombol Eksekusi Filter --}}
                    <button type="submit" class="px-4 py-2 border border-slate-200 rounded-xl text-white bg-slate-900 hover:bg-slate-800 transition-colors shadow-sm text-sm font-semibold">
                        Filter
                    </button>

                    {{-- 5. Tombol Reset Kondisi Pencarian --}}
                    @if(request('search') || request('lab') || request('status'))
                        <a href="{{ route('teknisi.dashboard.pc_list') }}" class="px-4 py-2 border border-slate-200 rounded-xl text-slate-700 bg-white hover:bg-slate-50 transition-colors shadow-sm flex items-center justify-center text-sm font-semibold">
                            Reset
                        </a>
                    @endif

                    {{-- 6. Tombol Aksi Sekunder (Import Data) - Didorong ke kanan via ml-auto secara aman --}}
                    <button type="button" class="hidden md:block ml-auto px-4 py-2 text-sm font-semibold rounded-xl text-slate-700 bg-white border-2 border-slate-200 hover:bg-slate-50 hover:border-slate-300 shadow-sm transition-all">
                        Import Data
                    </button>
                    
                </form>
            </div>
            
            {{-- 2. AREA TABEL (Langsung diletakkan di bawah filter, DI DALAM wadah utama yang sama) --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-100">
                        <thead class="bg-gray-50">
                           <tr>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 capitalize tracking-wider">Komputer</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 capitalize tracking-wider">Teknisi</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 capitalize tracking-wider">Lab</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 capitalize tracking-wider">Status</th>
                            </tr>
                        </thead>
                            <tbody class="bg-white divide-y divide-gray-50">
                                @forelse ($pc as $item)
                                    <tr class="hover:bg-gray-50/50 transition-colors group cursor-pointer">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center gap-3">
                                                <div>
                                                    <div class="text-sm font-medium text-slate-600 group-hover:text-slate-950 transition-colors">
                                                        {{ $item->nama_komputer }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600 group-hover:text-slate-950 transition-colors font-medium">
                                            {{ $item->laboratorium->teknisi->nama_teknisi ?? '-' }}
                                        </td>
                                        
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600 group-hover:text-slate-950 transition-colors">
                                            {{ $item->laboratorium->nama_lab ?? '-' }}
                                        </td>
                                        
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @php
                                                $hasUse = $item->requests->whereIn('status', ['setuju', 'pending'])->first();
                                                $hasPending = $item->requests->whereIn('status', ['tolak', 'selesai'])->first();

                                                $statusText = 'Ready';
                                                $colorClass = 'bg-emerald-50 text-emerald-700 border-emerald-100'; 

                                                if ($hasUse) {
                                                    $statusText = 'In Use';
                                                    $colorClass = 'bg-slate-950 text-white border-slate-950'; 
                                                } elseif ($hasPending) {
                                                    $statusText = 'After Use';
                                                    $colorClass = 'bg-blue-50 text-blue-700 border-blue-100'; 
                                                }
                                            @endphp

                                            <span class="px-2.5 py-0.5 inline-flex text-[11px] leading-5 font-bold uppercase tracking-wider rounded-full border {{ $colorClass }} transition-colors">
                                                {{ $statusText }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-8 text-center text-sm text-gray-500 font-medium">
                                            Data Tidak Ada.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                    </table>
                </div>

                {{-- Paginasi --}}
                <div class="bg-white px-6 py-4 border-t border-gray-100">
                    {{ $pc->links() }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>