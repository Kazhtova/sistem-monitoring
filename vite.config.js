import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import os from 'os';

function getLocalIPv4() {
    const interfaces = os.networkInterfaces();
    let fallbackIP = '127.0.0.1';

    for (const name of Object.keys(interfaces)) {
        for (const iface of interfaces[name] ?? []) {
            if (iface.family === 'IPv4' && !iface.internal) {
                // 🟢 OTOMATIS: Prioritaskan IP Wi-Fi asli (ITS/Home) & abaikan IP virtual virtualbox/wsl
                if (iface.address.startsWith('10.') || iface.address.startsWith('192.168.')) {
                    return iface.address;
                }
                fallbackIP = iface.address;
            }
        }
    }

    return fallbackIP;
}

const activeIP = getLocalIPv4();

console.log(`
🚀 [Vite Auto IP] Berhasil mengunci IP Jaringan Asli:
Local   : http://localhost:5173
Network : http://${activeIP}:5173
`);

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],

    server: {
        host: '0.0.0.0', // Membuka akses jaringan
        port: 5173,
        strictPort: true,

        hmr: {
            host: activeIP, // 🟢 Otomatis mendistribusikan IP Wi-Fi asli ke HP
        },

        cors: true,
    },
});