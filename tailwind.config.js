/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./app/views/**/*.php",
    "./public/**/*.php",
    "./public/index.php"
  ],
  theme: {
    extend: {},
  },
  plugins: [],
  safelist: [
    'h-[25vh]',
    'h-[50vh]',
    'h-[70vh]',
    'h-[100vh]'
  ]
}

