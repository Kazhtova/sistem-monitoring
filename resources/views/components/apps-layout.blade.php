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
        {{-- <script src="https://cdn.jsdelivr.net/npm/eruda"></script>
        <script>eruda.init();</script> --}}
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigations')

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
        
<script src="//cdn.jsdelivr.net/npm/eruda"></script>
<script>eruda.init();</script>
        <script type="module">
    import { initializeApp } from "https://www.gstatic.com/firebasejs/10.8.0/firebase-app.js";
    import { getMessaging, getToken, onMessage } from "https://www.gstatic.com/firebasejs/10.8.0/firebase-messaging.js";

    const firebaseConfig = {
        apiKey: "AIzaSyAuV6NPZC8rReZ6Ih-fO8XY-5Lf_aUWoN4",
        authDomain: "monitoring-sistem-a7dcc.firebaseapp.com",
        projectId: "monitoring-sistem-a7dcc",
        storageBucket: "monitoring-sistem-a7dcc.firebasestorage.app",
        messagingSenderId: "695086798991",
        appId: "1:695086798991:web:56ed5bb920c7c4382578fa",
        measurementId: "G-JZSDBXYB6E"
    };

    const app = initializeApp(firebaseConfig);
    const messaging = getMessaging(app);

    if ('Notification' in window) {
        Notification.requestPermission().then((permission) => {
            if (permission !== 'granted') return;

            navigator.serviceWorker.register('/firebase-messaging-sw.js')
                .then((registration) => {
                    setTimeout(() => {
                        getToken(messaging, {
                            vapidKey: 'BMlMQ83fonoc5_BfqVW-3UtZ0X7qQOWdMmDrVV-wG6ZoKEEvRkjkg-TygC1zPVzw1QT0xXazuPhyuJTO77mLCVI',
                            serviceWorkerRegistration: registration
                        })
                        .then((currentToken) => {
                            if (!currentToken) return console.warn('Token kosong');

                            // ✅ Ambil CSRF dari meta tag, bukan dari Blade di dalam SW
                            const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                            fetch('/mahasiswa/update-fcm-token', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': csrf // ✅ Benar
                                },
                                body: JSON.stringify({ fcm_token: currentToken })
                            })
                            .then(res => res.json())
                            .then(data => console.log('Token tersimpan:', data.message))
                            .catch(err => console.error('Gagal simpan token:', err));
                        })
                        .catch(err => console.error('getToken error:', err));
                    }, 1000);
                })
                .catch(err => console.error('SW gagal register:', err));
        });
    }

    // ✅ TAMBAHAN: Handler notifikasi saat app sedang terbuka (foreground)
    onMessage(messaging, (payload) => {
        console.log('[Foreground] Pesan masuk:', payload);
        const title = payload.notification?.title || 'Notifikasi';
        const body  = payload.notification?.body  || '';
        new Notification(title, { body, icon: '/favicon.ico' });
    });
</script>
    </body>
</html>
