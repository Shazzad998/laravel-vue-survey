module.exports = {
  content: ["./src/**/*.{html,js,vue}"],
  theme: {
    extend: {
      keyframes: {
        "fade-in-left": {
          from: {
            transform: "translateX(5rem)",
            opacity: "0",
          },
          to: {
            transform: "translateX(0rem)",
            opacity: "1",
          },
        },
      },
      animation: {
        "fade-in-left": "fade-in-left 0.3s ease-in-out both",
      },
    },
  },
  plugins: [require("@tailwindcss/forms")],
};
