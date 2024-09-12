import forms from '@tailwindcss/forms'

export default {
  content: [
      './resources/**/*.phtml',
    './resources/**/*.php',
  ],
  theme: {
    extend: {},
  },
  plugins: [forms],
}

