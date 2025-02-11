/** @type {import('tailwindcss').Config} */

module.exports = {
  content: ["./**/*.{html,js,php}", "./*.{html,js,php}"],
  theme: {
    colors: {
      primary: "#226E6A",
      secondary: "#003C86",
      white: "#FBF8EE",
      black: "#232323",
      gray: "#C2C2C2",
      red: "#E24B4B",
      yellow: "#FFC145",
      green: "#1B8600",
      "light/red": "#E24B4B",
      "light/yellow": "#FFC145",
      "light/green": "#1B8600",
      "light/blue": "#ABCDFF",
    },
    extend: {
      maxWidth: {
        content: "1200px"
      },
      minWidth: {
        content: "1200px"
      },
      width: {
        content: "1200px"
      },
    },
  },
  plugins: [],
}
