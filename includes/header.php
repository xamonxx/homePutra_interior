<!DOCTYPE html>
<html class="dark" lang="id">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta name="description" content="Home Putra Interior - Studio desain interior premium yang menciptakan ruang mewah dan hangat untuk gaya hidup Anda">
    <meta name="keywords" content="desain interior, interior design, home putra, furniture custom, renovasi rumah, jakarta, indonesia">
    <meta name="author" content="Home Putra Interior">

    <title><?php echo isset($pageTitle) ? $pageTitle . ' - ' : ''; ?>Home Putra Interior</title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?php echo SITE_URL; ?>/assets/images/favicon.ico">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect" />
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;0,700;1,400;1,600&amp;family=Montserrat:wght@300;400;500;600;700&amp;display=swap" rel="stylesheet" />

    <!-- Google Material Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>

    <!-- AOS Animation Library -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?php echo SITE_URL; ?>/assets/css/custom.css" rel="stylesheet">

    <!-- Custom Tailwind Config -->
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#ffb204",
                        "primary-hover": "#e6a000",
                        "accent": "#ffb204",
                        "background-light": "#FAFAF8",
                        "background-dark": "#1A1A1A",
                        "surface-dark": "#252525",
                        "surface-light": "#ffffff",
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
        }
    </script>

    <!-- Custom Styles -->
    <style type="text/tailwindcss">
        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #1A1A1A; 
        }
        ::-webkit-scrollbar-thumb {
            background: #333333; 
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #ffb204; 
        }
        
        /* Glass Navigation */
        .glass-nav {
            background: rgba(26, 26, 26, 0.85);
            @apply backdrop-blur-md;
            border-bottom: 1px solid rgba(255, 178, 4, 0.15);
        }
        
        .glass-nav.scrolled {
            background: rgba(26, 26, 26, 0.95);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.3);
        }
        
        /* Gold Gradient Text */
        .text-gold-gradient {
            background: linear-gradient(to right, #ffb204, #ffe066, #ffb204);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-size: 200% auto;
            animation: shine 5s linear infinite;
        }
        
        @keyframes shine {
            to {
                background-position: 200% center;
            }
        }
        
        /* Pulse Ring Animation */
        .pulse-ring {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border-radius: 50%;
            animation: pulse-ring 2s cubic-bezier(0.215, 0.61, 0.355, 1) infinite;
            background-color: #ffb204;
            opacity: 0.6;
            z-index: -1;
        }
        
        @keyframes pulse-ring {
            0% { transform: scale(0.8); opacity: 0.6; }
            100% { transform: scale(2.0); opacity: 0; }
        }
        
        /* Typography */
        h1, h2, h3, .brand-font {
            @apply font-serif;
        }
        
        body, nav, button, input, select, textarea {
            @apply font-sans;
        }
        
        /* Smooth Scroll */
        html {
            scroll-behavior: smooth;
        }
        
        /* Image Hover Effects */
        .img-hover-zoom {
            overflow: hidden;
        }
        
        .img-hover-zoom img {
            transition: transform 1s ease;
        }
        
        .img-hover-zoom:hover img {
            transform: scale(1.1);
        }
        
        /* Magnetic Button Effect */
        .magnetic-btn {
            transition: all 0.3s cubic-bezier(0.23, 1, 0.32, 1);
        }
        
        .magnetic-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 20px 40px rgba(255, 178, 4, 0.3);
        }
        
        /* Underline Animation */
        .underline-animation {
            position: relative;
        }
        
        .underline-animation::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -4px;
            left: 0;
            background: #ffb204;
            transition: width 0.3s ease;
        }
        
        .underline-animation:hover::after {
            width: 100%;
        }
        
        /* Card Hover Effect */
        .card-hover {
            transition: all 0.4s cubic-bezier(0.23, 1, 0.32, 1);
        }
        
        .card-hover:hover {
            transform: translateY(-10px);
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.3);
        }
        
        /* Gradient Border */
        .gradient-border {
            position: relative;
            background: linear-gradient(#252525, #252525) padding-box,
                        linear-gradient(135deg, #ffb204, #ffe066, #ffb204) border-box;
            border: 2px solid transparent;
        }
        
        /* Glowing Button */
        .glow-btn {
            position: relative;
            overflow: hidden;
        }
        
        .glow-btn::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(
                45deg,
                transparent,
                rgba(255, 178, 4, 0.1),
                transparent
            );
            transform: rotate(45deg);
            animation: glow 3s linear infinite;
        }
        
        @keyframes glow {
            0% { transform: translateX(-100%) rotate(45deg); }
            100% { transform: translateX(100%) rotate(45deg); }
        }
        
        /* Parallax Background */
        .parallax-bg {
            background-attachment: fixed;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }
        
        /* Loading Skeleton */
        .skeleton {
            background: linear-gradient(90deg, #333 25%, #444 50%, #333 75%);
            background-size: 200% 100%;
            animation: skeleton-loading 1.5s infinite;
        }
        
        @keyframes skeleton-loading {
            0% { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }
        
        /* Mobile Menu */
        .mobile-menu {
            transform: translateX(100%);
            transition: transform 0.3s ease;
        }
        
        .mobile-menu.active {
            transform: translateX(0);
        }
        
        /* Counter Animation */
        .counter {
            display: inline-block;
        }
    </style>
</head>

<body class="bg-background-light dark:bg-background-dark text-slate-900 dark:text-white antialiased overflow-x-hidden transition-colors duration-300">

    <!-- Preloader -->
    <div id="preloader" class="fixed inset-0 z-[100] bg-background-dark flex items-center justify-center transition-opacity duration-500">
        <div class="text-center">
            <div class="relative w-24 h-24 mx-auto mb-6">
                <div class="absolute inset-0 border-4 border-primary/20 rounded-full"></div>
                <div class="absolute inset-0 border-4 border-transparent border-t-primary rounded-full animate-spin"></div>
                <span class="material-symbols-outlined text-4xl text-primary absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2">other_houses</span>
            </div>
            <p class="text-gray-400 text-sm uppercase tracking-widest">Memuat...</p>
        </div>
    </div>

    <!-- Navigation -->
    <nav id="main-nav" class="fixed top-0 w-full z-50 glass-nav transition-all duration-300">
        <div class="max-w-[1200px] mx-auto px-6 lg:px-12 h-20 flex items-center justify-between">
            <!-- Logo -->
            <a href="<?php echo SITE_URL; ?>" class="flex items-center gap-3 group">
                <span class="material-symbols-outlined text-4xl text-primary transition-transform duration-300 group-hover:rotate-12">other_houses</span>
                <span class="brand-font text-2xl font-bold tracking-tight text-white">
                    Home Putra <span class="text-primary italic normal-case">Interior</span>
                </span>
            </a>

            <!-- Desktop Menu -->
            <div class="hidden md:flex items-center gap-10">
                <a class="text-xs uppercase tracking-[0.2em] font-semibold text-gray-300 hover:text-primary transition-colors underline-animation" href="#portfolio">Portfolio</a>
                <a class="text-xs uppercase tracking-[0.2em] font-semibold text-gray-300 hover:text-primary transition-colors underline-animation" href="#services">Layanan</a>
                <a class="text-xs uppercase tracking-[0.2em] font-semibold text-gray-300 hover:text-primary transition-colors underline-animation" href="#calculator">Kalkulator</a>
                <a class="text-xs uppercase tracking-[0.2em] font-semibold text-gray-300 hover:text-primary transition-colors underline-animation" href="#testimonials">Testimoni</a>
            </div>

            <!-- CTA & Mobile Toggle -->
            <div class="flex items-center gap-4">
                <a class="hidden sm:flex h-11 px-6 items-center justify-center rounded-sm bg-primary hover:bg-primary-hover text-black text-xs uppercase tracking-widest font-bold transition-all magnetic-btn" href="#contact">
                    Konsultasi
                </a>
                <button id="mobile-menu-btn" class="md:hidden text-white p-2 hover:text-primary transition-colors">
                    <span class="material-symbols-outlined text-2xl">menu</span>
                </button>
            </div>
        </div>
    </nav>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="mobile-menu fixed top-0 right-0 w-80 h-full bg-surface-dark z-[60] shadow-2xl p-8">
        <div class="flex justify-between items-center mb-12">
            <span class="text-white text-lg font-bold uppercase tracking-widest">Menu</span>
            <button id="mobile-menu-close" class="text-white hover:text-primary transition-colors">
                <span class="material-symbols-outlined text-2xl">close</span>
            </button>
        </div>
        <div class="flex flex-col gap-6">
            <a class="text-xl text-gray-300 hover:text-primary transition-colors py-2 border-b border-white/5" href="#portfolio">Portfolio</a>
            <a class="text-xl text-gray-300 hover:text-primary transition-colors py-2 border-b border-white/5" href="#services">Layanan</a>
            <a class="text-xl text-gray-300 hover:text-primary transition-colors py-2 border-b border-white/5" href="#calculator">Kalkulator</a>
            <a class="text-xl text-gray-300 hover:text-primary transition-colors py-2 border-b border-white/5" href="#testimonials">Testimoni</a>
            <a class="text-xl text-gray-300 hover:text-primary transition-colors py-2 border-b border-white/5" href="#contact">Kontak</a>
        </div>
        <a class="mt-10 w-full h-14 flex items-center justify-center rounded-sm bg-primary text-black text-xs uppercase tracking-widest font-bold" href="#contact">
            Konsultasi Gratis
        </a>
    </div>

    <!-- Mobile Menu Overlay -->
    <div id="mobile-menu-overlay" class="fixed inset-0 bg-black/50 z-[55] hidden opacity-0 transition-opacity duration-300"></div>