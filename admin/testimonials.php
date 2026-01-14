<?php

/**
 * Testimonials Management
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
        header('Location: testimonials.php');
        exit;
    }

    $postAction = $_POST['action'] ?? '';

    if ($postAction === 'save') {
        $data = [
            'client_name' => trim($_POST['client_name'] ?? ''),
            'client_location' => trim($_POST['client_location'] ?? ''),
            'testimonial_text' => trim($_POST['testimonial_text'] ?? ''),
            'rating' => (int)($_POST['rating'] ?? 5),
            'display_order' => (int)($_POST['display_order'] ?? 0),
            'is_active' => isset($_POST['is_active']) ? 1 : 0,
        ];

        // Handle image upload
        if (!empty($_FILES['client_image']['name'])) {
            $uploadDir = __DIR__ . '/../uploads/testimonials/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

            $ext = strtolower(pathinfo($_FILES['client_image']['name'], PATHINFO_EXTENSION));
            $allowed = ['jpg', 'jpeg', 'png', 'webp'];

            if (in_array($ext, $allowed)) {
                $filename = 'testimonial_' . time() . '_' . uniqid() . '.' . $ext;
                if (move_uploaded_file($_FILES['client_image']['tmp_name'], $uploadDir . $filename)) {
                    $data['client_image'] = 'uploads/testimonials/' . $filename;
                }
            }
        }

        try {
            if (!empty($_POST['id'])) {
                $sql = "UPDATE testimonials SET client_name = :client_name, client_location = :client_location, 
                        testimonial_text = :testimonial_text, rating = :rating, display_order = :display_order, is_active = :is_active";
                if (isset($data['client_image'])) {
                    $sql .= ", client_image = :client_image";
                }
                $sql .= " WHERE id = :id";
                $data['id'] = $_POST['id'];

                $stmt = $db->prepare($sql);
                $stmt->execute($data);
                setFlash('success', 'Testimoni berhasil diperbarui');
            } else {
                $stmt = $db->prepare("INSERT INTO testimonials (client_name, client_location, client_image, testimonial_text, rating, display_order, is_active) 
                                      VALUES (:client_name, :client_location, :client_image, :testimonial_text, :rating, :display_order, :is_active)");
                $data['client_image'] = $data['client_image'] ?? '';
                $stmt->execute($data);
                setFlash('success', 'Testimoni berhasil ditambahkan');
            }
        } catch (PDOException $e) {
            setFlash('error', 'Gagal menyimpan: ' . $e->getMessage());
        }

        header('Location: testimonials.php');
        exit;
    }

    if ($postAction === 'delete' && !empty($_POST['id'])) {
        try {
            $stmt = $db->prepare("DELETE FROM testimonials WHERE id = :id");
            $stmt->execute(['id' => $_POST['id']]);
            setFlash('success', 'Testimoni berhasil dihapus');
        } catch (PDOException $e) {
            setFlash('error', 'Gagal menghapus');
        }
        header('Location: testimonials.php');
        exit;
    }
}

$item = null;
if ($action === 'edit' && $id) {
    $stmt = $db->prepare("SELECT * FROM testimonials WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $item = $stmt->fetch();
}

$items = [];
if ($action === 'list') {
    $stmt = $db->query("SELECT * FROM testimonials ORDER BY display_order ASC, created_at DESC");
    $items = $stmt->fetchAll();
}

$csrfToken = generateCSRFToken();

// NOW include header - after all redirects are done
$pageTitle = 'Testimoni';
require_once __DIR__ . '/includes/header.php';
?>

<?php if ($action === 'list'): ?>
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="p-3 md:p-4 lg:p-6 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 md:gap-3">
            <h2 class="text-sm md:text-base lg:text-lg font-semibold text-gray-800">Daftar Testimoni</h2>
            <a href="?action=add" class="inline-flex items-center justify-center gap-1.5 md:gap-2 px-3 md:px-4 py-1.5 md:py-2 bg-primary text-dark font-medium rounded-lg hover:bg-primary-dark transition-colors text-xs md:text-sm">
                <span class="material-symbols-outlined text-base md:text-lg">add</span>
                <span>Tambah</span>
            </a>
        </div>

        <?php if (empty($items)): ?>
            <div class="p-6 md:p-8 lg:p-12 text-center text-gray-500">
                <span class="material-symbols-outlined text-3xl md:text-4xl lg:text-5xl mb-3 md:mb-4">rate_review</span>
                <p class="text-xs md:text-sm lg:text-base">Belum ada testimoni</p>
                <a href="?action=add" class="text-primary hover:underline mt-2 inline-block text-xs md:text-sm">Tambah testimoni pertama →</a>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3 md:gap-4 p-3 md:p-4 lg:p-6">
                <?php foreach ($items as $row): ?>
                    <div class="border border-gray-200 rounded-xl p-3 md:p-4 lg:p-6 hover:shadow-lg transition-shadow">
                        <div class="flex items-center gap-2 md:gap-3 mb-2 md:mb-3 lg:mb-4">
                            <?php if ($row['client_image']): ?>
                                <img src="../<?php echo e($row['client_image']); ?>" alt="" class="w-9 h-9 md:w-10 md:h-10 lg:w-12 lg:h-12 rounded-full object-cover">
                            <?php else: ?>
                                <div class="w-9 h-9 md:w-10 md:h-10 lg:w-12 lg:h-12 rounded-full bg-primary/20 flex items-center justify-center text-primary font-bold text-xs md:text-sm lg:text-base">
                                    <?php echo strtoupper(substr($row['client_name'], 0, 2)); ?>
                                </div>
                            <?php endif; ?>
                            <div class="min-w-0">
                                <p class="font-semibold text-gray-800 text-xs md:text-sm lg:text-base truncate"><?php echo e($row['client_name']); ?></p>
                                <p class="text-[10px] md:text-xs lg:text-sm text-gray-500 truncate"><?php echo e($row['client_location']); ?></p>
                            </div>
                        </div>

                        <div class="flex gap-0.5 mb-2 md:mb-3">
                            <?php for ($i = 0; $i < 5; $i++): ?>
                                <span class="material-symbols-outlined text-xs md:text-sm lg:text-base <?php echo $i < $row['rating'] ? 'text-yellow-400' : 'text-gray-300'; ?>">star</span>
                            <?php endfor; ?>
                        </div>

                        <p class="text-gray-600 text-[10px] md:text-xs lg:text-sm line-clamp-3 mb-2 md:mb-3 lg:mb-4">"<?php echo e($row['testimonial_text']); ?>"</p>

                        <div class="flex items-center justify-between pt-2 md:pt-3 lg:pt-4 border-t">
                            <span class="inline-block px-1.5 md:px-2 py-0.5 md:py-1 rounded-full text-[10px] md:text-xs font-medium <?php echo $row['is_active'] ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600'; ?>">
                                <?php echo $row['is_active'] ? 'Aktif' : 'Nonaktif'; ?>
                            </span>
                            <div class="flex gap-1.5 md:gap-2">
                                <a href="?action=edit&id=<?php echo $row['id']; ?>" class="text-blue-600 hover:underline text-[10px] md:text-xs lg:text-sm">Edit</a>
                                <form method="POST" class="inline" onsubmit="return confirmDelete()">
                                    <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                    <button type="submit" class="text-red-600 hover:underline text-[10px] md:text-xs lg:text-sm">Hapus</button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

<?php else: ?>
    <div class="max-w-2xl mx-auto">
        <div class="mb-3 md:mb-4 lg:mb-6">
            <a href="testimonials.php" class="text-gray-600 hover:text-gray-800 flex items-center gap-1 text-xs md:text-sm">
                <span class="material-symbols-outlined text-base md:text-lg">arrow_back</span>
                Kembali
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-3 md:p-4 lg:p-6">
            <h2 class="text-sm md:text-base lg:text-lg font-semibold text-gray-800 mb-3 md:mb-4 lg:mb-6"><?php echo $item ? 'Edit' : 'Tambah'; ?> Testimoni</h2>

            <form method="POST" enctype="multipart/form-data" class="space-y-3 md:space-y-4 lg:space-y-6">
                <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
                <input type="hidden" name="action" value="save">
                <?php if ($item): ?>
                    <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
                <?php endif; ?>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 md:gap-4">
                    <div>
                        <label class="block text-xs md:text-sm font-medium text-gray-700 mb-1.5 md:mb-2">Nama Klien <span class="text-red-500">*</span></label>
                        <input type="text" name="client_name" value="<?php echo e($item['client_name'] ?? ''); ?>" required
                            class="w-full px-2.5 md:px-3 lg:px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary text-xs md:text-sm lg:text-base">
                    </div>
                    <div>
                        <label class="block text-xs md:text-sm font-medium text-gray-700 mb-1.5 md:mb-2">Lokasi</label>
                        <input type="text" name="client_location" value="<?php echo e($item['client_location'] ?? ''); ?>"
                            placeholder="Contoh: Jakarta"
                            class="w-full px-2.5 md:px-3 lg:px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary text-xs md:text-sm lg:text-base">
                    </div>
                </div>

                <div>
                    <label class="block text-xs md:text-sm font-medium text-gray-700 mb-1.5 md:mb-2">Foto Klien</label>
                    <?php if (!empty($item['client_image'])): ?>
                        <div class="mb-2 md:mb-3">
                            <img src="../<?php echo e($item['client_image']); ?>" alt="" class="w-12 h-12 md:w-14 md:h-14 lg:w-16 lg:h-16 object-cover rounded-full">
                        </div>
                    <?php endif; ?>
                    <input type="file" name="client_image" accept="image/*"
                        class="w-full px-2.5 md:px-3 lg:px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary text-xs md:text-sm">
                </div>

                <div>
                    <label class="block text-xs md:text-sm font-medium text-gray-700 mb-1.5 md:mb-2">Testimoni <span class="text-red-500">*</span></label>
                    <textarea name="testimonial_text" rows="4" required
                        class="w-full px-2.5 md:px-3 lg:px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary text-xs md:text-sm lg:text-base"><?php echo e($item['testimonial_text'] ?? ''); ?></textarea>
                </div>

                <div class="grid grid-cols-2 gap-3 md:gap-4">
                    <div>
                        <label class="block text-xs md:text-sm font-medium text-gray-700 mb-1.5 md:mb-2">Rating</label>
                        <select name="rating" class="w-full px-2.5 md:px-3 lg:px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary text-xs md:text-sm lg:text-base">
                            <?php for ($i = 5; $i >= 1; $i--): ?>
                                <option value="<?php echo $i; ?>" <?php echo ($item['rating'] ?? 5) == $i ? 'selected' : ''; ?>><?php echo $i; ?> ⭐</option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs md:text-sm font-medium text-gray-700 mb-1.5 md:mb-2">Urutan</label>
                        <input type="number" name="display_order" value="<?php echo e($item['display_order'] ?? 0); ?>" min="0"
                            class="w-full px-2.5 md:px-3 lg:px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary text-xs md:text-sm lg:text-base">
                    </div>
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
                    <a href="testimonials.php" class="px-4 md:px-6 py-2 bg-gray-100 text-gray-700 font-medium rounded-lg hover:bg-gray-200 transition-colors text-xs md:text-sm lg:text-base text-center">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
<?php endif; ?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>