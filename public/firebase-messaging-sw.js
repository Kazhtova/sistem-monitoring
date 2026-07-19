importScripts('https://www.gstatic.com/firebasejs/10.8.0/firebase-app-compat.js');
importScripts('https://www.gstatic.com/firebasejs/10.8.0/firebase-messaging-compat.js');

const firebaseConfig = {
    apiKey: "AIzaSyAuV6NPZC8rReZ6Ih-fO8XY-5Lf_aUWoN4",
    authDomain: "monitoring-sistem-a7dcc.firebaseapp.com",
    projectId: "monitoring-sistem-a7dcc",
    storageBucket: "monitoring-sistem-a7dcc.firebasestorage.app",
    messagingSenderId: "695086798991",
    appId: "1:695086798991:web:56ed5bb920c7c4382578fa",
    measurementId: "G-JZSDBXYB6E"
};

firebase.initializeApp(firebaseConfig);
const messaging = firebase.messaging();

messaging.onBackgroundMessage((payload) => {
    console.log('[SW] Background message:', payload);

    const notificationTitle = payload.notification?.title
                           || payload.data?.title
                           || "Notifikasi Baru";

    const notificationOptions = {
        body:    payload.notification?.body || payload.data?.body || "",
        icon:    '/favicon.ico',
        badge:   '/favicon.ico',
        vibrate: [200, 100, 200],
        tag:     payload.data?.type || 'default', 
        data: {
            url: '/mahasiswa/dashboard-mahasiswa',
            ...payload.data
        }
    };

    return self.registration.showNotification(notificationTitle, notificationOptions);
});

self.addEventListener('notificationclick', (event) => {
    event.notification.close();
    const targetUrl = event.notification.data?.url || '/';

    event.waitUntil(
        clients.matchAll({ type: 'window', includeUncontrolled: true })
            .then((clientList) => {
                for (const client of clientList) {
                    if (client.url.includes(targetUrl) && 'focus' in client) {
                        return client.focus();
                    }
                }
                if (clients.openWindow) {
                    return clients.openWindow(targetUrl);
                }
            })
    );
});