/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./index.html",
    "./src/**/*.{vue,js,ts,jsx,tsx}",
  ],
  theme: {
    extend: {
      fontFamily: {
        body: ['Lato', 'sans-serif'],
        title: ['Marcellus', 'serif'],
      },
      colors: {
        'fond': '#f7f8f3'
    },
      variants: {
        backgroundColor : ['responsive','hover','focus','active']
    }
  },
  plugins: [],
}
}