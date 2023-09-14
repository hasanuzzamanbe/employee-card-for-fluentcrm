import('tailwindcss').Config
module.exports = {
    content: [
        './public/**/*.html',
        './views/**/*.php',
        './src/**/*.{vue,js,ts,jsx,tsx}'
    ],
    theme: {
        extend: {},
    },
    plugins: [],
}
