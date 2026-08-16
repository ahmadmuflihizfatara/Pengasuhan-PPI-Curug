import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import path from 'path';
import { fileURLToPath } from 'url';

const __filename = fileURLToPath(import.meta.url);
const __dirname = path.dirname(__filename);

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/sass/app.scss',
                'resources/js/app.js',
                'resources/assets/js/pages-account-settings-account.js',
                'resources/assets/js/ui-modals.js',
                'resources/assets/js/ui-toasts.js',
                'resources/assets/js/ui-popover.js',
            ],
            refresh: true,
        }),
    ],
    resolve: {
        alias: {
            '~coreui': path.resolve(__dirname, 'node_modules/@coreui/coreui'),
        }
    }
});