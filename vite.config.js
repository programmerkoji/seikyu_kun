import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig(({ mode }) => {
    return {
        base: process.env.VITE_BASE_PATH || '/',
        plugins: [
            laravel({
                input: [
                    'resources/css/app.css',
                    'resources/js/app.js',
                    'resources/js/flatpickr.js',
                    'resources/js/autocomplete.js',
                    'resources/css/autocomplete.css',
                ],
                refresh: true,
            }),
        ],
    }
});
