<?php

/**
 * Admin Dashboard
 * Home Putra Interior CMS
 */

// Include auth FIRST - before any output
require_once __DIR__ . '/includes/auth.php';

// Get statistics
try {
    $db = getDB();

    // Count portfolio items
    $stmt = $db->query("SELECT COUNT(*) FROM portfolio WHERE is_active = 1");
    $portfolioCount = $stmt->fetchColumn();

    // Count services
    $stmt = $db->query("SELECT COUNT(*) FROM services WHERE is_active = 1");
    $servicesCount = $stmt->fetchColumn();

    // Count testimonials
    $stmt = $db->query("SELECT COUNT(*) FROM testimonials WHERE is_active = 1");
    $testimonialsCount = $stmt->fetchColumn();

    // Count unread messages
    $stmt = $db->query("SELECT COUNT(*) FROM contact_submissions WHERE is_read = 0");
    $unreadMessages = $stmt->fetchColumn();

    // Get recent messages
    $stmt = $db->query("SELECT * FROM contact_submissions ORDER BY created_at DESC LIMIT 5");
    $recentMessages = $stmt->fetchAll();
} catch (PDOException $e) {
    $portfolioCount = $servicesCount = $testimonialsCount = $unreadMessages = 0;
    $recentMessages = [];
}

// NOW include header - after all database operations
$pageTitle = 'Dashboard';
require_once __DIR__ . '/includes/header.php';
?>

<!-- Stats Cards -->
<div class="grid grid-cols-2 md:grid-cols-4 gap-2 md:gap-4 lg:gap-6 mb-4 md:mb-6 lg:mb-8">
    <!-- Portfolio Card -->
    <div class="bg-white rounded-xl p-3 md:p-4 lg:p-6 shadow-sm border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-[10px] md:text-xs lg:text-sm font-medium text-gray-500">Portfolio</p>
                <p class="text-xl md:text-2xl lg:text-3xl font-bold text-gray-800 mt-0.5 md:mt-1"><?php echo $portfolioCount; ?></p>
            </div>
            <div class="w-8 h-8 md:w-10 md:h-10 lg:w-12 lg:h-12 bg-blue-100 rounded-lg md:rounded-xl flex items-center justify-center">
                <span class="material-symbols-outlined text-blue-600 text-lg md:text-xl lg:text-2xl">photo_library</span>
            </div>
        </div>
        <a href="portfolio.php" class="text-[10px] md:text-xs lg:text-sm text-blue-600 hover:underline mt-2 md:mt-3 lg:mt-4 inline-flex items-center gap-1">
            Kelola
            <span class="material-symbols-outlined text-[10px] md:text-xs lg:text-sm">arrow_forward</span>
        </a>
    </div>

    <!-- Services Card -->
    <div class="bg-white rounded-xl p-3 md:p-4 lg:p-6 shadow-sm border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-[10px] md:text-xs lg:text-sm font-medium text-gray-500">Layanan</p>
                <p class="text-xl md:text-2xl lg:text-3xl font-bold text-gray-800 mt-0.5 md:mt-1"><?php echo $servicesCount; ?></p>
            </div>
            <div class="w-8 h-8 md:w-10 md:h-10 lg:w-12 lg:h-12 bg-green-100 rounded-lg md:rounded-xl flex items-center justify-center">
                <span class="material-symbols-outlined text-green-600 text-lg md:text-xl lg:text-2xl">design_services</span>
            </div>
        </div>
        <a href="services.php" class="text-[10px] md:text-xs lg:text-sm text-green-600 hover:underline mt-2 md:mt-3 lg:mt-4 inline-flex items-center gap-1">
            Kelola
            <span class="material-symbols-outlined text-[10px] md:text-xs lg:text-sm">arrow_forward</span>
        </a>
    </div>

    <!-- Testimonials Card -->
    <div class="bg-white rounded-xl p-3 md:p-4 lg:p-6 shadow-sm border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-[10px] md:text-xs lg:text-sm font-medium text-gray-500">Testimoni</p>
                <p class="text-xl md:text-2xl lg:text-3xl font-bold text-gray-800 mt-0.5 md:mt-1"><?php echo $testimonialsCount; ?></p>
            </div>
            <div class="w-8 h-8 md:w-10 md:h-10 lg:w-12 lg:h-12 bg-purple-100 rounded-lg md:rounded-xl flex items-center justify-center">
                <span class="material-symbols-outlined text-purple-600 text-lg md:text-xl lg:text-2xl">rate_review</span>
            </div>
        </div>
        <a href="testimonials.php" class="text-[10px] md:text-xs lg:text-sm text-purple-600 hover:underline mt-2 md:mt-3 lg:mt-4 inline-flex items-center gap-1">
            Kelola
            <span class="material-symbols-outlined text-[10px] md:text-xs lg:text-sm">arrow_forward</span>
        </a>
    </div>

    <!-- Messages Card -->
    <div class="bg-white rounded-xl p-3 md:p-4 lg:p-6 shadow-sm border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-[10px] md:text-xs lg:text-sm font-medium text-gray-500">Pesan Baru</p>
                <p class="text-xl md:text-2xl lg:text-3xl font-bold text-gray-800 mt-0.5 md:mt-1"><?php echo $unreadMessages; ?></p>
            </div>
            <div class="w-8 h-8 md:w-10 md:h-10 lg:w-12 lg:h-12 bg-orange-100 rounded-lg md:rounded-xl flex items-center justify-center">
                <span class="material-symbols-outlined text-orange-600 text-lg md:text-xl lg:text-2xl">mail</span>
            </div>
        </div>
        <a href="contacts.php" class="text-[10px] md:text-xs lg:text-sm text-orange-600 hover:underline mt-2 md:mt-3 lg:mt-4 inline-flex items-center gap-1">
            Lihat
            <span class="material-symbols-outlined text-[10px] md:text-xs lg:text-sm">arrow_forward</span>
        </a>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3 md:gap-4 lg:gap-6">
    <!-- Recent Messages -->
    <div class="md:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="p-3 md:p-4 lg:p-6 border-b border-gray-100">
            <h2 class="text-sm md:text-base lg:text-lg font-semibold text-gray-800">Pesan Terbaru</h2>
        </div>
        <div class="divide-y divide-gray-100">
            <?php if (empty($recentMessages)): ?>
                <div class="p-4 md:p-6 text-center text-gray-500">
                    <span class="material-symbols-outlined text-3xl md:text-4xl mb-2">inbox</span>
                    <p class="text-xs md:text-sm">Belum ada pesan masuk</p>
                </div>
            <?php else: ?>
                <?php foreach ($recentMessages as $message): ?>
                    <a href="contacts.php?view=detail&id=<?php echo $message['id']; ?>" class="block p-2.5 md:p-3 lg:p-4 hover:bg-gray-50 transition-colors">
                        <div class="flex items-start gap-2 md:gap-3">
                            <div class="w-8 h-8 md:w-9 md:h-9 lg:w-10 lg:h-10 rounded-full bg-primary/20 flex items-center justify-center text-primary font-semibold flex-shrink-0 text-xs md:text-sm">
                                <?php echo strtoupper(substr($message['first_name'], 0, 1)); ?>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between mb-0.5 md:mb-1 gap-2">
                                    <p class="font-medium text-gray-800 text-xs md:text-sm lg:text-base truncate">
                                        <?php echo e($message['first_name'] . ' ' . $message['last_name']); ?>
                                        <?php if (!$message['is_read']): ?>
                                            <span class="inline-block w-1.5 h-1.5 md:w-2 md:h-2 bg-primary rounded-full ml-1"></span>
                                        <?php endif; ?>
                                    </p>
                                    <span class="text-[10px] md:text-xs text-gray-400 flex-shrink-0"><?php echo date('d/m', strtotime($message['created_at'])); ?></span>
                                </div>
                                <p class="text-[10px] md:text-xs lg:text-sm text-gray-600 truncate"><?php echo e($message['message'] ?: 'Tidak ada pesan'); ?></p>
                            </div>
                        </div>
                    </a>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <?php if (!empty($recentMessages)): ?>
            <div class="p-2.5 md:p-3 lg:p-4 border-t border-gray-100">
                <a href="contacts.php" class="text-[10px] md:text-xs lg:text-sm text-primary hover:underline">Lihat semua pesan →</a>
            </div>
        <?php endif; ?>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="p-3 md:p-4 lg:p-6 border-b border-gray-100">
            <h2 class="text-sm md:text-base lg:text-lg font-semibold text-gray-800">Aksi Cepat</h2>
        </div>
        <div class="p-2 md:p-3 lg:p-4 space-y-1.5 md:space-y-2 lg:space-y-3">
            <a href="portfolio.php?action=add" class="flex items-center gap-2 md:gap-3 p-2 md:p-2.5 lg:p-3 rounded-lg hover:bg-gray-50 transition-colors group">
                <div class="w-8 h-8 md:w-9 md:h-9 lg:w-10 lg:h-10 bg-blue-100 rounded-lg flex items-center justify-center group-hover:bg-blue-200 transition-colors">
                    <span class="material-symbols-outlined text-blue-600 text-base md:text-lg lg:text-xl">add_photo_alternate</span>
                </div>
                <div>
                    <p class="font-medium text-gray-800 text-xs md:text-sm lg:text-base">Tambah Portfolio</p>
                    <p class="text-[10px] md:text-xs text-gray-500 hidden md:block">Upload karya baru</p>
                </div>
            </a>

            <a href="services.php?action=add" class="flex items-center gap-2 md:gap-3 p-2 md:p-2.5 lg:p-3 rounded-lg hover:bg-gray-50 transition-colors group">
                <div class="w-8 h-8 md:w-9 md:h-9 lg:w-10 lg:h-10 bg-green-100 rounded-lg flex items-center justify-center group-hover:bg-green-200 transition-colors">
                    <span class="material-symbols-outlined text-green-600 text-base md:text-lg lg:text-xl">add_circle</span>
                </div>
                <div>
                    <p class="font-medium text-gray-800 text-xs md:text-sm lg:text-base">Tambah Layanan</p>
                    <p class="text-[10px] md:text-xs text-gray-500 hidden md:block">Buat layanan baru</p>
                </div>
            </a>

            <a href="testimonials.php?action=add" class="flex items-center gap-2 md:gap-3 p-2 md:p-2.5 lg:p-3 rounded-lg hover:bg-gray-50 transition-colors group">
                <div class="w-8 h-8 md:w-9 md:h-9 lg:w-10 lg:h-10 bg-purple-100 rounded-lg flex items-center justify-center group-hover:bg-purple-200 transition-colors">
                    <span class="material-symbols-outlined text-purple-600 text-base md:text-lg lg:text-xl">reviews</span>
                </div>
                <div>
                    <p class="font-medium text-gray-800 text-xs md:text-sm lg:text-base">Tambah Testimoni</p>
                    <p class="text-[10px] md:text-xs text-gray-500 hidden md:block">Tambah ulasan klien</p>
                </div>
            </a>

            <a href="settings.php" class="flex items-center gap-2 md:gap-3 p-2 md:p-2.5 lg:p-3 rounded-lg hover:bg-gray-50 transition-colors group">
                <div class="w-8 h-8 md:w-9 md:h-9 lg:w-10 lg:h-10 bg-gray-100 rounded-lg flex items-center justify-center group-hover:bg-gray-200 transition-colors">
                    <span class="material-symbols-outlined text-gray-600 text-base md:text-lg lg:text-xl">settings</span>
                </div>
                <div>
                    <p class="font-medium text-gray-800 text-xs md:text-sm lg:text-base">Pengaturan</p>
                    <p class="text-[10px] md:text-xs text-gray-500 hidden md:block">Kelola pengaturan</p>
                </div>
            </a>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>