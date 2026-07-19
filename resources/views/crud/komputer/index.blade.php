<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-black text-2xl text-gray-900 tracking-tight">Master Komputer</h2>
            <a href="{{ route('teknisi.master-komputer.create') }}" class="px-4 py-1 bg-slate-900 text-white font-bold rounded-xl hover:bg-slate-800 transition-colors shadow-sm active:scale-95">
                + Tambah Komputer
            </a>
        </div>
    </x-slot>

    <div class="py-8 min-h-screen bg-slate-50/50">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- 🟢 FITUR BARU: Form Search & Filter Lab -->
            <div class="mb-6 flex flex-col lg:flex-row justify-between items-start lg:items-center bg-white p-4 rounded-2xl shadow-sm border border-slate-200">
                <form action="{{ route('teknisi.master-komputer.index') }}" method="GET" class="flex flex-wrap md:flex-nowrap w-full items-center gap-3">
                    
                    <!-- Input Search Nama Komputer -->
                    <div class="relative w-full md:w-72 flex-shrink-0">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </span>
                        <input type="text" name="search" value="{{ request('search') }}" 
                               placeholder="Cari nama komputer..." 
                               class="pl-10 w-full rounded-xl border border-slate-200 bg-slate-50/50 py-2 shadow-sm outline-none focus:bg-white focus:border-slate-500 focus:ring-slate-500 sm:text-sm transition-all duration-300">
                    </div>
                    
                    <!-- Select Filter Lab -->
                    <select name="lab" onchange="this.form.submit()" 
                            class="rounded-xl border-slate-200 text-sm shadow-sm bg-slate-50/50 text-slate-600 outline-none focus:bg-white focus:ring-1 focus:ring-slate-500 focus:border-slate-500 py-2 transition-all duration-300">
                        <option value="all">Semua Laboratorium</option>
                        @foreach($daftarLab as $lab)
                            <option value="{{ $lab->id_laboratorium }}" {{ request('lab') == $lab->id_laboratorium ? 'selected' : '' }}>
                                {{ $lab->nama_lab }}
                            </option>
                        @endforeach
                    </select>

                    <!-- Button Cari -->
                    <button type="submit" class="bg-slate-900 hover:bg-slate-800 text-white px-5 py-2 rounded-xl text-sm font-bold tracking-wide transition-all duration-300 shadow-sm active:scale-95 flex-shrink-0">
                        Cari
                    </button>
                    
                    <!-- Tombol Reset Kondisi Pencarian -->
                    @if(request('search') || (request('lab') && request('lab') !== 'all'))
                        <a href="{{ route('teknisi.master-komputer.index') }}" class="text-sm text-slate-400 hover:text-red-500 font-semibold transition-colors flex items-center gap-1 flex-shrink-0 ms-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            Reset
                        </a>
                    @endif
                </form>
            </div>

            <!-- Area Tabel Data Komputer -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                <table class="w-full text-left border-collapse whitespace-nowrap">
                    <thead class="bg-slate-50/50 border-b border-slate-200">
                        <tr>
                            <th class="py-4 px-6 text-xs font-bold text-slate-900 uppercase tracking-wider">Nama Komputer</th>
                            <th class="py-4 px-6 text-xs font-bold text-center text-slate-900 uppercase tracking-wider">Lokasi Laboratorium</th>
                            <th class="py-4 px-6 text-xs font-bold text-center text-slate-900 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($komputers as $item)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="py-4 px-6 font-bold text-slate-800">{{ $item->nama_komputer }}</td>
                                <td class="py-4 px-6 text-sm text-center font-medium text-slate-600">
                                    <span class="bg-slate-50 text-slate-700 py-1 px-3 rounded-lg border border-slate-100">
                                        {{ $item->laboratorium->nama_lab ?? 'Tanpa Lab' }}
                                    </span>
                                </td>
                                <td class="py-4 px-6 text-center">
                                    <div class="flex justify-center gap-2">
                                        <a href="{{ route('teknisi.master-komputer.edit', $item->id_komputer) }}" class="px-4 py-1.5 text-xs font-bold text-blue-700 bg-blue-50 border border-blue-200 rounded-lg hover:bg-blue-100 shadow-sm transition-colors">Edit</a>
                                        
                                        <form action="{{ route('teknisi.master-komputer.destroy', $item->id_komputer) }}" method="POST" class="m-0" onsubmit="return confirm('Yakin ingin menghapus Komputer ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="px-4 py-1.5 text-xs font-bold text-red-700 bg-red-50 border border-red-200 rounded-lg hover:bg-red-100 shadow-sm transition-colors">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="py-12 text-center">
                                    <div class="flex flex-col items-center justify-center text-slate-400">
                                        <svg class="w-12 h-12 mb-3 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                        </svg>
                                        <span class="text-sm font-medium">Komputer tidak ditemukan atau data masih kosong.</span>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($komputers->hasPages())
                <div class="mt-4 px-2">{{ $komputers->links() }}</div>
            @endif
        </div>
    </div>
</x-app-layout>