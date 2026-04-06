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
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
                heading: ['Avenir Next', 'Inter', ...defaultTheme.fontFamily.sans],
                body: ['Inter', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                prowise: {
                    navy: '#061B3A',
                    blue: '#3F79F2',
                    green: '#4CBF88',
                    coral: '#FC7158',
                    yellow: '#F2C94C',
                    gray: '#8A95A5',
                    softblue: '#B8C7E0',
                }
            },
        },
    },

    plugins: [forms],
};
