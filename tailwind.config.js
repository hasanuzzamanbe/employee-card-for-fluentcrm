import('tailwindcss').Config
module.exports = {
    content: [
        'employee-card.php',
        './public/**/*.html',
        './src/**/*.{vue,js,ts,jsx,tsx}',
    ],
    theme: {
        extend: {},
    },
    plugins: [],
}
