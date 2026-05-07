module.exports = {
  content: [
    './resources/views/**/*.blade.php',
    './resources/js/**/*.js',
  ],
  theme: {
    extend: {
      colors: {
        primary: {
          teal: "#0F8B8D",
          navy: "#062B45",
          mint: "#DFF4F2",
          cyan: "#1AA6A5",
        },

        background: {
          main: "#F8FAFA",
          card: "#FFFFFF",
          light: "#EEF7F6",
        },

        textcolor: {
          primary: "#1B1B1B",
          secondary: "#6B7280",
          light: "#9CA3AF",
        },
      },
    },
  },
  plugins: [],
}