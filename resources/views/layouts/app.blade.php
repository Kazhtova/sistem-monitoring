<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
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
        } 
        else {
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
                            text: `Dari: ${data.mahasiswa?.nama_mahasiswa || 'Mahasiswa'}`,
                            icon: 'info',
                            toast: true,
                            position: 'top',
                            showConfirmButton: false,
                            timer: 5000,
                            timerProgressBar: true
                        });
                    }

                    const acceptUrl = `/teknisi/request-list/accept/${id}`; 
                    const rejectUrl = `/teknisi/request-list/reject/${id}`;
                    
                    const formatTgl = (dateString) => {
                        if(!dateString) return '-';
                        const d = new Date(dateString);
                        return d.toLocaleDateString('id-ID', { day: '2-digit', month: 'short', hour: '2-digit', minute: '2-digit' }).replace('.', ':');
                    };

                    localStorage.removeItem('has_opened_request_list');

                    if (container) {
                        const newCardHtml = `
                            <div class="bg-white rounded-3xl shadow-sm border-2 border-indigo-500 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col overflow-hidden animate-fade-in group">
                                    <div class="p-6 flex flex-col flex-grow">
                                        
                                        <div class="flex justify-between items-center mb-5 pb-4 border-b border-gray-50">
                                            <span class="bg-indigo-100 text-indigo-700 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest">
                                                NEW
                                            </span>
                                            <span class="text-[10px] uppercase font-bold tracking-wider text-gray-800 bg-gray-50 px-2 py-1 rounded">
                                                Baru Saja
                                            </span>
                                        </div>

                                        <div class="mb-5">
                                            <h3 class="text-lg font-bold text-gray-900 leading-tight mb-1">Student: ${data.mahasiswa?.nama_mahasiswa || 'Mahasiswa'}</h3>
                                            <p class="text-sm text-violet-950 font-medium">Dosen: ${data.dosen_ta}</p>
                                            <h4 class="text-lg font-bold text-gray-900 leading-tight mt-1">PC: Komputer ${data.id_komputer}</h4>
                                        </div>

                                        <div class="grid grid-cols-2 gap-4 mb-6">
                                            <div class="bg-gray-50 p-3 rounded-2xl">
                                                <p class="text-[10px] uppercase font-bold text-gray-400 mb-1">Software</p>
                                                <p class="text-sm font-bold text-gray-800 truncate">${data.software}</p>
                                            </div>
                                            <div class="bg-gray-50 p-3 rounded-2xl">
                                                <p class="text-[10px] uppercase font-bold text-gray-400 mb-1">No Telp</p>
                                                <p class="text-sm font-bold text-gray-800">${data.no_hp}</p>
                                            </div>
                                        </div>

                                        <div class="space-y-2 border-l-2 border-indigo-100 pl-4 mb-8">
                                            <div class="flex items-center gap-2">
                                                <span class="w-2 h-2 rounded-full bg-green-500"></span>
                                                <p class="text-sm text-gray-600"><span class="font-bold">Start:</span> ${formatTgl(data.tanggal_mulai)}</p>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <span class="w-2 h-2 rounded-full bg-red-500"></span>
                                                <p class="text-sm text-gray-600"><span class="font-bold">End:</span> ${formatTgl(data.perkiraan_selesai)}</p>
                                            </div>
                                        </div>

                                        <div class="mt-auto flex gap-3">
                                            <form action="${rejectUrl}" method="POST" class="flex-1">
                                                <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]').content}">
                                                <input type="hidden" name="_method" value="PATCH">
                                                <button type="submit" class="w-full bg-white border-2 border-red-500 text-red-500 hover:bg-red-500 hover:text-white font-bold py-2.5 rounded-xl transition duration-200 text-sm">
                                                    Tolak
                                                </button>
                                            </form>
                                            <form action="${acceptUrl}" method="POST" class="flex-1">
                                                <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]').content}">
                                                <input type="hidden" name="_method" value="PATCH">
                                                <button type="submit" class="w-full bg-violet-700 hover:bg-violet-900 text-white font-bold py-2.5 rounded-xl transition duration-200 shadow-lg shadow-indigo-100 text-sm">
                                                    Setujui
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                        `;
                        container.insertAdjacentHTML('afterbegin', newCardHtml);

                        const currentCards = container.querySelectorAll('.bg-white.rounded-3xl');
                        if (currentCards.length > 2) {
                            currentCards[currentCards.length - 1].remove();
                        }
                    } else {
                        const hasOpened = localStorage.getItem('has_opened_request_list');
                        if (hasOpened !== 'true') {
                            if (badgeDesktop) {
                                let count = parseInt(badgeDesktop.innerText) || 0;
                                count += 1;
                                badgeDesktop.innerText = count;
                                badgeDesktop.classList.remove('hidden');
                            }
                            if (badgeMobile) {
                                let count = parseInt(badgeMobile.innerText) || 0;
                                count += 1;
                                badgeMobile.innerText = count;
                                badgeMobile.classList.remove('hidden');
                            }
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
