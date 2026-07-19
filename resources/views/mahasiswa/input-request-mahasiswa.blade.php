<x-apps-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-slate-800 tracking-tight">
                {{ __('Send Request') }} To {{ $labTerpilih->nama_lab }}
            </h2>
            
            <a href="{{ route('mahasiswa.request.mahasiswa') }}" 
               class="inline-flex items-center px-4 py-2 bg-white rounded-xl shadow-sm border border-slate-200 hover:border-slate-300 hover:bg-slate-50 text-sm font-bold text-slate-600 hover:text-slate-900 transition-all duration-300 group">
                <svg class="w-4 h-4 mr-2 text-slate-400 group-hover:text-slate-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back
            </a>
        </div>
    </x-slot>

    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css" rel="stylesheet">

    <div class="py-12 bg-slate-50/50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex justify-center">
            
            <div class="w-full sm:max-w-md px-8 py-8 bg-white shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100 overflow-hidden rounded-[32px]">

                <!-- 🟢 FITUR BARU: Modern Inline Error Banner -->
                @if ($errors->any())
                    <div class="mb-6 p-4 rounded-2xl bg-rose-50 border border-rose-100 flex items-start gap-3 animate-fade-in">
                        <div class="mt-0.5 flex-shrink-0">
                            <svg class="w-5 h-5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-sm font-bold text-rose-900">Sedang Dipakai</h3>
                            <div class="mt-1 text-[13px] text-rose-600 font-medium leading-relaxed">
                                <ul class="list-disc pl-4 space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ route('mahasiswa.request.post') }}" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" name="id_teknisi" value="{{ $labTerpilih->id_teknisi }}">
                    <input type="hidden" name="nrp" value="{{ auth()->guard('mahasiswa')->user()->nrp }}">
                    <input type="hidden" name="nama_mahasiswa" value="{{ auth()->guard('mahasiswa')->user()->nama_mahasiswa }}">
                    <input type="hidden" name="id_laboratorium" value="{{ $labId }}">
                    
                    <div class="mb-4">
                        <x-input-label for="id_komputer" :value="__('Choose Computer Lab')" class="text-slate-700 font-bold mb-2" />    
                        <div class="relative">
                            <select id="id_komputer" name="id_komputer" class="tom-select-init block w-full" required>
                                <option value="" disabled selected>-- Select Available Computers --</option>
                                @foreach ($komputerTersedia as $komputer)
                                    <option value="{{ $komputer->id_komputer }}" {{ old('id_komputer') == $komputer->id_komputer ? 'selected' : ''}}>
                                        {{ $komputer->nama_komputer }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mb-4">
    <x-input-label for="dosen_ta" :value="__('Lecture')" class="text-slate-700 font-bold mb-2" />
    <div class="relative">
        <!-- 🟢 KUNCI: Bersihkan class block w-full bawaan select standar agar dicover penuh oleh TomSelect -->
        <select id="dosen_ta" name="dosen_ta" required>
            <option value="" disabled selected>-- Select Lecture --</option>
            @foreach ($daftarDosen as $dosen)
                <option value="{{ $dosen->nama_dosen }}" {{ old('dosen_ta') == $dosen->nama_dosen ? 'selected' : ''}}>
                    {{ $dosen->nama_dosen }}
                </option>
            @endforeach
        </select>
    </div>
</div>

                    <div class="mb-4">
                        <x-input-label for="software" :value="__('Software')" class="text-slate-700 font-bold" />
                        <x-text-input id="software" class="block mt-1.5 w-full text-sm rounded-xl border-slate-200" type="text" name="software" :value="old('software')" required placeholder="Example: Jupiter, MatLab"/>
                    </div>

                    <div class="mb-4">
                        <x-input-label for="no_hp" :value="__('No HP')" class="text-slate-700 font-bold" />
                        <x-text-input id="no_hp" class="block mt-1.5 w-full text-sm rounded-xl border-slate-200" type="number" name="no_hp" :value="old('no_hp')" required placeholder="Example: 0812345678"/>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <x-input-label for="tanggal_mulai" :value="__('Time Start')" class="text-slate-700 font-bold" />
                            <x-text-input id="tanggal_mulai" class="block mt-1.5 w-full text-sm rounded-xl border-slate-200" type="date" name="tanggal_mulai" :value="old('tanggal_mulai')" required />
                        </div>

                        <div>
                            <x-input-label for="perkiraan_selesai" :value="__('Estimate')" class="text-slate-700 font-bold" />
                            <x-text-input id="perkiraan_selesai" class="block mt-1.5 w-full text-sm rounded-xl border-slate-200" type="date" name="perkiraan_selesai" :value="old('perkiraan_selesai')" required />
                        </div>
                    </div>

                    <div class="mb-6">
                        <x-input-label for="catatan" :value="__('Note')" class="text-slate-700 font-bold" />
                        <x-text-input id="catatan" class="block mt-1.5 w-full text-sm rounded-xl border-slate-200" type="text" name="catatan" :value="old('catatan')" required placeholder="Note..."/>
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="w-full flex justify-center items-center gap-2 py-3.5 px-4 bg-slate-900 hover:bg-slate-800 text-white text-sm font-bold rounded-xl transition-all shadow-sm active:scale-95">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                            {{ __('Send Request') }}
                        </button>
                    </div>
                </form>
            </div>
            
        </div>
    </div>
    
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    @vite(['resources/js/app.js'])
    <script type="module">
        document.addEventListener('DOMContentLoaded', function () {
            
            let komputerSelectBox = new TomSelect('#id_komputer', {
                create: false,
                sortField: {
                    field: "text",
                    direction: "asc"
                },
                allowEmptyOption: false,
                plugins: ['dropdown_input'], 
            });

            let dosenSelectBox = new TomSelect('#dosen_ta', {
                create: false,
                sortField: { field: "text", direction: "asc" },
                allowEmptyOption: false,
                plugins: ['dropdown_input'],
                controlInput: null,
                render: {
                    item: function(data, escape) {
                        return '<div class="text-sm rounded-xl border-slate-200">' + escape(data.text) + '</div>';
                    }
                }
            });

            @if (session('success'))
                Swal.fire({
                    icon: "success",
                    title: "Berhasil!",
                    text: "{{ session('success') }}",
                    showConfirmButton: false,
                    timer: 2000,
                    customClass: { popup: 'rounded-3xl' }
                });
            @endif

            @if ($errors->any())
                let errorMessage = "{!! addslashes($errors->first()) !!}";
                
                Swal.fire({
                    icon: 'error',
                    title: 'Jadwal Tidak Tersedia',
                    html: `<p class="text-sm font-medium text-slate-600 mt-2 leading-relaxed">${errorMessage}</p>`,
                    confirmButtonColor: '#e11d48',
                    confirmButtonText: 'Ubah Jadwal',
                    customClass: { 
                        popup: 'rounded-3xl',
                        confirmButton: 'rounded-xl font-bold px-6 py-2.5'
                    }
                });
            @endif

            let currentLabId = "{{ $labId }}";

            if(typeof window.Echo !== 'undefined'){
                window.Echo.channel('laboratorium.' + currentLabId)
                .listen('.ComputerAccepted', (e) => {
                    if(e.id_komputer){
                        komputerSelectBox.removeOption(e.id_komputer);
                        
                        if (komputerSelectBox.getValue() == e.id_komputer) {
                            komputerSelectBox.clear();
                            Swal.fire({
                                icon: "info",
                                title: "Komputer Telah Diambil",
                                text: "Komputer yang Anda pilih baru saja disetujui untuk mahasiswa lain. Silakan pilih komputer lain.",
                                confirmButtonColor: '#4f46e5',
                                customClass: { popup: 'rounded-3xl' }
                            });
                        }
                    }
                });
            }
        });
    </script>
    @endpush

</x-apps-layout>