<?php

/**
 * Admin - Calculator Price Management
 * Home Putra Interior
 */

require_once __DIR__ . '/includes/auth.php';
requireLogin();

// Initialize calculator tables
try {
    $db = getDB();
    $sql = file_get_contents(__DIR__ . '/../config/calculator_schema.sql');
    $db->exec($sql);

    // Cleanup duplicate materials - keep only the first entry of each slug
    $db->exec("
        DELETE m1 FROM calculator_materials m1
        INNER JOIN calculator_materials m2 
        WHERE m1.id > m2.id AND m1.slug = m2.slug
    ");

    // Cleanup duplicate products
    $db->exec("
        DELETE p1 FROM calculator_products p1
        INNER JOIN calculator_products p2 
        WHERE p1.id > p2.id AND p1.slug = p2.slug
    ");

    // Cleanup duplicate models
    $db->exec("
        DELETE m1 FROM calculator_models m1
        INNER JOIN calculator_models m2 
        WHERE m1.id > m2.id AND m1.slug = m2.slug
    ");

    // Cleanup duplicate shipping - keep only the first entry of each min_total + location_type
    $db->exec("
        DELETE s1 FROM calculator_shipping s1
        INNER JOIN calculator_shipping s2 
        WHERE s1.id > s2.id AND s1.min_total = s2.min_total AND s1.location_type = s2.location_type
    ");

    // Cleanup duplicate additional costs
    $db->exec("
        DELETE a1 FROM calculator_additional_costs a1
        INNER JOIN calculator_additional_costs a2 
        WHERE a1.id > a2.id AND a1.slug = a2.slug
    ");
} catch (Exception $e) {
    // Tables might already exist or cleanup failed
}

$db = getDB();
$message = '';
$messageType = '';

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    try {
        if ($action === 'update_price') {
            $stmt = $db->prepare("
                INSERT INTO calculator_prices (product_id, material_id, model_id, location_type, price_per_meter, is_active)
                VALUES (?, ?, ?, ?, ?, 1)
                ON DUPLICATE KEY UPDATE price_per_meter = VALUES(price_per_meter), updated_at = NOW()
            ");
            $stmt->execute([
                $_POST['product_id'],
                $_POST['material_id'],
                $_POST['model_id'],
                $_POST['location_type'],
                $_POST['price_per_meter']
            ]);
            $message = 'Harga berhasil disimpan!';
            $messageType = 'success';
        }

        if ($action === 'delete_price') {
            $stmt = $db->prepare("UPDATE calculator_prices SET is_active = 0 WHERE id = ?");
            $stmt->execute([$_POST['price_id']]);
            $message = 'Harga berhasil dihapus!';
            $messageType = 'success';
        }

        if ($action === 'update_shipping') {
            $stmt = $db->prepare("UPDATE calculator_shipping SET shipping_cost = ? WHERE id = ?");
            $stmt->execute([$_POST['shipping_cost'], $_POST['shipping_id']]);
            $message = 'Ongkir berhasil diupdate!';
            $messageType = 'success';
        }

        if ($action === 'bulk_update') {
            $prices = json_decode($_POST['prices_json'], true);
            $stmt = $db->prepare("
                INSERT INTO calculator_prices (product_id, material_id, model_id, location_type, price_per_meter, is_active)
                VALUES (?, ?, ?, ?, ?, 1)
                ON DUPLICATE KEY UPDATE price_per_meter = VALUES(price_per_meter), updated_at = NOW()
            ");
            foreach ($prices as $price) {
                $stmt->execute([
                    $price['product_id'],
                    $price['material_id'],
                    $price['model_id'],
                    $price['location_type'],
                    $price['price_per_meter']
                ]);
            }
            $message = count($prices) . ' harga berhasil diupdate!';
            $messageType = 'success';
        }
    } catch (Exception $e) {
        $message = 'Error: ' . $e->getMessage();
        $messageType = 'error';
    }
}

// Fetch data
$products = $db->query("SELECT * FROM calculator_products WHERE is_active = 1 ORDER BY display_order")->fetchAll();
$materials = $db->query("SELECT * FROM calculator_materials WHERE is_active = 1 ORDER BY display_order")->fetchAll();
$models = $db->query("SELECT * FROM calculator_models WHERE is_active = 1 ORDER BY display_order")->fetchAll();
$shipping = $db->query("SELECT * FROM calculator_shipping WHERE is_active = 1 ORDER BY location_type, min_total")->fetchAll();

// Fetch all prices
$pricesQuery = $db->query("
    SELECT p.*, 
           pr.name as product_name, 
           m.name as material_name, 
           mo.name as model_name
    FROM calculator_prices p
    JOIN calculator_products pr ON p.product_id = pr.id
    JOIN calculator_materials m ON p.material_id = m.id
    JOIN calculator_models mo ON p.model_id = mo.id
    WHERE p.is_active = 1
    ORDER BY pr.display_order, m.display_order, mo.display_order, p.location_type
");
$prices = $pricesQuery->fetchAll();

// Fetch recent estimates
$estimates = $db->query("
    SELECT e.*, pr.name as product_name, m.name as material_name, mo.name as model_name
    FROM calculator_estimates e
    JOIN calculator_products pr ON e.product_id = pr.id
    JOIN calculator_materials m ON e.material_id = m.id
    JOIN calculator_models mo ON e.model_id = mo.id
    ORDER BY e.created_at DESC
    LIMIT 20
")->fetchAll();

$pageTitle = 'Manajemen Harga Kalkulator';
require_once __DIR__ . '/includes/header.php';
?>

<?php if ($message): ?>
    <div class="mb-6 p-4 rounded-lg <?= $messageType === 'success' ? 'bg-green-500/20 text-green-400 border border-green-500/30' : 'bg-red-500/20 text-red-400 border border-red-500/30' ?>">
        <?= htmlspecialchars($message) ?>
    </div>
<?php endif; ?>

<!-- Header -->
<div class="flex flex-col md:flex-row md:items-center justify-between mb-6 md:mb-8">
    <div>
        <h1 class="text-xl md:text-2xl lg:text-3xl text-white font-bold"><?= $pageTitle ?></h1>
        <p class="text-gray-400 text-sm mt-1">Kelola harga produk, material, dan ongkir kalkulator</p>
    </div>
</div>

<!-- Tabs -->
<div class="border-b border-white/10 mb-6 md:mb-8">
    <nav class="flex gap-4 md:gap-8 overflow-x-auto">
        <button onclick="showTab('prices')" id="tab-prices" class="tab-btn tab-active py-3 md:py-4 text-xs md:text-sm font-medium transition-all whitespace-nowrap">
            <span class="material-symbols-outlined align-middle mr-1 md:mr-2 text-base md:text-xl">payments</span>
            Daftar Harga
        </button>
        <button onclick="showTab('shipping')" id="tab-shipping" class="tab-btn py-3 md:py-4 text-gray-400 text-xs md:text-sm font-medium hover:text-white transition-all whitespace-nowrap">
            <span class="material-symbols-outlined align-middle mr-1 md:mr-2 text-base md:text-xl">local_shipping</span>
            Ongkos Kirim
        </button>
        <button onclick="showTab('estimates')" id="tab-estimates" class="tab-btn py-3 md:py-4 text-gray-400 text-xs md:text-sm font-medium hover:text-white transition-all whitespace-nowrap">
            <span class="material-symbols-outlined align-middle mr-1 md:mr-2 text-base md:text-xl">receipt_long</span>
            Riwayat Estimasi
        </button>
    </nav>
</div>

<!-- Tab: Prices -->
<div id="content-prices" class="tab-content">
    <!-- Toolbar -->
    <div class="bg-surface-dark border border-white/10 rounded-lg p-4 mb-6">
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
            <!-- Left: Add Button -->
            <div class="flex items-center gap-3">
                <button onclick="openPriceModal()" class="px-4 py-2.5 bg-primary text-black rounded-lg text-sm font-bold hover:bg-primary-hover transition-all flex items-center gap-2">
                    <span class="material-symbols-outlined text-lg">add</span>
                    Tambah Harga
                </button>
                <div class="text-xs text-gray-400 hidden sm:block">
                    Total: <span class="text-primary font-bold"><?= count($prices) ?></span> harga
                </div>
            </div>

            <!-- Right: Search & Filters -->
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                <!-- Search Input -->
                <div class="relative">
                    <input type="text" id="search-price" onkeyup="searchTable()" placeholder="Cari harga..."
                        class="w-full sm:w-64 bg-background-dark border border-white/10 rounded-lg text-white pl-10 pr-4 py-2 text-sm focus:border-primary outline-none">
                    <span class="material-symbols-outlined text-gray-500 absolute left-3 top-1/2 -translate-y-1/2 text-lg">search</span>
                </div>

                <!-- Filter Product -->
                <select id="filter-product" onchange="filterTable()" class="bg-background-dark border border-white/10 rounded-lg text-white px-3 py-2 text-sm">
                    <option value="">Semua Produk</option>
                    <?php foreach ($products as $p): ?>
                        <option value="<?= htmlspecialchars($p['name']) ?>"><?= htmlspecialchars($p['name']) ?></option>
                    <?php endforeach; ?>
                </select>

                <!-- Filter Location -->
                <select id="filter-location" onchange="filterTable()" class="bg-background-dark border border-white/10 rounded-lg text-white px-3 py-2 text-sm">
                    <option value="">Semua Lokasi</option>
                    <option value="dalam_kota">🏠 Dalam Kota</option>
                    <option value="luar_kota">🚚 Luar Kota</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Price Table - Desktop -->
    <div class="hidden md:block bg-surface-dark border border-white/10 rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full" id="price-table">
                <thead class="bg-gradient-to-r from-primary/10 to-transparent">
                    <tr>
                        <th class="text-left text-[10px] md:text-xs text-primary uppercase tracking-wider p-3 md:p-4 font-bold">
                            <span class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-sm">category</span>
                                Produk
                            </span>
                        </th>
                        <th class="text-left text-[10px] md:text-xs text-primary uppercase tracking-wider p-3 md:p-4 font-bold">
                            <span class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-sm">texture</span>
                                Material
                            </span>
                        </th>
                        <th class="text-left text-[10px] md:text-xs text-primary uppercase tracking-wider p-3 md:p-4 font-bold">
                            <span class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-sm">design_services</span>
                                Model
                            </span>
                        </th>
                        <th class="text-center text-[10px] md:text-xs text-primary uppercase tracking-wider p-3 md:p-4 font-bold">
                            <span class="flex items-center justify-center gap-2">
                                <span class="material-symbols-outlined text-sm">location_on</span>
                                Lokasi
                            </span>
                        </th>
                        <th class="text-right text-[10px] md:text-xs text-primary uppercase tracking-wider p-3 md:p-4 font-bold">
                            <span class="flex items-center justify-end gap-2">
                                <span class="material-symbols-outlined text-sm">payments</span>
                                Harga/Meter
                            </span>
                        </th>
                        <th class="text-center text-[10px] md:text-xs text-primary uppercase tracking-wider p-3 md:p-4 font-bold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    <?php
                    $currentProduct = '';
                    foreach ($prices as $index => $price):
                        $isNewProduct = $currentProduct !== $price['product_name'];
                        $currentProduct = $price['product_name'];
                    ?>
                        <tr class="hover:bg-white/5 transition-colors price-row"
                            data-product="<?= htmlspecialchars($price['product_name']) ?>"
                            data-location="<?= $price['location_type'] ?>">
                            <td class="p-3 md:p-4">
                                <?php if ($isNewProduct): ?>
                                    <div class="flex items-center gap-2">
                                        <div class="w-8 h-8 rounded-lg bg-primary/20 flex items-center justify-center">
                                            <span class="material-symbols-outlined text-primary text-sm">
                                                <?php
                                                $icons = ['Kitchen Set' => 'countertops', 'Wardrobe' => 'door_sliding', 'Backdrop TV' => 'tv', 'Wallpanel' => 'dashboard'];
                                                echo $icons[$price['product_name']] ?? 'category';
                                                ?>
                                            </span>
                                        </div>
                                        <span class="text-white text-sm font-medium"><?= htmlspecialchars($price['product_name']) ?></span>
                                    </div>
                                <?php else: ?>
                                    <span class="text-gray-500 text-sm pl-10">—</span>
                                <?php endif; ?>
                            </td>
                            <td class="p-3 md:p-4">
                                <span class="inline-flex items-center gap-1.5 px-2 py-1 rounded-md bg-white/5 text-white text-xs md:text-sm">
                                    <?= htmlspecialchars($price['material_name']) ?>
                                </span>
                            </td>
                            <td class="p-3 md:p-4 text-gray-300 text-xs md:text-sm"><?= htmlspecialchars($price['model_name']) ?></td>
                            <td class="p-3 md:p-4 text-center">
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium <?= $price['location_type'] === 'dalam_kota' ? 'bg-green-500/20 text-green-400' : 'bg-blue-500/20 text-blue-400' ?>">
                                    <?= $price['location_type'] === 'dalam_kota' ? '🏠 Jabar' : '🚚 Luar' ?>
                                </span>
                            </td>
                            <td class="p-3 md:p-4 text-right">
                                <span class="text-primary font-bold text-sm md:text-base">Rp <?= number_format($price['price_per_meter'], 0, ',', '.') ?></span>
                            </td>
                            <td class="p-3 md:p-4 text-center">
                                <div class="flex items-center justify-center gap-1">
                                    <button onclick="openEditModal(<?= htmlspecialchars(json_encode($price)) ?>)" class="w-8 h-8 rounded-lg bg-white/5 hover:bg-blue-500/20 text-gray-400 hover:text-blue-400 transition-all inline-flex items-center justify-center" title="Edit">
                                        <span class="material-symbols-outlined text-lg">edit</span>
                                    </button>
                                    <button onclick="openDeleteModal(<?= $price['id'] ?>, '<?= htmlspecialchars($price['product_name']) ?>', '<?= htmlspecialchars($price['material_name']) ?>')" class="w-8 h-8 rounded-lg bg-white/5 hover:bg-red-500/20 text-gray-400 hover:text-red-400 transition-all inline-flex items-center justify-center" title="Hapus">
                                        <span class="material-symbols-outlined text-lg">delete</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Price Cards - Mobile -->
    <div class="md:hidden space-y-3" id="price-cards">
        <?php foreach ($prices as $price): ?>
            <div class="bg-surface-dark border border-white/10 rounded-lg p-4 price-card"
                data-product="<?= htmlspecialchars($price['product_name']) ?>"
                data-location="<?= $price['location_type'] ?>">
                <div class="flex items-start justify-between mb-3">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg bg-primary/20 flex items-center justify-center">
                            <span class="material-symbols-outlined text-primary text-sm">
                                <?php
                                $icons = ['Kitchen Set' => 'countertops', 'Wardrobe' => 'door_sliding', 'Backdrop TV' => 'tv', 'Wallpanel' => 'dashboard'];
                                echo $icons[$price['product_name']] ?? 'category';
                                ?>
                            </span>
                        </div>
                        <div>
                            <div class="text-white text-sm font-medium"><?= htmlspecialchars($price['product_name']) ?></div>
                            <div class="text-gray-500 text-xs"><?= htmlspecialchars($price['material_name']) ?> • <?= htmlspecialchars($price['model_name']) ?></div>
                        </div>
                    </div>
                    <div class="flex items-center gap-1">
                        <button onclick="openEditModal(<?= htmlspecialchars(json_encode($price)) ?>)" class="w-8 h-8 rounded-lg bg-white/5 text-gray-400 hover:text-blue-400 transition-all inline-flex items-center justify-center">
                            <span class="material-symbols-outlined text-lg">edit</span>
                        </button>
                        <button onclick="openDeleteModal(<?= $price['id'] ?>, '<?= htmlspecialchars($price['product_name']) ?>', '<?= htmlspecialchars($price['material_name']) ?>')" class="w-8 h-8 rounded-lg bg-white/5 text-gray-400 hover:text-red-400 transition-all inline-flex items-center justify-center">
                            <span class="material-symbols-outlined text-lg">delete</span>
                        </button>
                    </div>
                </div>
                <div class="flex items-center justify-between pt-3 border-t border-white/5">
                    <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-medium <?= $price['location_type'] === 'dalam_kota' ? 'bg-green-500/20 text-green-400' : 'bg-blue-500/20 text-blue-400' ?>">
                        <?= $price['location_type'] === 'dalam_kota' ? '🏠 Dalam Kota' : '🚚 Luar Kota' ?>
                    </span>
                    <span class="text-primary font-bold">Rp <?= number_format($price['price_per_meter'], 0, ',', '.') ?></span>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- Tab: Shipping -->
<div id="content-shipping" class="tab-content hidden">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Dalam Kota -->
        <div class="bg-surface-dark border border-white/10 rounded-lg p-6">
            <h3 class="text-lg text-white font-medium mb-4 flex items-center gap-2">
                <span class="material-symbols-outlined text-green-400">home_pin</span>
                Jawa Barat
            </h3>
            <div class="space-y-4">
                <?php foreach ($shipping as $s): if ($s['location_type'] === 'dalam_kota'): ?>
                        <form method="POST" class="flex items-center gap-4 p-4 bg-white/5 rounded-lg">
                            <input type="hidden" name="action" value="update_shipping">
                            <input type="hidden" name="shipping_id" value="<?= $s['id'] ?>">
                            <div class="flex-1">
                                <div class="text-white text-sm font-medium">
                                    Rp <?= number_format($s['min_total'], 0, ',', '.') ?>
                                    <?= $s['max_total'] ? '- Rp ' . number_format($s['max_total'], 0, ',', '.') : '++' ?>
                                </div>
                                <div class="text-gray-500 text-xs"><?= htmlspecialchars($s['description']) ?></div>
                            </div>
                            <input type="number" name="shipping_cost" value="<?= $s['shipping_cost'] ?>" step="50000" class="w-40 bg-background-dark border border-white/10 rounded-lg text-white p-2 text-sm text-right">
                            <button type="submit" class="px-4 py-2 bg-primary/20 text-primary rounded-lg text-sm font-medium hover:bg-primary hover:text-black transition-all">Update</button>
                        </form>
                <?php endif;
                endforeach; ?>
            </div>
        </div>

        <!-- Luar Kota -->
        <div class="bg-surface-dark border border-white/10 rounded-lg p-6">
            <h3 class="text-lg text-white font-medium mb-4 flex items-center gap-2">
                <span class="material-symbols-outlined text-blue-400">local_shipping</span>
                Luar Jawa Barat
            </h3>
            <div class="space-y-4">
                <?php foreach ($shipping as $s): if ($s['location_type'] === 'luar_kota'): ?>
                        <form method="POST" class="flex items-center gap-4 p-4 bg-white/5 rounded-lg">
                            <input type="hidden" name="action" value="update_shipping">
                            <input type="hidden" name="shipping_id" value="<?= $s['id'] ?>">
                            <div class="flex-1">
                                <div class="text-white text-sm font-medium">
                                    Rp <?= number_format($s['min_total'], 0, ',', '.') ?>
                                    <?= $s['max_total'] ? '- Rp ' . number_format($s['max_total'], 0, ',', '.') : '++' ?>
                                </div>
                                <div class="text-gray-500 text-xs"><?= htmlspecialchars($s['description']) ?></div>
                            </div>
                            <input type="number" name="shipping_cost" value="<?= $s['shipping_cost'] ?>" step="50000" class="w-40 bg-background-dark border border-white/10 rounded-lg text-white p-2 text-sm text-right">
                            <button type="submit" class="px-4 py-2 bg-primary/20 text-primary rounded-lg text-sm font-medium hover:bg-primary hover:text-black transition-all">Update</button>
                        </form>
                <?php endif;
                endforeach; ?>
            </div>
        </div>
    </div>
</div>

<!-- Tab: Estimates History -->
<div id="content-estimates" class="tab-content hidden">
    <div class="bg-surface-dark border border-white/10 rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-white/5">
                    <tr>
                        <th class="text-left text-xs text-gray-400 uppercase tracking-wider p-4">Kode</th>
                        <th class="text-left text-xs text-gray-400 uppercase tracking-wider p-4">Tanggal</th>
                        <th class="text-left text-xs text-gray-400 uppercase tracking-wider p-4">Produk</th>
                        <th class="text-left text-xs text-gray-400 uppercase tracking-wider p-4">Material</th>
                        <th class="text-center text-xs text-gray-400 uppercase tracking-wider p-4">Panjang</th>
                        <th class="text-right text-xs text-gray-400 uppercase tracking-wider p-4">Grand Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    <?php if (empty($estimates)): ?>
                        <tr>
                            <td colspan="6" class="p-8 text-center text-gray-500">Belum ada riwayat estimasi</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($estimates as $est): ?>
                            <tr class="hover:bg-white/5">
                                <td class="p-4 text-primary text-sm font-mono"><?= htmlspecialchars($est['estimate_code']) ?></td>
                                <td class="p-4 text-gray-400 text-sm"><?= date('d/m/Y H:i', strtotime($est['created_at'])) ?></td>
                                <td class="p-4 text-white text-sm"><?= htmlspecialchars($est['product_name']) ?></td>
                                <td class="p-4 text-white text-sm"><?= htmlspecialchars($est['material_name']) ?></td>
                                <td class="p-4 text-center text-white text-sm"><?= $est['length_meter'] ?>m</td>
                                <td class="p-4 text-right text-primary font-medium">Rp <?= number_format($est['grand_total'], 0, ',', '.') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal: Add/Edit Price -->
<div id="priceModal" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-black/70 backdrop-blur-sm" onclick="closePriceModal()"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-xl mx-4">
        <div class="bg-surface-dark border border-white/10 rounded-xl shadow-2xl overflow-hidden">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-5 border-b border-white/10">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-primary/20 flex items-center justify-center">
                        <span class="material-symbols-outlined text-primary" id="modal-icon">add_circle</span>
                    </div>
                    <div>
                        <h3 id="modal-title" class="text-lg text-white font-semibold">Tambah Harga Baru</h3>
                        <p class="text-gray-500 text-xs">Pilih kombinasi produk dan masukkan harga</p>
                    </div>
                </div>
                <button onclick="closePriceModal()" class="w-8 h-8 rounded-lg bg-white/5 hover:bg-white/10 text-gray-400 hover:text-white transition-all flex items-center justify-center">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
            <!-- Modal Body -->
            <form id="priceForm" method="POST" class="p-5 space-y-4">
                <input type="hidden" name="action" value="update_price">

                <!-- Row 1: Product & Material -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs text-gray-400 uppercase tracking-wider mb-2">
                            <span class="inline-flex items-center gap-1">
                                <span class="material-symbols-outlined text-xs">category</span>
                                Produk
                            </span>
                        </label>
                        <select name="product_id" id="modal-product" required class="w-full bg-background-dark border border-white/10 rounded-lg text-white p-3 text-sm focus:border-primary outline-none">
                            <?php foreach ($products as $p): ?>
                                <option value="<?= $p['id'] ?>"><?= htmlspecialchars($p['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs text-gray-400 uppercase tracking-wider mb-2">
                            <span class="inline-flex items-center gap-1">
                                <span class="material-symbols-outlined text-xs">layers</span>
                                Material
                            </span>
                        </label>
                        <select name="material_id" id="modal-material" required class="w-full bg-background-dark border border-white/10 rounded-lg text-white p-3 text-sm focus:border-primary outline-none">
                            <?php foreach ($materials as $m): ?>
                                <option value="<?= $m['id'] ?>"><?= htmlspecialchars($m['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <!-- Row 2: Model & Location -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs text-gray-400 uppercase tracking-wider mb-2">
                            <span class="inline-flex items-center gap-1">
                                <span class="material-symbols-outlined text-xs">design_services</span>
                                Model
                            </span>
                        </label>
                        <select name="model_id" id="modal-model" required class="w-full bg-background-dark border border-white/10 rounded-lg text-white p-3 text-sm focus:border-primary outline-none">
                            <?php foreach ($models as $m): ?>
                                <option value="<?= $m['id'] ?>"><?= htmlspecialchars($m['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs text-gray-400 uppercase tracking-wider mb-2">
                            <span class="inline-flex items-center gap-1">
                                <span class="material-symbols-outlined text-xs">location_on</span>
                                Lokasi
                            </span>
                        </label>
                        <select name="location_type" id="modal-location" required class="w-full bg-background-dark border border-white/10 rounded-lg text-white p-3 text-sm focus:border-primary outline-none">
                            <option value="dalam_kota">🏠 Jawa Barat</option>
                            <option value="luar_kota">🚚 Luar Jawa Barat</option>
                        </select>
                    </div>
                </div>

                <!-- Price Input -->
                <div>
                    <label class="block text-xs text-gray-400 uppercase tracking-wider mb-2">
                        <span class="inline-flex items-center gap-1">
                            <span class="material-symbols-outlined text-xs">payments</span>
                            Harga Per Meter
                        </span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 text-sm font-medium">Rp</span>
                        <input type="number" name="price_per_meter" id="modal-price" required min="0" step="50000" placeholder="2.500.000"
                            class="w-full bg-background-dark border border-white/10 rounded-lg text-white pl-12 pr-4 py-3 text-lg font-bold focus:border-primary outline-none">
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="flex items-center justify-end gap-3 pt-4 border-t border-white/10">
                    <button type="button" onclick="closePriceModal()" class="px-5 py-2.5 bg-white/5 border border-white/10 rounded-lg text-white text-sm font-medium hover:bg-white/10 transition-all">
                        Batal
                    </button>
                    <button type="submit" class="px-6 py-2.5 bg-primary text-black rounded-lg text-sm font-bold hover:bg-primary-hover transition-all flex items-center gap-2">
                        <span class="material-symbols-outlined text-lg">save</span>
                        Simpan Harga
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal: Delete Confirmation -->
<div id="deleteModal" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-black/70 backdrop-blur-sm" onclick="closeDeleteModal()"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-md mx-4">
        <div class="bg-surface-dark border border-white/10 rounded-xl shadow-2xl overflow-hidden">
            <!-- Modal Header -->
            <div class="p-5 text-center border-b border-white/10">
                <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-red-500/20 flex items-center justify-center">
                    <span class="material-symbols-outlined text-red-400 text-3xl">delete_forever</span>
                </div>
                <h3 class="text-lg text-white font-semibold mb-2">Hapus Harga?</h3>
                <p class="text-gray-400 text-sm" id="delete-message">Apakah Anda yakin ingin menghapus harga ini?</p>
            </div>
            <!-- Modal Footer -->
            <form id="deleteForm" method="POST" class="p-5 flex items-center justify-center gap-3">
                <input type="hidden" name="action" value="delete_price">
                <input type="hidden" name="price_id" id="delete-price-id">
                <button type="button" onclick="closeDeleteModal()" class="px-5 py-2.5 bg-white/5 border border-white/10 rounded-lg text-white text-sm font-medium hover:bg-white/10 transition-all">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2.5 bg-red-500 text-white rounded-lg text-sm font-bold hover:bg-red-600 transition-all flex items-center gap-2">
                    <span class="material-symbols-outlined text-lg">delete</span>
                    Hapus
                </button>
            </form>
        </div>
    </div>
</div>

<style>
    .tab-active {
        border-bottom: 2px solid #ffb204;
        color: #ffb204;
    }
</style>

<script>
    // Tab Navigation
    function showTab(tab) {
        document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.classList.remove('tab-active');
            btn.classList.add('text-gray-400');
        });

        document.getElementById('content-' + tab).classList.remove('hidden');
        document.getElementById('tab-' + tab).classList.add('tab-active');
        document.getElementById('tab-' + tab).classList.remove('text-gray-400');
    }

    // Price Modal Functions
    function openPriceModal() {
        document.getElementById('modal-title').textContent = 'Tambah Harga Baru';
        document.getElementById('modal-icon').textContent = 'add_circle';
        document.getElementById('priceForm').reset();
        document.getElementById('priceModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function openEditModal(price) {
        document.getElementById('modal-title').textContent = 'Edit Harga';
        document.getElementById('modal-icon').textContent = 'edit';

        document.getElementById('modal-product').value = price.product_id;
        document.getElementById('modal-material').value = price.material_id;
        document.getElementById('modal-model').value = price.model_id;
        document.getElementById('modal-location').value = price.location_type;
        document.getElementById('modal-price').value = price.price_per_meter;

        document.getElementById('priceModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closePriceModal() {
        document.getElementById('priceModal').classList.add('hidden');
        document.body.style.overflow = '';
    }

    // Delete Modal Functions
    function openDeleteModal(priceId, productName, materialName) {
        document.getElementById('delete-price-id').value = priceId;
        document.getElementById('delete-message').textContent = `Apakah Anda yakin ingin menghapus harga "${productName} - ${materialName}"?`;
        document.getElementById('deleteModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
        document.body.style.overflow = '';
    }

    // Search Function
    function searchTable() {
        const searchValue = document.getElementById('search-price').value.toLowerCase();

        // Search desktop table rows
        document.querySelectorAll('.price-row').forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(searchValue) ? '' : 'none';
        });

        // Search mobile cards
        document.querySelectorAll('.price-card').forEach(card => {
            const text = card.textContent.toLowerCase();
            card.style.display = text.includes(searchValue) ? '' : 'none';
        });
    }

    // Filter Function
    function filterTable() {
        const productFilter = document.getElementById('filter-product').value;
        const locationFilter = document.getElementById('filter-location').value;
        const searchValue = document.getElementById('search-price').value.toLowerCase();

        // Filter desktop table rows
        document.querySelectorAll('.price-row').forEach(row => {
            const product = row.dataset.product;
            const location = row.dataset.location;
            const text = row.textContent.toLowerCase();

            const matchProduct = !productFilter || product === productFilter;
            const matchLocation = !locationFilter || location === locationFilter;
            const matchSearch = !searchValue || text.includes(searchValue);

            row.style.display = (matchProduct && matchLocation && matchSearch) ? '' : 'none';
        });

        // Filter mobile cards
        document.querySelectorAll('.price-card').forEach(card => {
            const product = card.dataset.product;
            const location = card.dataset.location;
            const text = card.textContent.toLowerCase();

            const matchProduct = !productFilter || product === productFilter;
            const matchLocation = !locationFilter || location === locationFilter;
            const matchSearch = !searchValue || text.includes(searchValue);

            card.style.display = (matchProduct && matchLocation && matchSearch) ? '' : 'none';
        });
    }

    // Close modals on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closePriceModal();
            closeDeleteModal();
        }
    });
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>