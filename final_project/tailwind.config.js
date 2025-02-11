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
      "dark/primary": "#104B48",
      "dark/red": "#702828",
      "dark/yellow": "#905A3C",
      "dark/green": "#43784B",
      "dark/blue": "#7D97B7"
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
