<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link rel="icon" href="{{ asset('images/M.svg') }}" type="image/svg+xml">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

    <script type="module">
    document.addEventListener('DOMContentLoaded', function () {
        const container = document.getElementById('request-container');
        const badgeDesktop = document.getElementById('nav-counter');
        const badgeMobile = document.getElementById('nav-counter-mobile');

        if (container) {
            localStorage.setItem('has_opened_request_list', 'true');
            if (badgeDesktop) { badgeDesktop.innerText = '0'; badgeDesktop.classList.add('hidden'); }
            if (badgeMobile) { badgeMobile.innerText = '0'; badgeMobile.classList.add('hidden'); }
        } else {
            const hasOpened = localStorage.getItem('has_opened_request_list');
            if (hasOpened === 'true') {
                if (badgeDesktop) { badgeDesktop.innerText = '0'; badgeDesktop.classList.add('hidden'); }
                if (badgeMobile) { badgeMobile.innerText = '0'; badgeMobile.classList.add('hidden'); }
            }
        }

        let currentTeknisiId = "{{ auth()->guard('teknisi')->id() }}";

        if (window.Echo && currentTeknisiId) {
            window.Echo.private('teknisi.' + currentTeknisiId)
                .listen('.request.new', (e) => {
                    const data = e.requestData;
                    const id = data.id_request;

                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            title: 'Request Baru!',
                            text: `Dari: ${data.mahasiswa?.nama || 'Mahasiswa'}`,
                            icon: 'info',
                            toast: true,
                            position: 'top',
                            showConfirmButton: false,
                            timer: 5000,
                            timerProgressBar: true
                        });
                    }

                    const acceptUrl = `/monlab/teknisi/request-list/accept/${id}`; 
                    const rejectUrl = `/monlab/teknisi/request-list/reject/${id}`;
                    const detailsUrl = `/monlab/teknisi/pending/list/${id}`;

                    let tbody = document.getElementById('request-table-body');
                    let emptyRow = document.getElementById('empty-state-row');

                    if (tbody) {
                        if (emptyRow) emptyRow.remove();

                        let csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
                        let tr = document.createElement('tr');
                        tr.className = "hover:bg-gray-50/50 transition-colors duration-150 animate-pulse";
                        tr.innerHTML = `
                            <td class="py-4 px-6 text-sm font-medium text-gray-400">New</td>
                            <td class="py-4 px-6">
                                <div class="flex flex-col">
                                    <span class="text-sm font-bold text-gray-900">${data.mahasiswa?.nama || 'N/A'}</span>
                                </div>
                            </td>
                            <td class="py-4 px-6 text-sm font-medium text-gray-600">${data.komputer?.nama_komputer || 'N/A'}</td>
                            <td class="py-4 px-6 text-sm font-medium text-gray-600">${data.laboratorium?.nama_lab || 'N/A'}</td>
                            <td class="py-4 px-6">
                                <div class="flex items-center justify-center gap-2">
                                    <form action="${rejectUrl}" method="POST" class="m-0">
                                        <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]').content}">
                                        <input type="hidden" name="_method" value="PATCH">
                                        <button type="submit" class="px-4 py-1.5 text-xs font-semibold text-red-600 bg-transparent border border-red-300 rounded-md hover:bg-red-100 hover:border-red-400 transition-colors duration-200">Tolak</button>
                                    </form>
                                    <form action="${acceptUrl}" method="POST" class="m-0">
                                        <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]').content}">
                                        <input type="hidden" name="_method" value="PATCH">
                                        <button type="submit" class="px-4 py-1.5 text-xs font-semibold text-white bg-slate-700 border border-transparent rounded-md hover:bg-slate-900 transition-colors duration-200 shadow-sm">Setujui</button>
                                    </form>
                                    <a href="${detailsUrl}" 
                                        class="inline-block px-4 py-1.5 text-xs font-semibold text-violet-600 bg-transparent border border-violet-200 rounded-md hover:bg-violet-100 hover:border-violet-300 transition-colors duration-200 text-center">
                                        Details
                                    </a>
                                </div>
                            </td>
                        `;
                        tbody.prepend(tr);
                        setTimeout(() => tr.classList.remove('animate-pulse'), 2500);
                    } 
                    else {
                        localStorage.setItem('has_opened_request_list', 'false');
                        
                        if (badgeDesktop) {
                            let currentCount = parseInt(badgeDesktop.innerText) || 0;
                            badgeDesktop.innerText = currentCount + 1;
                            badgeDesktop.classList.remove('hidden');
                        }
                        if (badgeMobile) {
                            let currentCount = parseInt(badgeMobile.innerText) || 0;
                            badgeMobile.innerText = currentCount + 1;
                            badgeMobile.classList.remove('hidden');
                        }
                    }
                });
        }
    });
</script>

    <style>
        @keyframes fadeIn { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }
        .animate-fade-in { animation: fadeIn 0.5s ease-out forwards; }
    </style>

    </body>
</html>
