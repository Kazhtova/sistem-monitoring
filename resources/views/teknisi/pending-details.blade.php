<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-slate-900 tracking-tight">
                {{ __('Details - Pending Request') }}
            </h2>
            <a href="{{ route('teknisi.dashboard.request') }}" 
               class="inline-flex items-center px-4 bg-white rounded-xl shadow-sm border border-gray-200 hover:border-slate-300 hover:bg-slate-50 text-sm font-bold text-gray-600 hover:text-slate-600 transition-all duration-300 group">
                <svg class="w-4 h-8 mr-2 text-gray-400 group-hover:text-slate-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back
            </a>
        </div>
    </x-slot>

</x-app-layout>