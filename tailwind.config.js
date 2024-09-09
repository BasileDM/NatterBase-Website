/** @type {import('tailwindcss').Config} */
module.exports = {
  mode: "jit",
  content: ["./public/**/*.{html,js,php}", "./src/Views/**/*.php"],
  theme: {
    extend: {
      keyframes: {
        slideIn: {
          "0%": {
            transform: "translateX(-100%)",
          },
          "100%": {
            transform: "translateX(0)",
          },
        },
      },
      animation: {
        slideIn: "slideIn 0.5s ease-in-out",
      },
    },
  },
  plugins: [],
};
