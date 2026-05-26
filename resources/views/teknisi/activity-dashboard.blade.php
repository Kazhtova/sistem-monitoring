<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-black text-2xl text-gray-900 tracking-tight">
                    {{ __('Activity Tracker') }}
                </h2>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50/50 min-h-screen">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-8 sm:p-10">
                
                <div class="flow-root">
                    <ul role="list" class="-mb-8">
                        @forelse($logs as $log)
                            <li>
                                <div class="relative pb-8">
                                    @if (!$loop->last)
                                        <span class="absolute top-5 left-5 -ml-px h-full w-0.5 bg-gray-100" aria-hidden="true"></span>
                                    @endif
                                    
                                    <div class="relative flex items-start space-x-4">
                                        <div class="relative">
                                            <span class="h-10 w-10 rounded-full flex items-center justify-center ring-8 ring-white transition-colors duration-300
                                                {{ $log->action == 'EXTEND_TIME' ? 'bg-violet-50 text-violet-600' : '' }}
                                                {{ $log->action == 'CREATE' || $log->action == 'CREATE_REQUEST' ? 'bg-emerald-50 text-emerald-600' : '' }}
                                                {{ $log->action == 'CANCEL' || $log->action == 'REJECT_REQUEST' ? 'bg-red-50 text-red-600' : '' }}
                                                {{ $log->action == 'UPLOAD_PHOTO' ? 'bg-blue-50 text-blue-600' : '' }}
                                                {{ $log->action == 'ACCEPT_REQUEST' ? 'bg-indigo-50 text-indigo-600' : '' }}
                                                {{ $log->action == 'COMPLETE_REQUEST' ? 'bg-emerald-50 text-emerald-600' : '' }}
                                                {{ !in_array($log->action, ['EXTEND_TIME', 'CREATE', 'CREATE_REQUEST', 'CANCEL', 'UPLOAD_PHOTO', 'ACCEPT_REQUEST', 'COMPLETE_REQUEST', 'REJECT_REQUEST']) ? 'bg-gray-50 text-gray-500' : '' }}">
                                                
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            </span>
                                        </div>
                                        
                                        <div class="min-w-0 flex-1 pt-1.5 flex justify-between gap-4">
                                            <div class="min-w-0 flex-1">
                                                <p class="text-sm text-gray-800 font-medium leading-relaxed">
                                                    <span class="font-bold text-gray-700 bg-gray-100/80 px-2.5 py-1 rounded-md text-[10px] mr-2 uppercase tracking-widest border border-gray-200/50 shadow-sm">{{ $log->action }}</span> 
                                                    {{ $log->description }}
                                                </p>
                                                
                                                <div class="mt-2 flex items-center gap-3 text-xs text-gray-400 font-medium">
                                                    <span class="flex items-center gap-1.5">
                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                                        <span class="text-gray-600">{{ $log->causer_name }}</span>
                                                    </span>
                                                    <span class="w-1 h-1 bg-gray-300 rounded-full"></span>
                                                    <span class="flex items-center gap-1.5" translate="no">
                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path></svg>
                                                        <span class="font-mono">{{ $log->ip_address }}</span>
                                                    </span>
                                                </div>

                                                @if($log->properties)
                                                    <div class="mt-3 bg-gray-50/80 p-4 rounded-2xl border border-gray-100 text-xs font-mono max-w-2xl text-gray-600 shadow-inner">
                                                        @if(isset($log->properties['waktu_lama']))
                                                            <div class="flex items-center gap-2 text-red-600/90 mb-1" translate="no">
                                                                <span class="font-black bg-red-100 px-1.5 rounded">- Old:</span> 
                                                                {{ \Carbon\Carbon::parse($log->properties['waktu_lama'])->format('d M, H:i') }}
                                                            </div>
                                                            <div class="flex items-center gap-2 text-emerald-600/90" translate="no">
                                                                <span class="font-black bg-emerald-100 px-1.5 rounded">+ New:</span> 
                                                                {{ \Carbon\Carbon::parse($log->properties['waktu_baru'])->format('d M, H:i') }}
                                                            </div>
                                                        @else
                                                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-2 gap-x-4">
                                                                @foreach(is_string($log->properties) ? json_decode($log->properties, true) : $log->properties as $key => $value)
                                                                    <div class="flex items-start gap-2">
                                                                        <span class="font-bold text-gray-500 capitalize">{{ str_replace('_', ' ', $key) }}:</span>
                                                                        <span class="text-gray-800 break-all">{{ is_array($value) ? json_encode($value) : $value ?? 'N/A' }}</span>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        @endif
                                                    </div>
                                                @endif
                                            </div>
                                            
                                            <div translate="no" class="text-right text-xs whitespace-nowrap tabular-nums pt-1 flex-shrink-0 w-[130px]">
                                                <span class="block text-gray-900 font-bold">{{ $log->created_at->diffForHumans() }}</span>
                                                <span class="block text-[11px] text-gray-400 font-medium mt-0.5 tracking-wide">
                                                    {{ $log->created_at->format('d M Y, H:i') }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @empty
                            <li class="text-center py-10 text-gray-400 font-medium">
                                Belum ada aktivitas yang terekam.
                            </li>
                        @endforelse
                    </ul>
                </div>

                <div class="mt-10 pt-6">
                    {{ $logs->links() }}
                </div>

            </div>
        </div>
    </div>
</x-app-layout>