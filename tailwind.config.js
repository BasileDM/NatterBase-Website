/** @type {import('tailwindcss').Config} */
export const mode = 'jit';
export const content = ['./public/**/*.{html,js,php}', './src/Views/**/*.{html,php}'];
export const theme = {
  extend: {
    fontFamily: {
      poppins: ['Poppins', 'sans-serif'],
    },
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
      toastSlideIn: {
        '0%': {
          transform: 'translateX(100%)',
        },
        '100%': {
          transform: 'translateX(0)',
        },
      },
      toastSlideOut: {
        '0%': {
          transform: 'translateX(0)',
        },
        '100%': {
          transform: 'translateX(150%)',
        },
      },
      'modal-open': {
        '0%': { opacity: '0', transform: 'translateY(-20px) scale(0.95)' },
        '100%': { opacity: '1', transform: 'translateY(0) scale(1)' },
      },
      'modal-close': {
        '0%': { opacity: '1', transform: 'translateY(0) scale(1)' },
        '100%': { opacity: '0', transform: 'translateY(-20px) scale(0.95)' },
      },
    },
    animation: {
      slideIn: 'slideIn 0.5s ease-in-out',
      slideOut: 'slideOut 0.5s ease-in-out',
      toastSlideIn: 'toastSlideIn 0.5s ease-in-out',
      toastSlideOut: 'toastSlideOut 0.5s ease-in-out',
      'modal-open': 'modal-open 0.3s ease-out forwards',
      'modal-close': 'modal-close 0.3s ease-in forwards',
    },
  },
};
export const plugins = [];
