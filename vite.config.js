import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import os from 'os';

function getLocalIPv4() {
    const interfaces = os.networkInterfaces();

    for (const name of Object.keys(interfaces)) {
        for (const iface of interfaces[name] ?? []) {
            if (iface.family === 'IPv4' && !iface.internal) {
                return iface.address;
            }
        }
    }

    return '127.0.0.1';
}

const activeIP = getLocalIPv4();

console.log(`

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
        host: '0.0.0.0',
        port: 5173,
        strictPort: true,

        hmr: {
            host: activeIP,
        },

        cors: true,
    },
});