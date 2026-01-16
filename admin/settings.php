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
    'general' => ['label' => 'Pengaturan Umum', 'icon' => 'tune', 'desc' => 'Konfigurasi dasar website'],
    'contact' => ['label' => 'Informasi Kontak', 'icon' => 'contact_page', 'desc' => 'Alamat dan nomor telepon'],
    'social' => ['label' => 'Media Sosial', 'icon' => 'share', 'desc' => 'Link profil sosial media'],
    'branding' => ['label' => 'Branding', 'icon' => 'palette', 'desc' => 'Logo dan identitas visual'],
];

$fieldIcons = [
    'site_name' => 'business',
    'site_tagline' => 'format_quote',
    'site_description' => 'description',
    'contact_email' => 'mail',
    'contact_phone' => 'phone',
    'contact_address' => 'location_on',
    'whatsapp_number' => 'chat',
    'instagram_url' => 'photo_camera',
    'facebook_url' => 'thumb_up',
    'logo_image' => 'image',
];

$csrfToken = generateCSRFToken();

// NOW include header - after all redirects are done
$pageTitle = 'Pengaturan';
require_once __DIR__ . '/includes/header.php';
?>

<div class="max-w-4xl mx-auto">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
        <div>
            <h2 class="text-xl md:text-2xl font-bold text-white flex items-center gap-2">
                <span class="material-symbols-outlined text-primary">settings</span>
                Pengaturan Website
            </h2>
            <p class="text-gray-400 text-sm mt-1">Konfigurasi informasi dan tampilan website Anda.</p>
        </div>
    </div>

    <form method="POST" class="space-y-6">
        <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">

        <?php foreach ($settings as $group => $items): ?>
            <?php $groupInfo = $groupLabels[$group] ?? ['label' => ucfirst($group), 'icon' => 'settings', 'desc' => '']; ?>
            <div class="bg-surface-dark rounded-2xl border border-white/5 overflow-hidden hover:border-primary/20 transition-all duration-300 shadow-lg">
                <!-- Group Header -->
                <div class="p-6 border-b border-white/5 bg-gradient-to-r from-primary/5 to-transparent">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-primary/20 flex items-center justify-center">
                            <span class="material-symbols-outlined text-primary"><?php echo $groupInfo['icon']; ?></span>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-white"><?php echo $groupInfo['label']; ?></h3>
                            <p class="text-xs text-gray-500"><?php echo $groupInfo['desc']; ?></p>
                        </div>
                    </div>
                </div>

                <!-- Group Content -->
                <div class="p-6 space-y-5">
                    <?php foreach ($items as $item): ?>
                        <?php
                        $label = str_replace('_', ' ', $item['setting_key']);
                        $icon = $fieldIcons[$item['setting_key']] ?? 'edit';
                        ?>
                        <div class="form-group">
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">
                                <?php echo ucwords($label); ?>
                            </label>

                            <?php if ($item['setting_type'] === 'textarea'): ?>
                                <div class="relative group">
                                    <span class="material-symbols-outlined absolute left-4 top-4 text-gray-500 group-focus-within:text-primary transition-colors"><?php echo $icon; ?></span>
                                    <textarea name="settings[<?php echo e($item['setting_key']); ?>]" rows="3"
                                        class="w-full pl-12 pr-4 py-3.5 bg-white/5 border border-white/10 rounded-xl focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all text-white placeholder-gray-600 hover:border-white/20 resize-none"><?php echo e($item['setting_value']); ?></textarea>
                                </div>

                            <?php elseif ($item['setting_type'] === 'boolean'): ?>
                                <label class="flex items-center gap-4 cursor-pointer group p-3.5 bg-white/5 border border-white/10 rounded-xl hover:border-white/20 transition-all">
                                    <div class="relative">
                                        <input type="checkbox" name="settings[<?php echo e($item['setting_key']); ?>]" value="1"
                                            <?php echo $item['setting_value'] ? 'checked' : ''; ?>
                                            class="sr-only peer">
                                        <div class="w-12 h-7 bg-white/10 rounded-full peer peer-checked:bg-primary transition-all"></div>
                                        <div class="absolute left-1 top-1 w-5 h-5 bg-white rounded-full shadow-md transition-all peer-checked:translate-x-5"></div>
                                    </div>
                                    <div>
                                        <span class="text-sm text-white font-medium">Aktifkan</span>
                                        <p class="text-[10px] text-gray-500">Aktifkan fitur ini</p>
                                    </div>
                                </label>

                            <?php elseif ($item['setting_type'] === 'image'): ?>
                                <div class="relative group">
                                    <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 group-focus-within:text-primary transition-colors"><?php echo $icon; ?></span>
                                    <input type="text"
                                        name="settings[<?php echo e($item['setting_key']); ?>]"
                                        value="<?php echo e($item['setting_value']); ?>"
                                        placeholder="URL gambar atau path lokal"
                                        class="w-full pl-12 pr-4 py-3.5 bg-white/5 border border-white/10 rounded-xl focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all text-white placeholder-gray-600 hover:border-white/20">
                                </div>

                            <?php else: ?>
                                <div class="relative group">
                                    <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 group-focus-within:text-primary transition-colors"><?php echo $icon; ?></span>
                                    <input type="<?php echo $item['setting_type'] === 'number' ? 'number' : 'text'; ?>"
                                        name="settings[<?php echo e($item['setting_key']); ?>]"
                                        value="<?php echo e($item['setting_value']); ?>"
                                        <?php if ($item['setting_key'] === 'whatsapp_number'): ?>
                                        placeholder="Contoh: 628123456789"
                                        <?php endif; ?>
                                        class="w-full pl-12 pr-4 py-3.5 bg-white/5 border border-white/10 rounded-xl focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all text-white placeholder-gray-600 hover:border-white/20">
                                </div>
                                <?php if ($item['setting_key'] === 'whatsapp_number'): ?>
                                    <p class="mt-2 text-xs text-gray-500 flex items-center gap-1.5">
                                        <span class="material-symbols-outlined text-sm text-primary">info</span>
                                        <span>Gunakan format internasional dengan <strong class="text-primary">62</strong> (tanpa + atau 0). Contoh: <code class="bg-white/10 px-1.5 py-0.5 rounded text-primary">628123456789</code></span>
                                    </p>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>

        <!-- Submit Button -->
        <div class="flex flex-col sm:flex-row gap-3 pt-4">
            <button type="submit" class="flex-1 sm:flex-none py-4 px-8 bg-primary text-black font-extrabold rounded-xl hover:shadow-[0_0_30px_rgba(255,178,4,0.3)] hover:scale-[1.02] transition-all flex items-center justify-center gap-2 uppercase tracking-widest text-xs">
                <span class="material-symbols-outlined">save</span>
                Simpan Pengaturan
            </button>
            <a href="index.php" class="py-4 px-6 bg-white/5 text-gray-400 font-bold rounded-xl hover:bg-white/10 hover:text-white transition-all flex items-center justify-center gap-2 uppercase tracking-widest text-xs border border-white/10">
                <span class="material-symbols-outlined">close</span>
                Batal
            </a>
        </div>
    </form>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>