<x-guest-layout>
    <form method="POST" action="{{ route('login.mahasiswa') }}">
        @csrf

        <!-- Input NRP -->
        <div>
            <x-input-label for="nrp" :value="__('NRP')" />
            <x-text-input id="nrp" class="block mt-1 w-full" type="text" 
                name="nrp" 
                inputmode="numeric" 
                pattern="[0-9]*" 
                oninput="this.value = this.value.replace(/[^0-9]/g, '')" 
                :value="old('nrp')" 
                required 
                autofocus 
                autocomplete="username" />
            <x-input-error :messages="$errors->get('nrp')" class="mt-2" />
        </div>

        <!-- Input Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('PASSWORD')" />
            <!-- 🟢 PERBAIKAN: Ubah type menjadi 'password' dan name menjadi 'password' -->
            <x-text-input id="password" class="block mt-1 w-full" type="password" 
                name="password" 
                required 
                autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-slate-600 shadow-sm focus:ring-slate-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <!-- Submit Button -->
        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="ms-4">
                {{ __('Enter') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>