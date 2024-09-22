import forms from '@tailwindcss/forms'

export default {
  content: [
    './resources/**/*.phtml',
    './resources/**/*.php',
    './resources/**/*.js'
  ],
  theme: {
    extend: {},
  },
  plugins: [forms],
}

