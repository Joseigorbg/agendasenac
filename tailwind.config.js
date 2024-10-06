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
                senacOrange: '#f37021', // Cor laranja
                senacBlue: '#004481',   // Cor azul
            },
            backgroundImage: {
                'fundo': "url('/img/fundo.png')", // Caminho relativo da imagem
            },
        },
    },

    plugins: [forms],
};
