/** @type {import('tailwindcss').Config} */
module.exports = {
  mode: "jit",
  content: [
    "./public/**/*.{html,js,php}",
    "./src/Views/**/*.php",
  ],
  theme: {
    extend: {},
  },
  plugins: [],
};
