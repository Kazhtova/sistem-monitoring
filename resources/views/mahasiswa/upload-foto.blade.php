<x-apps-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('mahasiswa.dashboard.mahasiswa') }}" class="p-2 bg-white rounded-full shadow-sm hover:bg-gray-50 hover:shadow-md transition-all duration-300 group">
                <svg class="w-6 h-6 text-gray-600 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h2 class="font-bold text-2xl text-gray-800 tracking-tight">
                Upload Photo Evidence
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden flex flex-col md:flex-row">
                
                <div class="w-full md:w-5/12 bg-gray-50 p-8 border-r border-gray-100 flex flex-col">
                    
                    <div>
                        <h3 class="text-slate-950 text-xs font-black uppercase tracking-widest mb-2">Detail Request</h3>
                        <p class="text-2xl font-black text-gray-900 mb-1">PC: {{ $dataRequest->komputer->nama_komputer ?? 'General Service' }}</p>
                        <p class="text-sm font-bold text-gray-500 mb-6">{{ $dataRequest->software }}</p>
                        
                        <div class="flex justify-between items-end mb-6">
                            <div>
                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-tighter">Assigned Technician</p>
                                <p class="text-sm font-bold text-gray-800">{{ $dataRequest->teknisi->nama_teknisi }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-tighter">Current Status</p>
                                <span class="inline-block mt-1 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider bg-slate-200 text-slate-950">
                                    {{ $dataRequest->status == 'setuju' ? 'RUNNING' : strtoupper($dataRequest->status) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 flex-grow flex flex-col">
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-tighter mb-2">Photo Preview</p>
                        
                        <div class="w-full h-48 md:h-full min-h-[200px] rounded-2xl border border-gray-200 bg-white flex items-center justify-center overflow-hidden relative shadow-inner group cursor-pointer" onclick="if(document.getElementById('preview-image').src && !document.getElementById('preview-image').src.endsWith('upload-foto')) { bukaModal(document.getElementById('preview-image').src) }">
                            
                            <img id="preview-image" 
                                 src="{{ $dataRequest->foto_bukti ? asset('storage/' . $dataRequest->foto_bukti) : '' }}" 
                                 class="{{ $dataRequest->foto_bukti ? 'block' : 'hidden' }} absolute inset-0 w-full h-full object-contain p-2 z-10 transition-transform duration-300 group-hover:scale-105" 
                                 alt="Preview Foto">

                            <div id="zoom-hint" class="{{ $dataRequest->foto_bukti ? 'flex' : 'hidden' }} absolute inset-0 bg-black/20 items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 z-20">
                                <div class="bg-black/50 backdrop-blur-sm p-3 rounded-full text-white shadow-lg">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path></svg>
                                </div>
                            </div>

                            <div id="no-image-placeholder" class="{{ $dataRequest->foto_bukti ? 'hidden' : 'flex' }} flex-col items-center text-gray-300 z-0">
                                <svg class="w-10 h-10 mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <span class="text-[10px] font-bold uppercase tracking-wider">No Photo Uploaded</span>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="w-full md:w-7/12 p-8 flex flex-col justify-center">
                    <form action="{{ route('mahasiswa.foto.post', $dataRequest->id_request) }}" method="POST" enctype="multipart/form-data" class="flex flex-col h-full">
                        @csrf
                        @method('PATCH') 
                        
                        <div class="flex-grow flex flex-col justify-center">
                            <label class="block text-sm font-black text-gray-700 mb-4">Select or Drag Photos Here</label>
                            
                            <div class="relative w-full h-72 border-2 border-dashed border-gray-300 rounded-2xl bg-gray-50/50 flex flex-col items-center justify-center overflow-hidden transition-all duration-300 hover:bg-slate-200 hover:border-slate-600 group cursor-pointer" id="dropzone">
                                
                                <img id="new-preview-image" src="" class="hidden absolute inset-0 w-full h-full object-contain bg-white z-10" alt="Preview Baru">

                                <div id="dropzone-placeholder" class="flex flex-col items-center justify-center p-6 text-center z-0">
                                    <div class="p-4 bg-white rounded-full shadow-sm mb-4 text-slate-600 group-hover:scale-110 group-hover:text-slate-800 transition-all duration-300">
                                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                                        </svg>
                                    </div>
                                    <p class="text-base font-bold text-gray-700">Click to browse files</p>
                                    <p class="text-xs text-gray-400 mt-2">Only supports JPG, JPEG, PNG (Max 2MB)</p>
                                </div>

                                <input type="file" id="foto_bukti" name="foto_bukti" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-20" accept="image/png, image/jpeg, image/jpg" onchange="previewFile(this)">
                            </div>
                        </div>
                        
                        <div class="mt-8 flex justify-end gap-3 pt-6 border-t border-gray-100">
                            <a href="{{ url()->current() }}" class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-bold rounded-xl transition-colors">
                                Cancel
                            </a>
                            <button type="submit" class="px-8 py-3 bg-slate-600 hover:bg-slate-700 text-white text-sm font-bold rounded-xl shadow-lg shadow-slate-200 transition-all hover:-translate-y-0.5 flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Uploads Photo
                            </button>
                        </div>
                    </form>
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

    @push('scripts')
    <script>
        // 1. Fungsi Buka/Tutup Modal (Sesuai dengan kodemu)
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

        // 2. Fungsi JS Live Preview Gambar Lokal
        function previewFile(input) {
        var file = input.files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function(e) {
                
                // A. Tampilkan gambar BARU di kotak KANAN (Dropzone)
                let imgElement = document.getElementById('new-preview-image');
                if (imgElement) {
                    imgElement.src = e.target.result;
                    imgElement.classList.remove('hidden');
                    imgElement.classList.add('block');
                }
                
                // B. Sembunyikan tulisan 'Click to browse files' di kotak KANAN
                let placeholder = document.getElementById('dropzone-placeholder');
                if (placeholder) {
                    placeholder.classList.add('hidden');
                    placeholder.classList.remove('flex');
                }
                
                // CATATAN: Kita tidak menyentuh elemen di kotak kiri sama sekali. 
                // Gambar lama di kiri akan tetap aman!
            }
            reader.readAsDataURL(file); 
        }
    }
    </script>
    @endpush
</x-apps-layout>