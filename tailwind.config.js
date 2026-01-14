/** @type {import('tailwindcss').Config} */
module.exports = {
    darkMode: "class",
    content: [
        "./index.php",
        "./portfolio-all.php",
        "./services-all.php",
        "./includes/**/*.php",
        "./admin/**/*.php",
        "./assets/js/**/*.js",
    ],
    theme: {
        extend: {
            colors: {
                "primary": "#ffb204",
                "primary-hover": "#e6a000",
                "primary-light": "#ffc84d",
                "accent": "#ffb204",
                "background-light": "#FDFDFD",
                "background-dark": "#0B0D11",
                "surface-dark": "#161B22",
                "surface-light": "#FFFFFF",
                "charcoal": "#1A1D23",
            },
            fontFamily: {
                "sans": ["Montserrat", "sans-serif"],
                "serif": ["Cormorant Garamond", "serif"],
            },
            boxShadow: {
                'glass': '0 4px 30px rgba(0, 0, 0, 0.1)',
            },
            animation: {
                'float': 'float 6s ease-in-out infinite',
                'pulse-slow': 'pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                'shimmer': 'shimmer 2s linear infinite',
                'slide-up': 'slideUp 0.5s ease-out',
                'slide-down': 'slideDown 0.5s ease-out',
                'fade-in': 'fadeIn 0.6s ease-out',
                'scale-in': 'scaleIn 0.5s ease-out',
            },
            keyframes: {
                float: {
                    '0%, 100%': {
                        transform: 'translateY(0)'
                    },
                    '50%': {
                        transform: 'translateY(-20px)'
                    },
                },
                shimmer: {
                    '0%': {
                        backgroundPosition: '-200% 0'
                    },
                    '100%': {
                        backgroundPosition: '200% 0'
                    },
                },
                slideUp: {
                    '0%': {
                        transform: 'translateY(20px)',
                        opacity: '0'
                    },
                    '100%': {
                        transform: 'translateY(0)',
                        opacity: '1'
                    },
                },
                slideDown: {
                    '0%': {
                        transform: 'translateY(-20px)',
                        opacity: '0'
                    },
                    '100%': {
                        transform: 'translateY(0)',
                        opacity: '1'
                    },
                },
                fadeIn: {
                    '0%': {
                        opacity: '0'
                    },
                    '100%': {
                        opacity: '1'
                    },
                },
                scaleIn: {
                    '0%': {
                        transform: 'scale(0.9)',
                        opacity: '0'
                    },
                    '100%': {
                        transform: 'scale(1)',
                        opacity: '1'
                    },
                },
            },
        },
    },
    plugins: [
        require('@tailwindcss/forms'),
        require('@tailwindcss/container-queries'),
    ],
}