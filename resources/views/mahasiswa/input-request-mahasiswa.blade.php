<x-apps-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-gray-800 tracking-tight">
                {{ __('Send Request') }} To {{ $labTerpilih->nama_lab }}
            </h2>
            
            <a href="{{ route('mahasiswa.request.mahasiswa') }}" 
               class="inline-flex items-center px-4 py-2 bg-white rounded-xl shadow-sm border border-gray-200 hover:border-slate-300 hover:bg-slate-50 text-sm font-bold text-gray-600 hover:text-slate-600 transition-all duration-300 group">
                <svg class="w-4 h-4 mr-2 text-gray-400 group-hover:text-slate-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back
            </a>
        </div>
    </x-slot>

    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css" rel="stylesheet">


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex justify-center">
            
            <div class="w-full sm:max-w-md px-8 py-8 bg-white shadow-sm border border-gray-100 overflow-hidden rounded-3xl">

                <form method="POST" action="{{ route('mahasiswa.request.post') }}" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" name="id_teknisi" value="{{ $labTerpilih->id_teknisi }}">
                    <input type="hidden" name="nrp" value="{{ auth()->guard('mahasiswa')->user()->nrp }}">
                    <input type="hidden" name="nama_mahasiswa" value="{{ auth()->guard('mahasiswa')->user()->nama_mahasiswa }}">
                    <input type="hidden" name="id_laboratorium" value="{{ $labId }}">
                    

                    <div class="mb-4">
                        <x-input-label for="id_komputer" :value="__('Choose Computer Lab')" class="text-gray-700 font-semibold mb-2" />    
                        <div class="relative">
                            <select id="id_komputer" 
                                    name="id_komputer" 
                                    class="tom-select-init block w-full"
                                    required>
                                
                                <option value="" disabled selected>-- Select Available Computers --</option>

                                @foreach ($komputerTersedia as $komputer)
                                    <option value="{{ $komputer->id_komputer }}" {{ old('id_komputer') == $komputer->id_komputer ? 'selected' : ''}}>
                                        {{ $komputer->nama_komputer }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <x-input-error :messages="$errors->get('id_komputer')" class="mt-1" />
                    </div>

                    <div class="mb-3">
                        <x-input-label for="dosen_ta" :value="__('Lecture')" />
                        <x-text-input id="dosen_ta" class="block mt-1 w-full text-sm" type="text" name="dosen_ta" :value="old('dosen_ta')" required autofocus placeholder="Example: Mr Budi"/>
                        <x-input-error :messages="$errors->get('dosen_ta')" class="mt-1" />
                    </div>

                    <div class="mb-3">
                        <x-input-label for="software" :value="__('Software')" />
                        <x-text-input id="software" class="block mt-1 w-full text-sm" type="text" name="software" :value="old('software')" required autofocus placeholder="Example: Jupiter, MatLab"/>
                        <x-input-error :messages="$errors->get('software')" class="mt-1" />
                    </div>

                    <div class="mb-3">
                        <x-input-label for="no_hp" :value="__('No HP')" />
                        <x-text-input id="no_hp" class="block mt-1 w-full text-sm" type="number" name="no_hp" :value="old('no_hp')" required autofocus placeholder="Example: 0812345678"/>
                        <x-input-error :messages="$errors->get('no_hp')" class="mt-1" />
                    </div>

                    <div class="mb-3">
                        <x-input-label for="tanggal_mulai" :value="__('Time Start')" />
                        <x-text-input id="tanggal_mulai" class="block mt-1 w-full text-sm" type="datetime-local" name="tanggal_mulai" :value="old('tanggal_mulai')" required autofocus />
                        <x-input-error :messages="$errors->get('tanggal_mulai')" class="mt-1" />
                    </div>

                    <div class="mb-3">
                        <x-input-label for="perkiraan_selesai" :value="__('Estimate Complete')" />
                        <x-text-input id="perkiraan_selesai" class="block mt-1 w-full text-sm" type="datetime-local" name="perkiraan_selesai" :value="old('perkiraan_selesai')" required autofocus />
                        <x-input-error :messages="$errors->get('perkiraan_selesai')" class="mt-1" />
                    </div>

                    <div class="mb-5">
                        <x-input-label for="catatan" :value="__('Note')" />
                        <x-text-input id="catatan" class="block mt-1 w-full text-sm" type="text" name="catatan" :value="old('catatan')" required autofocus />
                        <x-input-error :messages="$errors->get('catatan')" class="mt-1" />
                    </div>

                    <div class="flex items-center justify-end pt-4 border-t border-gray-100">
                        <x-primary-button class="w-full justify-center py-3 rounded-xl shadow-lg shadow-slate-200 hover:shadow-slate-300 transition-all">
                            {{ __('Send Request') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
            
        </div>
    </div>
    
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
    
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

            @if (session('success'))
                Swal.fire({
                    icon: "success",
                    title: "{{ session('success') }}",
                    showConfirmButton: false,
                    timer: 1500
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
                                confirmButtonColor: '#4f46e5'
                            });
                        }
                    }
                });
            }
        });
    </script>
    @endpush

</x-apps-layout>