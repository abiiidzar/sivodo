import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'navy': '#1a2744',
                'navy-light': '#2e4a8a',
                'gold': '#c9a227',
                'gold-light': '#f0d060',
                'gold-10': 'rgba(201,162,39,0.10)',
                'gold-15': 'rgba(201,162,39,0.15)',
                'gold-20': 'rgba(201,162,39,0.20)',
                'gold-25': 'rgba(201,162,39,0.25)',
                'krem': '#f5f3ef',
                'blue-muda': '#bfdbfe',
                'silver': '#9ca3af',
                'bronze': '#cd7f32',
                'emerald-50': '#ecfdf5',
                'emerald-200': '#a7f3d0',
                'emerald-700': '#065f46',
                'gray-input': '#eef0f5',
            },
            backgroundImage: {
                'gradient-navy': 'linear-gradient(135deg, #1a2744 0%, #2e4a8a 50%, #1a2744 100%)',
                'gradient-gold': 'linear-gradient(90deg, #c9a227 0%, #f0d060 100%)',
                'gradient-login': 'linear-gradient(135deg, #1a2744 0%, #2e4a8a 100%)',
            },
        },
    },

    plugins: [forms],
};
