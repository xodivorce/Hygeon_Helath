/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./htdocs/**/*.{php,html,js}"],
  theme: {
    extend: {},
  },
  plugins: [],
}

//npx tailwindcss -i ./src/input.css -o ./src/output.css --watch