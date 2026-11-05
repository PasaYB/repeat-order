import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Outfit', ...defaultTheme.fontFamily.sans],
                xmind: ['Xmind', 'sans-serif'],
                playwrite: ['Playwrite IT Trad', 'sans-serif'],
            },
            colors: {
                shopee: '#EE5001',
                acidlime: '#C8FD03'
        },
        },
    },

    plugins: [forms],
};
