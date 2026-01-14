<?php

/**
 * Contact Messages Management
 * Home Putra Interior CMS
 */

// Include auth FIRST - before any output
require_once __DIR__ . '/includes/auth.php';

$db = getDB();
$view = $_GET['view'] ?? 'list';
$id = $_GET['id'] ?? null;

// Handle form submissions BEFORE any output
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $csrf = $_POST['csrf_token'] ?? '';
    if (!verifyCSRFToken($csrf)) {
        setFlash('error', 'Token keamanan tidak valid');
        header('Location: contacts.php');
        exit;
    }

    $postAction = $_POST['action'] ?? '';

    if ($postAction === 'mark_read' && !empty($_POST['id'])) {
        try {
            $stmt = $db->prepare("UPDATE contact_submissions SET is_read = 1 WHERE id = :id");
            $stmt->execute(['id' => $_POST['id']]);
            setFlash('success', 'Pesan ditandai sudah dibaca');
        } catch (PDOException $e) {
            setFlash('error', 'Gagal memperbarui');
        }
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
}

// Get single message for detail view
$message = null;
if ($view === 'detail' && $id) {
    $stmt = $db->prepare("SELECT * FROM contact_submissions WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $message = $stmt->fetch();

    // Mark as read
    if ($message && !$message['is_read']) {
        $stmt = $db->prepare("UPDATE contact_submissions SET is_read = 1 WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $message['is_read'] = 1;
    }
}

// Get all messages for list
$messages = [];
if ($view === 'list') {
    $stmt = $db->query("SELECT * FROM contact_submissions ORDER BY created_at DESC");
    $messages = $stmt->fetchAll();
}

$csrfToken = generateCSRFToken();

// NOW include header
$pageTitle = 'Pesan Kontak';
require_once __DIR__ . '/includes/header.php';
?>

<?php if ($view === 'list'): ?>
    <div class="max-w-6xl mx-auto">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
            <div>
                <h2 class="text-xl md:text-2xl font-bold text-white flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">mail</span>
                    Pesan Kontak
                </h2>
                <p class="text-gray-400 text-sm mt-1">Daftar pesan yang masuk dari form kontak website.</p>
            </div>
        </div>

        <?php if (empty($messages)): ?>
            <div class="bg-surface-dark rounded-2xl border border-white/5 p-20 text-center">
                <div class="w-20 h-20 bg-primary/10 rounded-full flex items-center justify-center mx-auto mb-6">
                    <span class="material-symbols-outlined text-4xl text-primary">inbox</span>
                </div>
                <h3 class="text-xl font-bold text-white mb-2">Belum ada pesan</h3>
                <p class="text-gray-500 max-w-xs mx-auto">Pesan dari pengunjung website akan muncul di sini.</p>
            </div>
        <?php else: ?>
            <div class="bg-surface-dark rounded-2xl border border-white/5 overflow-hidden">
                <div class="divide-y divide-white/5">
                    <?php foreach ($messages as $msg): ?>
                        <div class="p-4 md:p-6 hover:bg-white/5 transition-colors flex items-start gap-4">
                            <div class="w-12 h-12 rounded-full bg-primary/20 flex items-center justify-center text-primary font-bold text-lg flex-shrink-0">
                                <?php echo strtoupper(substr($msg['first_name'], 0, 1)); ?>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between mb-1 gap-2">
                                    <h4 class="font-bold text-white flex items-center gap-2">
                                        <?php echo e($msg['first_name'] . ' ' . $msg['last_name']); ?>
                                        <?php if (!$msg['is_read']): ?>
                                            <span class="w-2 h-2 bg-primary rounded-full animate-pulse"></span>
                                        <?php endif; ?>
                                    </h4>
                                    <span class="text-xs text-gray-500"><?php echo date('d M Y, H:i', strtotime($msg['created_at'])); ?></span>
                                </div>
                                <p class="text-sm text-gray-400 mb-2"><?php echo e($msg['email']); ?></p>
                                <p class="text-sm text-gray-300 line-clamp-2"><?php echo e($msg['message']); ?></p>
                                <div class="flex items-center gap-3 mt-4">
                                    <a href="?view=detail&id=<?php echo $msg['id']; ?>" class="text-xs text-primary hover:text-white transition-colors font-medium">Lihat Detail →</a>
                                    <form method="POST" class="inline" onsubmit="return confirmDelete()">
                                        <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="id" value="<?php echo $msg['id']; ?>">
                                        <button type="submit" class="text-xs text-red-400 hover:text-red-300 transition-colors font-medium">Hapus</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>

<?php else: ?>
    <!-- Detail View -->
    <div class="max-w-4xl mx-auto">
        <div class="mb-8">
            <a href="contacts.php" class="inline-flex items-center gap-2 text-gray-500 hover:text-primary transition-all text-sm font-bold uppercase tracking-widest">
                <span class="material-symbols-outlined">arrow_back</span>
                Kembali
            </a>
        </div>

        <?php if ($message): ?>
            <div class="bg-surface-dark rounded-2xl border border-white/5 overflow-hidden">
                <div class="p-6 md:p-8 border-b border-white/5">
                    <div class="flex items-start gap-4">
                        <div class="w-16 h-16 rounded-full bg-primary/20 flex items-center justify-center text-primary font-bold text-2xl flex-shrink-0">
                            <?php echo strtoupper(substr($message['first_name'], 0, 1)); ?>
                        </div>
                        <div class="flex-1">
                            <h2 class="text-xl font-bold text-white mb-1"><?php echo e($message['first_name'] . ' ' . $message['last_name']); ?></h2>
                            <p class="text-sm text-gray-400 mb-1"><?php echo e($message['email']); ?></p>
                            <?php if (!empty($message['phone'])): ?>
                                <p class="text-sm text-gray-400"><?php echo e($message['phone']); ?></p>
                            <?php endif; ?>
                        </div>
                        <span class="text-xs text-gray-500"><?php echo date('d M Y, H:i', strtotime($message['created_at'])); ?></span>
                    </div>
                </div>
                <div class="p-6 md:p-8">
                    <h3 class="text-sm font-bold text-primary uppercase tracking-widest mb-4">Isi Pesan</h3>
                    <p class="text-gray-300 leading-relaxed whitespace-pre-wrap"><?php echo e($message['message']); ?></p>
                </div>
                <div class="p-6 md:p-8 bg-white/5 border-t border-white/5 flex items-center justify-between">
                    <a href="mailto:<?php echo e($message['email']); ?>" class="inline-flex items-center gap-2 px-6 py-3 bg-primary text-black font-bold rounded-lg hover:shadow-[0_0_20px_rgba(255,178,4,0.4)] transition-all">
                        <span class="material-symbols-outlined">reply</span>
                        Balas Email
                    </a>
                    <form method="POST" onsubmit="return confirmDelete()">
                        <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="id" value="<?php echo $message['id']; ?>">
                        <button type="submit" class="inline-flex items-center gap-2 px-6 py-3 bg-red-500/10 text-red-400 font-bold rounded-lg hover:bg-red-500 hover:text-white transition-all">
                            <span class="material-symbols-outlined">delete</span>
                            Hapus Pesan
                        </button>
                    </form>
                </div>
            </div>
        <?php else: ?>
            <div class="bg-surface-dark rounded-2xl border border-white/5 p-20 text-center">
                <span class="material-symbols-outlined text-4xl text-gray-500 mb-4">error</span>
                <h3 class="text-xl font-bold text-white mb-2">Pesan tidak ditemukan</h3>
                <a href="contacts.php" class="text-primary hover:underline">Kembali ke daftar pesan</a>
            </div>
        <?php endif; ?>
    </div>
<?php endif; ?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>