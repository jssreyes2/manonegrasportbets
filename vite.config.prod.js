import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import inject from "@rollup/plugin-inject";
import path from 'path';

export default defineConfig({

    server: {
        host: 'localhost',
    },

    plugins: [
        laravel({
            input: [
                'resources/css/app.css',     // Backend CSS
                'resources/js/app.js',       // Backend JS
                'resources/css/app_web.css', // Web Pública CSS
                'resources/js/app_web.js',   // Web Pública JS
            ],
            refresh: false,
        }),
        inject({
            $: 'jquery',
            jQuery: 'jquery',
        }),
    ],
    resolve:{
        alias:{
            '~bootstrap': path.resolve(__dirname, 'node_modules/bootstrap'),
            '$':  'jQuery'
        },
    },
    optimizeDeps: {
        include: ['lodash'],
    },
});