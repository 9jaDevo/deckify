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
            colors: {
                primary: '#00FF94',
                secondary: '#2E8753',
                'bg-base': '#121212',
                'bg-surface': '#1A1A1A',
                'text-primary': '#F5F5F5',
                'text-secondary': '#C4C4C4',
                'text-muted': '#9CA3AF',
                'border-muted': '#2A2A2A',
                success: {
                    DEFAULT: '#2ECC71',
                    dark: '#27AE60',
                },
                error: {
                    DEFAULT: '#FF4D4F',
                    dark: '#D9363E',
                },
                warning: {
                    DEFAULT: '#F1C40F',
                    dark: '#D4AC0D',
                },
            },
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
                serif: ['Newsreader', ...defaultTheme.fontFamily.serif],
            },
        },
    },

    plugins: [forms],
};
