/** @type {import('tailwindcss').Config} */

module.exports = {
  content: ["./**/*.{html,js,php}", "./*.{html,js,php}"],
  theme: {
    extend: {
      maxWidth: {
        content: "1200px"
      },
      fontFamily: {
        'kanit': ['Kanit', 'sans-serif'],
      },
      colors: {
        primary: "#226E6A",
        secondary: "#003C86",
        white: "#FBF8EE",
        black: "#232323",
        red: "#E24B4B",
        yellow: "#FFC145",
        green: "#1B8600",
        light: {
          green: "#BCFFAB",
        },
        dark: {
          primary: "#104B48",
          red: "#702828",
          yellow: "#905A3C",
          green: "#43784B",
          blue: "#7D97B7"
        },
        gray: {
          50: '#f9fafb',
          100: '#f3f4f6',
          200: '#e5e7eb',
          300: '#d1d5db',
          400: '#9ca3af',
          500: '#6b7280',
          600: '#4b5563',
          700: '#374151',
          800: '#1f2937',
          900: '#111827',
          950: '#030712'
        }
      },
      minWidth: {
        content: "1200px"
      },
      width: {
        content: "1200px"
      },
    },
  },
  plugins: []
}
