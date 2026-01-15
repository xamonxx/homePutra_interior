<?php

/**
 * Calculator Page - Budget Planner
 * Home Putra Interior - Halaman Kalkulator Estimasi
 */

require_once __DIR__ . '/config/database.php';
$pageTitle = 'Kalkulator Estimasi Biaya';
?>
<!DOCTYPE html>
<html class="dark" lang="id">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta name="description" content="Hitung estimasi biaya proyek interior atau furniture custom Anda secara instan dengan kalkulator anggaran Home Putra Interior">
    <meta name="keywords" content="kalkulator interior, estimasi biaya kitchen set, harga lemari custom, calculator furniture">
    <meta name="author" content="Home Putra Interior">

    <title><?= $pageTitle ?> - Home Putra Interior</title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?= SITE_URL ?>/assets/images/favicon.ico">

    <!-- Tailwind CSS -->
    <link href="<?= SITE_URL ?>/assets/css/output.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect" />
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;0,700;1,400;1,600&family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet" />

    <!-- Material Symbols -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet" />

    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
</head>

<body class="bg-[#0a0c10] text-white antialiased overflow-x-hidden">
    <!-- Navigation -->
    <nav class="fixed top-0 w-full z-50 bg-[#0f1218]/95 backdrop-blur-xl border-b border-white/5">
        <div class="max-w-[1240px] mx-auto px-4 sm:px-6 lg:px-12 h-20 flex items-center justify-between">
            <!-- Logo -->
            <a href="<?= SITE_URL ?>" class="flex items-center gap-3 group">
                <svg class="w-8 h-8 text-primary transition-transform duration-300 group-hover:rotate-12" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 3L4 9v12h5v-7h6v7h5V9l-8-6z"></path>
                </svg>
                <span class="font-serif text-xl md:text-2xl font-bold tracking-tight text-white">
                    Home Putra <span class="text-primary italic">Interior</span>
                </span>
            </a>

            <!-- Back to Home -->
            <a href="<?= SITE_URL ?>" class="flex items-center gap-2 text-gray-400 hover:text-primary transition-colors text-sm">
                <span class="material-symbols-outlined text-lg">arrow_back</span>
                Kembali ke Beranda
            </a>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="pt-32 pb-12 relative overflow-hidden">
        <!-- Background -->
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute top-0 right-0 w-1/2 h-full bg-gradient-to-l from-primary/10 to-transparent"></div>
            <div class="absolute bottom-0 left-0 w-1/3 h-1/2 bg-gradient-to-tr from-primary/5 to-transparent"></div>
            <div class="absolute top-20 left-1/4 w-72 h-72 bg-primary/5 rounded-full blur-[100px]"></div>
        </div>

        <div class="max-w-[1200px] mx-auto px-6 relative z-10">
            <div class="text-center mb-8" data-aos="fade-up">
                <span class="inline-flex items-center gap-2 px-4 py-2 bg-primary/10 border border-primary/20 rounded-full text-primary text-xs font-bold uppercase tracking-widest mb-6">
                    <span class="material-symbols-outlined text-sm">calculate</span>
                    Kalkulator Anggaran
                </span>
                <h1 class="text-4xl md:text-5xl lg:text-6xl text-white font-serif mb-6">
                    Hitung <span class="text-primary italic">Estimasi</span> Proyek Anda
                </h1>
                <p class="text-gray-400 max-w-2xl mx-auto font-light leading-relaxed text-lg">
                    Masukkan spesifikasi proyek dan dapatkan estimasi harga yang transparan secara instan.
                </p>
            </div>

            <!-- Feature Pills -->
            <div class="flex flex-wrap justify-center gap-4 mb-8" data-aos="fade-up" data-aos-delay="100">
                <div class="flex items-center gap-2 px-4 py-2 bg-white/5 border border-white/10 rounded-full text-sm text-gray-300">
                    <span class="material-symbols-outlined text-primary text-lg">verified</span>
                    Harga Transparan
                </div>
                <div class="flex items-center gap-2 px-4 py-2 bg-white/5 border border-white/10 rounded-full text-sm text-gray-300">
                    <span class="material-symbols-outlined text-primary text-lg">speed</span>
                    Hasil Instan
                </div>
                <div class="flex items-center gap-2 px-4 py-2 bg-white/5 border border-white/10 rounded-full text-sm text-gray-300">
                    <span class="material-symbols-outlined text-primary text-lg">support_agent</span>
                    Konsultasi Gratis
                </div>
            </div>
        </div>
    </section>

    <!-- Calculator Section -->
    <?php include __DIR__ . '/includes/sections/calculator-full.php'; ?>

    <!-- Trust Section -->
    <section class="py-16 bg-[#0f1218] border-t border-white/5">
        <div class="max-w-[1200px] mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center p-6 bg-white/[0.02] rounded-xl border border-white/5" data-aos="fade-up">
                    <div class="w-16 h-16 mx-auto bg-gradient-to-br from-primary/20 to-primary/5 rounded-2xl flex items-center justify-center mb-4">
                        <span class="material-symbols-outlined text-primary text-3xl">workspace_premium</span>
                    </div>
                    <h3 class="text-white font-medium mb-2">Garansi 2 Tahun</h3>
                    <p class="text-gray-500 text-sm">Jaminan kualitas untuk setiap proyek yang kami kerjakan</p>
                </div>
                <div class="text-center p-6 bg-white/[0.02] rounded-xl border border-white/5" data-aos="fade-up" data-aos-delay="100">
                    <div class="w-16 h-16 mx-auto bg-gradient-to-br from-primary/20 to-primary/5 rounded-2xl flex items-center justify-center mb-4">
                        <span class="material-symbols-outlined text-primary text-3xl">handyman</span>
                    </div>
                    <h3 class="text-white font-medium mb-2">Tukang Profesional</h3>
                    <p class="text-gray-500 text-sm">Tim ahli berpengalaman dengan standar kerja tinggi</p>
                </div>
                <div class="text-center p-6 bg-white/[0.02] rounded-xl border border-white/5" data-aos="fade-up" data-aos-delay="200">
                    <div class="w-16 h-16 mx-auto bg-gradient-to-br from-primary/20 to-primary/5 rounded-2xl flex items-center justify-center mb-4">
                        <span class="material-symbols-outlined text-primary text-3xl">local_shipping</span>
                    </div>
                    <h3 class="text-white font-medium mb-2">Pengiriman Aman</h3>
                    <p class="text-gray-500 text-sm">Gratis ongkir untuk proyek di atas Rp 20 juta</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-8 bg-[#0a0c10] border-t border-white/5">
        <div class="max-w-[1200px] mx-auto px-6">
            <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <svg class="w-6 h-6 text-primary" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 3L4 9v12h5v-7h6v7h5V9l-8-6z"></path>
                    </svg>
                    <span class="font-serif text-lg text-white">Home Putra <span class="text-primary italic">Interior</span></span>
                </div>
                <p class="text-gray-500 text-sm">© 2024 Home Putra Interior. All rights reserved.</p>
                <div class="flex items-center gap-4">
                    <a href="<?= SITE_URL ?>/#contact" class="text-gray-400 hover:text-primary transition-colors text-sm">Hubungi Kami</a>
                    <a href="<?= SITE_URL ?>" class="text-gray-400 hover:text-primary transition-colors text-sm">Beranda</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 800,
            once: true,
            offset: 50
        });
    </script>
</body>

</html>