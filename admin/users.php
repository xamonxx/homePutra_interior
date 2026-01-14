<?php

/**
 * User Management (Admin Only)
 * Home Putra Interior CMS
 */

// Include auth FIRST - before any output
require_once __DIR__ . '/includes/auth.php';

// Check if admin
if (!isAdmin()) {
    setFlash('error', 'Anda tidak memiliki akses ke halaman ini');
    header('Location: index.php');
    exit;
}

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

        try {
            if (!empty($_POST['id'])) {
                // Update user
                $sql = "UPDATE admin_users SET username = :username, full_name = :full_name, 
                        email = :email, role = :role, is_active = :is_active";

                // Update password if provided
                if (!empty($_POST['password'])) {
                    $data['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
                    $sql .= ", password = :password";
                }

                $sql .= " WHERE id = :id";
                $data['id'] = $_POST['id'];

                $stmt = $db->prepare($sql);
                $stmt->execute($data);
                setFlash('success', 'Pengguna berhasil diperbarui');
            } else {
                // Create new user
                if (empty($_POST['password'])) {
                    setFlash('error', 'Password wajib diisi untuk pengguna baru');
                    header('Location: users.php?action=add');
                    exit;
                }

                $data['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
                $stmt = $db->prepare("INSERT INTO admin_users (username, password, full_name, email, role, is_active) 
                                      VALUES (:username, :password, :full_name, :email, :role, :is_active)");
                $stmt->execute($data);
                setFlash('success', 'Pengguna berhasil ditambahkan');
            }
        } catch (PDOException $e) {
            if (strpos($e->getMessage(), 'Duplicate entry') !== false) {
                setFlash('error', 'Username sudah digunakan');
            } else {
                setFlash('error', 'Gagal menyimpan: ' . $e->getMessage());
            }
        }

        header('Location: users.php');
        exit;
    }

    if ($postAction === 'delete' && !empty($_POST['id'])) {
        // Prevent self-delete
        if ($_POST['id'] == $_SESSION['admin_id']) {
            setFlash('error', 'Anda tidak dapat menghapus akun Anda sendiri');
        } else {
            try {
                $stmt = $db->prepare("DELETE FROM admin_users WHERE id = :id");
                $stmt->execute(['id' => $_POST['id']]);
                setFlash('success', 'Pengguna berhasil dihapus');
            } catch (PDOException $e) {
                setFlash('error', 'Gagal menghapus');
            }
        }
        header('Location: users.php');
        exit;
    }
}

// Get data for edit
$item = null;
if ($action === 'edit' && $id) {
    $stmt = $db->prepare("SELECT * FROM admin_users WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $item = $stmt->fetch();
}

// Get all items for list
$items = [];
if ($action === 'list') {
    $stmt = $db->query("SELECT * FROM admin_users ORDER BY created_at DESC");
    $items = $stmt->fetchAll();
}

$csrfToken = generateCSRFToken();

// NOW include header - after all redirects are done
$pageTitle = 'Pengguna';
require_once __DIR__ . '/includes/header.php';
?>

<?php if ($action === 'list'): ?>
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="p-4 lg:p-6 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <h2 class="text-base lg:text-lg font-semibold text-gray-800">Daftar Pengguna</h2>
            <a href="?action=add" class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-primary text-dark font-medium rounded-lg hover:bg-primary-dark transition-colors text-sm">
                <span class="material-symbols-outlined text-lg">person_add</span>
                <span>Tambah</span>
            </a>
        </div>

        <!-- Mobile Card View -->
        <div class="lg:hidden divide-y divide-gray-100">
            <?php foreach ($items as $row): ?>
                <div class="p-4">
                    <div class="flex gap-3">
                        <div class="w-10 h-10 rounded-full bg-primary/20 flex items-center justify-center text-primary font-semibold flex-shrink-0">
                            <?php echo strtoupper(substr($row['full_name'] ?: $row['username'], 0, 1)); ?>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-medium text-gray-800"><?php echo e($row['full_name'] ?: $row['username']); ?></p>
                            <p class="text-xs text-gray-500 truncate"><?php echo e($row['email']); ?></p>
                            <div class="flex items-center gap-2 mt-2">
                                <span class="px-2 py-0.5 rounded-full text-xs font-medium <?php echo $row['role'] === 'admin' ? 'bg-purple-100 text-purple-700' : 'bg-blue-100 text-blue-700'; ?>">
                                    <?php echo ucfirst($row['role']); ?>
                                </span>
                                <span class="px-2 py-0.5 rounded-full text-xs font-medium <?php echo $row['is_active'] ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600'; ?>">
                                    <?php echo $row['is_active'] ? 'Aktif' : 'Nonaktif'; ?>
                                </span>
                            </div>
                        </div>
                    </div>
                    <?php if ($row['id'] != $_SESSION['admin_id']): ?>
                        <div class="flex gap-3 mt-3 pt-3 border-t">
                            <a href="?action=edit&id=<?php echo $row['id']; ?>" class="flex-1 text-center py-2 text-sm text-blue-600 bg-blue-50 rounded-lg">Edit</a>
                            <form method="POST" class="flex-1" onsubmit="return confirmDelete('Hapus pengguna ini?')">
                                <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                <button type="submit" class="w-full py-2 text-sm text-red-600 bg-red-50 rounded-lg">Hapus</button>
                            </form>
                        </div>
                    <?php else: ?>
                        <div class="flex gap-3 mt-3 pt-3 border-t">
                            <a href="?action=edit&id=<?php echo $row['id']; ?>" class="flex-1 text-center py-2 text-sm text-blue-600 bg-blue-50 rounded-lg">Edit Profil</a>
                            <span class="flex-1 text-center py-2 text-sm text-gray-400">(Akun Anda)</span>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Desktop Table View -->
        <div class="hidden lg:block overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Pengguna</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Username</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Role</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Login Terakhir</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php foreach ($items as $row): ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-primary/20 flex items-center justify-center text-primary font-semibold">
                                        <?php echo strtoupper(substr($row['full_name'] ?: $row['username'], 0, 1)); ?>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-800"><?php echo e($row['full_name'] ?: '-'); ?></p>
                                        <p class="text-sm text-gray-500"><?php echo e($row['email']); ?></p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-gray-600"><?php echo e($row['username']); ?></td>
                            <td class="px-6 py-4">
                                <span class="inline-block px-2 py-1 rounded-full text-xs font-medium <?php echo $row['role'] === 'admin' ? 'bg-purple-100 text-purple-700' : 'bg-blue-100 text-blue-700'; ?>">
                                    <?php echo ucfirst($row['role']); ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 text-gray-600 text-sm">
                                <?php echo $row['last_login'] ? date('d M Y H:i', strtotime($row['last_login'])) : 'Belum pernah'; ?>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-block px-2 py-1 rounded-full text-xs font-medium <?php echo $row['is_active'] ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600'; ?>">
                                    <?php echo $row['is_active'] ? 'Aktif' : 'Nonaktif'; ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="?action=edit&id=<?php echo $row['id']; ?>" class="text-blue-600 hover:underline mr-3">Edit</a>
                                <?php if ($row['id'] != $_SESSION['admin_id']): ?>
                                    <form method="POST" class="inline" onsubmit="return confirmDelete('Hapus pengguna ini?')">
                                        <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                        <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                                    </form>
                                <?php else: ?>
                                    <span class="text-gray-400">(Anda)</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

<?php else: ?>
    <div class="max-w-lg mx-auto">
        <div class="mb-4 lg:mb-6">
            <a href="users.php" class="text-gray-600 hover:text-gray-800 flex items-center gap-1 text-sm">
                <span class="material-symbols-outlined text-lg">arrow_back</span>
                Kembali
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 lg:p-6">
            <h2 class="text-base lg:text-lg font-semibold text-gray-800 mb-4 lg:mb-6"><?php echo $item ? 'Edit' : 'Tambah'; ?> Pengguna</h2>

            <form method="POST" class="space-y-4 lg:space-y-6">
                <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
                <input type="hidden" name="action" value="save">
                <?php if ($item): ?>
                    <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
                <?php endif; ?>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Username <span class="text-red-500">*</span></label>
                    <input type="text" name="username" value="<?php echo e($item['username'] ?? ''); ?>" required
                        class="w-full px-3 lg:px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary text-sm lg:text-base">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Password <?php echo $item ? '' : '<span class="text-red-500">*</span>'; ?>
                    </label>
                    <input type="password" name="password" <?php echo $item ? '' : 'required'; ?>
                        class="w-full px-3 lg:px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary text-sm lg:text-base">
                    <?php if ($item): ?>
                        <p class="text-xs text-gray-500 mt-1">Kosongkan jika tidak ingin mengubah</p>
                    <?php endif; ?>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                    <input type="text" name="full_name" value="<?php echo e($item['full_name'] ?? ''); ?>"
                        class="w-full px-3 lg:px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary text-sm lg:text-base">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <input type="email" name="email" value="<?php echo e($item['email'] ?? ''); ?>"
                        class="w-full px-3 lg:px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary text-sm lg:text-base">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Role</label>
                    <select name="role" class="w-full px-3 lg:px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary text-sm lg:text-base">
                        <option value="editor" <?php echo ($item['role'] ?? 'editor') === 'editor' ? 'selected' : ''; ?>>Editor</option>
                        <option value="admin" <?php echo ($item['role'] ?? '') === 'admin' ? 'selected' : ''; ?>>Admin</option>
                    </select>
                </div>

                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" <?php echo ($item['is_active'] ?? 1) ? 'checked' : ''; ?>
                        class="w-4 h-4 text-primary rounded focus:ring-primary">
                    <span class="text-sm text-gray-700">Aktif</span>
                </label>

                <div class="pt-4 border-t flex flex-col sm:flex-row gap-3">
                    <button type="submit" class="px-6 py-2 bg-primary text-dark font-medium rounded-lg hover:bg-primary-dark transition-colors text-sm lg:text-base">
                        Simpan
                    </button>
                    <a href="users.php" class="px-6 py-2 bg-gray-100 text-gray-700 font-medium rounded-lg hover:bg-gray-200 transition-colors text-sm lg:text-base text-center">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
<?php endif; ?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>