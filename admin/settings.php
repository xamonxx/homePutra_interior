<?php

/**
 * Site Settings Management
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
        header('Location: settings.php');
        exit;
    }

    $settings = $_POST['settings'] ?? [];

    try {
        foreach ($settings as $key => $value) {
            $stmt = $db->prepare("UPDATE site_settings SET setting_value = :value WHERE setting_key = :key");
            $stmt->execute(['value' => trim($value), 'key' => $key]);
        }

        setFlash('success', 'Pengaturan berhasil disimpan');
    } catch (PDOException $e) {
        setFlash('error', 'Gagal menyimpan: ' . $e->getMessage());
    }

    header('Location: settings.php');
    exit;
}

// Get all settings grouped
$stmt = $db->query("SELECT * FROM site_settings ORDER BY setting_group, id");
$allSettings = $stmt->fetchAll();

$settings = [];
foreach ($allSettings as $setting) {
    $settings[$setting['setting_group']][] = $setting;
}

$groupLabels = [
    'general' => 'Pengaturan Umum',
    'contact' => 'Informasi Kontak',
    'social' => 'Media Sosial',
    'branding' => 'Branding',
];

$csrfToken = generateCSRFToken();

// NOW include header - after all redirects are done
$pageTitle = 'Pengaturan';
require_once __DIR__ . '/includes/header.php';
?>

<form method="POST" class="max-w-3xl mx-auto space-y-4 lg:space-y-6">
    <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">

    <?php foreach ($settings as $group => $items): ?>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 lg:p-6">
            <h2 class="text-base lg:text-lg font-semibold text-gray-800 mb-4 lg:mb-6"><?php echo $groupLabels[$group] ?? ucfirst($group); ?></h2>

            <div class="space-y-4">
                <?php foreach ($items as $item): ?>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <?php
                            $label = str_replace('_', ' ', $item['setting_key']);
                            echo ucwords($label);
                            ?>
                        </label>

                        <?php if ($item['setting_type'] === 'textarea'): ?>
                            <textarea name="settings[<?php echo e($item['setting_key']); ?>]" rows="3"
                                class="w-full px-3 lg:px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary text-sm lg:text-base"><?php echo e($item['setting_value']); ?></textarea>

                        <?php elseif ($item['setting_type'] === 'boolean'): ?>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="settings[<?php echo e($item['setting_key']); ?>]" value="1"
                                    <?php echo $item['setting_value'] ? 'checked' : ''; ?>
                                    class="w-4 h-4 text-primary rounded focus:ring-primary">
                                <span class="text-sm text-gray-600">Aktifkan</span>
                            </label>

                        <?php else: ?>
                            <input type="<?php echo $item['setting_type'] === 'number' ? 'number' : 'text'; ?>"
                                name="settings[<?php echo e($item['setting_key']); ?>]"
                                value="<?php echo e($item['setting_value']); ?>"
                                class="w-full px-3 lg:px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary text-sm lg:text-base">
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endforeach; ?>

    <div class="flex">
        <button type="submit" class="w-full sm:w-auto px-6 py-2 bg-primary text-dark font-medium rounded-lg hover:bg-primary-dark transition-colors text-sm lg:text-base">
            Simpan Pengaturan
        </button>
    </div>
</form>

<?php require_once __DIR__ . '/includes/footer.php'; ?>