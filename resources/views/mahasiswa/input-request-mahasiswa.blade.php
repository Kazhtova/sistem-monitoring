<x-apps-layout>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
        <div class="w-full sm:max-w-sm px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            
            <div class="mb-4 text-center">
                <h2 class="font-bold text-lg text-gray-700 uppercase tracking-widest">
                    {{ __('Send Request') }}
                </h2>
            </div>

            <form method="POST" action="{{ route('request.post') }}" enctype="multipart/form-data">
                @csrf

                <input type="hidden" name="id_teknisi" value="4">
                <input type="hidden" name="id_mahasiswa" value="{{ auth()->guard('mahasiswa')->user()->id_mahasiswa }}">
                <input type="hidden" name="id_komputer" value="1">

                <!-- Input Teknisi -->
                <div class="mb-2">
                    <x-input-label for="dosen_ta" :value="__('Lecture')" />
                    <x-text-input id="dosen_ta" class="block mt-1 w-full text-sm" type="text" name="dosen_ta" :value="old('dosen_ta')" required autofocus />
                    <x-input-error :messages="$errors->get('dosen_ta')" class="mt-1" />
                </div>

                <div class="mb-2">
                    <x-input-label for="software" :value="__('Software')" />
                    <x-text-input id="software" class="block mt-1 w-full text-sm" type="text" name="software" :value="old('software')" required autofocus />
                    <x-input-error :messages="$errors->get('software')" class="mt-1" />
                </div>

                <div class="mb-2">
                    <x-input-label for="no_hp" :value="__('No HP')" />
                    <x-text-input id="no_hp" class="block mt-1 w-full text-sm" type="number" name="no_hp" :value="old('no_hp')" required autofocus />
                    <x-input-error :messages="$errors->get('no_hp')" class="mt-1" />
                </div>

                <div class="mb-2">
                    <x-input-label for="tanggal_mulai" :value="__('Time Start')" />
                    <x-text-input id="tanggal_mulai" class="block mt-1 w-full text-sm" type="datetime-local" name="tanggal_mulai" :value="old('tanggal_mulai')" required autofocus />
                    <x-input-error :messages="$errors->get('tanggal_mulai')" class="mt-1" />
                </div>

                <div class="mb-2">
                    <x-input-label for="perkiraan_selesai" :value="__('Estimate Complete')" />
                    <x-text-input id="perkiraan_selesai" class="block mt-1 w-full text-sm" type="datetime-local" name="perkiraan_selesai" :value="old('perkiraan_selesai')" required autofocus />
                    <x-input-error :messages="$errors->get('perkiraan_selesai')" class="mt-1" />
                </div>

                <div class="mb-2">
                    <x-input-label for="catatan" :value="__('Note')" />
                    <x-text-input id="catatan" class="block mt-1 w-full text-sm" type="text" name="catatan" :value="old('catatan')" required autofocus />
                    <x-input-error :messages="$errors->get('catatan')" class="mt-1" />
                </div>

                <x-input-label for="foto_bukti" :value="__('Upload Photo')" class="mb-2 text-gray-700 font-semibold" />
    
                <div class="relative">
                    <input id="foto_bukti" 
                        type="file" 
                        name="foto_bukti" 
                        accept="image/*"
                        class="block w-full text-sm text-gray-500
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-md file:border-0
                                file:text-sm file:font-semibold
                                file:bg-indigo-50 file:text-indigo-700
                                hover:file:bg-indigo-100
                                border border-gray-300 rounded-lg shadow-sm
                                focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500
                                transition duration-150 ease-in-out"
                        required />
                </div>

                <p class="mt-1 text-xs text-gray-500">Format: JPG, PNG. Maks 2MB.</p>
                <x-input-error :messages="$errors->get('foto_bukti')" class="mt-2" />

                <div class="flex items-center justify-end mt-4">
                    <x-primary-button>
                        {{ __('Send') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
    @push('scripts')
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
        });
    </script>
    @endpush

</x-apps-layout> 