/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./src/**/*.{html,js,php}"],
  plugins: [require("daisyui")],
  daisyui: {
    themes: ["dark"],
  },
}
