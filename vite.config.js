import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/sass/app.scss', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    build: {
        outDir: 'public/build',
        manifest: true,
        rollupOptions: {
            input: {
                app: 'resources/js/app.js',
                sass: 'resources/sass/app.scss',
            },
            output: {
                entryFileNames: '[name].js',
                chunkFileNames: 'js/[name].js',
                assetFileNames: '[name].[ext]',
                manualChunks: undefined,
            },
        },
    },
});
