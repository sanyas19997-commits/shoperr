import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/shop.css',
                'resources/js/shop.js',
                'resources/js/admin/main.js',
                'resources/css/admin.css',
            ],
            refresh: true,
        }),
        vue({
            template: { transformAssetUrls: { base: null, includeAbsolute: false } },
        }),
    ],
});
