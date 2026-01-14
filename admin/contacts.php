<?php

/**
 * Contact Submissions Management
 * Home Putra Interior CMS
 */

// Include auth FIRST - before any output
require_once __DIR__ . '/includes/auth.php';

$db = getDB();
$view = $_GET['view'] ?? null;
$id = $_GET['id'] ?? null;

// Handle actions BEFORE any output
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $csrf = $_POST['csrf_token'] ?? '';
    if (!verifyCSRFToken($csrf)) {
        setFlash('error', 'Token keamanan tidak valid');
        header('Location: contacts.php');
        exit;
    }

    $postAction = $_POST['action'] ?? '';

    if ($postAction === 'mark_read' && !empty($_POST['id'])) {
        $stmt = $db->prepare("UPDATE contact_submissions SET is_read = 1 WHERE id = :id");
        $stmt->execute(['id' => $_POST['id']]);
        header('Location: contacts.php');
        exit;
    }

    if ($postAction === 'delete' && !empty($_POST['id'])) {
        try {
            $stmt = $db->prepare("DELETE FROM contact_submissions WHERE id = :id");
            $stmt->execute(['id' => $_POST['id']]);
            setFlash('success', 'Pesan berhasil dihapus');
        } catch (PDOException $e) {
            setFlash('error', 'Gagal menghapus');
        }
        header('Location: contacts.php');
        exit;
    }

    if ($postAction === 'mark_all_read') {
        $db->exec("UPDATE contact_submissions SET is_read = 1");
        setFlash('success', 'Semua pesan ditandai sudah dibaca');
        header('Location: contacts.php');
        exit;
    }
}

// Get single message for view
$message = null;
if ($view && $id) {
    $stmt = $db->prepare("SELECT * FROM contact_submissions WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $message = $stmt->fetch();

    if ($message && !$message['is_read']) {
        $stmt = $db->prepare("UPDATE contact_submissions SET is_read = 1 WHERE id = :id");
        $stmt->execute(['id' => $id]);
    }
}

// Get all messages
$items = [];
if (!$view) {
    $stmt = $db->query("SELECT * FROM contact_submissions ORDER BY created_at DESC");
    $items = $stmt->fetchAll();
}

// Count unread
$stmt = $db->query("SELECT COUNT(*) FROM contact_submissions WHERE is_read = 0");
$unreadCount = $stmt->fetchColumn();

$csrfToken = generateCSRFToken();

// NOW include header - after all redirects are done
$pageTitle = 'Pesan Masuk';
require_once __DIR__ . '/includes/header.php';
?>

<?php if ($view && $message): ?>
    <!-- Detail View -->
    <div class="max-w-3xl mx-auto">
        <div class="mb-4 lg:mb-6">
            <a href="contacts.php" class="text-gray-600 hover:text-gray-800 flex items-center gap-1 text-sm">
                <span class="material-symbols-outlined text-lg">arrow_back</span>
                Kembali
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 lg:p-6">
            <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-3 mb-4 lg:mb-6">
                <div class="flex items-center gap-3 lg:gap-4">
                    <div class="w-12 h-12 lg:w-14 lg:h-14 rounded-full bg-primary/20 flex items-center justify-center text-primary font-bold text-lg lg:text-xl">
                        <?php echo strtoupper(substr($message['first_name'], 0, 1)); ?>
                    </div>
                    <div>
                        <h2 class="text-lg lg:text-xl font-semibold text-gray-800">
                            <?php echo e($message['first_name'] . ' ' . $message['last_name']); ?>
                        </h2>
                        <p class="text-gray-500 text-sm"><?php echo e($message['email']); ?></p>
                    </div>
                </div>
                <span class="text-xs lg:text-sm text-gray-400"><?php echo date('d M Y, H:i', strtotime($message['created_at'])); ?></span>
            </div>

            <div class="grid grid-cols-2 gap-3 lg:gap-4 mb-4 lg:mb-6 p-3 lg:p-4 bg-gray-50 rounded-lg">
                <div>
                    <p class="text-xs text-gray-500 uppercase font-semibold mb-1">Telepon</p>
                    <p class="text-gray-800 text-sm lg:text-base"><?php echo e($message['phone'] ?: '-'); ?></p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase font-semibold mb-1">Layanan</p>
                    <p class="text-gray-800 text-sm lg:text-base"><?php echo e($message['service_type'] ?: '-'); ?></p>
                </div>
            </div>

            <div class="mb-4 lg:mb-6">
                <p class="text-xs text-gray-500 uppercase font-semibold mb-2">Pesan</p>
                <div class="p-3 lg:p-4 bg-gray-50 rounded-lg">
                    <p class="text-gray-700 text-sm lg:text-base whitespace-pre-wrap"><?php echo e($message['message'] ?: 'Tidak ada pesan'); ?></p>
                </div>
            </div>

            <div class="flex flex-wrap gap-2 lg:gap-3 pt-4 border-t">
                <a href="mailto:<?php echo e($message['email']); ?>" class="flex-1 sm:flex-none px-3 lg:px-4 py-2 bg-primary text-dark font-medium rounded-lg hover:bg-primary-dark transition-colors flex items-center justify-center gap-2 text-sm">
                    <span class="material-symbols-outlined text-lg">reply</span>
                    <span>Email</span>
                </a>
                <?php if ($message['phone']): ?>
                    <a href="https://wa.me/<?php echo preg_replace('/[^0-9]/', '', $message['phone']); ?>" target="_blank" class="flex-1 sm:flex-none px-3 lg:px-4 py-2 bg-green-500 text-white font-medium rounded-lg hover:bg-green-600 transition-colors flex items-center justify-center gap-2 text-sm">
                        <span class="material-symbols-outlined text-lg">chat</span>
                        <span>WhatsApp</span>
                    </a>
                <?php endif; ?>
                <form method="POST" class="flex-1 sm:flex-none" onsubmit="return confirmDelete()">
                    <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="id" value="<?php echo $message['id']; ?>">
                    <button type="submit" class="w-full px-3 lg:px-4 py-2 bg-red-100 text-red-600 font-medium rounded-lg hover:bg-red-200 transition-colors flex items-center justify-center gap-2 text-sm">
                        <span class="material-symbols-outlined text-lg">delete</span>
                        <span>Hapus</span>
                    </button>
                </form>
            </div>
        </div>
    </div>

<?php else: ?>
    <!-- List View -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="p-4 lg:p-6 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div class="flex items-center gap-2 lg:gap-3">
                <h2 class="text-base lg:text-lg font-semibold text-gray-800">Pesan Masuk</h2>
                <?php if ($unreadCount > 0): ?>
                    <span class="px-2 py-0.5 bg-primary text-dark text-xs font-bold rounded-full"><?php echo $unreadCount; ?> baru</span>
                <?php endif; ?>
            </div>
            <?php if ($unreadCount > 0): ?>
                <form method="POST">
                    <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
                    <input type="hidden" name="action" value="mark_all_read">
                    <button type="submit" class="text-xs lg:text-sm text-primary hover:underline">Tandai semua dibaca</button>
                </form>
            <?php endif; ?>
        </div>

        <?php if (empty($items)): ?>
            <div class="p-8 lg:p-12 text-center text-gray-500">
                <span class="material-symbols-outlined text-4xl lg:text-5xl mb-4">inbox</span>
                <p class="text-sm lg:text-base">Belum ada pesan masuk</p>
            </div>
        <?php else: ?>
            <div class="divide-y divide-gray-100">
                <?php foreach ($items as $row): ?>
                    <a href="?view=detail&id=<?php echo $row['id']; ?>" class="flex items-start gap-3 lg:gap-4 p-3 lg:p-4 hover:bg-gray-50 transition-colors <?php echo !$row['is_read'] ? 'bg-primary/5' : ''; ?>">
                        <div class="w-10 h-10 lg:w-12 lg:h-12 rounded-full bg-primary/20 flex items-center justify-center text-primary font-semibold flex-shrink-0 text-sm lg:text-base">
                            <?php echo strtoupper(substr($row['first_name'], 0, 1)); ?>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between mb-1 gap-2">
                                <p class="font-medium text-gray-800 text-sm lg:text-base truncate <?php echo !$row['is_read'] ? 'font-semibold' : ''; ?>">
                                    <?php echo e($row['first_name'] . ' ' . $row['last_name']); ?>
                                    <?php if (!$row['is_read']): ?>
                                        <span class="inline-block w-2 h-2 bg-primary rounded-full ml-1"></span>
                                    <?php endif; ?>
                                </p>
                                <span class="text-xs text-gray-400 flex-shrink-0"><?php echo date('d/m', strtotime($row['created_at'])); ?></span>
                            </div>
                            <p class="text-xs lg:text-sm text-gray-600 truncate"><?php echo e($row['message'] ?: 'Tidak ada pesan'); ?></p>
                            <p class="text-xs text-gray-400 mt-1 truncate"><?php echo e($row['email']); ?></p>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
<?php endif; ?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>