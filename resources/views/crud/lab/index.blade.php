<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-black text-2xl text-gray-900 tracking-tight">Master Laboratorium</h2>
            <a href="{{ route('teknisi.master-lab.create') }}" class="px-4 py-1 bg-slate-900 text-white font-bold rounded-xl hover:bg-slate-800 transition-colors shadow-sm active:scale-95">
                + Tambah Lab
            </a>
        </div>
    </x-slot>

    <div class="py-8 min-h-screen bg-slate-50/50">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                <table class="w-full text-left border-collapse whitespace-nowrap">
                    <thead class="bg-slate-50/50 border-b border-slate-200">
                        <tr>
                            <th class="py-4 px-6 text-xs font-bold text-slate-900 uppercase tracking-wider">Nama Lab</th>
                            <th class="py-4 px-6 text-xs font-bold text-slate-900 uppercase tracking-wider text-center">Jumlah Komputer</th>
                            <th class="py-4 px-6 text-xs font-bold text-center text-slate-900 uppercase tracking-wider">Teknisi/Penanggung Jawab</th>
                            <th class="py-4 px-6 text-xs font-bold text-slate-900 uppercase tracking-wider text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($labs as $item)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="py-4 px-6 font-bold text-slate-800">{{ $item->nama_lab }}</td>
                                <td class="py-4 px-6 text-sm font-medium text-slate-600 text-center">
                                    <span class="bg-slate-50 text-slate-700 py-1 px-3 rounded-lg">{{ $item->jumlah_komputer }} PC</span>
                                </td>
                                <td class="py-4 px-6 text-sm text-center text-slate-600">{{ $item->teknisi->nama_teknisi ?? 'Tanpa Teknisi' }}</td>
                                <td class="py-4 px-6 text-right">
                                    <div class="flex justify-center gap-2">
                                        <a href="{{ route('teknisi.master-lab.edit', $item->id_laboratorium) }}" class="px-4 py-1.5 text-xs font-bold text-blue-700 bg-blue-50 border border-blue-200 rounded-lg hover:bg-blue-100 shadow-sm transition-colors">Edit</a>
                                        
                                        <form action="{{ route('teknisi.master-lab.destroy', $item->id_laboratorium) }}" method="POST" class="m-0" onsubmit="return confirm('Yakin ingin menghapus Lab ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="px-4 py-1.5 text-xs font-bold text-red-700 bg-red-50 border border-red-200 rounded-lg hover:bg-red-100 shadow-sm transition-colors">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            @if($labs->hasPages())
                <div class="mt-4 px-2">{{ $labs->links() }}</div>
            @endif
        </div>
    </div>
</x-app-layout>