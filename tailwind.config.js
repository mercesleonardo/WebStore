/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
      './resources/**/*.phtml',
    './resources/**/*.php',
  ],
  theme: {
    extend: {},
  },
  plugins: [
      require('@tailwindcss/forms')
  ],
}

