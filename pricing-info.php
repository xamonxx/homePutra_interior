<?php
require_once __DIR__ . '/config/database.php';
$pageTitle = 'Informasi Harga & Material - Home Putra Interior';
require_once __DIR__ . '/includes/header.php';

$materials = [
    ['id' => 'aluminium-acp', 'name' => 'Aluminium + ACP', 'grade' => 'A', 'image' => SITE_URL . '/assets/images/materials/aluminium-acp.png', 'badge' => '🏆 Best Seller', 'features' => ['Anti Air', 'Anti Rayap', 'Tahan Lama'], 'description' => 'Rangka aluminium kokoh dengan panel ACP 4mm. Material premium dengan daya tahan tertinggi.', 'price_same' => true, 'prices' => [['type' => 'Minimalis', 'dalam' => 3500000, 'luar' => 3500000], ['type' => 'Premium', 'dalam' => 4500000, 'luar' => 4500000], ['type' => 'Semi Klasik', 'dalam' => 5000000, 'luar' => 5000000], ['type' => 'Luxury', 'dalam' => 5500000, 'luar' => 5500000]]],
    ['id' => 'pvc-board', 'name' => 'PVC Board', 'grade' => 'B', 'image' => SITE_URL . '/assets/images/materials/pvc-board.png', 'badge' => '💧 Tahan Air', 'features' => ['Anti Air', 'Anti Rayap', 'Ringan'], 'description' => 'Material PVC tebal 18mm dengan finishing HPL. Tahan air dan rayap sempurna.', 'price_same' => false, 'diff' => '+100rb', 'prices' => [['type' => 'Minimalis', 'dalam' => 4000000, 'luar' => 4100000], ['type' => 'Semi Klasik', 'dalam' => 4500000, 'luar' => 4600000], ['type' => 'Klasik', 'dalam' => 5000000, 'luar' => 5100000], ['type' => 'Luxury', 'dalam' => 5500000, 'luar' => 5600000]]],
    ['id' => 'multipleks-hpl', 'name' => 'Multipleks HPL', 'grade' => 'B', 'image' => SITE_URL . '/assets/images/materials/multipleks-hpl.png', 'badge' => '⭐ Populer', 'features' => ['Struktur Kuat', 'Finishing HPL', 'Tahan Lama'], 'description' => 'Plywood 18mm dengan finishing HPL berkualitas. Pilihan populer untuk berbagai gaya.', 'price_same' => false, 'diff' => '+100rb', 'prices' => [['type' => 'Minimalis', 'dalam' => 2500000, 'luar' => 2600000], ['type' => 'Semi Klasik', 'dalam' => 2800000, 'luar' => 2900000], ['type' => 'Klasik', 'dalam' => 3200000, 'luar' => 3300000], ['type' => 'Luxury', 'dalam' => 3500000, 'luar' => 3600000]]],
    ['id' => 'multipleks-duco', 'name' => 'Multipleks Duco', 'grade' => 'B', 'image' => SITE_URL . '/assets/images/materials/multipleks-duco.png', 'badge' => '💎 Premium', 'features' => ['Glossy Finish', 'Cat Duco', 'Premium Look'], 'description' => 'Plywood dengan finishing cat Duco glossy premium. Tampilan mewah dan elegan.', 'price_same' => false, 'diff' => '+500rb', 'prices' => [['type' => 'Minimalis', 'dalam' => 4500000, 'luar' => 5000000], ['type' => 'Semi Klasik', 'dalam' => 5000000, 'luar' => 5500000], ['type' => 'Klasik', 'dalam' => 5500000, 'luar' => 6000000], ['type' => 'Luxury', 'dalam' => 6000000, 'luar' => 6500000]]],
    ['id' => 'blockboard', 'name' => 'Blockboard', 'grade' => 'C', 'image' => SITE_URL . '/assets/images/materials/blockboard.png', 'badge' => '💰 Ekonomis', 'features' => ['Harga Terjangkau', 'Finishing HPL', 'Opsi Ekonomis'], 'description' => 'Material blockboard 18mm dengan finishing HPL. Pilihan ekonomis dengan kualitas baik.', 'price_same' => false, 'diff' => '+300rb', 'prices' => [['type' => 'Minimalis', 'dalam' => 2000000, 'luar' => 2300000], ['type' => 'Semi Klasik', 'dalam' => 2300000, 'luar' => 2600000], ['type' => 'Klasik', 'dalam' => 2600000, 'luar' => 2900000], ['type' => 'Luxury', 'dalam' => 2900000, 'luar' => 3200000]]],
];
function formatRupiah($n)
{
    return 'Rp ' . number_format($n, 0, ',', '.');
}
$gradeColors = ['A' => ['bg' => 'bg-emerald-500', 'text' => 'text-emerald-400'], 'B' => ['bg' => 'bg-blue-500', 'text' => 'text-blue-400'], 'C' => ['bg' => 'bg-orange-500', 'text' => 'text-orange-400']];
?>

<style>
    /* ===== CLEAN PREMIUM DESIGN ===== */

    /* Product Card */
    .product-card {
        position: relative;
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 24px;
        overflow: hidden;
        transition: all 0.4s ease;
    }

    .product-card:hover {
        transform: translateY(-8px);
        border-color: rgba(197, 158, 62, 0.5);
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5), 0 0 0 1px rgba(197, 158, 62, 0.2);
    }

    /* Image */
    .product-card .card-img {
        position: relative;
        aspect-ratio: 4/3;
        overflow: hidden;
        background: #1a1a2e;
    }

    .product-card .card-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .product-card:hover .card-img img {
        transform: scale(1.08);
    }

    .product-card .card-img::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(15, 23, 42, 0.9) 0%, transparent 50%);
        opacity: 0;
        transition: opacity 0.4s;
    }

    .product-card:hover .card-img::after {
        opacity: 1;
    }

    /* View Button */
    .product-card .view-btn {
        position: absolute;
        bottom: 20px;
        left: 50%;
        transform: translateX(-50%) translateY(20px);
        opacity: 0;
        z-index: 5;
        transition: all 0.4s ease;
    }

    .product-card:hover .view-btn {
        transform: translateX(-50%) translateY(0);
        opacity: 1;
    }

    /* Badge */
    .card-badge {
        position: absolute;
        top: 16px;
        z-index: 10;
        padding: 8px 16px;
        border-radius: 50px;
        font-size: 12px;
        font-weight: 700;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
    }

    .card-badge.left {
        left: 16px;
    }

    .card-badge.right {
        right: 16px;
    }

    /* Price Box */
    .price-box {
        background: linear-gradient(135deg, rgba(197, 158, 62, 0.12) 0%, rgba(197, 158, 62, 0.04) 100%);
        border: 1px solid rgba(197, 158, 62, 0.25);
        border-radius: 16px;
        padding: 20px;
        text-align: center;
    }

    .price-value {
        font-size: 1.75rem;
        font-weight: 800;
        color: #C59E3E;
    }

    /* Tags */
    .feature-tag {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 50px;
        font-size: 11px;
        color: #94a3b8;
        transition: all 0.3s;
    }

    .feature-tag:hover {
        background: rgba(197, 158, 62, 0.1);
        border-color: rgba(197, 158, 62, 0.3);
        color: #C59E3E;
    }

    /* Table */
    .price-table {
        border-radius: 16px;
        overflow: hidden;
        background: rgba(255, 255, 255, 0.02);
        border: 1px solid rgba(255, 255, 255, 0.05);
    }

    .price-row {
        display: grid;
        grid-template-columns: 1.5fr 1fr 1fr;
        padding: 16px 20px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        transition: background 0.2s;
    }

    .price-row:last-child {
        border-bottom: none;
    }

    .price-row:not(.header):hover {
        background: rgba(197, 158, 62, 0.05);
    }

    .price-row.header {
        background: rgba(255, 255, 255, 0.03);
    }

    /* Modal */
    .modal-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.85);
        backdrop-filter: blur(10px);
        z-index: 1000;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s;
    }

    .modal-overlay.active {
        opacity: 1;
        visibility: visible;
    }

    .modal-container {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%) scale(0.95);
        width: 95%;
        max-width: 900px;
        max-height: 90vh;
        overflow-y: auto;
        background: linear-gradient(145deg, #1e293b 0%, #0f172a 100%);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 24px;
        z-index: 1001;
        opacity: 0;
        visibility: hidden;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .modal-container.active {
        opacity: 1;
        visibility: visible;
        transform: translate(-50%, -50%) scale(1);
    }

    /* Shipping Card */
    .ship-card {
        padding: 32px 24px;
        border-radius: 20px;
        text-align: center;
        transition: all 0.3s;
        background: rgba(255, 255, 255, 0.02);
    }

    .ship-card:hover {
        transform: translateY(-5px);
        background: rgba(255, 255, 255, 0.04);
    }

    /* CTA */
    .cta-section {
        position: relative;
        border-radius: 32px;
        background: linear-gradient(135deg, rgba(197, 158, 62, 0.1) 0%, rgba(197, 158, 62, 0.02) 100%);
        border: 1px solid rgba(197, 158, 62, 0.2);
        overflow: hidden;
    }

    /* Gold Button */
    .btn-gold {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        height: 56px;
        padding: 0 32px;
        background: linear-gradient(135deg, #C59E3E 0%, #D4AF37 100%);
        color: #000;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        border-radius: 50px;
        transition: all 0.3s;
        box-shadow: 0 8px 25px rgba(197, 158, 62, 0.3);
    }

    .btn-gold:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 35px rgba(197, 158, 62, 0.4);
    }

    /* Outline Button */
    .btn-outline {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        height: 56px;
        padding: 0 32px;
        background: transparent;
        color: #fff;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        border: 2px solid rgba(255, 255, 255, 0.2);
        border-radius: 50px;
        transition: all 0.3s;
    }

    .btn-outline:hover {
        border-color: #C59E3E;
        color: #C59E3E;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .price-row {
            grid-template-columns: 1fr 1fr;
            gap: 4px;
        }

        .price-row .col-model {
            grid-column: span 2;
            text-align: center;
            margin-bottom: 8px;
        }

        .modal-container {
            max-height: 95vh;
            border-radius: 24px 24px 0 0;
            top: auto;
            bottom: 0;
            transform: translateX(-50%) translateY(100%);
        }

        .modal-container.active {
            transform: translateX(-50%) translateY(0);
        }
    }
</style>

<section class="py-20 lg:py-32 bg-background-dark min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Header -->
        <div class="text-center mb-16 lg:mb-24" data-aos="fade-up">
            <a href="<?= SITE_URL ?>" class="inline-flex items-center gap-2 text-primary hover:text-white text-xs uppercase tracking-widest font-bold mb-6 transition-colors">
                <span class="material-symbols-outlined text-lg">arrow_back</span>
                Kembali
            </a>
            <div class="mb-4">
                <span class="inline-block px-5 py-2 rounded-full bg-primary/10 border border-primary/30 text-primary text-[10px] font-bold uppercase tracking-widest">Katalog Material</span>
            </div>
            <h1 class="text-3xl sm:text-4xl lg:text-6xl text-white font-serif italic mb-4">Material <span class="text-primary">Premium</span></h1>
            <p class="text-gray-400 max-w-xl mx-auto">Koleksi material furniture berkualitas tinggi dengan harga transparan.</p>
        </div>

        <!-- Region Info -->
        <div class="flex flex-wrap justify-center gap-3 mb-12 lg:mb-20" data-aos="fade-up">
            <div class="flex items-center gap-2 px-5 py-3 rounded-full bg-primary/10 border border-primary/30">
                <span class="w-2.5 h-2.5 rounded-full bg-primary"></span>
                <span class="text-white text-sm font-medium">Dalam Kota</span>
                <span class="text-gray-500 text-xs">(Bandung)</span>
            </div>
            <div class="flex items-center gap-2 px-5 py-3 rounded-full bg-white/5 border border-white/10">
                <span class="w-2.5 h-2.5 rounded-full bg-gray-400"></span>
                <span class="text-white text-sm font-medium">Luar Kota</span>
                <span class="text-gray-500 text-xs">(Jabodetabek, Jateng, Jatim)</span>
            </div>
        </div>

        <!-- Product Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8 mb-20 lg:mb-32">
            <?php foreach ($materials as $i => $m): ?>
                <div class="product-card" data-aos="fade-up" data-aos-delay="<?= $i * 80 ?>">
                    <div class="card-img">
                        <img src="<?= $m['image'] ?>" alt="<?= $m['name'] ?>" loading="lazy">
                        <div class="card-badge left bg-primary text-black"><?= $m['badge'] ?></div>
                        <div class="card-badge right <?= $gradeColors[$m['grade']]['bg'] ?> text-white">Grade <?= $m['grade'] ?></div>
                        <div class="view-btn">
                            <button onclick="openModal('<?= $m['id'] ?>')" class="btn-gold text-xs px-6 h-11">Lihat Detail</button>
                        </div>
                    </div>
                    <div class="p-5 sm:p-6">
                        <h3 class="text-lg sm:text-xl text-white font-bold mb-2"><?= $m['name'] ?></h3>
                        <p class="text-gray-400 text-sm mb-4 line-clamp-2"><?= $m['description'] ?></p>
                        <div class="flex flex-wrap gap-2 mb-5">
                            <?php foreach ($m['features'] as $f): ?>
                                <span class="feature-tag"><span class="text-primary">✓</span> <?= $f ?></span>
                            <?php endforeach; ?>
                        </div>
                        <div class="price-box">
                            <div class="text-gray-400 text-xs uppercase tracking-wider mb-1">Mulai dari</div>
                            <div class="price-value"><?= formatRupiah($m['prices'][0]['dalam']) ?></div>
                            <div class="text-gray-500 text-xs mt-1">per meter</div>
                            <div class="mt-3 pt-3 border-t border-white/10">
                                <?php if ($m['price_same']): ?>
                                    <span class="text-xs text-emerald-400 font-medium">✓ Harga sama semua wilayah</span>
                                <?php else: ?>
                                    <span class="text-xs text-gray-400">Luar Kota: </span>
                                    <span class="text-xs text-amber-400 font-bold"><?= $m['diff'] ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Price Tables -->
        <div class="mb-20 lg:mb-32" data-aos="fade-up">
            <div class="text-center mb-12">
                <span class="inline-block px-4 py-1.5 rounded-full bg-primary/10 text-primary text-[10px] font-bold uppercase tracking-widest mb-3">Harga Lengkap</span>
                <h2 class="text-2xl sm:text-3xl lg:text-4xl text-white font-serif">Perbandingan Detail</h2>
            </div>

            <?php foreach ($materials as $m): ?>
                <div class="mb-8 p-5 sm:p-8 rounded-2xl border border-white/5 bg-white/[0.02]">
                    <div class="flex flex-col sm:flex-row sm:items-center gap-4 sm:gap-6 mb-6">
                        <img src="<?= $m['image'] ?>" alt="<?= $m['name'] ?>" class="w-20 h-20 sm:w-24 sm:h-24 rounded-xl object-cover mx-auto sm:mx-0">
                        <div class="flex-1 text-center sm:text-left">
                            <h3 class="text-xl sm:text-2xl text-white font-bold"><?= $m['name'] ?></h3>
                            <p class="text-gray-400 text-sm mt-1"><?= $m['description'] ?></p>
                        </div>
                        <div class="px-4 py-2 rounded-lg text-center <?= $m['price_same'] ? 'bg-emerald-500/10 border border-emerald-500/30' : 'bg-amber-500/10 border border-amber-500/30' ?>">
                            <span class="text-sm font-bold <?= $m['price_same'] ? 'text-emerald-400' : 'text-amber-400' ?>">
                                <?= $m['price_same'] ? '✓ Sama' : 'LK: ' . $m['diff'] ?>
                            </span>
                        </div>
                    </div>
                    <div class="price-table">
                        <div class="price-row header">
                            <div class="text-gray-400 text-xs uppercase tracking-wider font-medium col-model">Model</div>
                            <div class="text-gray-400 text-xs uppercase tracking-wider font-medium text-right">Dalam Kota</div>
                            <div class="text-gray-400 text-xs uppercase tracking-wider font-medium text-right">Luar Kota</div>
                        </div>
                        <?php foreach ($m['prices'] as $p): ?>
                            <div class="price-row">
                                <div class="text-white font-medium col-model"><?= $p['type'] ?></div>
                                <div class="text-white text-right"><?= formatRupiah($p['dalam']) ?></div>
                                <div class="text-primary font-bold text-right"><?= formatRupiah($p['luar']) ?></div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Shipping -->
        <div class="mb-20 lg:mb-32" data-aos="fade-up">
            <div class="text-center mb-12">
                <span class="inline-block px-4 py-1.5 rounded-full bg-primary/10 text-primary text-[10px] font-bold uppercase tracking-widest mb-3">Pengiriman</span>
                <h2 class="text-2xl sm:text-3xl lg:text-4xl text-white font-serif">Ongkos Kirim</h2>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                <div class="ship-card border border-primary/20">
                    <div class="w-16 h-16 rounded-xl bg-primary/10 flex items-center justify-center mx-auto mb-5">
                        <span class="material-symbols-outlined text-primary text-3xl">local_shipping</span>
                    </div>
                    <div class="text-2xl sm:text-3xl font-bold text-white mb-2">Rp 500rb</div>
                    <div class="text-gray-400 text-sm mb-3">Proyek &lt; Rp 15 juta</div>
                    <span class="inline-block px-4 py-1.5 rounded-full bg-primary/10 text-primary text-xs font-bold">Dalam Kota</span>
                </div>
                <div class="ship-card border border-amber-500/20">
                    <div class="w-16 h-16 rounded-xl bg-amber-500/10 flex items-center justify-center mx-auto mb-5">
                        <span class="material-symbols-outlined text-amber-400 text-3xl">flight</span>
                    </div>
                    <div class="text-2xl sm:text-3xl font-bold text-white mb-2">Rp 1 juta</div>
                    <div class="text-gray-400 text-sm mb-3">Proyek Rp 15-20 juta</div>
                    <span class="inline-block px-4 py-1.5 rounded-full bg-amber-500/10 text-amber-400 text-xs font-bold">Luar Area</span>
                </div>
                <div class="ship-card border border-emerald-500/20">
                    <div class="w-16 h-16 rounded-xl bg-emerald-500/10 flex items-center justify-center mx-auto mb-5">
                        <span class="material-symbols-outlined text-emerald-400 text-3xl">verified</span>
                    </div>
                    <div class="text-2xl sm:text-3xl font-bold text-emerald-400 mb-2">GRATIS</div>
                    <div class="text-gray-400 text-sm mb-3">Proyek ≥ Rp 20 juta</div>
                    <span class="inline-block px-4 py-1.5 rounded-full bg-emerald-500/10 text-emerald-400 text-xs font-bold">Free Ongkir</span>
                </div>
            </div>
        </div>

        <!-- CTA -->
        <div class="cta-section p-8 sm:p-12 lg:p-16 text-center" data-aos="fade-up">
            <h2 class="text-2xl sm:text-3xl lg:text-4xl text-white mb-4 font-serif">Siap Memulai Proyek?</h2>
            <p class="text-gray-400 max-w-lg mx-auto mb-8">Hitung estimasi biaya Anda sekarang dengan kalkulator interaktif kami.</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="<?= SITE_URL ?>/calculator.php" class="btn-gold">
                    <span class="material-symbols-outlined mr-2 text-lg">calculate</span> Hitung Estimasi
                </a>
                <a href="<?= SITE_URL ?>/#contact" class="btn-outline">
                    <span class="material-symbols-outlined mr-2 text-lg">chat</span> Konsultasi
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Modals -->
<?php foreach ($materials as $m): ?>
    <div class="modal-overlay" id="overlay-<?= $m['id'] ?>" onclick="closeModal('<?= $m['id'] ?>')"></div>
    <div class="modal-container" id="modal-<?= $m['id'] ?>">
        <button onclick="closeModal('<?= $m['id'] ?>')" class="absolute top-4 right-4 w-10 h-10 rounded-full bg-white/10 hover:bg-white/20 flex items-center justify-center text-white transition-colors z-10">
            <span class="material-symbols-outlined">close</span>
        </button>
        <div class="grid md:grid-cols-2">
            <div class="aspect-square md:aspect-auto bg-slate-800">
                <img src="<?= $m['image'] ?>" alt="<?= $m['name'] ?>" class="w-full h-full object-cover">
            </div>
            <div class="p-6 sm:p-8">
                <span class="inline-block px-3 py-1 rounded-full <?= $gradeColors[$m['grade']]['bg'] ?> text-white text-xs font-bold mb-4">Grade <?= $m['grade'] ?></span>
                <h3 class="text-2xl sm:text-3xl text-white font-bold mb-3"><?= $m['name'] ?></h3>
                <p class="text-gray-400 mb-5"><?= $m['description'] ?></p>
                <div class="flex flex-wrap gap-2 mb-6">
                    <?php foreach ($m['features'] as $f): ?>
                        <span class="feature-tag">✓ <?= $f ?></span>
                    <?php endforeach; ?>
                </div>
                <div class="border-t border-white/10 pt-5">
                    <h4 class="text-white font-bold mb-4">Daftar Harga</h4>
                    <?php foreach ($m['prices'] as $p): ?>
                        <div class="flex justify-between py-2.5 border-b border-white/5">
                            <span class="text-gray-400"><?= $p['type'] ?></span>
                            <span class="text-white font-bold"><?= formatRupiah($p['dalam']) ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
                <a href="<?= SITE_URL ?>/calculator.php" class="btn-gold w-full mt-6 h-12 text-xs">Hitung Estimasi</a>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<script>
    function openModal(id) {
        document.getElementById('overlay-' + id).classList.add('active');
        document.getElementById('modal-' + id).classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeModal(id) {
        document.getElementById('overlay-' + id).classList.remove('active');
        document.getElementById('modal-' + id).classList.remove('active');
        document.body.style.overflow = 'auto';
    }
    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') {
            document.querySelectorAll('.modal-overlay.active, .modal-container.active').forEach(el => el.classList.remove('active'));
            document.body.style.overflow = 'auto';
        }
    });
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>