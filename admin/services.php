<?php

/**
 * Services Management
 * Home Putra Interior CMS
 */

// Include auth FIRST - before any output
require_once __DIR__ . '/includes/auth.php';

$db = getDB();
$action = $_GET['action'] ?? 'list';
$id = $_GET['id'] ?? null;

// Material icons list for services
$iconOptions = [
    'home' => 'Rumah',
    'storefront' => 'Toko',
    'chair' => 'Furniture',
    'chat' => 'Konsultasi',
    'engineering' => 'Manajemen',
    'brush' => 'Dekorasi',
    'palette' => 'Warna',
    'lightbulb' => 'Pencahayaan',
    'construction' => 'Konstruksi',
    'architecture' => 'Arsitektur',
];

// Handle form submissions BEFORE any output
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $csrf = $_POST['csrf_token'] ?? '';
    if (!verifyCSRFToken($csrf)) {
        setFlash('error', 'Token keamanan tidak valid');
        header('Location: services.php');
        exit;
    }

    $postAction = $_POST['action'] ?? '';

    if ($postAction === 'save') {
        $data = [
            'title' => trim($_POST['title'] ?? ''),
            'description' => trim($_POST['description'] ?? ''),
            'icon' => trim($_POST['icon'] ?? 'home'),
            'display_order' => (int)($_POST['display_order'] ?? 0),
            'is_active' => isset($_POST['is_active']) ? 1 : 0,
        ];

        try {
            if (!empty($_POST['id'])) {
                $stmt = $db->prepare("UPDATE services SET title = :title, description = :description, 
                        icon = :icon, display_order = :display_order, is_active = :is_active WHERE id = :id");
                $data['id'] = $_POST['id'];
                $stmt->execute($data);
                setFlash('success', 'Layanan berhasil diperbarui');
            } else {
                $stmt = $db->prepare("INSERT INTO services (title, description, icon, display_order, is_active) 
                                      VALUES (:title, :description, :icon, :display_order, :is_active)");
                $stmt->execute($data);
                setFlash('success', 'Layanan berhasil ditambahkan');
            }
        } catch (PDOException $e) {
            setFlash('error', 'Gagal menyimpan: ' . $e->getMessage());
        }

        header('Location: services.php');
        exit;
    }

    if ($postAction === 'delete' && !empty($_POST['id'])) {
        try {
            $stmt = $db->prepare("DELETE FROM services WHERE id = :id");
            $stmt->execute(['id' => $_POST['id']]);
            setFlash('success', 'Layanan berhasil dihapus');
        } catch (PDOException $e) {
            setFlash('error', 'Gagal menghapus');
        }
        header('Location: services.php');
        exit;
    }
}

// Get data for edit
$item = null;
if ($action === 'edit' && $id) {
    $stmt = $db->prepare("SELECT * FROM services WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $item = $stmt->fetch();
}

// Get all items for list
$items = [];
if ($action === 'list') {
    $stmt = $db->query("SELECT * FROM services ORDER BY display_order ASC, created_at DESC");
    $items = $stmt->fetchAll();
}

$csrfToken = generateCSRFToken();

// NOW include header - after all redirects are done
$pageTitle = 'Layanan';
require_once __DIR__ . '/includes/header.php';
?>

<?php if ($action === 'list'): ?>
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="p-3 md:p-4 lg:p-6 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 md:gap-3">
            <h2 class="text-sm md:text-base lg:text-lg font-semibold text-gray-800">Daftar Layanan</h2>
            <a href="?action=add" class="inline-flex items-center justify-center gap-1.5 md:gap-2 px-3 md:px-4 py-1.5 md:py-2 bg-primary text-dark font-medium rounded-lg hover:bg-primary-dark transition-colors text-xs md:text-sm">
                <span class="material-symbols-outlined text-base md:text-lg">add</span>
                <span>Tambah</span>
            </a>
        </div>

        <?php if (empty($items)): ?>
            <div class="p-6 md:p-8 lg:p-12 text-center text-gray-500">
                <span class="material-symbols-outlined text-3xl md:text-4xl lg:text-5xl mb-3 md:mb-4">design_services</span>
                <p class="text-xs md:text-sm lg:text-base">Belum ada layanan</p>
                <a href="?action=add" class="text-primary hover:underline mt-2 inline-block text-xs md:text-sm">Tambah layanan pertama →</a>
            </div>
        <?php else: ?>

            <!-- Mobile & Tablet Card View -->
            <div class="md:hidden divide-y divide-gray-100">
                <?php foreach ($items as $row): ?>
                    <div class="p-3 md:p-4">
                        <div class="flex gap-2.5 md:gap-3">
                            <div class="w-9 h-9 md:w-10 md:h-10 bg-primary/10 rounded-lg flex items-center justify-center flex-shrink-0">
                                <span class="material-symbols-outlined text-primary text-lg md:text-xl"><?php echo e($row['icon']); ?></span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-medium text-gray-800 text-sm md:text-base"><?php echo e($row['title']); ?></p>
                                <p class="text-[10px] md:text-xs text-gray-500 line-clamp-2 mt-0.5 md:mt-1"><?php echo e($row['description']); ?></p>
                                <div class="flex items-center gap-2 mt-1.5 md:mt-2">
                                    <span class="text-[10px] md:text-xs text-gray-400">Urutan: <?php echo $row['display_order']; ?></span>
                                    <span class="px-1.5 md:px-2 py-0.5 rounded text-[10px] md:text-xs <?php echo $row['is_active'] ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600'; ?>">
                                        <?php echo $row['is_active'] ? 'Aktif' : 'Nonaktif'; ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="flex gap-2 md:gap-3 mt-2.5 md:mt-3 pt-2.5 md:pt-3 border-t">
                            <a href="?action=edit&id=<?php echo $row['id']; ?>" class="flex-1 text-center py-1.5 md:py-2 text-xs md:text-sm text-blue-600 bg-blue-50 rounded-lg">Edit</a>
                            <form method="POST" class="flex-1" onsubmit="return confirmDelete()">
                                <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                <button type="submit" class="w-full py-1.5 md:py-2 text-xs md:text-sm text-red-600 bg-red-50 rounded-lg">Hapus</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Tablet Grid View -->
            <div class="hidden md:grid md:grid-cols-2 lg:hidden gap-3 p-4">
                <?php foreach ($items as $row): ?>
                    <div class="border border-gray-200 rounded-xl p-4 hover:shadow-md transition-shadow">
                        <div class="flex items-start gap-3 mb-3">
                            <div class="w-10 h-10 bg-primary/10 rounded-lg flex items-center justify-center flex-shrink-0">
                                <span class="material-symbols-outlined text-primary"><?php echo e($row['icon']); ?></span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-semibold text-gray-800"><?php echo e($row['title']); ?></p>
                                <p class="text-xs text-gray-500 line-clamp-2 mt-1"><?php echo e($row['description']); ?></p>
                            </div>
                        </div>
                        <div class="flex items-center justify-between pt-3 border-t">
                            <div class="flex items-center gap-2">
                                <span class="px-2 py-0.5 rounded text-xs <?php echo $row['is_active'] ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600'; ?>">
                                    <?php echo $row['is_active'] ? 'Aktif' : 'Nonaktif'; ?>
                                </span>
                                <span class="text-xs text-gray-400">Urutan: <?php echo $row['display_order']; ?></span>
                            </div>
                            <div class="flex gap-2">
                                <a href="?action=edit&id=<?php echo $row['id']; ?>" class="text-blue-600 hover:underline text-sm">Edit</a>
                                <form method="POST" class="inline" onsubmit="return confirmDelete()">
                                    <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                    <button type="submit" class="text-red-600 hover:underline text-sm">Hapus</button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Desktop Table View -->
            <div class="hidden lg:block overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Icon</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Judul</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Deskripsi</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Urutan</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <?php foreach ($items as $row): ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <div class="w-10 h-10 bg-primary/10 rounded-lg flex items-center justify-center">
                                        <span class="material-symbols-outlined text-primary"><?php echo e($row['icon']); ?></span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 font-medium text-gray-800"><?php echo e($row['title']); ?></td>
                                <td class="px-6 py-4 text-gray-600 max-w-xs truncate"><?php echo e($row['description']); ?></td>
                                <td class="px-6 py-4 text-gray-600"><?php echo $row['display_order']; ?></td>
                                <td class="px-6 py-4">
                                    <span class="inline-block px-2 py-1 rounded-full text-xs font-medium <?php echo $row['is_active'] ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600'; ?>">
                                        <?php echo $row['is_active'] ? 'Aktif' : 'Nonaktif'; ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="?action=edit&id=<?php echo $row['id']; ?>" class="text-blue-600 hover:underline mr-3">Edit</a>
                                    <form method="POST" class="inline" onsubmit="return confirmDelete()">
                                        <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                        <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>

<?php else: ?>
    <div class="max-w-2xl mx-auto">
        <div class="mb-3 md:mb-4 lg:mb-6">
            <a href="services.php" class="text-gray-600 hover:text-gray-800 flex items-center gap-1 text-xs md:text-sm">
                <span class="material-symbols-outlined text-base md:text-lg">arrow_back</span>
                Kembali
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-3 md:p-4 lg:p-6">
            <h2 class="text-sm md:text-base lg:text-lg font-semibold text-gray-800 mb-3 md:mb-4 lg:mb-6"><?php echo $item ? 'Edit' : 'Tambah'; ?> Layanan</h2>

            <form method="POST" class="space-y-3 md:space-y-4 lg:space-y-6">
                <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
                <input type="hidden" name="action" value="save">
                <?php if ($item): ?>
                    <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
                <?php endif; ?>

                <div>
                    <label class="block text-xs md:text-sm font-medium text-gray-700 mb-1.5 md:mb-2">Judul <span class="text-red-500">*</span></label>
                    <input type="text" name="title" value="<?php echo e($item['title'] ?? ''); ?>" required
                        class="w-full px-2.5 md:px-3 lg:px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary text-xs md:text-sm lg:text-base">
                </div>

                <div>
                    <label class="block text-xs md:text-sm font-medium text-gray-700 mb-1.5 md:mb-2">Icon</label>
                    <select name="icon" class="w-full px-2.5 md:px-3 lg:px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary text-xs md:text-sm lg:text-base">
                        <?php foreach ($iconOptions as $icon => $label): ?>
                            <option value="<?php echo $icon; ?>" <?php echo ($item['icon'] ?? 'home') === $icon ? 'selected' : ''; ?>>
                                <?php echo $label; ?> (<?php echo $icon; ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label class="block text-xs md:text-sm font-medium text-gray-700 mb-1.5 md:mb-2">Deskripsi</label>
                    <textarea name="description" rows="4"
                        class="w-full px-2.5 md:px-3 lg:px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary text-xs md:text-sm lg:text-base"><?php echo e($item['description'] ?? ''); ?></textarea>
                </div>

                <div>
                    <label class="block text-xs md:text-sm font-medium text-gray-700 mb-1.5 md:mb-2">Urutan Tampil</label>
                    <input type="number" name="display_order" value="<?php echo e($item['display_order'] ?? 0); ?>" min="0"
                        class="w-16 md:w-20 lg:w-24 px-2.5 md:px-3 lg:px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary text-xs md:text-sm lg:text-base">
                </div>

                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" <?php echo ($item['is_active'] ?? 1) ? 'checked' : ''; ?>
                        class="w-4 h-4 text-primary rounded focus:ring-primary">
                    <span class="text-xs md:text-sm text-gray-700">Aktif</span>
                </label>

                <div class="pt-3 md:pt-4 border-t flex flex-col sm:flex-row gap-2 md:gap-3">
                    <button type="submit" class="px-4 md:px-6 py-2 bg-primary text-dark font-medium rounded-lg hover:bg-primary-dark transition-colors text-xs md:text-sm lg:text-base">
                        Simpan
                    </button>
                    <a href="services.php" class="px-4 md:px-6 py-2 bg-gray-100 text-gray-700 font-medium rounded-lg hover:bg-gray-200 transition-colors text-xs md:text-sm lg:text-base text-center">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
<?php endif; ?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>