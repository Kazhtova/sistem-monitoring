<x-apps-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-slate-800 tracking-tight">
                {{ __('My Profile & Security') }}
            </h2>
            <div class="bg-slate-200 px-4 py-2 rounded-xl border border-slate-300">
                <span class="text-xs font-black text-slate-950 uppercase tracking-widest">Active Queue: </span>
                <span class="text-sm font-black text-slate-900">{{ $readRequest->count() ?? 0 }}/3</span>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="w-full bg-white rounded-[24px] overflow-hidden shadow-sm border border-slate-200">
                
                <div class="h-32 w-full bg-gradient-to-r from-[#0067A6] to-[#0067A6] relative"></div>

                <div class="px-8 pb-8 relative">
                    <div class="absolute -top-12 left-8 w-24 h-24 rounded-full border-[4px] border-white bg-slate-100 shadow-sm flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="w-12 h-12 text-[#0067A6]">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 14.25L3.75 9.75L12 5.25L20.25 9.75L12 14.25ZM6.75 11.625V15C6.75 16.657 9.103 18 12 18C14.897 18 17.25 16.657 17.25 15V11.625" />
                        </svg>
                    </div>

                    <div class="pt-16 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                        <div>
                            <h3 class="text-2xl font-bold text-slate-900 tracking-tight">{{ auth()->user()->nama }}</h3>
                            <p class="text-base font-bold text-slate-500 mt-1 flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path></svg>
                                NRP: {{ auth()->user()->nrp }}
                            </p>
                        </div>
                        
                        <a href="{{ route('mahasiswa.request.mahasiswa') }}" class="inline-flex items-center gap-2 px-6 py-2.5 bg-slate-950 hover:bg-slate-800 text-white text-sm font-bold rounded-xl transition-all duration-300 shadow-sm active:scale-95">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                            Add Request
                        </a>
                    </div>

                    <hr class="my-6 border-slate-100">
                </div>
            </div>

            {{-- <div class="w-full bg-white rounded-[24px] p-8 shadow-sm border border-slate-200">
                
                <div class="flex items-center gap-3 mb-8">
                    <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-700">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900">Security & Authentication</h3>
                </div>

                @if (session('status') === 'password-updated')
                    <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm font-bold rounded-xl flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                        Password berhasil diperbarui!
                    </div>
                @endif

                <form method="POST" action="{{ route('mahasiswa.password.update') }}" class="space-y-6 max-w-2xl">
                    @csrf
                    @method('PATCH')

                    <div>
                        <label for="current_password" class="block text-sm font-bold text-slate-700 mb-1.5">Current Password</label>
                        <div class="relative">
                            <input id="current_password" name="current_password" type="password" class="block w-full rounded-xl border-slate-200 bg-slate-50 text-slate-900 focus:border-blue-500 focus:ring-blue-500 pr-10" placeholder="Enter current password" required>
                            <button type="button" onclick="togglePassword('current_password')" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->get('current_password')" class="mt-2" />
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-bold text-slate-700 mb-1.5">New Password</label>
                        <div class="relative">
                            <input id="password" name="password" type="password" class="block w-full rounded-xl border-slate-200 bg-slate-50 text-slate-900 focus:border-blue-500 focus:ring-blue-500 pr-10" placeholder="Enter new password" required>
                            <button type="button" onclick="togglePassword('password')" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </button>
                        </div>
                        <p class="text-[11px] font-medium text-slate-400 mt-1.5 flex items-center gap-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Minimum 8 characters.
                        </p>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-bold text-slate-700 mb-1.5">Confirm New Password</label>
                        <div class="relative">
                            <input id="password_confirmation" name="password_confirmation" type="password" class="block w-full rounded-xl border-slate-200 bg-slate-50 text-slate-900 focus:border-blue-500 focus:ring-blue-500 pr-10" placeholder="Confirm new password" required>
                            <button type="button" onclick="togglePassword('password_confirmation')" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </button>
                        </div>
                    </div>

                    <div class="pt-4 flex items-center justify-end gap-3">
                        <button type="reset" class="px-6 py-2.5 bg-white border border-slate-200 text-slate-700 text-sm font-bold rounded-xl hover:bg-slate-50 transition shadow-sm">
                            Cancel
                        </button>
                        <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 bg-slate-950 border border-transparent text-white text-sm font-bold rounded-xl hover:bg-slate-800 transition shadow-sm active:scale-95">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                            Save Changes
                        </button>
                    </div>
                </form>

            </div> --}}
        </div>
    </div>

    <script>
        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            if (input.type === "password") {
                input.type = "text";
            } else {
                input.type = "password";
            }
        }
    </script>
</x-apps-layout>