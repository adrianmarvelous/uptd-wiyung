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
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                brand: {
                    50: '#eef4ff',
                    100: '#d9e6ff',
                    200: '#bcd3ff',
                    300: '#8eb4ff',
                    400: '#598cff',
                    500: '#2f66f5',
                    600: '#1a49db',
                    700: '#1536b0',
                    800: '#152f8b',
                    900: '#0d2363',
                },
                accent: {
                    400: '#ffd64d',
                    500: '#f7c325',
                    600: '#dda712',
                },
            },
        },
    },

    plugins: [forms],
};
