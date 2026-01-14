<?php

/**
 * Hero Section Management
 * Home Putra Interior CMS
 */

// Include auth FIRST - before any output
require_once __DIR__ . '/includes/auth.php';

$db = getDB();

// Handle form submission BEFORE any output
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $csrf = $_POST['csrf_token'] ?? '';
    if (!verifyCSRFToken($csrf)) {
        setFlash('error', 'Token keamanan tidak valid');
        header('Location: hero.php');
        exit;
    }

    $data = [
        'title' => trim($_POST['title'] ?? ''),
        'subtitle' => trim($_POST['subtitle'] ?? ''),
        'button1_text' => trim($_POST['button1_text'] ?? ''),
        'button1_link' => trim($_POST['button1_link'] ?? ''),
        'button2_text' => trim($_POST['button2_text'] ?? ''),
        'button2_link' => trim($_POST['button2_link'] ?? ''),
        'is_active' => isset($_POST['is_active']) ? 1 : 0,
    ];

    // Handle image upload
    if (!empty($_FILES['background_image']['name'])) {
        $uploadDir = __DIR__ . '/../uploads/hero/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

        $ext = strtolower(pathinfo($_FILES['background_image']['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'webp'];

        if (in_array($ext, $allowed)) {
            $filename = 'hero_' . time() . '_' . uniqid() . '.' . $ext;
            if (move_uploaded_file($_FILES['background_image']['tmp_name'], $uploadDir . $filename)) {
                $data['background_image'] = 'uploads/hero/' . $filename;
            }
        }
    }

    try {
        // Check if hero exists
        $stmt = $db->query("SELECT id FROM hero_section LIMIT 1");
        $existing = $stmt->fetch();

        if ($existing) {
            $sql = "UPDATE hero_section SET title = :title, subtitle = :subtitle, 
                    button1_text = :button1_text, button1_link = :button1_link,
                    button2_text = :button2_text, button2_link = :button2_link, is_active = :is_active";
            if (isset($data['background_image'])) {
                $sql .= ", background_image = :background_image";
            }
            $sql .= " WHERE id = :id";
            $data['id'] = $existing['id'];

            $stmt = $db->prepare($sql);
            $stmt->execute($data);
        } else {
            $data['background_image'] = $data['background_image'] ?? '';
            $stmt = $db->prepare("INSERT INTO hero_section (title, subtitle, background_image, button1_text, button1_link, button2_text, button2_link, is_active) 
                                  VALUES (:title, :subtitle, :background_image, :button1_text, :button1_link, :button2_text, :button2_link, :is_active)");
            $stmt->execute($data);
        }

        setFlash('success', 'Hero section berhasil disimpan');
    } catch (PDOException $e) {
        setFlash('error', 'Gagal menyimpan: ' . $e->getMessage());
    }

    header('Location: hero.php');
    exit;
}

// Get hero data
$stmt = $db->query("SELECT * FROM hero_section LIMIT 1");
$hero = $stmt->fetch();

$csrfToken = generateCSRFToken();

// NOW include header - after all redirects are done
$pageTitle = 'Hero Section';
require_once __DIR__ . '/includes/header.php';
?>

<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <h2 class="text-xl md:text-2xl font-bold text-white flex items-center gap-2">
            <span class="material-symbols-outlined text-primary">view_carousel</span>
            Pengaturan Hero Section
        </h2>
        <p class="text-gray-400 text-sm mt-1">Kelola tampilan utama di bagian paling atas landing page Anda.</p>
    </div>

    <form method="POST" enctype="multipart/form-data" class="space-y-6">
        <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">

        <!-- Hero Card Preview -->
        <div class="bg-surface-dark rounded-xl shadow-xl border border-white/5 overflow-hidden">
            <div class="p-4 border-b border-white/5 bg-white/5">
                <p class="text-[10px] font-bold uppercase tracking-widest text-primary">Visual Preview</p>
            </div>
            <div class="relative h-48 md:h-64 bg-black overflow-hidden group">
                <img id="hero_preview_img" src="../<?php echo !empty($hero['background_image']) ? e($hero['background_image']) : 'assets/images/placeholder.jpg'; ?>"
                    alt="" class="w-full h-full object-cover opacity-60 transition-transform duration-700 group-hover:scale-110">
                <div class="absolute inset-0 flex flex-col items-center justify-center text-center px-6">
                    <h3 id="preview_title" class="text-lg md:text-3xl font-bold text-white mb-2 max-w-lg leading-tight uppercase tracking-wide">
                        <?php echo strip_tags($hero['title'] ?? 'Judul Hero Anda'); ?>
                    </h3>
                    <p id="preview_subtitle" class="text-xs md:text-sm text-gray-300 max-w-md line-clamp-2 italic">
                        <?php echo e($hero['subtitle'] ?? 'Tambahkan deskripsi singkat di sini untuk menarik perhatian pengunjung.'); ?>
                    </p>
                    <div class="mt-4 flex gap-3">
                        <div id="preview_btn1" class="px-4 py-1.5 bg-primary text-black text-[10px] font-bold rounded">
                            <?php echo e($hero['button1_text'] ?? 'PRIMARY CTA'); ?>
                        </div>
                        <div id="preview_btn2" class="px-4 py-1.5 border border-white/20 text-white text-[10px] font-bold rounded">
                            <?php echo e($hero['button2_text'] ?? 'SECONDARY'); ?>
                        </div>
                    </div>
                </div>
                <div class="absolute bottom-4 right-4 animate-bounce">
                    <span class="material-symbols-outlined text-white/30 text-2xl">keyboard_double_arrow_down</span>
                </div>
            </div>
        </div>

        <div class="bg-surface-dark rounded-xl border border-white/5 p-4 md:p-6 lg:p-8 space-y-6">
            <div class="form-group">
                <label class="form-label">Judul Utama (Mendukung HTML)</label>
                <textarea name="title" id="input_title" rows="3"
                    class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-lg focus:border-primary transition-all font-mono text-sm tracking-tight"
                    placeholder="Mendefinisikan Ruang, &lt;span class='text-gold-gradient italic'&gt;Meningkatkan Gaya Hidup&lt;/span&gt;"><?php echo e($hero['title'] ?? ''); ?></textarea>
                <p class="form-help">Tip: Gunakan &lt;span class="text-gold-gradient italic"&gt;teks&lt;/span&gt; untuk efek emas miring.</p>
            </div>

            <div class="form-group">
                <label class="form-label">Subtitle / Deskripsi</label>
                <textarea name="subtitle" id="input_subtitle" rows="3"
                    class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-lg focus:border-primary transition-all text-sm md:text-base"
                    placeholder="Jelaskan secara singkat apa yang perusahaan Anda tawarkan..."><?php echo e($hero['subtitle'] ?? ''); ?></textarea>
            </div>

            <div class="form-group">
                <label class="form-label">Background Image</label>
                <div class="file-upload-wrapper">
                    <input type="file" name="background_image" id="hero_image_input" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                    <div class="space-y-2">
                        <span class="material-symbols-outlined text-4xl text-gray-500">wallpaper</span>
                        <p class="text-sm text-gray-400">Klik atau drag gambar latar baru ke sini</p>
                        <p class="text-[10px] text-gray-500">Resolusi disarankan: 1920x1080px (Maks. 5MB)</p>
                    </div>
                </div>
            </div>

            <div class="bg-white/5 rounded-xl p-4 md:p-6 border border-white/5">
                <h3 class="text-sm font-bold text-primary flex items-center gap-2 mb-6 uppercase tracking-wider">
                    <span class="material-symbols-outlined text-lg">link</span>
                    Konfigurasi Tombol (CTA)
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pb-6 border-b border-white/5">
                    <div class="form-group mb-0">
                        <label class="form-label">Tombol 1 - Teks</label>
                        <input type="text" name="button1_text" id="input_btn1" value="<?php echo e($hero['button1_text'] ?? 'Lihat Portofolio'); ?>"
                            class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-lg focus:border-primary transition-all">
                    </div>
                    <div class="form-group mb-0">
                        <label class="form-label">Tombol 1 - Link</label>
                        <input type="text" name="button1_link" value="<?php echo e($hero['button1_link'] ?? '#portfolio'); ?>"
                            class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-lg focus:border-primary transition-all">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-6">
                    <div class="form-group mb-0">
                        <label class="form-label">Tombol 2 - Teks</label>
                        <input type="text" name="button2_text" id="input_btn2" value="<?php echo e($hero['button2_text'] ?? 'Konsultasi Gratis'); ?>"
                            class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-lg focus:border-primary transition-all">
                    </div>
                    <div class="form-group mb-0">
                        <label class="form-label">Tombol 2 - Link</label>
                        <input type="text" name="button2_link" value="<?php echo e($hero['button2_link'] ?? '#contact'); ?>"
                            class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-lg focus:border-primary transition-all">
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-between pt-6 border-t border-white/5">
                <label class="flex items-center gap-3 cursor-pointer group">
                    <input type="checkbox" name="is_active" value="1" <?php echo ($hero['is_active'] ?? 1) ? 'checked' : ''; ?>
                        class="w-5 h-5 rounded border-white/10 bg-white/5 text-primary focus:ring-primary transition-all">
                    <span class="text-sm text-gray-300 group-hover:text-primary transition-colors">Hero Section Aktif</span>
                </label>

                <div class="flex gap-4">
                    <button type="submit" class="px-10 py-3 bg-primary text-black font-bold rounded-lg hover:shadow-[0_0_20px_rgba(255,178,4,0.4)] transition-all flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined text-xl">save</span>
                        Simpan Perubahan
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const inputTitle = document.getElementById('input_title');
        const inputSubtitle = document.getElementById('input_subtitle');
        const previewTitle = document.getElementById('preview_title');
        const previewSubtitle = document.getElementById('preview_subtitle');
        const heroInput = document.getElementById('hero_image_input');
        const heroPreviewImg = document.getElementById('hero_preview_img');

        // CTA Inputs
        const inputBtn1 = document.getElementById('input_btn1');
        const inputBtn2 = document.getElementById('input_btn2');
        const previewBtn1 = document.getElementById('preview_btn1');
        const previewBtn2 = document.getElementById('preview_btn2');

        // Local Real-time Update
        inputTitle.addEventListener('input', (e) => {
            const val = e.target.value;
            previewTitle.textContent = val.replace(/<[^>]*>?/gm, '');
        });

        inputSubtitle.addEventListener('input', (e) => {
            const val = e.target.value;
            previewSubtitle.textContent = val.replace(/<[^>]*>?/gm, '');
        });

        inputBtn1.addEventListener('input', (e) => {
            previewBtn1.textContent = e.target.value;
        });

        inputBtn2.addEventListener('input', (e) => {
            previewBtn2.textContent = e.target.value;
        });

        heroInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    heroPreviewImg.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    });
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>