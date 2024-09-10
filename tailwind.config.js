/** @type {import('tailwindcss').Config} */
export const mode = 'jit';
export const content = ['./public/**/*.{html,js,php}', './src/Views/**/*.{html,php}'];
export const theme = {
  extend: {
    keyframes: {
      slideIn: {
        '0%': {
          transform: 'translateX(-100%)',
        },
        '100%': {
          transform: 'translateX(0)',
        },
      },
      slideOut: {
        '0%': {
          transform: 'translateX(0)',
        },
        '100%': {
          transform: 'translateX(-100%)',
        },
      },
    },
    animation: {
      slideIn: 'slideIn 0.5s ease-in-out',
      slideOut: 'slideOut 0.5s ease-in-out',
    },
  },
};
export const plugins = [];
