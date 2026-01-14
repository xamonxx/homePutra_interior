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

// NOW include header
$pageTitle = 'Layanan';
require_once __DIR__ . '/includes/header.php';
?>

<?php if ($action === 'list'): ?>
    <div class="max-w-6xl mx-auto">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
            <div>
                <h2 class="text-xl md:text-2xl font-bold text-white flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">design_services</span>
                    Manajemen Layanan
                </h2>
                <p class="text-gray-400 text-sm mt-1">Daftar solusi interior yang Anda tawarkan kepada klien.</p>
            </div>
            <a href="?action=add" class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-primary text-black font-bold rounded-lg hover:shadow-[0_0_20px_rgba(255,178,4,0.4)] transition-all">
                <span class="material-symbols-outlined">add</span>
                <span>Tambah Layanan</span>
            </a>
        </div>

        <?php if (empty($items)): ?>
            <div class="bg-surface-dark rounded-2xl border border-white/5 p-20 text-center">
                <div class="w-20 h-20 bg-primary/10 rounded-full flex items-center justify-center mx-auto mb-6">
                    <span class="material-symbols-outlined text-4xl text-primary">design_services</span>
                </div>
                <h3 class="text-xl font-bold text-white mb-2">Belum ada layanan</h3>
                <p class="text-gray-500 max-w-xs mx-auto mb-8">Tambahkan layanan interior yang Anda tawarkan sekarang.</p>
                <a href="?action=add" class="text-primary font-bold hover:underline">Tambah Sekarang</a>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($items as $row): ?>
                    <div class="bg-surface-dark border border-white/5 rounded-2xl overflow-hidden hover:border-primary/30 transition-all group flex flex-col h-full shadow-lg">
                        <div class="p-6 flex-1">
                            <div class="w-14 h-14 bg-primary/10 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-primary group-hover:text-black transition-all">
                                <span class="material-symbols-outlined text-3xl"><?php echo e($row['icon']); ?></span>
                            </div>
                            <h4 class="text-lg font-bold text-white mb-3"><?php echo e($row['title']); ?></h4>
                            <p class="text-gray-400 text-sm leading-relaxed line-clamp-3">
                                <?php echo strip_tags($row['description']); ?>
                            </p>
                        </div>
                        <div class="px-6 py-4 bg-white/5 border-t border-white/5 flex items-center justify-between">
                            <span class="text-[10px] font-bold text-gray-500 uppercase tracking-widest">ORDER: #<?php echo $row['display_order']; ?></span>
                            <div class="flex gap-2">
                                <a href="?action=edit&id=<?php echo $row['id']; ?>" class="p-2 bg-blue-500/10 text-blue-400 rounded-lg hover:bg-blue-500 hover:text-white transition-all">
                                    <span class="material-symbols-outlined text-lg">edit</span>
                                </a>
                                <form method="POST" class="inline" onsubmit="return confirmDelete()">
                                    <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                    <button type="submit" class="p-2 bg-red-500/10 text-red-400 rounded-lg hover:bg-red-500 hover:text-white transition-all">
                                        <span class="material-symbols-outlined text-lg">delete</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

<?php else: ?>
    <!-- Form View -->
    <div class="max-w-4xl mx-auto">
        <div class="mb-8">
            <a href="services.php" class="inline-flex items-center gap-2 text-gray-500 hover:text-primary transition-all text-sm font-bold uppercase tracking-widest">
                <span class="material-symbols-outlined">arrow_back</span>
                Kembali
            </a>
        </div>

        <form method="POST" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
            <input type="hidden" name="action" value="save">
            <?php if ($item): ?>
                <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
            <?php endif; ?>

            <!-- Main Form -->
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-surface-dark rounded-2xl border border-white/5 p-6 md:p-8 space-y-6">
                    <h3 class="text-lg font-bold text-white mb-2">Konten Layanan</h3>

                    <div class="form-group">
                        <label class="form-label">Judul Layanan <span class="text-red-500">*</span></label>
                        <input type="text" name="title" id="input_title" value="<?php echo e($item['title'] ?? ''); ?>" required
                            placeholder="Contoh: Interior Design"
                            class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl focus:border-primary transition-all">
                    </div>

                    <div class="form-group">
                        <label class="form-label text-xs uppercase tracking-widest font-bold text-gray-500 mb-3">Pilih Ikon</label>
                        <div class="grid grid-cols-5 sm:grid-cols-10 gap-3">
                            <?php foreach ($iconOptions as $icon => $label): ?>
                                <label class="cursor-pointer group">
                                    <input type="radio" name="icon" value="<?php echo $icon; ?>" class="sr-only peer" <?php echo ($item['icon'] ?? 'home') === $icon ? 'checked' : ''; ?>>
                                    <div class="w-full aspect-square bg-white/5 border border-white/10 rounded-xl flex items-center justify-center transition-all peer-checked:bg-primary peer-checked:text-black hover:border-primary/50" title="<?php echo $label; ?>">
                                        <span class="material-symbols-outlined"><?php echo $icon; ?></span>
                                    </div>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Deskripsi Lengkap <span class="text-red-500">*</span></label>
                        <textarea name="description" id="input_description" rows="5" required
                            class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl focus:border-primary transition-all"><?php echo e($item['description'] ?? ''); ?></textarea>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <div class="bg-surface-dark rounded-2xl border border-white/5 p-6 space-y-6 shadow-xl">
                    <h3 class="text-sm font-bold text-primary uppercase tracking-widest">Pengaturan</h3>

                    <div class="form-group">
                        <label class="form-label text-xs">Urutan Tampil</label>
                        <input type="number" name="display_order" value="<?php echo e($item['display_order'] ?? 0); ?>" min="0"
                            class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl focus:border-primary transition-all">
                    </div>

                    <label class="flex items-center gap-3 cursor-pointer group py-2">
                        <div class="relative">
                            <input type="checkbox" name="is_active" value="1" <?php echo ($item['is_active'] ?? 1) ? 'checked' : ''; ?>
                                class="sr-only peer">
                            <div class="w-10 h-6 bg-white/10 rounded-full peer peer-checked:bg-primary transition-all"></div>
                            <div class="absolute left-1 top-1 w-4 h-4 bg-white rounded-full transition-all peer-checked:translate-x-4"></div>
                        </div>
                        <span class="text-sm text-gray-400 group-hover:text-white transition-colors font-medium">Aktifkan Layanan</span>
                    </label>

                    <button type="submit" class="w-full py-4 bg-primary text-black font-extrabold rounded-xl hover:shadow-[0_0_30px_rgba(255,178,4,0.3)] transition-all flex items-center justify-center gap-2 uppercase tracking-widest text-xs">
                        <span class="material-symbols-outlined">save</span>
                        Simpan Layanan
                    </button>
                </div>

                <!-- Card Preview -->
                <div class="bg-surface-dark rounded-2xl border border-white/5 p-8 relative overflow-hidden group">
                    <div class="absolute top-0 right-0 p-3">
                        <span class="text-[9px] font-bold text-primary bg-primary/10 px-2 py-1 rounded uppercase tracking-widest">Preview</span>
                    </div>
                    <div class="w-14 h-14 bg-primary/10 rounded-2xl flex items-center justify-center mb-6">
                        <span id="preview_icon" class="material-symbols-outlined text-3xl text-primary"><?php echo e($item['icon'] ?? 'home'); ?></span>
                    </div>
                    <h4 id="preview_title" class="text-lg font-bold text-white mb-2"><?php echo e($item['title'] ?? 'Judul Layanan'); ?></h4>
                    <p id="preview_description" class="text-xs text-gray-500 leading-relaxed line-clamp-4 italic">
                        <?php echo e($item['description'] ?? 'Deskripsi singkat layanan akan tampil di sini saat Anda mulai mengetik...'); ?>
                    </p>
                </div>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const inputTitle = document.getElementById('input_title');
            const previewTitle = document.getElementById('preview_title');
            const previewDescription = document.getElementById('preview_description');
            const previewIcon = document.getElementById('preview_icon');
            const iconRadios = document.querySelectorAll('input[name="icon"]');

            inputTitle.addEventListener('input', (e) => {
                previewTitle.textContent = e.target.value || 'Judul Layanan';
            });

            document.getElementById('input_description').addEventListener('input', (e) => {
                previewDescription.textContent = e.target.value.replace(/<[^>]*>?/gm, '') || 'Deskripsi singkat...';
            });

            iconRadios.forEach(radio => {
                radio.addEventListener('change', (e) => {
                    previewIcon.textContent = e.target.value;
                });
            });
        });
    </script>
<?php endif; ?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>