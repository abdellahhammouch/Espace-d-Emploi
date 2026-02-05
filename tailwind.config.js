import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

export default {
  content: [
    './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
    './storage/framework/views/*.php',
    './resources/views/**/*.blade.php',
  ],
  theme: {
    extend: {
      colors: {
        primary: '#137fec',
        'navy-deep': '#0f172a',
        'background-light': '#f6f7f8',
        'background-dark': '#101922',
        'emerald-accent': '#10b981',
        ink: '#111418',
        muted: '#617589',
      },
      fontFamily: {
        sans: ['Inter', ...defaultTheme.fontFamily.sans],
        display: ['Inter', ...defaultTheme.fontFamily.sans],
      },
      boxShadow: {
        soft: '0 10px 30px rgba(15,23,42,0.08)',
      },
    },
  },
  plugins: [forms],
};
