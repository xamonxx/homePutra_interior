<?php

/**
 * Home Putra Interior - Landing Page
 * Premium Interior Design Studio
 */

// Include configuration
require_once __DIR__ . '/config/database.php';

// Set page title
$pageTitle = 'Desain Interior Premium';

// Include header
require_once __DIR__ . '/includes/header.php';
?>

<!-- Hero Section -->
<header class="hero-section relative min-h-screen flex items-center justify-center pt-24 md:pt-20 overflow-hidden">
    <!-- Background with Parallax -->
    <div class="absolute inset-0 z-0">
        <div class="absolute inset-0 bg-gradient-to-b from-black/70 via-black/40 to-[#1A1A1A] z-10"></div>
        <div class="hero-bg w-full h-full bg-cover bg-center transition-transform duration-[20s] hover:scale-105"
            style="background-image: url('https://images.unsplash.com/photo-1618221195710-dd6b41faaea6?ixlib=rb-4.0.3&auto=format&fit=crop&w=2000&q=80');">
        </div>
    </div>

    <!-- Hero Content -->
    <div class="relative z-20 max-w-[1000px] px-6 text-center flex flex-col items-center gap-8">
        <!-- Badge -->
        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full border border-white/10 bg-white/5 backdrop-blur-sm" data-aos="fade-down">
            <span class="w-1.5 h-1.5 rounded-full bg-primary animate-pulse"></span>
            <span class="text-[10px] uppercase tracking-[0.3em] text-gray-300 font-semibold">Studio Desain Berpenghargaan</span>
        </div>

        <!-- Title -->
        <h1 class="text-3xl sm:text-5xl md:text-7xl lg:text-8xl font-medium leading-[1.1] text-white" data-aos="fade-up" data-aos-delay="100">
            Mendefinisikan Ruang, <br />
            <span class="text-gold-gradient italic">Meningkatkan Gaya Hidup</span>
        </h1>

        <!-- Subtitle -->
        <p class="text-lg md:text-xl text-gray-300 max-w-2xl font-light leading-relaxed tracking-wide" data-aos="fade-up" data-aos-delay="200">
            Rasakan seni desain interior eksklusif. Kami menciptakan lingkungan hangat dan mewah yang disesuaikan dengan visi dan gaya hidup unik Anda.
        </p>

        <!-- CTA Buttons -->
        <div class="flex flex-wrap gap-5 justify-center mt-6" data-aos="fade-up" data-aos-delay="300">
            <a class="min-w-[180px] h-14 flex items-center justify-center px-8 rounded-sm bg-primary text-black text-xs uppercase tracking-widest font-bold hover:bg-primary-hover transition-all magnetic-btn glow-btn" href="#portfolio">
                Lihat Portfolio
            </a>
            <a class="min-w-[180px] h-14 flex items-center justify-center px-8 rounded-sm border border-white/30 bg-white/5 backdrop-blur-sm text-white text-xs uppercase tracking-widest font-semibold hover:bg-white/10 transition-all" href="#contact">
                Konsultasi Gratis
            </a>
        </div>
    </div>

    <!-- Scroll Indicator -->
    <div class="absolute bottom-10 left-1/2 -translate-x-1/2 z-20 flex flex-col items-center gap-2 opacity-60" data-aos="fade-up" data-aos-delay="500">
        <span class="text-[9px] uppercase tracking-[0.4em] text-white">Scroll</span>
        <svg class="w-6 h-6 text-white animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7-7-7"></path>
        </svg>
    </div>
</header>

<!-- Statistics Section -->
<?php
// Fetch statistics from database
$statistics = [];
try {
    $db = getDB();
    $stmt = $db->query("SELECT * FROM statistics WHERE is_active = 1 ORDER BY display_order ASC LIMIT 4");
    $statistics = $stmt->fetchAll();
} catch (PDOException $e) {
    // Fallback to empty array if error
    $statistics = [];
}
?>
<section class="border-y border-white/5 bg-[#171717]">
    <div class="max-w-[1200px] mx-auto px-6 py-12">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 md:divide-x divide-white/5">
            <?php if (!empty($statistics)): ?>
                <?php foreach ($statistics as $index => $stat): ?>
                    <div class="flex flex-col items-center justify-center text-center gap-2" data-aos="fade-up" <?php echo $index > 0 ? 'data-aos-delay="' . ($index * 100) . '"' : ''; ?>>
                        <span class="font-serif text-4xl md:text-5xl text-primary">
                            <?php
                            // Check if suffix looks like "th" for italic styling
                            $suffix = e($stat['stat_suffix'] ?? '');
                            if (strtolower($suffix) === 'th') {
                                echo '<span class="counter" data-target="' . e($stat['stat_number']) . '" data-suffix="">0</span> <span class="text-2xl ml-0.5 italic">th</span>';
                            } else {
                                echo '<span class="counter" data-target="' . e($stat['stat_number']) . '" data-suffix="' . $suffix . '">0</span>';
                            }
                            ?>
                        </span>
                        <span class="text-[10px] uppercase tracking-[0.2em] font-semibold text-gray-500"><?php echo e($stat['stat_label']); ?></span>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <!-- Fallback jika tidak ada data -->
                <div class="flex flex-col items-center justify-center text-center gap-2" data-aos="fade-up">
                    <span class="font-serif text-4xl md:text-5xl text-primary">
                        <span class="counter" data-target="500" data-suffix="+">0</span>
                    </span>
                    <span class="text-[10px] uppercase tracking-[0.2em] font-semibold text-gray-500">Proyek Selesai</span>
                </div>
                <div class="flex flex-col items-center justify-center text-center gap-2" data-aos="fade-up" data-aos-delay="100">
                    <span class="font-serif text-4xl md:text-5xl text-primary">
                        <span class="counter" data-target="12" data-suffix="+">0</span>
                    </span>
                    <span class="text-[10px] uppercase tracking-[0.2em] font-semibold text-gray-500">Tahun Pengalaman</span>
                </div>
                <div class="flex flex-col items-center justify-center text-center gap-2" data-aos="fade-up" data-aos-delay="200">
                    <span class="font-serif text-4xl md:text-5xl text-primary">
                        <span class="counter" data-target="98" data-suffix="%">0</span>
                    </span>
                    <span class="text-[10px] uppercase tracking-[0.2em] font-semibold text-gray-500">Kepuasan Klien</span>
                </div>
                <div class="flex flex-col items-center justify-center text-center gap-2" data-aos="fade-up" data-aos-delay="300">
                    <span class="font-serif text-4xl md:text-5xl text-primary">2 <span class="text-2xl ml-0.5 italic">th</span></span>
                    <span class="text-[10px] uppercase tracking-[0.2em] font-semibold text-gray-500">Garansi</span>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Portfolio Section -->
<?php
// Fetch portfolio from database
$portfolios = [];
try {
    $db = getDB();
    $stmt = $db->query("SELECT * FROM portfolio WHERE is_active = 1 ORDER BY display_order ASC, created_at DESC LIMIT 6");
    $portfolios = $stmt->fetchAll();
} catch (PDOException $e) {
    $portfolios = [];
}

// Fallback images for when no image uploaded
$fallbackImages = [
    'https://images.unsplash.com/photo-1600210492486-724fe5c67fb0?auto=format&fit=crop&w=800&q=80',
    'https://images.unsplash.com/photo-1497366216548-37526070297c?auto=format&fit=crop&w=800&q=80',
    'https://images.unsplash.com/photo-1616594039964-ae9021a400a0?auto=format&fit=crop&w=800&q=80',
    'https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?auto=format&fit=crop&w=800&q=80',
    'https://images.unsplash.com/photo-1617806118233-18e1de247200?auto=format&fit=crop&w=800&q=80',
    'https://images.unsplash.com/photo-1618221195710-dd6b41faaea6?auto=format&fit=crop&w=800&q=80',
];
?>
<section class="py-20 md:py-32 bg-background-dark relative" id="portfolio">
    <div class="max-w-[1200px] mx-auto px-6">
        <!-- Section Header -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-8 mb-16">
            <div data-aos="fade-right">
                <span class="text-primary uppercase tracking-[0.4em] text-[10px] font-bold">Karya Kami</span>
                <h2 class="text-4xl md:text-6xl text-white mt-3 mb-5">Portfolio Pilihan</h2>
                <p class="text-gray-400 max-w-md font-light leading-relaxed">Jelajahi koleksi proyek pilihan kami yang menampilkan komitmen kami pada keanggunan dan detail.</p>
            </div>
            <a href="portfolio-all.php" class="text-primary hover:text-white flex items-center gap-3 text-xs uppercase tracking-widest font-bold transition-colors group" data-aos="fade-left">
                Lihat Semua Proyek
                <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                </svg>
            </a>
        </div>

        <!-- Portfolio Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
            <?php if (!empty($portfolios)): ?>
                <?php foreach ($portfolios as $index => $portfolio): ?>
                    <?php
                    $imageSrc = !empty($portfolio['image']) ? $portfolio['image'] : $fallbackImages[$index % count($fallbackImages)];
                    $delay = $index * 100;
                    ?>
                    <div class="group relative overflow-hidden rounded-sm break-inside-avoid cursor-pointer img-hover-zoom card-hover" data-aos="fade-up" <?php echo $delay > 0 ? 'data-aos-delay="' . $delay . '"' : ''; ?>>
                        <img alt="<?php echo e($portfolio['title']); ?>" class="w-full aspect-[4/5] object-cover"
                            src="<?php echo e($imageSrc); ?>" />
                        <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex flex-col justify-end p-8">
                            <span class="text-primary text-[10px] uppercase tracking-[0.3em] font-bold mb-2"><?php echo e($portfolio['category'] ?: 'Interior'); ?></span>
                            <h3 class="text-2xl md:text-3xl text-white italic font-serif"><?php echo e($portfolio['title']); ?></h3>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <!-- Fallback jika tidak ada data -->
                <div class="group relative overflow-hidden rounded-sm break-inside-avoid cursor-pointer img-hover-zoom card-hover" data-aos="fade-up">
                    <img alt="Ruang tamu minimalis modern" class="w-full h-auto object-cover"
                        src="https://images.unsplash.com/photo-1600210492486-724fe5c67fb0?auto=format&fit=crop&w=800&q=80" />
                    <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex flex-col justify-end p-8">
                        <span class="text-primary text-[10px] uppercase tracking-[0.3em] font-bold mb-2">Residensial</span>
                        <h3 class="text-2xl md:text-3xl text-white italic font-serif">The Penthouse Edit</h3>
                    </div>
                </div>
                <div class="group relative overflow-hidden rounded-sm break-inside-avoid cursor-pointer img-hover-zoom card-hover" data-aos="fade-up" data-aos-delay="100">
                    <img alt="Ruang kerja kayu gelap" class="w-full h-auto object-cover"
                        src="https://images.unsplash.com/photo-1497366216548-37526070297c?auto=format&fit=crop&w=800&q=80" />
                    <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex flex-col justify-end p-8">
                        <span class="text-primary text-[10px] uppercase tracking-[0.3em] font-bold mb-2">Kantor</span>
                        <h3 class="text-2xl md:text-3xl text-white italic font-serif">Executive Study</h3>
                    </div>
                </div>
                <div class="group relative overflow-hidden rounded-sm break-inside-avoid cursor-pointer img-hover-zoom card-hover" data-aos="fade-up" data-aos-delay="200">
                    <img alt="Kamar tidur Scandinavian" class="w-full h-auto object-cover"
                        src="https://images.unsplash.com/photo-1616594039964-ae9021a400a0?auto=format&fit=crop&w=800&q=80" />
                    <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex flex-col justify-end p-8">
                        <span class="text-primary text-[10px] uppercase tracking-[0.3em] font-bold mb-2">Residensial</span>
                        <h3 class="text-2xl md:text-3xl text-white italic font-serif">Serene Master Suite</h3>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/sections/services.php'; ?>
<?php require_once __DIR__ . '/includes/sections/calculator.php'; ?>
<?php require_once __DIR__ . '/includes/sections/testimonials.php'; ?>
<?php require_once __DIR__ . '/includes/sections/contact.php'; ?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>