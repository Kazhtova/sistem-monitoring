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
                                    class="block w-full text-sm text-gray-700 bg-white border border-gray-300 rounded-lg shadow-sm py-2.5 px-3 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out"
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
                        <x-primary-button class="w-full justify-center py-3 rounded-xl shadow-lg shadow-indigo-200">
                            {{ __('Send Request') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
            
        </div>
    </div>
    
    @push('scripts')
    @vite(['resources/js/app.js'])
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            @if (session('success'))
                Swal.fire({
                    icon: "success",
                    title: "{{ session('success') }}",
                    showConfirmButton: false,
                    timer: 1500
                });
            @endif

            let currentLabId = "{{ $labId }}"

            if(typeof window.Echo !== 'undefined'){
                console.log("✅ [ECHO STATUS] Aktif dan mendengarkan channel: laboratorium." + currentLabId);
                
                window.Echo.channel('laboratorium.' + currentLabId)
                .listen('.ComputerAccepted', (e) => {
                    
                    console.log("🔥 [SINYAL REVERB MASUK] Data payload:", e);

                    let selectKomputer = document.getElementById('id_komputer');
                    let optionRemove = selectKomputer.querySelector(`option[value="${e.id_komputer}"]`);

                    if(optionRemove){
                        console.log("🗑️ [DOM MANIPULATION] Menghapus komputer ID:", e.id_komputer);
                        optionRemove.remove();
                    } else {
                        console.warn("⚠️ [WARNING] Sinyal masuk, tapi ID komputer tidak ditemukan di dropdown!");
                    }
                });
            } else {
                console.error("❌ [ECHO ERROR] Library Echo gagal dimuat. Apakah npm run dev mati?");
            }
        });
    </script>
    @endpush

</x-apps-layout>