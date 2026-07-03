<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    @php

                    $teknisi = Auth::guard('teknisi')->check();

                    $dashboardRequestUrl = $teknisi ? route('teknisi.dashboard.request') : route('teknisi.dashboard.request');

                    $routeRequest = $teknisi ? 'teknisi.dashboard.request' : 'teknisi.dashboard.request';

                    $requestAcceptUrl = $teknisi ? route('teknisi.dashboard.accept') : route('teknisi.dashboard.accept');

                    $routeAccept = $teknisi ? 'teknisi.dashboard.accept' : 'teknisi.dashboard.accept';

                    $routeActivity = $teknisi ? 'teknisi.dashboard.activity' : 'teknisi.dashboard.activity';

                    $activityDashboardUrl = $teknisi ? route('teknisi.dashboard.activity') : route('teknisi.dashboard.activity');

                    $routeDashboardPc = $teknisi ? 'teknisi.dashboard.pc_list' : 'teknisi.dashboard.pc_list';

                    $pcListUrl = $teknisi ? route('teknisi.dashboard.pc_list') : route('teknisi.dashboard.pc_list');

                    $user = $teknisi ? Auth::guard('teknisi')->user() : Auth::guard('mahasiswa')->user();

                    $name = $teknisi ? $user->nama_teknisi : $user->nama_mahasiswa;

                    $jumlahPending = $teknisi ? \App\Models\Request::where('status', 'pending')->count() : 0;

                    @endphp
                    <a href="{{ $dashboardRequestUrl }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="$dashboardRequestUrl" :active="request()->routeIs($routeRequest)">
                        <span>{{ __('Request List') }}</span>
                        <span id="nav-counter-mobile" 
                            class="bg-slate-500 text-white text-[10px] ml-1 font-bold px-2 py-0.5 rounded-full {{ request()->routeIs($routeRequest) || session('has_opened_request_list') || $jumlahPending == 0 ? 'hidden' : '' }}">
                            {{ $jumlahPending }}
                        </span>
                    </x-nav-link>
                </div>
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="$requestAcceptUrl" :active="request()->routeIs($routeAccept)">
                        {{ __('Accept List') }}
                    </x-nav-link>
                </div>
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="$activityDashboardUrl" :active="request()->routeIs($routeActivity)">
                        {{ __('Dashboard Activity') }}
                    </x-nav-link>
                </div>
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="$pcListUrl" :active="request()->routeIs($routeDashboardPc)">
                        {{ __('Dashboard PC') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ $name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            
            <x-responsive-nav-link :href="$dashboardRequestUrl" :active="request()->routeIs($routeRequest)">
                {{ __('Request List') }}
                <span class="bg-slate-800 text-white text-[10px] ml-1 font-bold px-2 py-0.5 rounded-full inline-block {{ request()->routeIs($routeRequest) || session('has_opened_request_list') || $jumlahPending == 0 ? 'hidden' : '' }}">
                    {{ $jumlahPending }}
                </span>
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="$requestAcceptUrl" :active="request()->routeIs($routeAccept)">
                {{ __('Accept List') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="$activityDashboardUrl" :active="request()->routeIs($routeActivity)">
                {{ __('Dashboard Activity') }}
            </x-responsive-nav-link>

        </div>

        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ $name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ $teknisi ? 'Teknisi' : $user->nrp }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link>
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
