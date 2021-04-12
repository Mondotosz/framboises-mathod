const { colors, opacity } = require('tailwindcss/defaultTheme');

module.exports = {
  purge: [
    './view/**/*.php',
    './view/**/*.html',
    './view/**/*.ts',
  ],
  darkMode: false, // or 'media' or 'class'
  theme: {
    extend: {
      spacing: {
        '128': '32rem',
        '144': '36rem',
      }
    },
  },
  variants: {
    extend: {
      padding: ['children'],
      margin:['children','first','last'],
      backgroundColor:['odd','even'],
      textColor:['odd','even'],
    },
  },
  plugins: [
    require('@tailwindcss/typography'),
    require('@tailwindcss/forms'),
    require('@tailwindcss/line-clamp'),
    require('@tailwindcss/aspect-ratio'),
    require('tailwindcss-children'),

    require("tailwind-heropatterns")({
      // as per tailwind docs you can pass variants
      variants: [],

      // the list of patterns you want to generate a class for
      // the names must be in kebab-case
      // an empty array will generate all 87 patterns
      patterns: ["diagonal-lines"],

      // The foreground colors of the pattern
      colors: {
        default: "#9C92AC",
        "pink": colors.pink["500"] //also works with rgb(0,0,205)
      },

      // The foreground opacity
      opacity: {
        default: "0.4",
        "10": "0.1",
        "100": "1.0",
      }
    })
  ]
}
