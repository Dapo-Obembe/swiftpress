/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './**/*.php',
    './assets/js/**/*.js',
    './blocks/**/*.css',
    './assets/css/pages/**/*.css',
    './assets/css/blocks/**/*.css',
    './assets/patterns/*.css',
    './templates/**/*.html',
    './parts/*.html',
  ],
  theme: {
    extend: {
      colors: {
      gray: {
            100: "#F8F9FA",
            200: "#E9ECEF",
            300: "#DEE2E6",
            400: "#CED4DA",
            500: "#ADB5BD",
            600: "#6C757D",
            700: "#495057",
            800: "#343A40",
            900: "#212529"
      }
},
      spacing: {
      '20': "10px",
      '30': "20px",
      '40': "30px",
      '50': "clamp(30px, 5vw, 50px)",
      '60': "clamp(30px, 7vw, 70px)",
      '70': "clamp(50px, 7vw, 90px)",
      '80': "clamp(20px, 10vw, 100px)"
},
      fontSize: {
      sm: "0.875rem",
      base: "1rem",
      lg: "1.38rem",
      '3xl': "2.5rem",
      '4xl': "3.5rem"
},
      fontFamily: {
        sans: [
        "Manrope",
        "sans-serif"
],
      },
      maxWidth: {
        'content': '846px',
        'wide': '1240px',
      },
    },
  },
  plugins: [],
};