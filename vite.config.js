import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({

    plugins: [
        laravel({
            input: [
                'resources/css/site.css',
                'resources/js/site.js'
            ],
            refresh: [
                'resources/**/*.antlers.html',
                'resources/**/*.blade.php',
                'resources/**/*.vue',
                'resources/**/*.yaml',
                'resources/**/*.css',
                'resources/**/*.js',
                'content/**/*.md'
            ],
        }),
        tailwindcss(),
    ],
});
