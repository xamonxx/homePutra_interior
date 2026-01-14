<?php

/**
 * All Services Page
 */
require_once __DIR__ . '/config/database.php';

$pageTitle = 'Layanan Desain Kami - Home Putra Interior';
require_once __DIR__ . '/includes/header.php';

// Fetch all services
$services = [];
try {
    $db = getDB();
    $stmt = $db->query("SELECT * FROM services WHERE is_active = 1 ORDER BY display_order ASC");
    $services = $stmt->fetchAll();
} catch (PDOException $e) {
    $services = [];
}

// Icon to SVG Mapping
function getServiceIconAll($iconName)
{
    $icons = [
        'home' => '<path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>',
        'storefront' => '<path d="M3 3h18v18H3V3zM9 9h6v6H9V9z"></path>',
        'chair' => '<path d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>',
        'chat' => '<path d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>',
        'engineering' => '<path d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>',
        'brush' => '<path d="M7 21a4 4 0 01-4-4 4 4 0 014-4h3l2 2 6 6-6 6-2-2H7z"></path>',
        'palette' => '<path d="M12 2a10 10 0 1010 10A10 10 0 0012 2zm0 18a8 8 0 118-8 8 8 0 01-8 8z"></path>',
        'lightbulb' => '<path d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0012 18.75V19a2 2 0 11-4 0v-.25c0-.994-.403-1.895-1.054-2.547l-.548-.547z"></path>',
        'construction' => '<path d="M14.7 6.3a1 1 0 000 1.4l1.6 1.6a1 1 0 001.4 0l3.77-3.77a6 6 0 01-7.94 7.94l-6.91 6.91a2.12 2.12 0 01-3-3l6.91-6.91a6 6 0 017.94-7.94l-3.77 3.77z"></path>',
        'architecture' => '<path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>'
    ];
    return $icons[$iconName] ?? $icons['home'];
}
?>

<section class="py-32 bg-background-dark min-h-screen">
    <div class="max-w-[1200px] mx-auto px-6">
        <!-- Header -->
        <div class="text-center mb-20" data-aos="fade-up">
            <a href="<?php echo SITE_URL; ?>" class="inline-flex text-primary hover:text-white items-center gap-2 text-xs uppercase tracking-widest font-bold mb-8 transition-colors group">
                <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali ke Beranda
            </a>
            <br>
            <span class="text-primary uppercase tracking-[0.4em] text-[10px] font-bold">Layanan Kami</span>
            <h1 class="text-5xl md:text-7xl text-white mt-5 font-serif italic">Solusi Desain Interior</h1>
        </div>

        <!-- Services Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
            <?php foreach ($services as $index => $service): ?>
                <div class="p-10 rounded-sm border border-white/5 bg-white/[0.02] hover:border-primary/30 transition-all duration-500 group card-hover" data-aos="fade-up" data-aos-delay="<?php echo ($index % 3) * 100; ?>">
                    <div class="w-16 h-16 rounded-full bg-primary/10 flex items-center justify-center text-primary mb-8 group-hover:bg-primary group-hover:text-black transition-all duration-300">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <?php echo getServiceIconAll($service['icon']); ?>
                        </svg>
                    </div>
                    <h3 class="text-3xl text-white mb-6 font-serif"><?php echo htmlspecialchars($service['title']); ?></h3>
                    <p class="text-gray-400 leading-relaxed mb-8 font-light italic">
                        <?php echo htmlspecialchars($service['description']); ?>
                    </p>
                    <div class="h-px bg-white/5 w-12 group-hover:w-full transition-all duration-500"></div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Contact CTA -->
        <div class="mt-32 p-16 rounded-sm bg-primary/5 border border-primary/10 text-center" data-aos="fade-up">
            <h2 class="text-3xl md:text-4xl text-white mb-6 font-serif">Punya Proyek Impian?</h2>
            <p class="text-gray-400 max-w-xl mx-auto mb-10 font-light">
                Konsultasikan kebutuhan ruang Anda dengan tim ahli kami secara gratis dan dapatkan penawaran yang disesuaikan.
            </p>
            <a href="<?php echo SITE_URL; ?>/#contact" class="inline-flex h-14 items-center justify-center px-10 rounded-sm bg-primary text-black text-xs uppercase tracking-widest font-bold hover:bg-primary-hover transition-all">
                Hubungi Kami Sekarang
            </a>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>