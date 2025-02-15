/** @type {import('tailwindcss').Config} */
const withMT = require("@material-tailwind/html/utils/withMT")

module.exports = withMT({
  content: ["./**/*.{html,js,php}", "./*.{html,js,php}"],
  theme: {
    extend: {
      colors: {
        black: "#222222"
      }
    },
  },
  plugins: [],
})