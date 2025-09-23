/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./**/*.php",
    "./assets/js/**/*.js",
    "./acf-blocks/**/*.{php,js}",
    "./assets/css/pages/**/*.css",
    "./assets/patterns/*.css",
  ],
  theme: {
    container: {
      center: true,
      padding: "1rem",
      screens: {
        sm: "600px",
        md: "728px",
        lg: "984px",
        xl: "1240px",
      },
    },
    extend: {
      colors: {
        primary: {
          DEFAULT: "#1E40AF", // blue-800
          light: "#3B82F6", // blue-500
          dark: "#1E3A8A", // blue-900
        },
        secondary: {
          DEFAULT: "#9333EA", // purple-600
          light: "#A855F7", // purple-500
          dark: "#7E22CE", // purple-700
        },
      },
      fontFamily: {
        sans: ["Inter", "ui-sans-serif", "system-ui"],
        heading: ["Poppins", "ui-sans-serif", "system-ui"],
      },
    },
  },
  plugins: [],
};
