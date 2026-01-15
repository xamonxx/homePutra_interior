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
} catch (Exception $e) {
    // Tables might already exist
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
            $message = 'Harga berhasil diupdate!';
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
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?> - Admin</title>
    <link rel="stylesheet" href="<?= SITE_URL ?>/assets/css/output.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght@300" rel="stylesheet">
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
        }

        .tab-active {
            border-bottom: 2px solid #ffb204;
            color: #ffb204;
        }
    </style>
</head>

<body class="bg-background-dark min-h-screen">
    <?php include __DIR__ . '/includes/sidebar.php'; ?>

    <main class="lg:ml-64 p-4 md:p-8">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-8">
            <div>
                <h1 class="text-2xl md:text-3xl text-white font-bold"><?= $pageTitle ?></h1>
                <p class="text-gray-400 mt-1">Kelola harga produk, material, dan ongkir kalkulator</p>
            </div>
        </div>

        <?php if ($message): ?>
            <div class="mb-6 p-4 rounded-lg <?= $messageType === 'success' ? 'bg-green-500/20 text-green-400 border border-green-500/30' : 'bg-red-500/20 text-red-400 border border-red-500/30' ?>">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>

        <!-- Tabs -->
        <div class="border-b border-white/10 mb-8">
            <nav class="flex gap-8">
                <button onclick="showTab('prices')" id="tab-prices" class="tab-btn tab-active py-4 text-sm font-medium transition-all">
                    <span class="material-symbols-outlined align-middle mr-2">payments</span>
                    Daftar Harga
                </button>
                <button onclick="showTab('shipping')" id="tab-shipping" class="tab-btn py-4 text-gray-400 text-sm font-medium hover:text-white transition-all">
                    <span class="material-symbols-outlined align-middle mr-2">local_shipping</span>
                    Ongkos Kirim
                </button>
                <button onclick="showTab('estimates')" id="tab-estimates" class="tab-btn py-4 text-gray-400 text-sm font-medium hover:text-white transition-all">
                    <span class="material-symbols-outlined align-middle mr-2">receipt_long</span>
                    Riwayat Estimasi
                </button>
            </nav>
        </div>

        <!-- Tab: Prices -->
        <div id="content-prices" class="tab-content">
            <!-- Quick Add Form -->
            <div class="bg-surface-dark border border-white/10 rounded-lg p-6 mb-8">
                <h3 class="text-lg text-white font-medium mb-4">Tambah/Update Harga</h3>
                <form method="POST" class="grid grid-cols-1 md:grid-cols-6 gap-4">
                    <input type="hidden" name="action" value="update_price">

                    <div>
                        <label class="block text-xs text-gray-400 uppercase tracking-wider mb-2">Produk</label>
                        <select name="product_id" required class="w-full bg-background-dark border border-white/10 rounded-lg text-white p-3 text-sm">
                            <?php foreach ($products as $p): ?>
                                <option value="<?= $p['id'] ?>"><?= htmlspecialchars($p['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs text-gray-400 uppercase tracking-wider mb-2">Material</label>
                        <select name="material_id" required class="w-full bg-background-dark border border-white/10 rounded-lg text-white p-3 text-sm">
                            <?php foreach ($materials as $m): ?>
                                <option value="<?= $m['id'] ?>"><?= htmlspecialchars($m['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs text-gray-400 uppercase tracking-wider mb-2">Model</label>
                        <select name="model_id" required class="w-full bg-background-dark border border-white/10 rounded-lg text-white p-3 text-sm">
                            <?php foreach ($models as $m): ?>
                                <option value="<?= $m['id'] ?>"><?= htmlspecialchars($m['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs text-gray-400 uppercase tracking-wider mb-2">Lokasi</label>
                        <select name="location_type" required class="w-full bg-background-dark border border-white/10 rounded-lg text-white p-3 text-sm">
                            <option value="dalam_kota">Dalam Kota</option>
                            <option value="luar_kota">Luar Kota</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs text-gray-400 uppercase tracking-wider mb-2">Harga/Meter</label>
                        <input type="number" name="price_per_meter" required min="0" step="50000" placeholder="2500000" class="w-full bg-background-dark border border-white/10 rounded-lg text-white p-3 text-sm">
                    </div>

                    <div class="flex items-end">
                        <button type="submit" class="w-full py-3 bg-primary text-black rounded-lg text-sm font-bold hover:bg-primary-hover transition-all">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>

            <!-- Price Table -->
            <div class="bg-surface-dark border border-white/10 rounded-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-white/5">
                            <tr>
                                <th class="text-left text-xs text-gray-400 uppercase tracking-wider p-4">Produk</th>
                                <th class="text-left text-xs text-gray-400 uppercase tracking-wider p-4">Material</th>
                                <th class="text-left text-xs text-gray-400 uppercase tracking-wider p-4">Model</th>
                                <th class="text-left text-xs text-gray-400 uppercase tracking-wider p-4">Lokasi</th>
                                <th class="text-right text-xs text-gray-400 uppercase tracking-wider p-4">Harga/Meter</th>
                                <th class="text-center text-xs text-gray-400 uppercase tracking-wider p-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5">
                            <?php foreach ($prices as $price): ?>
                                <tr class="hover:bg-white/5">
                                    <td class="p-4 text-white text-sm"><?= htmlspecialchars($price['product_name']) ?></td>
                                    <td class="p-4 text-white text-sm"><?= htmlspecialchars($price['material_name']) ?></td>
                                    <td class="p-4 text-white text-sm"><?= htmlspecialchars($price['model_name']) ?></td>
                                    <td class="p-4">
                                        <span class="px-2 py-1 rounded text-xs <?= $price['location_type'] === 'dalam_kota' ? 'bg-green-500/20 text-green-400' : 'bg-blue-500/20 text-blue-400' ?>">
                                            <?= $price['location_type'] === 'dalam_kota' ? 'Dalam Kota' : 'Luar Kota' ?>
                                        </span>
                                    </td>
                                    <td class="p-4 text-right text-primary font-medium">Rp <?= number_format($price['price_per_meter'], 0, ',', '.') ?></td>
                                    <td class="p-4 text-center">
                                        <button onclick="editPrice(<?= htmlspecialchars(json_encode($price)) ?>)" class="text-gray-400 hover:text-primary transition-all">
                                            <span class="material-symbols-outlined">edit</span>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Tab: Shipping -->
        <div id="content-shipping" class="tab-content hidden">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Dalam Kota -->
                <div class="bg-surface-dark border border-white/10 rounded-lg p-6">
                    <h3 class="text-lg text-white font-medium mb-4 flex items-center gap-2">
                        <span class="material-symbols-outlined text-green-400">home_pin</span>
                        Dalam Kota (Jawa Timur)
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
                        Luar Kota (Jabodetabek, dll)
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
    </main>

    <script>
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

        function editPrice(price) {
            document.querySelector('select[name="product_id"]').value = price.product_id;
            document.querySelector('select[name="material_id"]').value = price.material_id;
            document.querySelector('select[name="model_id"]').value = price.model_id;
            document.querySelector('select[name="location_type"]').value = price.location_type;
            document.querySelector('input[name="price_per_meter"]').value = price.price_per_meter;
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }
    </script>
</body>

</html>