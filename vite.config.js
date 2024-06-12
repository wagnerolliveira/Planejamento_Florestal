import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import path from 'path';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/fonts/materialdesignicons.css',
                'resources/css/layout_dashboard.css',
                'resources/css/home.css',
                'resources/css/auth.css',
                'resources/sass/app.scss',
                'resources/js/app.js',
                'resources/js/home.js',
                'resources/js/auth/auth.js',
                'resources/js/scripts.js',
                'resources/css/job.css',
                'resources/css/restrictions.css',
                'resources/css/zones.css'
            ],
            refresh: true,
        }),
    ],
    resolve:{
        alias:{
            '~bootstrap': path.resolve(__dirname, 'node_modules/bootstrap')
        }
    }
});