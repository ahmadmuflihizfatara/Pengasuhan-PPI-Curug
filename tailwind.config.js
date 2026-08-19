import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', 'Plus Jakarta Sans', 'Figtree', ...defaultTheme.fontFamily.sans],
                serif: ['Instrument Serif', 'Playfair Display', 'Merriweather', ...defaultTheme.fontFamily.serif],
                mono: ['JetBrains Mono', 'Fira Code', ...defaultTheme.fontFamily.mono],
            },
            boxShadow: {
                'glass-sm': '0 4px 16px 0 rgba(0, 0, 0, 0.08)',
                'glass': '0 8px 32px 0 rgba(0, 0, 0, 0.15)',
                'glass-lg': '0 16px 48px 0 rgba(0, 0, 0, 0.22)',
                'glass-pill': '0 6px 20px -2px rgba(0, 0, 0, 0.2)',
                'workspace': '0 25px 50px -12px rgba(0, 0, 0, 0.35)',
            },
            backdropBlur: {
                'xs': '2px',
                '2xl': '24px',
                '3xl': '32px',
            },
        },
    },

    plugins: [forms],
};

