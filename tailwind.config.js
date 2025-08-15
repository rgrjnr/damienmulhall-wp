/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './*.php',
    './parts/**/*.php',
    './custom-posts/**/*.php',
    './assets/ts/**/*.ts',
    './assets/js/**/*.js',
  ],
  theme: {
    extend: {
      colors: {
        primary: '#f300c2',
        'primary-dark': '#af078d',
      },
      fontFamily: {
        sans: [
          'system-ui',
          '-apple-system',
          'BlinkMacSystemFont',
          'Segoe UI',
          'Roboto',
          'Helvetica Neue',
          'Arial',
          'sans-serif',
        ],
      },
    },
  },
  plugins: [],
};
