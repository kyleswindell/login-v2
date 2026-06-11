import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss(),
    ],
    server: {
        allowedHosts: ['localhost', '127.0.0.1', 'host.docker.internal', 'node'],
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});
