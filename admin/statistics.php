<?php

/**
 * Statistics Management
 * Home Putra Interior CMS
 */

// Include auth FIRST - before any output
require_once __DIR__ . '/includes/auth.php';

$db = getDB();
$action = $_GET['action'] ?? 'list';
$id = $_GET['id'] ?? null;

// Handle form submissions BEFORE any output
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $csrf = $_POST['csrf_token'] ?? '';
    if (!verifyCSRFToken($csrf)) {
        setFlash('error', 'Token keamanan tidak valid');
        header('Location: statistics.php');
        exit;
    }

    $postAction = $_POST['action'] ?? '';

    if ($postAction === 'save') {
        $data = [
            'stat_number' => trim($_POST['stat_number'] ?? ''),
            'stat_suffix' => trim($_POST['stat_suffix'] ?? ''),
            'stat_label' => trim($_POST['stat_label'] ?? ''),
            'display_order' => (int)($_POST['display_order'] ?? 0),
            'is_active' => isset($_POST['is_active']) ? 1 : 0,
        ];

        try {
            if (!empty($_POST['id'])) {
                $stmt = $db->prepare("UPDATE statistics SET stat_number = :stat_number, stat_suffix = :stat_suffix, 
                        stat_label = :stat_label, display_order = :display_order, is_active = :is_active WHERE id = :id");
                $data['id'] = $_POST['id'];
                $stmt->execute($data);
                setFlash('success', 'Statistik berhasil diperbarui');
            } else {
                $stmt = $db->prepare("INSERT INTO statistics (stat_number, stat_suffix, stat_label, display_order, is_active) 
                                      VALUES (:stat_number, :stat_suffix, :stat_label, :display_order, :is_active)");
                $stmt->execute($data);
                setFlash('success', 'Statistik berhasil ditambahkan');
            }
        } catch (PDOException $e) {
            setFlash('error', 'Gagal menyimpan: ' . $e->getMessage());
        }

        header('Location: statistics.php');
        exit;
    }

    if ($postAction === 'delete' && !empty($_POST['id'])) {
        try {
            $stmt = $db->prepare("DELETE FROM statistics WHERE id = :id");
            $stmt->execute(['id' => $_POST['id']]);
            setFlash('success', 'Statistik berhasil dihapus');
        } catch (PDOException $e) {
            setFlash('error', 'Gagal menghapus');
        }
        header('Location: statistics.php');
        exit;
    }
}

$item = null;
if ($action === 'edit' && $id) {
    $stmt = $db->prepare("SELECT * FROM statistics WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $item = $stmt->fetch();
}

$items = [];
if ($action === 'list') {
    $stmt = $db->query("SELECT * FROM statistics ORDER BY display_order ASC");
    $items = $stmt->fetchAll();
}

$csrfToken = generateCSRFToken();

// NOW include header - after all redirects are done
$pageTitle = 'Statistik';
require_once __DIR__ . '/includes/header.php';
?>

<?php if ($action === 'list'): ?>
    <?php
    $activeCount = 0;
    foreach ($items as $i) {
        if ($i['is_active']) $activeCount++;
    }
    ?>
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="p-4 lg:p-6 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h2 class="text-base lg:text-lg font-semibold text-gray-800">Statistik Perusahaan</h2>
                <p class="text-xs text-gray-500 mt-1"><?php echo $activeCount; ?> dari <?php echo count($items); ?> statistik aktif ditampilkan di landing page</p>
            </div>
            <a href="?action=add" class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-primary text-dark font-medium rounded-lg hover:bg-primary-dark transition-colors text-sm">
                <span class="material-symbols-outlined text-lg">add</span>
                <span>Tambah</span>
            </a>
        </div>

        <?php if (empty($items)): ?>
            <div class="p-8 lg:p-12 text-center text-gray-500">
                <span class="material-symbols-outlined text-4xl lg:text-5xl mb-4">analytics</span>
                <p class="text-sm lg:text-base">Belum ada statistik</p>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 lg:gap-6 p-4 lg:p-6">
                <?php foreach ($items as $row): ?>
                    <div class="border border-gray-200 rounded-xl p-4 lg:p-6 text-center relative group">
                        <div class="absolute top-2 right-2 flex gap-1 opacity-100 lg:opacity-0 group-hover:opacity-100 transition-opacity">
                            <a href="?action=edit&id=<?php echo $row['id']; ?>" class="w-6 h-6 lg:w-7 lg:h-7 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 hover:bg-blue-200">
                                <span class="material-symbols-outlined text-xs lg:text-sm">edit</span>
                            </a>
                            <form method="POST" class="inline" onsubmit="return confirmDelete()">
                                <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                <button type="submit" class="w-6 h-6 lg:w-7 lg:h-7 bg-red-100 rounded-full flex items-center justify-center text-red-600 hover:bg-red-200">
                                    <span class="material-symbols-outlined text-xs lg:text-sm">delete</span>
                                </button>
                            </form>
                        </div>

                        <div class="text-2xl lg:text-4xl font-bold text-primary mb-1 lg:mb-2">
                            <?php echo e($row['stat_number']); ?><span class="text-lg lg:text-2xl"><?php echo e($row['stat_suffix']); ?></span>
                        </div>
                        <div class="text-xs lg:text-sm text-gray-600 mb-2"><?php echo e($row['stat_label']); ?></div>

                        <?php if ($row['is_active']): ?>
                            <span class="inline-block px-2 py-0.5 bg-green-100 text-green-700 text-xs rounded">✓ Aktif</span>
                        <?php else: ?>
                            <span class="inline-block px-2 py-0.5 bg-gray-100 text-gray-600 text-xs rounded">Nonaktif</span>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

<?php else: ?>
    <div class="max-w-lg mx-auto">
        <div class="mb-4 lg:mb-6">
            <a href="statistics.php" class="text-gray-600 hover:text-gray-800 flex items-center gap-1 text-sm">
                <span class="material-symbols-outlined text-lg">arrow_back</span>
                Kembali
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 lg:p-6">
            <h2 class="text-base lg:text-lg font-semibold text-gray-800 mb-4 lg:mb-6"><?php echo $item ? 'Edit' : 'Tambah'; ?> Statistik</h2>

            <form method="POST" class="space-y-4 lg:space-y-6">
                <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
                <input type="hidden" name="action" value="save">
                <?php if ($item): ?>
                    <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
                <?php endif; ?>

                <div class="grid grid-cols-2 gap-3 lg:gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Angka <span class="text-red-500">*</span></label>
                        <input type="text" name="stat_number" value="<?php echo e($item['stat_number'] ?? ''); ?>" required
                            placeholder="500"
                            class="w-full px-3 lg:px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary text-sm lg:text-base">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Suffix</label>
                        <input type="text" name="stat_suffix" value="<?php echo e($item['stat_suffix'] ?? ''); ?>"
                            placeholder="+, %, th"
                            class="w-full px-3 lg:px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary text-sm lg:text-base">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Label <span class="text-red-500">*</span></label>
                    <input type="text" name="stat_label" value="<?php echo e($item['stat_label'] ?? ''); ?>" required
                        placeholder="Proyek Selesai"
                        class="w-full px-3 lg:px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary text-sm lg:text-base">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Urutan Tampil</label>
                    <input type="number" name="display_order" value="<?php echo e($item['display_order'] ?? 0); ?>" min="0"
                        class="w-20 lg:w-24 px-3 lg:px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary text-sm lg:text-base">
                </div>

                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" <?php echo (!isset($item) || !$item || $item['is_active']) ? 'checked' : ''; ?>
                        class="w-4 h-4 text-primary rounded focus:ring-primary">
                    <span class="text-sm text-gray-700">Aktif (tampil di landing page)</span>
                </label>

                <div class="pt-4 border-t flex flex-col sm:flex-row gap-3">
                    <button type="submit" class="px-6 py-2 bg-primary text-dark font-medium rounded-lg hover:bg-primary-dark transition-colors text-sm lg:text-base">
                        Simpan
                    </button>
                    <a href="statistics.php" class="px-6 py-2 bg-gray-100 text-gray-700 font-medium rounded-lg hover:bg-gray-200 transition-colors text-sm lg:text-base text-center">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
<?php endif; ?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>