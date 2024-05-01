/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './components/**/*.{html,js}',
    "./index.html",
    "./src/**/*.{vue,js,ts,jsx,tsx}",
  ],
  theme: {
    extend: {},
  },
  plugins: [
    require('@tailwindcss/forms'),
  ],
}

