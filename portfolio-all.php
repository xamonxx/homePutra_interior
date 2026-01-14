<?php

/**
 * All Portfolios Page
 */
require_once __DIR__ . '/config/database.php';

$pageTitle = 'Semua Portfolio - Home Putra Interior';
require_once __DIR__ . '/includes/header.php';

// Fetch all portfolios
$portfolios = [];
try {
    $db = getDB();
    $stmt = $db->query("SELECT * FROM portfolio WHERE is_active = 1 ORDER BY display_order ASC, created_at DESC");
    $portfolios = $stmt->fetchAll();
} catch (PDOException $e) {
    $portfolios = [];
}

// Fallback images
$fallbackImages = [
    'https://images.unsplash.com/photo-1600210492486-724fe5c67fb0?auto=format&fit=crop&w=800&q=80',
    'https://images.unsplash.com/photo-1497366216548-37526070297c?auto=format&fit=crop&w=800&q=80',
    'https://images.unsplash.com/photo-1616594039964-ae9021a400a0?auto=format&fit=crop&w=800&q=80',
    'https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?auto=format&fit=crop&w=800&q=80',
    'https://images.unsplash.com/photo-1617806118233-18e1de247200?auto=format&fit=crop&w=800&q=80',
];
?>

<section class="py-32 bg-background-dark min-h-screen">
    <div class="max-w-[1200px] mx-auto px-6">
        <!-- Header -->
        <div class="mb-20" data-aos="fade-up">
            <a href="<?php echo SITE_URL; ?>" class="text-primary hover:text-white flex items-center gap-2 text-xs uppercase tracking-widest font-bold mb-8 transition-colors group">
                <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali ke Beranda
            </a>
            <span class="text-primary uppercase tracking-[0.4em] text-[10px] font-bold">Koleksi Lengkap</span>
            <h1 class="text-5xl md:text-7xl text-white mt-5 font-serif italic">Portfolio Kami</h1>
        </div>

        <!-- Portfolio Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php if (!empty($portfolios)): ?>
                <?php foreach ($portfolios as $index => $portfolio): ?>
                    <?php
                    $imageSrc = !empty($portfolio['image']) ? $portfolio['image'] : $fallbackImages[$index % count($fallbackImages)];
                    ?>
                    <div class="group relative overflow-hidden rounded-sm cursor-pointer img-hover-zoom card-hover aspect-[4/5]" data-aos="fade-up" data-aos-delay="<?php echo ($index % 3) * 100; ?>">
                        <img alt="<?php echo htmlspecialchars($portfolio['title']); ?>" class="w-full h-full object-cover"
                            src="<?php echo htmlspecialchars($imageSrc); ?>" />
                        <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex flex-col justify-end p-8">
                            <span class="text-primary text-[10px] uppercase tracking-[0.3em] font-bold mb-2"><?php echo htmlspecialchars($portfolio['category'] ?: 'Interior'); ?></span>
                            <h3 class="text-2xl text-white italic font-serif"><?php echo htmlspecialchars($portfolio['title']); ?></h3>
                            <p class="text-gray-400 text-xs mt-2 line-clamp-2 font-light"><?php echo htmlspecialchars($portfolio['description'] ?? ''); ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-span-full py-20 text-center">
                    <p class="text-gray-500">Belum ada portfolio untuk ditampilkan.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>