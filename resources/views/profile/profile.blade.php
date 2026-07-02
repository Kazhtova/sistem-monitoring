<x-apps-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-slate-800 tracking-tight">
                {{ __('My Requests') }}
            </h2>
            <div class="bg-slate-200 px-4 py-2 rounded-xl border border-slate-300">
                <span class="text-xs font-black text-slate-950 uppercase tracking-widest">Active Queue: </span>
                <span class="text-sm font-black text-slate-900">{{ $readRequest->count() }}/3</span>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50/50 min-h-screen">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        <div class="flex justify-center w-full">
            
            <div class="w-full max-w-lg bg-white rounded-[32px] overflow-hidden shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100 transition-all duration-300 hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)]">
                
                <div class="h-40 w-full bg-[#0067A6] relative transition-colors duration-300">
                </div>

                <div class="px-8 pb-8 relative">
                    
                    <div class="absolute -top-12 left-8">
                        <div class="w-24 h-24 rounded-full border-[4px] border-white bg-slate-100 shadow-sm flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24"
                                fill="currentColor"
                                class="w-14 h-14 text-slate-500">
                                <path fill-rule="evenodd"
                                    d="M7.5 6a4.5 4.5 0 119 0 4.5 4.5 0 01-9 0zM3.751 20.105a8.25 8.25 0 0116.498 0 .75.75 0 01-.437.695A18.683 18.683 0 0112 22.5a18.683 18.683 0 01-7.812-1.7.75.75 0 01-.437-.695z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>

                    <div class="pt-16">
                        <h3 class="text-2xl font-bold text-slate-900 tracking-tight">{{ auth()->user()->nama_mahasiswa }}</h3>
                        <p class="text-base font-medium text-slate-500 mt-1">{{ auth()->user()->nrp }}</p>
                    </div>

                    <div class="flex items-center gap-4 mt-8">
                        <a href="{{ route('mahasiswa.request.mahasiswa') }}" class="px-5 py-3 bg-slate-900 hover:bg-slate-800 text-white text-sm font-bold rounded-xl transition-all duration-300 shadow-sm active:scale-95 flex-1 text-center">
                            Add Request
                        </a>
                    </div>

                </div>
            </div>

        </div>

    </div>
</div>
</x-apps-layout>