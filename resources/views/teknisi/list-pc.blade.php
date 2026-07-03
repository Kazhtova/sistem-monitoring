<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="font-black text-2xl text-gray-900 tracking-tight">
                    {{ __('Activity Tracker') }}
                </h2>
            </div>
            
            <div class="flex items-center gap-3">
                <div class="relative w-full md:w-64">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <input type="text" class="block w-full pl-10 pr-3 py-2 border border-gray-200 rounded-lg text-sm bg-gray-50 placeholder-gray-400 focus:outline-none focus:bg-white focus:ring-1 focus:ring-slate-500 focus:border-slate-500 transition-colors" placeholder="Search...">
                </div>

                <button class="p-2 border border-gray-200 rounded-lg text-gray-500 hover:bg-gray-50 hover:text-gray-700 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                </button>

                <button class="hidden md:block px-4 py-2 text-sm font-medium rounded-lg text-white bg-slate-600 hover:bg-slate-700 shadow-sm transition-colors">
                    Import
                </button>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
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
                                                // 1. Ambil data request dengan status 'setuju' atau 'pending' yang terikat pada PC ini 
                                                $hasUse = $item->requests->whereIn('status', ['setuju', 'pending'])->first();
                                            $hasPending = $item->requests->whereIn('status', ['tolak', 'selesai'])->first();

                                                // 2. Variabel Default: Jika tidak ada request aktif, maka PC otomatis 'Ready'
                                                $statusText = 'Ready';
                                                $colorClass = 'bg-emerald-50 text-emerald-700 border-emerald-100'; // Hijau Pastel

                                                // 3. Pengecekan Kondisi Murni dari Relasi Request 
                                                if ($hasUse) {
                                                    // ENUM: 'setuju' -> Komputer sedang dipakai oleh mahasiswa 
                                                    $statusText = 'In Use';
                                                    $colorClass = 'bg-slate-950 text-white border-slate-950'; // Utilitarian Slate Gelap
                                                } elseif ($hasPending) {
                                                    // ENUM: 'pending' -> Ada pengajuan masuk yang belum direspons teknisi 
                                                    $statusText = 'Pending Approval';
                                                    $colorClass = 'bg-blue-50 text-blue-700 border-blue-100'; // Biru Pastel
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
                                            Tidak ada data PC yang terhubung ke Lab dan Teknisi.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                            </table>
                            </div>

                            <div class="bg-white px-6 py-4 border-t border-gray-100">
                                {{ $pc->links() }}
                            </div>
            </div>
        </div>
    </div>
</x-app-layout>