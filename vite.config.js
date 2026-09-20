import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';
import path from 'path';

export default defineConfig({
    server: {
        host: '127.0.0.1',
        port: 5175,
        strictPort: false, // Forzamos a que use el 5175 sí o sí ahora que lo liberamos
        cors: true,
        https: false, // Vite corre en HTTP plano localmente
        hmr: {
            host: '127.0.0.1',
            hmr: false,
        },
        watch: {
            // ✅ Ignorar cambios en archivos PHP
            ignored: [
                '**/*.php',           // Ignorar TODOS los PHP
                '**/app/**',          // Ignorar toda la carpeta app
                '**/storage/**',
                '**/vendor/**',
            ],
        },
    },

    plugins: [
        tailwindcss(),
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/css/app_web.css',
                'resources/js/app_web.js',
            ],
            refresh: false,
        }),
    ],
    base: '/build/',
    optimizeDeps: {
        include: [
            "jquery",
            "jquery-ui",
            "jquery-validation",
            "lucide",
            "toastr"
        ],
    },

    resolve: {
        alias: {
            '~jquery': path.resolve(__dirname, 'node_modules/jquery'),
            'jquery-ui': path.resolve(__dirname, 'node_modules/jquery-ui'),
            'jquery-validation': path.resolve(__dirname, 'node_modules/jquery-validation'),
        }
    },

    build: {
        outDir: 'public/build',
        rollupOptions: {
            output: {
                manualChunks: {
                    vendor: ['jquery', 'jquery-ui', 'jquery-validation', 'toastr'],
                }
            }
        }
    }
});