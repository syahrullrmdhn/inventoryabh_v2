// tailwind.config.js
module.exports = {
  content: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './node_modules/flowbite/**/*.js'
  ],
  theme: {
    extend: {
      fontFamily: {
        mulish: ['Mulish', 'sans-serif'],
      },
      colors: {
        darkbg: '#0f0f10',
        cardbg: 'rgba(255,255,255,0.05)',
      },
      backdropFilter: {
        'none':'none',
        'blur':'blur(10px)',
      },
    },
  },
  plugins: [
    require('flowbite/plugin'),
    require('tailwindcss-filters'),
  ],
}
