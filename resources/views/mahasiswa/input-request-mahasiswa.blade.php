<x-apps-layout>
    
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-gray-800 tracking-tight">
                {{ __('Send Request') }}
            </h2>
            
            <a href="{{ route('mahasiswa.request.mahasiswa') }}" 
               class="inline-flex items-center px-4 py-2 bg-white rounded-xl shadow-sm border border-gray-200 hover:border-indigo-300 hover:bg-indigo-50 text-sm font-bold text-gray-600 hover:text-indigo-600 transition-all duration-300 group">
                <svg class="w-4 h-4 mr-2 text-gray-400 group-hover:text-indigo-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back
            </a>
        </div>
    </x-slot>

    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css" rel="stylesheet">
    <style>
        /* 1. KOTAK UTAMA (Tombol Select) */
        .ts-control {
            border-radius: 0.5rem !important; 
            
            /* 🌟 FIX: Memperbesar tinggi kotak dan memastikan teks sejajar di tengah vertikal */
            padding: 0.65rem 0.75rem !important; 
            min-height: 42px !important; 
            display: flex !important;
            align-items: center !important;
            
            border: 1px solid #d1d5db !important; 
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05) !important; 
            font-size: 0.875rem !important; 
            background-color: #ffffff !important;
            cursor: pointer !important;
            transition: all 150ms ease-in-out !important;
            
            /* Ikon Panah Chevron Native Tailwind */
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e") !important;
            background-position: right 0.75rem center !important;
            background-repeat: no-repeat !important;
            background-size: 1.5em 1.5em !important;
            padding-right: 2.5rem !important;
        }

        /* Hilangkan input kursor di kotak utama karena sudah dipindah ke dalam dropdown */
        .ts-control input { display: none !important; }
        
        /* Efek saat dropdown terbuka (Fokus pada tombol utama) */
        .ts-wrapper.focus .ts-control {
            border-color: #6610f2 !important; 
            box-shadow: 0 0 0 2px rgba(102, 116, 242) !important; 
        }
        
        /* Sembunyikan panah bawaan Tom Select */
        .ts-wrapper.single .ts-control:after { display: none !important; }

        /* ========================================================= */
        /* 2. TAMPILAN MENU POPUP DROPDOWN UTAMA */
        /* ========================================================= */
        .ts-dropdown {
            border-radius: 0.5rem !important;
            border: 1px solid #e5e7eb !important;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05) !important;
            margin-top: 0.35rem !important;
            overflow: hidden !important;
            background-color: #ffffff !important;
        }

        /* ========================================================= */
        /* 3. DESAIN KOTAK PENCARIAN DI DALAM DROPDOWN */
        /* ========================================================= */
        .ts-dropdown .dropdown-input-wrap {
            padding: 0.75rem !important;
            border-bottom: 1px solid #f3f4f6 !important; 
            background-color: #f9fafb !important; 
        }
        
        .ts-dropdown .dropdown-input {
            border-radius: 0.375rem !important; 
            border: 1px solid #d1d5db !important; 
            padding: 0.5rem 0.75rem 0.5rem 2.25rem !important; 
            font-size: 0.875rem !important;
            width: 100% !important;
            transition: all 150ms ease-in-out !important;
            
            /* Ikon Kaca Pembesar (Search) via Data URI */
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%239ca3af'%3e%3cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z'/%3e%3c/svg%3e") !important;
            background-repeat: no-repeat !important;
            background-position: left 0.6rem center !important;
            background-size: 1.1rem 1.1rem !important;
        }

        .ts-dropdown .dropdown-input:focus {
            outline: none !important;
            border-color: #6610f2 !important; 
            box-shadow: 0 0 0 2px rgba(102, 116, 242) !important;
        }

        /* ========================================================= */
        /* 4. DAFTAR OPSI (LIST ITEM) */
        /* ========================================================= */
        .ts-dropdown .option {
            padding: 0.625rem 1rem !important;
            font-size: 0.875rem !important;
            color: #374151 !important;
            cursor: pointer !important;
        }
        
        .ts-dropdown .option.active, 
        .ts-dropdown .option:hover {
            background-color: #e0e7ff !important; 
            color: #6610f2 !important; 
            font-weight: 600 !important;
        }
    </style>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex justify-center">
            
            <div class="w-full sm:max-w-md px-8 py-8 bg-white shadow-sm border border-gray-100 overflow-hidden rounded-3xl">

                <form method="POST" action="{{ route('mahasiswa.request.post') }}" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" name="id_teknisi" value="{{ $labTerpilih->id_teknisi }}">
                    <input type="hidden" name="id_mahasiswa" value="{{ auth()->guard('mahasiswa')->user()->id_mahasiswa }}">
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
                                        {{ $komputer->id_komputer }}
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
                        <x-text-input id="software" class="block mt-1 w-full text-sm" type="text" name="software" :value="old('software')" required autofocus placeholder="Example: Jupiter, MitLab"/>
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
                        <x-primary-button class="w-full justify-center py-3 rounded-xl shadow-lg shadow-indigo-200 hover:shadow-indigo-300 transition-all">
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
            
            // 🌟 INISIALISASI TOM SELECT DENGAN PLUGIN DROPDOWN_INPUT 🌟
            let komputerSelectBox = new TomSelect('#id_komputer', {
                create: false,
                sortField: {
                    field: "text",
                    direction: "asc"
                },
                allowEmptyOption: false,
                plugins: ['dropdown_input'], // Memunculkan kotak pencarian di dalam dropdown
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