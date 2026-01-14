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

    <!-- Tailwind CSS (Lokal Build) -->
    <link href="<?php echo SITE_URL; ?>/assets/css/output.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect" />


    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;0,700;1,400;1,600&amp;family=Montserrat:wght@300;400;500;600;700&amp;display=swap" rel="stylesheet" />




</head>

<body class="bg-background-light dark:bg-background-dark text-slate-900 dark:text-white antialiased overflow-x-hidden transition-colors duration-300">

    <!-- Preloader -->
    <div id="preloader" class="fixed inset-0 z-[100] bg-background-dark flex items-center justify-center transition-opacity duration-500">
        <div class="text-center">
            <div class="relative w-24 h-24 mx-auto mb-6">
                <div class="absolute inset-0 border-4 border-primary/20 rounded-full"></div>
                <div class="absolute inset-0 border-4 border-transparent border-t-primary rounded-full animate-spin"></div>
                <svg class="w-10 h-10 text-primary absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 3L4 9v12h5v-7h6v7h5V9l-8-6z"></path>
                </svg>
            </div>
            <p class="text-gray-400 text-sm uppercase tracking-widest">Memuat...</p>
        </div>
    </div>

    <!-- Navigation -->
    <nav id="main-nav" class="fixed top-0 w-full z-50 glass-nav transition-all duration-300">
        <div class="max-w-[1240px] mx-auto px-4 sm:px-6 lg:px-12 h-20 flex items-center justify-between">
            <!-- Logo -->
            <a href="<?php echo SITE_URL; ?>" class="flex items-center gap-3 group">
                <svg class="w-8 h-8 text-primary transition-transform duration-300 group-hover:rotate-12" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 3L4 9v12h5v-7h6v7h5V9l-8-6z"></path>
                </svg>
                <span class="brand-font text-xl md:text-2xl font-bold tracking-tight text-white">
                    Home Putra <span class="text-primary italic normal-case">Interior</span>
                </span>
            </a>

            <!-- Desktop Menu -->
            <div class="hidden lg:flex items-center gap-6 xl:gap-10">
                <!-- Dropdown Layanan -->
                <div class="relative group h-20 flex items-center">
                    <a class="nav-link text-[11px] uppercase tracking-[0.3em] font-bold text-white/70 hover:text-primary transition-all duration-300 flex items-center gap-1.5" href="<?php echo SITE_URL; ?>/services-all.php">
                        Layanan
                        <svg class="w-3 h-3 transition-transform duration-300 group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </a>
                    <span class="absolute bottom-5 left-0 w-0 h-[1px] bg-primary transition-all duration-300 group-hover:w-full"></span>

                    <!-- Dropdown Content -->
                    <div class="absolute top-[80px] left-0 w-64 bg-surface-dark/95 backdrop-blur-xl border border-white/5 p-6 rounded-b-sm opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 transform translate-y-2 group-hover:translate-y-0 z-[100] shadow-2xl">
                        <div class="flex flex-col gap-5">
                            <a href="<?php echo SITE_URL; ?>/services-all.php" class="text-[10px] uppercase tracking-widest text-gray-400 hover:text-primary transition-colors flex items-center justify-between group/item">
                                Semua Layanan
                                <svg class="w-3 h-3 opacity-0 -translate-x-2 group-hover/item:opacity-100 group-hover/item:translate-x-0 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                            <div class="h-px bg-white/5"></div>
                            <a href="<?php echo SITE_URL; ?>/index.php#services" class="text-xs text-white/80 hover:text-primary transition-colors font-medium">Desain Residensial</a>
                            <a href="<?php echo SITE_URL; ?>/index.php#services" class="text-xs text-white/80 hover:text-primary transition-colors font-medium">Ruang Komersial</a>
                            <a href="<?php echo SITE_URL; ?>/index.php#services" class="text-xs text-white/80 hover:text-primary transition-colors font-medium">Furniture Custom</a>
                        </div>
                    </div>
                </div>

                <!-- Dropdown Portfolio -->
                <div class="relative group h-20 flex items-center">
                    <a class="nav-link text-[11px] uppercase tracking-[0.3em] font-bold text-white/70 hover:text-primary transition-all duration-300 flex items-center gap-1.5" href="<?php echo SITE_URL; ?>/#portfolio">
                        Portfolio
                        <svg class="w-3 h-3 transition-transform duration-300 group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </a>
                    <span class="absolute bottom-5 left-0 w-0 h-[1px] bg-primary transition-all duration-300 group-hover:w-full"></span>

                    <!-- Dropdown Content -->
                    <div class="absolute top-[80px] left-0 w-64 bg-surface-dark/95 backdrop-blur-xl border border-white/5 p-6 rounded-b-sm opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 transform translate-y-2 group-hover:translate-y-0 z-[100] shadow-2xl">
                        <div class="flex flex-col gap-5">
                            <a href="<?php echo SITE_URL; ?>/portfolio-all.php" class="text-[10px] uppercase tracking-widest text-gray-400 hover:text-primary transition-colors flex items-center justify-between group/item">
                                Lihat Portfolio
                                <svg class="w-3 h-3 opacity-0 -translate-x-2 group-hover/item:opacity-100 group-hover/item:translate-x-0 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                            <div class="h-px bg-white/5"></div>
                            <a href="<?php echo SITE_URL; ?>/index.php#portfolio" class="text-xs text-white/80 hover:text-primary transition-colors font-medium">Karya Residensial</a>
                            <a href="<?php echo SITE_URL; ?>/index.php#portfolio" class="text-xs text-white/80 hover:text-primary transition-colors font-medium">Karya Komersial</a>
                        </div>
                    </div>
                </div>

                <a class="nav-link text-[11px] uppercase tracking-[0.3em] font-bold text-white/70 hover:text-primary transition-all duration-300 relative group" href="<?php echo SITE_URL; ?>/#testimonials">
                    Testimoni
                    <span class="absolute -bottom-1 left-0 w-0 h-[1px] bg-primary transition-all duration-300 group-hover:w-full"></span>
                </a>
                <a class="nav-link text-[11px] uppercase tracking-[0.3em] font-bold text-white/70 hover:text-primary transition-all duration-300 relative group" href="<?php echo SITE_URL; ?>/#contact">
                    Kontak
                    <span class="absolute -bottom-1 left-0 w-0 h-[1px] bg-primary transition-all duration-300 group-hover:w-full"></span>
                </a>
            </div>

            <!-- CTA & Mobile Toggle -->
            <div class="flex items-center gap-4">
                <a class="hidden lg:flex h-11 px-6 items-center justify-center rounded-sm bg-primary hover:bg-primary-hover text-black text-xs uppercase tracking-widest font-bold transition-all magnetic-btn" href="<?php echo SITE_URL; ?>/#contact">
                    Konsultasi
                </a>
                <button id="mobile-menu-btn" class="lg:hidden text-white p-2 hover:text-primary transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>
    </nav>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="mobile-menu fixed top-0 right-0 w-[280px] sm:w-80 h-full bg-surface-dark z-[60] shadow-2xl p-6 sm:p-8">
        <div class="flex justify-between items-center mb-12">
            <span class="text-white text-lg font-bold uppercase tracking-widest">Menu</span>
            <button id="mobile-menu-close" class="text-white hover:text-primary transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <div class="flex flex-col gap-4 overflow-y-auto max-h-[calc(100vh-250px)] pr-2">
            <div class="flex flex-col gap-2">
                <a class="text-xl text-white font-serif italic py-2" href="<?php echo SITE_URL; ?>/services-all.php">Layanan</a>
                <div class="flex flex-col gap-3 ml-4 border-l border-white/10 pl-4 py-2">
                    <a href="<?php echo SITE_URL; ?>/services-all.php" class="text-sm text-gray-500 hover:text-primary italic">Semua Layanan</a>
                    <a href="<?php echo SITE_URL; ?>/index.php#services" class="text-sm text-gray-500 hover:text-primary">Residensial</a>
                    <a href="<?php echo SITE_URL; ?>/index.php#services" class="text-sm text-gray-500 hover:text-primary">Komersial</a>
                </div>
            </div>

            <div class="flex flex-col gap-2">
                <a class="text-xl text-white font-serif italic py-2" href="<?php echo SITE_URL; ?>/portfolio-all.php">Portfolio</a>
                <div class="flex flex-col gap-3 ml-4 border-l border-white/10 pl-4 py-2">
                    <a href="<?php echo SITE_URL; ?>/portfolio-all.php" class="text-sm text-gray-500 hover:text-primary italic">Semua Proyek</a>
                    <a href="<?php echo SITE_URL; ?>/index.php#portfolio" class="text-sm text-gray-500 hover:text-primary">Residensial</a>
                </div>
            </div>

            <a class="text-xl text-gray-300 hover:text-primary transition-colors py-2 border-b border-white/5" href="<?php echo SITE_URL; ?>/#calculator">Kalkulator</a>
            <a class="text-xl text-gray-300 hover:text-primary transition-colors py-2 border-b border-white/5" href="<?php echo SITE_URL; ?>/#testimonials">Testimoni</a>
            <a class="text-xl text-gray-300 hover:text-primary transition-colors py-2 border-b border-white/5" href="<?php echo SITE_URL; ?>/#contact">Kontak</a>
        </div>
        <a class="mt-10 w-full h-14 flex items-center justify-center rounded-sm bg-primary text-black text-xs uppercase tracking-widest font-bold" href="<?php echo SITE_URL; ?>/#contact">
            Konsultasi Gratis
        </a>
    </div>

    <!-- Mobile Menu Overlay -->
    <div id="mobile-menu-overlay" class="fixed inset-0 bg-black/50 z-[55] hidden opacity-0 transition-opacity duration-300"></div>