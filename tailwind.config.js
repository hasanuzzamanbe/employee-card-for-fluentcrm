import('tailwindcss').Config
module.exports = {
    content: [
        'employee-card.php',
        './public/**/*.html',
        './views/**/*.php',
        './src/**/*.{vue,js,ts,jsx,tsx}'
    ],
    theme: {
        extend: {},
    },
    plugins: [],
}
