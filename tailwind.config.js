module.exports = {
    purge: [
        './_packages/**/resources/**/*.blade.php',
        './_packages/**/resources/**/*.js',
        './_packages/**/resources/**/*.vue',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
  darkMode: false, // or 'media' or 'class'
  theme: {
    extend: {},
  },
  variants: {
    extend: {},
  },
  plugins: [],
}
