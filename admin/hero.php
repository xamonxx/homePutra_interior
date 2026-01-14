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

<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 lg:p-6">
        <h2 class="text-base lg:text-lg font-semibold text-gray-800 mb-4 lg:mb-6">Edit Hero Section</h2>

        <form method="POST" enctype="multipart/form-data" class="space-y-4 lg:space-y-6">
            <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">

            <!-- Preview -->
            <?php if (!empty($hero['background_image'])): ?>
                <div class="p-3 lg:p-4 bg-gray-900 rounded-lg text-center">
                    <p class="text-xs text-gray-500 mb-2 lg:mb-3 uppercase tracking-wider">Preview</p>
                    <div class="relative h-32 lg:h-48 rounded-lg overflow-hidden">
                        <img src="../<?php echo e($hero['background_image']); ?>" alt="" class="w-full h-full object-cover opacity-50">
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="text-center px-4">
                                <h3 class="text-lg lg:text-2xl font-bold text-white truncate"><?php echo substr(strip_tags($hero['title'] ?? 'Judul Hero'), 0, 40); ?>...</h3>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Judul Utama</label>
                <textarea name="title" rows="3"
                    class="w-full px-3 lg:px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary font-mono text-xs lg:text-sm"
                    placeholder="Mendefinisikan Ruang, &lt;span class='text-gold-gradient italic'&gt;Meningkatkan Gaya Hidup&lt;/span&gt;"><?php echo e($hero['title'] ?? ''); ?></textarea>
                <p class="text-xs text-gray-500 mt-1">Mendukung HTML untuk styling.</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Subtitle</label>
                <textarea name="subtitle" rows="3"
                    class="w-full px-3 lg:px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary text-sm lg:text-base"><?php echo e($hero['subtitle'] ?? ''); ?></textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Background Image</label>
                <?php if (!empty($hero['background_image'])): ?>
                    <div class="mb-3">
                        <img src="../<?php echo e($hero['background_image']); ?>" alt="" class="w-full h-32 lg:h-48 object-cover rounded-lg">
                    </div>
                <?php endif; ?>
                <input type="file" name="background_image" accept="image/*"
                    class="w-full px-3 lg:px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary text-sm">
                <p class="text-xs text-gray-500 mt-1">Rekomendasi: 1920x1080px atau lebih.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 lg:gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tombol 1 - Teks</label>
                    <input type="text" name="button1_text" value="<?php echo e($hero['button1_text'] ?? 'Lihat Portfolio'); ?>"
                        class="w-full px-3 lg:px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary text-sm lg:text-base">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tombol 1 - Link</label>
                    <input type="text" name="button1_link" value="<?php echo e($hero['button1_link'] ?? '#portfolio'); ?>"
                        class="w-full px-3 lg:px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary text-sm lg:text-base">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 lg:gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tombol 2 - Teks</label>
                    <input type="text" name="button2_text" value="<?php echo e($hero['button2_text'] ?? 'Konsultasi Gratis'); ?>"
                        class="w-full px-3 lg:px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary text-sm lg:text-base">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tombol 2 - Link</label>
                    <input type="text" name="button2_link" value="<?php echo e($hero['button2_link'] ?? '#contact'); ?>"
                        class="w-full px-3 lg:px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary text-sm lg:text-base">
                </div>
            </div>

            <label class="flex items-center gap-2 cursor-pointer">
                <input type="checkbox" name="is_active" value="1" <?php echo ($hero['is_active'] ?? 1) ? 'checked' : ''; ?>
                    class="w-4 h-4 text-primary rounded focus:ring-primary">
                <span class="text-sm text-gray-700">Aktif</span>
            </label>

            <div class="pt-4 border-t">
                <button type="submit" class="w-full sm:w-auto px-6 py-2 bg-primary text-dark font-medium rounded-lg hover:bg-primary-dark transition-colors text-sm lg:text-base">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>