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
        'dm-black': '#201a1e',
        'dm-cyan': '#33a199',
        'dm-white': '#e1dfd0',
        'dm-purple': '#85316d',
        'dm-red': '#bf4c31',
        'dm-green': '#68882a',
        'dm-yellow': '#e3bf30',
      },
      fontFamily: {
        'haas-display': ['Neue Haas Grotesk Display Pro', 'sans-serif'],
        'haas-text': ['Neue Haas Grotesk Text Pro', 'sans-serif'],
      },
      maxWidth: {
        'page': '1120px',
      },
      fontSize: {
        'display-xl': '84px',
        'display-lg': '67.714px',
        'display-md': '62px',
        'display-sm': '40.5px',
        'heading-lg': '36px',
        'heading-md': '34px',
        'heading-sm': '27px',
        'heading-xs': '24px',
        'body-lg': '18px',
        'body-md': '16px',
        'body-sm': '14px',
      },
      spacing: {
        'section': '96px',
        'content': '72px',
        'card': '48px',
      },
    },
  },
  plugins: [],
};
