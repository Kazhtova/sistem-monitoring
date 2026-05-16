<x-guest-layout>
    <form method="POST" action="{{ route('login.mahasiswa') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="nama_mahasiswa" :value="__('Nama Mahasiswa')" />
            <x-text-input id="nama_mahasiswa" class="block mt-1 w-full" type="text" name="nama_mahasiswa" :value="old('nama_mahasiswa')" required autofocus autocomplete="nama_mahasiswa" />
            <x-input-error :messages="$errors->get('nama_mahasiswa')" class="mt-2" />
        </div>

        <!-- nrp Address -->
        <div class="mt-4">
            <x-input-label for="nrp" :value="__('NRP')" />
            <x-text-input id="nrp" class="block mt-1 w-full" type="text" 
       name="nrp" 
       inputmode="numeric" 
       pattern="[0-9]*" 
       oninput="this.value = this.value.replace(/[^0-9]/g, '')" :value="old('nrp')" required autocomplete="nrp" />
            <x-input-error :messages="$errors->get('nrp')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            {{-- <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a> --}}
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

            <x-primary-button class="ms-4">
                {{ __('Masuk') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
