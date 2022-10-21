module.exports = {
    mode: 'jit',
    content: [
        './resources/**/*.antlers.html',
        './resources/**/*.blade.php',
        './resources/**/*.vue',
        './resources/**/*.yaml',
        './resources/**/*.css',
        './resources/**/*.js',
        './content/**/*.md'
    ],
    theme: {
        extend: {},
    },
    plugins: [require('@tailwindcss/forms'), require('@tailwindcss/typography')],
}
