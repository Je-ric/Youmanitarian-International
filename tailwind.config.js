import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        "./resources/css/**/*.css",
        "./resources/js/**/*.js",
        "./resources/**/*.{blade.php,js,ts,vue}",
        "./vendor/flowbite/**/*.js",
        "./node_modules/flowbite/**/*.js"
        
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [
        forms, 
        typography, 
        require("daisyui"),
        require('flowbite/plugin'),
        // require('flowbite-typography'),
        require('@tailwindcss/typography'),
    ],

    daisyui: {
        themes: ["light", "dark", "cupcake"], 
    },
    
};
