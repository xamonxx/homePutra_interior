<?php

/**
 * Portfolio Management
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
        header('Location: portfolio.php');
        exit;
    }

    $postAction = $_POST['action'] ?? '';

    if ($postAction === 'save') {
        $data = [
            'title' => trim($_POST['title'] ?? ''),
            'category' => trim($_POST['category'] ?? ''),
            'description' => trim($_POST['description'] ?? ''),
            'display_order' => (int)($_POST['display_order'] ?? 0),
            'is_featured' => isset($_POST['is_featured']) ? 1 : 0,
            'is_active' => isset($_POST['is_active']) ? 1 : 0,
        ];

        // Handle image upload
        if (!empty($_FILES['image']['name'])) {
            $uploadDir = __DIR__ . '/../uploads/portfolio/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

            $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
            $allowed = ['jpg', 'jpeg', 'png', 'webp'];

            if (in_array($ext, $allowed)) {
                $filename = 'portfolio_' . time() . '_' . uniqid() . '.' . $ext;
                if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $filename)) {
                    $data['image'] = 'uploads/portfolio/' . $filename;
                }
            }
        }

        try {
            if (!empty($_POST['id'])) {
                $sql = "UPDATE portfolio SET title = :title, category = :category, description = :description, 
                        display_order = :display_order, is_featured = :is_featured, is_active = :is_active";
                if (isset($data['image'])) {
                    $sql .= ", image = :image";
                }
                $sql .= " WHERE id = :id";
                $data['id'] = $_POST['id'];

                $stmt = $db->prepare($sql);
                $stmt->execute($data);
                setFlash('success', 'Portfolio berhasil diperbarui');
            } else {
                $stmt = $db->prepare("INSERT INTO portfolio (title, category, description, image, display_order, is_featured, is_active) 
                                      VALUES (:title, :category, :description, :image, :display_order, :is_featured, :is_active)");
                $data['image'] = $data['image'] ?? '';
                $stmt->execute($data);
                setFlash('success', 'Portfolio berhasil ditambahkan');
            }
        } catch (PDOException $e) {
            setFlash('error', 'Gagal menyimpan: ' . $e->getMessage());
        }

        header('Location: portfolio.php');
        exit;
    }

    if ($postAction === 'delete' && !empty($_POST['id'])) {
        try {
            $stmt = $db->prepare("DELETE FROM portfolio WHERE id = :id");
            $stmt->execute(['id' => $_POST['id']]);
            setFlash('success', 'Portfolio berhasil dihapus');
        } catch (PDOException $e) {
            setFlash('error', 'Gagal menghapus');
        }
        header('Location: portfolio.php');
        exit;
    }
}

// Get data for edit
$item = null;
if ($action === 'edit' && $id) {
    $stmt = $db->prepare("SELECT * FROM portfolio WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $item = $stmt->fetch();
}

// Get all items for list
$items = [];
if ($action === 'list') {
    $stmt = $db->query("SELECT * FROM portfolio ORDER BY display_order ASC, created_at DESC");
    $items = $stmt->fetchAll();
}

$csrfToken = generateCSRFToken();

// NOW include header
$pageTitle = 'Portfolio';
require_once __DIR__ . '/includes/header.php';
?>

<?php if ($action === 'list'): ?>
    <div class="max-w-6xl mx-auto">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
            <div>
                <h2 class="text-xl md:text-2xl font-bold text-white flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">photo_library</span>
                    Manajemen Portofolio
                </h2>
                <p class="text-gray-400 text-sm mt-1">Koleksi karya interior terbaik yang pernah Anda kerjakan.</p>
            </div>
            <a href="?action=add" class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-primary text-black font-bold rounded-lg hover:shadow-[0_0_20px_rgba(255,178,4,0.4)] transition-all">
                <span class="material-symbols-outlined">add</span>
                <span>Tambah Proyek</span>
            </a>
        </div>

        <?php if (empty($items)): ?>
            <div class="bg-surface-dark rounded-2xl border border-white/5 p-20 text-center">
                <div class="w-20 h-20 bg-primary/10 rounded-full flex items-center justify-center mx-auto mb-6">
                    <span class="material-symbols-outlined text-4xl text-primary">photo_library</span>
                </div>
                <h3 class="text-xl font-bold text-white mb-2">Belum ada karya</h3>
                <p class="text-gray-500 max-w-xs mx-auto mb-8">Pamerkan proyek interior terbaik Anda di sini.</p>
                <a href="?action=add" class="text-primary font-bold hover:underline">Tambah Sekarang</a>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($items as $row): ?>
                    <div class="bg-surface-dark border border-white/5 rounded-2xl overflow-hidden hover:border-primary/30 transition-all group flex flex-col h-full shadow-lg relative">
                        <!-- Status Indicators -->
                        <div class="absolute top-3 left-3 z-10 flex gap-2">
                            <?php if ($row['is_active']): ?>
                                <div class="bg-green-500/20 text-green-400 text-[8px] font-bold px-2 py-1 rounded border border-green-500/30 uppercase tracking-widest backdrop-blur-md">Aktif</div>
                            <?php else: ?>
                                <div class="bg-red-500/20 text-red-400 text-[8px] font-bold px-2 py-1 rounded border border-red-500/30 uppercase tracking-widest backdrop-blur-md">Non-Aktif</div>
                            <?php endif; ?>
                        </div>

                        <?php if ($row['is_featured']): ?>
                            <div class="absolute top-3 right-3 z-10 bg-primary text-black text-[9px] font-bold px-2 py-1 rounded uppercase tracking-widest shadow-xl">Featured</div>
                        <?php endif; ?>

                        <div class="aspect-video relative overflow-hidden">
                            <?php if ($row['image']): ?>
                                <img src="../<?php echo e($row['image']); ?>" alt="" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                            <?php else: ?>
                                <div class="w-full h-full bg-white/5 flex items-center justify-center">
                                    <span class="material-symbols-outlined text-4xl text-white/10">image</span>
                                </div>
                            <?php endif; ?>
                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-4">
                                <p class="text-[10px] text-primary font-bold uppercase tracking-widest"><?php echo e($row['category']); ?></p>
                            </div>
                        </div>

                        <div class="p-6 flex-1">
                            <h4 class="text-lg font-bold text-white mb-2 truncate"><?php echo e($row['title']); ?></h4>
                            <p class="text-gray-400 text-xs leading-relaxed line-clamp-2">
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
    <div class="max-w-5xl mx-auto">
        <div class="mb-8">
            <a href="portfolio.php" class="inline-flex items-center gap-2 text-gray-500 hover:text-primary transition-all text-sm font-bold uppercase tracking-widest">
                <span class="material-symbols-outlined">arrow_back</span>
                Kembali
            </a>
        </div>

        <form method="POST" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
            <input type="hidden" name="action" value="save">
            <?php if ($item): ?>
                <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
            <?php endif; ?>

            <!-- Main Fields -->
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-surface-dark rounded-2xl border border-white/5 p-6 md:p-8 space-y-6">
                    <h3 class="text-lg font-bold text-white">Detail Proyek</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="form-group">
                            <label class="form-label">Judul Portofolio <span class="text-red-500">*</span></label>
                            <input type="text" name="title" id="input_title" value="<?php echo e($item['title'] ?? ''); ?>" required
                                placeholder="Contoh: Modern House Jakarta"
                                class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl focus:border-primary transition-all">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Kategori</label>
                            <input type="text" name="category" id="input_category" value="<?php echo e($item['category'] ?? ''); ?>"
                                placeholder="Contoh: Residensial, Kantor, Dapur"
                                class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl focus:border-primary transition-all">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Deskripsi Proyek</label>
                        <textarea name="description" id="input_description" rows="5"
                            class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl focus:border-primary transition-all"><?php echo e($item['description'] ?? ''); ?></textarea>
                    </div>
                </div>

                <div class="bg-surface-dark rounded-2xl border border-white/5 p-6 md:p-8">
                    <h3 class="text-lg font-bold text-white mb-6">Gambar Utama</h3>
                    <div class="file-upload-wrapper">
                        <input type="file" name="image" id="portfolio_image" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                        <div class="space-y-2">
                            <span class="material-symbols-outlined text-4xl text-gray-500">cloud_upload</span>
                            <p class="text-sm text-gray-400 font-medium">Klik atau drag gambar proyek ke sini</p>
                            <p class="text-[10px] text-gray-500 uppercase font-bold tracking-widest">JPG, PNG, WebP (Maks. 5MB)</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Settings Card -->
                <div class="bg-surface-dark rounded-2xl border border-white/5 p-6 space-y-6 shadow-xl">
                    <h3 class="text-sm font-bold text-primary uppercase tracking-widest">Pengaturan</h3>

                    <div class="form-group">
                        <label class="form-label text-xs">Urutan Tampil</label>
                        <input type="number" name="display_order" value="<?php echo e($item['display_order'] ?? 0); ?>" min="0"
                            class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl focus:border-primary transition-all">
                    </div>

                    <div class="space-y-4 pt-2">
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <div class="relative">
                                <input type="checkbox" name="is_featured" value="1" <?php echo ($item['is_featured'] ?? 0) ? 'checked' : ''; ?> class="sr-only peer">
                                <div class="w-10 h-6 bg-white/10 rounded-full peer peer-checked:bg-primary transition-all"></div>
                                <div class="absolute left-1 top-1 w-4 h-4 bg-white rounded-full transition-all peer-checked:translate-x-4"></div>
                            </div>
                            <span class="text-sm text-gray-400 group-hover:text-white transition-colors font-medium">Proyek Utama (Featured)</span>
                        </label>

                        <label class="flex items-center gap-3 cursor-pointer group">
                            <div class="relative">
                                <input type="checkbox" name="is_active" value="1" <?php echo ($item['is_active'] ?? 1) ? 'checked' : ''; ?> class="sr-only peer">
                                <div class="w-10 h-6 bg-white/10 rounded-full peer peer-checked:bg-primary transition-all"></div>
                                <div class="absolute left-1 top-1 w-4 h-4 bg-white rounded-full transition-all peer-checked:translate-x-4"></div>
                            </div>
                            <span class="text-sm text-gray-400 group-hover:text-white transition-colors font-medium">Tampilkan Proyek</span>
                        </label>
                    </div>

                    <button type="submit" class="w-full py-4 bg-primary text-black font-extrabold rounded-xl hover:shadow-[0_0_30px_rgba(255,178,4,0.3)] transition-all flex items-center justify-center gap-2 uppercase tracking-widest text-xs">
                        <span class="material-symbols-outlined">save</span>
                        Simpan Karya
                    </button>
                </div>

                <!-- Card Preview -->
                <div class="bg-surface-dark rounded-2xl border border-white/5 overflow-hidden group shadow-2xl">
                    <div class="aspect-video relative overflow-hidden bg-white/5">
                        <img id="preview_img" src="<?php echo !empty($item['image']) ? '../' . e($item['image']) : ''; ?>"
                            class="w-full h-full object-cover <?php echo !empty($item['image']) ? '' : 'hidden'; ?>">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/20 to-transparent flex flex-col justify-end p-6">
                            <span id="preview_category" class="text-primary text-[9px] uppercase tracking-[0.3em] font-bold mb-1 italic"><?php echo e($item['category'] ?? 'Kategori'); ?></span>
                            <h4 id="preview_title" class="text-base font-bold text-white italic font-serif"><?php echo e($item['title'] ?? 'Judul Proyek'); ?></h4>
                        </div>
                        <div class="absolute top-2 right-2">
                            <span class="text-[8px] font-bold text-primary bg-black/50 backdrop-blur-md px-2 py-1 rounded border border-white/10">PREVIEW</span>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const inputTitle = document.getElementById('input_title');
            const inputCategory = document.getElementById('input_category');
            const previewTitle = document.getElementById('preview_title');
            const previewCategory = document.getElementById('preview_category');
            const imgInput = document.getElementById('portfolio_image');
            const previewImg = document.getElementById('preview_img');

            inputTitle.addEventListener('input', (e) => {
                previewTitle.textContent = e.target.value || 'Judul Proyek';
            });

            inputCategory.addEventListener('input', (e) => {
                previewCategory.textContent = (e.target.value || 'Kategori').toUpperCase();
            });

            imgInput.addEventListener('change', function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        previewImg.src = e.target.result;
                        previewImg.classList.remove('hidden');
                    };
                    reader.readAsDataURL(file);
                }
            });
        });
    </script>
<?php endif; ?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>