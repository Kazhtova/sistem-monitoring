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
                $hasAfterUse = $item->requests->whereIn('status', ['tolak', 'selesai'])->first();

                $statusText = 'Ready';
                $colorClass = 'bg-emerald-50 text-emerald-700 border-emerald-100'; 

                if ($hasUse) {
                    $statusText = 'In Use';
                    $colorClass = 'bg-slate-950 text-white border-slate-950'; 
                } elseif ($hasAfterUse) {
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