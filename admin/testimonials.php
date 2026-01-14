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

// NOW include header
$pageTitle = 'Testimoni';
require_once __DIR__ . '/includes/header.php';
?>

<?php if ($action === 'list'): ?>
    <div class="max-w-6xl mx-auto">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
            <div>
                <h2 class="text-xl md:text-2xl font-bold text-white flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">rate_review</span>
                    Manajemen Testimoni
                </h2>
                <p class="text-gray-400 text-sm mt-1">Ulasan dari klien yang telah mempercayakan proyek mereka kepada kami.</p>
            </div>
            <a href="?action=add" class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-primary text-black font-bold rounded-lg hover:shadow-[0_0_20px_rgba(255,178,4,0.4)] transition-all">
                <span class="material-symbols-outlined">add</span>
                <span>Tambah Ulasan</span>
            </a>
        </div>

        <?php if (empty($items)): ?>
            <div class="bg-surface-dark rounded-2xl border border-white/5 p-20 text-center">
                <div class="w-20 h-20 bg-primary/10 rounded-full flex items-center justify-center mx-auto mb-6">
                    <span class="material-symbols-outlined text-4xl text-primary">rate_review</span>
                </div>
                <h3 class="text-xl font-bold text-white mb-2">Belum ada testimoni</h3>
                <p class="text-gray-500 max-w-xs mx-auto mb-8">Mulailah dengan menambahkan testimoni dari klien pertama Anda.</p>
                <a href="?action=add" class="text-primary font-bold hover:underline">Tambah Sekarang</a>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($items as $row): ?>
                    <div class="bg-surface-dark border border-white/5 rounded-2xl overflow-hidden hover:border-primary/30 transition-all group flex flex-col h-full shadow-lg">
                        <div class="p-6 flex-1">
                            <div class="flex items-center gap-4 mb-6">
                                <div class="relative">
                                    <?php if ($row['client_image']): ?>
                                        <img src="../<?php echo e($row['client_image']); ?>" alt="" class="w-14 h-14 rounded-full object-cover border-2 border-primary/20">
                                    <?php else: ?>
                                        <div class="w-14 h-14 rounded-full bg-primary/10 flex items-center justify-center text-primary font-bold text-xl border-2 border-primary/20">
                                            <?php echo strtoupper(substr($row['client_name'], 0, 1)); ?>
                                        </div>
                                    <?php endif; ?>
                                    <div class="absolute -bottom-1 -right-1 bg-background-dark p-1 rounded-full">
                                        <div class="bg-green-500 w-2 h-2 rounded-full <?php echo $row['is_active'] ? 'animate-pulse' : 'bg-gray-600'; ?>"></div>
                                    </div>
                                </div>
                                <div class="min-w-0">
                                    <h4 class="font-bold text-white truncate"><?php echo e($row['client_name']); ?></h4>
                                    <p class="text-[10px] text-gray-500 uppercase tracking-widest font-bold"><?php echo e($row['client_location']); ?></p>
                                </div>
                            </div>

                            <div class="flex gap-1 mb-4">
                                <?php for ($i = 0; $i < 5; $i++): ?>
                                    <span class="material-symbols-outlined text-sm <?php echo $i < $row['rating'] ? 'text-primary' : 'text-gray-700'; ?>">star</span>
                                <?php endfor; ?>
                            </div>

                            <p class="text-gray-400 text-sm leading-relaxed italic line-clamp-4">
                                "<?php echo strip_tags($row['testimonial_text']); ?>"
                            </p>
                        </div>

                        <div class="px-6 py-4 bg-white/5 border-t border-white/5 flex items-center justify-between">
                            <span class="text-[10px] font-bold text-gray-500">ORDER: #<?php echo $row['display_order']; ?></span>
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
            <a href="testimonials.php" class="inline-flex items-center gap-2 text-gray-500 hover:text-primary transition-all text-sm font-bold uppercase tracking-widest">
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

            <!-- Main Form -->
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-surface-dark rounded-2xl border border-white/5 p-6 md:p-8 space-y-6">
                    <h3 class="text-lg font-bold text-white mb-2">Informasi Klien</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="form-group">
                            <label class="form-label">Nama Klien <span class="text-red-500">*</span></label>
                            <input type="text" name="client_name" id="input_name" value="<?php echo e($item['client_name'] ?? ''); ?>" required
                                placeholder="Contoh: Bpk. Andi"
                                class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl focus:border-primary transition-all">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Lokasi / Profesi</label>
                            <input type="text" name="client_location" id="input_location" value="<?php echo e($item['client_location'] ?? ''); ?>"
                                placeholder="Contoh: Jakarta Selatan"
                                class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl focus:border-primary transition-all">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Isi Testimoni <span class="text-red-500">*</span></label>
                        <textarea name="testimonial_text" id="input_text" rows="5" required
                            class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl focus:border-primary transition-all"><?php echo e($item['testimonial_text'] ?? ''); ?></textarea>
                    </div>
                </div>

                <div class="bg-surface-dark rounded-2xl border border-white/5 p-6 md:p-8">
                    <h3 class="text-lg font-bold text-white mb-6">Foto Profil</h3>
                    <div class="file-upload-wrapper">
                        <input type="file" name="client_image" id="client_image_input" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                        <div class="space-y-2">
                            <span class="material-symbols-outlined text-4xl text-gray-500">account_circle</span>
                            <p class="text-sm text-gray-400">Klik atau drag foto profil klien ke sini</p>
                            <p class="text-[10px] text-gray-500 uppercase tracking-widest font-bold">REKOMENDASI: 500x500px</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar Form -->
            <div class="space-y-6">
                <div class="bg-surface-dark rounded-2xl border border-white/5 p-6 space-y-6">
                    <h3 class="text-sm font-bold text-primary uppercase tracking-widest">Pengaturan</h3>

                    <div class="form-group">
                        <label class="form-label text-xs">Rating (1-5)</label>
                        <select name="rating" id="input_rating" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl focus:border-primary transition-all">
                            <?php for ($i = 5; $i >= 1; $i--): ?>
                                <option value="<?php echo $i; ?>" <?php echo ($item['rating'] ?? 5) == $i ? 'selected' : ''; ?> class="bg-surface-dark"><?php echo $i; ?> ⭐ Bintang</option>
                            <?php endfor; ?>
                        </select>
                    </div>

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
                        <span class="text-sm text-gray-400 group-hover:text-white transition-colors font-medium">Aktif / Tampilkan</span>
                    </label>

                    <button type="submit" class="w-full py-4 bg-primary text-black font-extrabold rounded-xl hover:shadow-[0_0_30px_rgba(255,178,4,0.3)] transition-all flex items-center justify-center gap-2 uppercase tracking-widest text-xs">
                        <span class="material-symbols-outlined">check_circle</span>
                        Simpan Data
                    </button>
                </div>

                <!-- Preview Card Local -->
                <div class="bg-surface-dark rounded-2xl border border-white/5 p-6 relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-3">
                        <span class="text-[10px] font-bold text-primary bg-primary/10 px-2 py-1 rounded uppercase tracking-widest">Preview</span>
                    </div>
                    <div class="pt-4 flex flex-col items-center text-center">
                        <!-- Avatar Preview -->
                        <div id="preview_avatar_container" class="w-16 h-16 md:w-20 md:h-20 lg:w-24 lg:h-24 rounded-full bg-primary/20 flex items-center justify-center mb-4 border-2 border-primary/30 overflow-hidden relative">
                            <img id="preview_img" src="<?php echo !empty($item['client_image']) ? '../' . e($item['client_image']) : ''; ?>" class="w-full h-full object-cover absolute inset-0 <?php echo empty($item['client_image']) ? 'hidden' : ''; ?>">
                            <span id="preview_initials" class="text-xl md:text-2xl lg:text-3xl font-bold text-primary <?php echo !empty($item['client_image']) ? 'hidden' : ''; ?>"><?php echo strtoupper(substr($item['client_name'] ?? 'U', 0, 1)); ?></span>
                        </div>

                        <h4 id="preview_name" class="font-bold text-white text-lg mb-1"><?php echo e($item['client_name'] ?? 'Nama Klien'); ?></h4>
                        <p id="preview_location" class="text-[10px] text-gray-500 uppercase tracking-widest font-bold mb-4"><?php echo e($item['client_location'] ?? 'Lokasi'); ?></p>

                        <div id="preview_stars" class="flex gap-1 mb-4 justify-center">
                            <?php $r = $item['rating'] ?? 5;
                            for ($i = 0; $i < 5; $i++): ?>
                                <span class="material-symbols-outlined text-sm <?php echo $i < $r ? 'text-primary' : 'text-gray-700'; ?>">star</span>
                            <?php endfor; ?>
                        </div>

                        <p id="preview_text" class="text-sm text-gray-400 italic leading-relaxed">
                            "<?php echo e($item['testimonial_text'] ?? 'Ulasan klien akan tampil di sini...'); ?>"
                        </p>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const inputName = document.getElementById('input_name');
            const inputLocation = document.getElementById('input_location');
            const inputRating = document.getElementById('input_rating');
            const previewName = document.getElementById('preview_name');
            const previewLocation = document.getElementById('preview_location');
            const previewText = document.getElementById('preview_text');
            const previewStars = document.getElementById('preview_stars');
            const previewInitials = document.getElementById('preview_initials');

            // Sync local card
            document.getElementById('input_text').addEventListener('input', (e) => {
                const val = e.target.value.replace(/<[^>]*>?/gm, '');
                previewText.textContent = `"${val}"`;
                // To complex to target marquee slide reliably, suggest reload for Live Preview
            });

            inputName.addEventListener('input', (e) => {
                previewName.textContent = e.target.value;
                previewInitials.textContent = e.target.value.charAt(0).toUpperCase() || 'U';
            });

            inputLocation.addEventListener('input', (e) => {
                previewLocation.textContent = e.target.value;
            });

            inputRating.addEventListener('change', (e) => {
                const r = parseInt(e.target.value);
                previewStars.innerHTML = '';
                for (let i = 0; i < 5; i++) {
                    const span = document.createElement('span');
                    span.className = `material-symbols-outlined text-xs ${i < r ? 'text-primary' : 'text-gray-700'}`;
                    span.textContent = 'star';
                    previewStars.appendChild(span);
                }
            });

            // Image Preview
            const imgInput = document.getElementById('client_image_input');
            const previewImg = document.getElementById('preview_img');
            imgInput.addEventListener('change', function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        previewImg.src = e.target.result;
                        previewImg.classList.remove('hidden');
                        previewInitials.classList.add('hidden');
                    };
                    reader.readAsDataURL(file);
                }
            });
        });
    </script>
<?php endif; ?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>