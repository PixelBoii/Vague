const colors = require('tailwindcss/colors');

module.exports = {
    // Disable purging since we want to allow for dynamically added classes
    // TODO: Long-term, replace dynamic classes with styles and purge normally
    safelist: [
        {
            pattern: /.*/
        }
    ],
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            zIndex: {
                '-10': '-10'
            },
            colors: {
                green: colors.emerald,
                yellow: colors.amber,
                purple: colors.violet,
            }
        }
    },
    plugins: [
        require('@tailwindcss/forms'),
        require('@tailwindcss/aspect-ratio'),
    ],
};
