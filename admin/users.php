<?php

/**
 * Admin Users Management
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
        header('Location: users.php');
        exit;
    }

    $postAction = $_POST['action'] ?? '';

    if ($postAction === 'save') {
        $data = [
            'username' => trim($_POST['username'] ?? ''),
            'full_name' => trim($_POST['full_name'] ?? ''),
            'email' => trim($_POST['email'] ?? ''),
            'role' => $_POST['role'] ?? 'editor',
            'is_active' => isset($_POST['is_active']) ? 1 : 0,
        ];

        // Validate username
        if (empty($data['username'])) {
            setFlash('error', 'Username wajib diisi');
            header('Location: users.php?action=' . ($_POST['id'] ? 'edit&id=' . $_POST['id'] : 'add'));
            exit;
        }

        try {
            if (!empty($_POST['id'])) {
                // Update existing user
                $sql = "UPDATE admin_users SET username = :username, full_name = :full_name, 
                        email = :email, role = :role, is_active = :is_active";

                // Update password only if provided
                if (!empty($_POST['password'])) {
                    $sql .= ", password = :password";
                    $data['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
                }

                $sql .= " WHERE id = :id";
                $data['id'] = $_POST['id'];

                $stmt = $db->prepare($sql);
                $stmt->execute($data);

                // Update session if editing current user
                if ($_POST['id'] == $_SESSION['admin_id']) {
                    $_SESSION['admin_name'] = $data['full_name'];
                    $_SESSION['admin_role'] = $data['role'];
                }

                setFlash('success', 'User berhasil diperbarui');
            } else {
                // Check if username already exists
                $stmt = $db->prepare("SELECT id FROM admin_users WHERE username = :username");
                $stmt->execute(['username' => $data['username']]);
                if ($stmt->fetch()) {
                    setFlash('error', 'Username sudah digunakan');
                    header('Location: users.php?action=add');
                    exit;
                }

                // Create new user
                if (empty($_POST['password'])) {
                    setFlash('error', 'Password wajib diisi untuk user baru');
                    header('Location: users.php?action=add');
                    exit;
                }

                $data['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);

                $stmt = $db->prepare("INSERT INTO admin_users (username, password, full_name, email, role, is_active) 
                                      VALUES (:username, :password, :full_name, :email, :role, :is_active)");
                $stmt->execute($data);
                setFlash('success', 'User berhasil ditambahkan');
            }
        } catch (PDOException $e) {
            setFlash('error', 'Gagal menyimpan: ' . $e->getMessage());
        }

        header('Location: users.php');
        exit;
    }

    if ($postAction === 'delete' && !empty($_POST['id'])) {
        // Prevent deleting self
        if ($_POST['id'] == $_SESSION['admin_id']) {
            setFlash('error', 'Tidak dapat menghapus akun sendiri');
            header('Location: users.php');
            exit;
        }

        try {
            $stmt = $db->prepare("DELETE FROM admin_users WHERE id = :id");
            $stmt->execute(['id' => $_POST['id']]);
            setFlash('success', 'User berhasil dihapus');
        } catch (PDOException $e) {
            setFlash('error', 'Gagal menghapus');
        }
        header('Location: users.php');
        exit;
    }
}

$item = null;
if ($action === 'edit' && $id) {
    $stmt = $db->prepare("SELECT * FROM admin_users WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $item = $stmt->fetch();
}

$items = [];
if ($action === 'list') {
    $stmt = $db->query("SELECT * FROM admin_users ORDER BY created_at DESC");
    $items = $stmt->fetchAll();
}

$csrfToken = generateCSRFToken();

// NOW include header
$pageTitle = 'Manajemen User';
require_once __DIR__ . '/includes/header.php';
?>

<?php if ($action === 'list'): ?>
    <div class="max-w-6xl mx-auto">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
            <div>
                <h2 class="text-xl md:text-2xl font-bold text-white flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">group</span>
                    Manajemen User
                </h2>
                <p class="text-gray-400 text-sm mt-1">Kelola akun administrator panel.</p>
            </div>
            <a href="?action=add" class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-primary text-black font-bold rounded-lg hover:shadow-[0_0_20px_rgba(255,178,4,0.4)] transition-all">
                <span class="material-symbols-outlined">person_add</span>
                <span>Tambah User</span>
            </a>
        </div>

        <?php if (empty($items)): ?>
            <div class="bg-surface-dark rounded-2xl border border-white/5 p-20 text-center">
                <div class="w-20 h-20 bg-primary/10 rounded-full flex items-center justify-center mx-auto mb-6">
                    <span class="material-symbols-outlined text-4xl text-primary">group</span>
                </div>
                <h3 class="text-xl font-bold text-white mb-2">Belum ada user</h3>
                <p class="text-gray-500 max-w-xs mx-auto mb-8">Mulailah dengan menambahkan admin pertama Anda.</p>
                <a href="?action=add" class="text-primary font-bold hover:underline">Tambah Sekarang</a>
            </div>
        <?php else: ?>
            <div class="bg-surface-dark rounded-2xl border border-white/5 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-white/5">
                                <th class="text-left px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-widest">User</th>
                                <th class="text-left px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-widest">Role</th>
                                <th class="text-left px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-widest">Status</th>
                                <th class="text-left px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-widest">Login Terakhir</th>
                                <th class="text-right px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-widest">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5">
                            <?php foreach ($items as $row): ?>
                                <tr class="hover:bg-white/5 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-full bg-primary/20 flex items-center justify-center text-primary font-bold">
                                                <?php echo strtoupper(substr($row['full_name'] ?: $row['username'], 0, 1)); ?>
                                            </div>
                                            <div>
                                                <p class="font-medium text-white"><?php echo e($row['full_name'] ?: $row['username']); ?></p>
                                                <p class="text-xs text-gray-500">@<?php echo e($row['username']); ?></p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 py-1 text-[10px] font-bold uppercase tracking-widest rounded <?php echo $row['role'] === 'admin' ? 'bg-primary/20 text-primary' : 'bg-blue-500/20 text-blue-400'; ?>">
                                            <?php echo e($row['role']); ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <?php if ($row['is_active']): ?>
                                            <span class="inline-flex items-center gap-1 text-xs text-green-400">
                                                <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                                                Aktif
                                            </span>
                                        <?php else: ?>
                                            <span class="inline-flex items-center gap-1 text-xs text-gray-500">
                                                <span class="w-2 h-2 bg-gray-500 rounded-full"></span>
                                                Nonaktif
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-400">
                                        <?php echo $row['last_login'] ? date('d M Y, H:i', strtotime($row['last_login'])) : '-'; ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="?action=edit&id=<?php echo $row['id']; ?>" class="p-2 bg-blue-500/10 text-blue-400 rounded-lg hover:bg-blue-500 hover:text-white transition-all">
                                                <span class="material-symbols-outlined text-lg">edit</span>
                                            </a>
                                            <?php if ($row['id'] != $_SESSION['admin_id']): ?>
                                                <form method="POST" class="inline" onsubmit="return confirmDelete('Hapus user ini?')">
                                                    <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
                                                    <input type="hidden" name="action" value="delete">
                                                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                                    <button type="submit" class="p-2 bg-red-500/10 text-red-400 rounded-lg hover:bg-red-500 hover:text-white transition-all">
                                                        <span class="material-symbols-outlined text-lg">delete</span>
                                                    </button>
                                                </form>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php endif; ?>
    </div>

<?php else: ?>
    <!-- Form View -->
    <div class="max-w-2xl mx-auto">
        <div class="mb-8">
            <a href="users.php" class="inline-flex items-center gap-2 text-gray-500 hover:text-primary transition-all text-sm font-bold uppercase tracking-widest group">
                <span class="material-symbols-outlined group-hover:-translate-x-1 transition-transform">arrow_back</span>
                Kembali
            </a>
        </div>

        <div class="bg-surface-dark rounded-2xl border border-white/5 overflow-hidden hover:border-primary/20 transition-all duration-300 shadow-lg hover:shadow-xl hover:shadow-primary/5">
            <div class="p-6 md:p-8 border-b border-white/5 bg-gradient-to-r from-primary/5 to-transparent">
                <h2 class="text-xl font-bold text-white flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-primary/20 flex items-center justify-center">
                        <span class="material-symbols-outlined text-primary"><?php echo $item ? 'edit' : 'person_add'; ?></span>
                    </div>
                    <?php echo $item ? 'Edit User' : 'Tambah User Baru'; ?>
                </h2>
                <p class="text-gray-500 text-sm mt-2 ml-13"><?php echo $item ? 'Perbarui informasi akun pengguna.' : 'Buat akun administrator baru.'; ?></p>
            </div>

            <form method="POST" class="p-6 md:p-8 space-y-6">
                <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
                <input type="hidden" name="action" value="save">
                <?php if ($item): ?>
                    <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
                <?php endif; ?>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="form-group">
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Username <span class="text-red-500">*</span></label>
                        <div class="relative group">
                            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 group-focus-within:text-primary transition-colors">person</span>
                            <input type="text" name="username" value="<?php echo e($item['username'] ?? ''); ?>" required
                                placeholder="contoh: admin"
                                class="w-full pl-12 pr-4 py-3.5 bg-white/5 border border-white/10 rounded-xl focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all text-white placeholder-gray-600 hover:border-white/20">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Nama Lengkap</label>
                        <div class="relative group">
                            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 group-focus-within:text-primary transition-colors">badge</span>
                            <input type="text" name="full_name" value="<?php echo e($item['full_name'] ?? ''); ?>"
                                placeholder="contoh: John Doe"
                                class="w-full pl-12 pr-4 py-3.5 bg-white/5 border border-white/10 rounded-xl focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all text-white placeholder-gray-600 hover:border-white/20">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Email</label>
                    <div class="relative group">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 group-focus-within:text-primary transition-colors">mail</span>
                        <input type="email" name="email" value="<?php echo e($item['email'] ?? ''); ?>"
                            placeholder="contoh: admin@example.com"
                            class="w-full pl-12 pr-4 py-3.5 bg-white/5 border border-white/10 rounded-xl focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all text-white placeholder-gray-600 hover:border-white/20">
                    </div>
                </div>

                <div class="form-group">
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Password <?php echo $item ? '<span class="text-gray-600 normal-case font-normal">(kosongkan jika tidak ingin mengubah)</span>' : '<span class="text-red-500">*</span>'; ?></label>
                    <div class="relative group">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 group-focus-within:text-primary transition-colors">lock</span>
                        <input type="password" name="password" <?php echo $item ? '' : 'required'; ?>
                            placeholder="••••••••"
                            class="w-full pl-12 pr-4 py-3.5 bg-white/5 border border-white/10 rounded-xl focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all text-white placeholder-gray-600 hover:border-white/20">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="form-group">
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Role</label>
                        <div class="relative group">
                            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 group-focus-within:text-primary transition-colors">shield_person</span>
                            <select name="role" class="w-full pl-12 pr-4 py-3.5 bg-white/5 border border-white/10 rounded-xl focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all text-white hover:border-white/20 appearance-none cursor-pointer">
                                <option value="admin" <?php echo ($item['role'] ?? '') === 'admin' ? 'selected' : ''; ?> class="bg-surface-dark">👑 Admin (Full Access)</option>
                                <option value="editor" <?php echo ($item['role'] ?? 'editor') === 'editor' ? 'selected' : ''; ?> class="bg-surface-dark">✏️ Editor (Limited)</option>
                            </select>
                            <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 pointer-events-none">expand_more</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Status</label>
                        <label class="flex items-center gap-4 cursor-pointer group p-3.5 bg-white/5 border border-white/10 rounded-xl hover:border-white/20 transition-all">
                            <div class="relative">
                                <input type="checkbox" name="is_active" value="1" <?php echo ($item['is_active'] ?? 1) ? 'checked' : ''; ?>
                                    class="sr-only peer">
                                <div class="w-12 h-7 bg-white/10 rounded-full peer peer-checked:bg-primary transition-all"></div>
                                <div class="absolute left-1 top-1 w-5 h-5 bg-white rounded-full shadow-md transition-all peer-checked:translate-x-5"></div>
                            </div>
                            <div>
                                <span class="text-sm text-white font-medium">Aktif</span>
                                <p class="text-[10px] text-gray-500">User dapat login ke panel</p>
                            </div>
                        </label>
                    </div>
                </div>

                <div class="pt-6 border-t border-white/5 flex flex-col sm:flex-row gap-3">
                    <button type="submit" class="flex-1 py-4 bg-primary text-black font-extrabold rounded-xl hover:shadow-[0_0_30px_rgba(255,178,4,0.3)] hover:scale-[1.02] transition-all flex items-center justify-center gap-2 uppercase tracking-widest text-xs">
                        <span class="material-symbols-outlined">check_circle</span>
                        <?php echo $item ? 'Simpan Perubahan' : 'Tambah User'; ?>
                    </button>
                    <a href="users.php" class="py-4 px-6 bg-white/5 text-gray-400 font-bold rounded-xl hover:bg-white/10 hover:text-white transition-all flex items-center justify-center gap-2 uppercase tracking-widest text-xs border border-white/10">
                        <span class="material-symbols-outlined">close</span>
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
<?php endif; ?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>