<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <h2 class="font-black text-2xl text-gray-900 tracking-tight">
                {{ $dosen->exists ? 'Edit Data Dosen' : 'Tambah Dosen Baru' }}
            </h2>
            
            <a href="{{ route('teknisi.master-dosen.index') }}" 
            class="inline-flex items-center justify-center px-4 py-1 bg-white rounded-xl shadow-sm border border-gray-200 hover:border-slate-300 hover:bg-slate-50 text-sm font-bold text-gray-600 hover:text-slate-600 transition-all duration-300 group flex-shrink-0">
                <svg class="w-4 h-4 mr-2 text-gray-400 group-hover:text-slate-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back
            </a>
        </div>
    </x-slot>

    <div class="py-8 min-h-screen bg-slate-50/50">
        <div class="max-w-2xl mx-auto px-4">
            <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-200">
                
                <form action="{{ $dosen->exists ? route('teknisi.master-dosen.update', $dosen->id_dosen) : route('teknisi.master-dosen.store') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    @if($dosen->exists) 
                        @method('PATCH') 
                    @endif

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Nama Lengkap Dosen</label>
                        <input type="text" name="nama_dosen" value="{{ old('nama_dosen', $dosen->nama_dosen) }}" required 
                               class="w-full rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-slate-500 py-2.5 px-4 outline-none transition-colors">
                        
                        @error('nama_dosen')
                            <p class="text-red-500 text-xs mt-2 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="pt-4 flex justify-end gap-3">
                        <a href="{{ route('teknisi.master-dosen.index') }}" class="px-5 py-2.5 bg-slate-100 text-slate-600 font-bold rounded-xl hover:bg-slate-200 transition-colors">Batal</a>
                        <button type="submit" class="px-5 py-2.5 bg-slate-900 text-white font-bold rounded-xl hover:bg-slate-800 shadow-sm transition-all active:scale-95">Simpan Data</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>