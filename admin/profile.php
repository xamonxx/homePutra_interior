<?php

/**
 * User Profile
 * Home Putra Interior CMS
 */

// Include auth FIRST - before any output
require_once __DIR__ . '/includes/auth.php';

$db = getDB();
$user = getCurrentUser();

// Handle form submission BEFORE any output
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $csrf = $_POST['csrf_token'] ?? '';
    if (!verifyCSRFToken($csrf)) {
        setFlash('error', 'Token keamanan tidak valid');
        header('Location: profile.php');
        exit;
    }

    $data = [
        'full_name' => trim($_POST['full_name'] ?? ''),
        'email' => trim($_POST['email'] ?? ''),
        'id' => $_SESSION['admin_id'],
    ];

    try {
        // Update profile
        $sql = "UPDATE admin_users SET full_name = :full_name, email = :email";

        // Change password if provided
        if (!empty($_POST['new_password'])) {
            // Verify current password
            if (!password_verify($_POST['current_password'], $user['password'])) {
                setFlash('error', 'Password saat ini salah');
                header('Location: profile.php');
                exit;
            }

            if ($_POST['new_password'] !== $_POST['confirm_password']) {
                setFlash('error', 'Password baru tidak cocok');
                header('Location: profile.php');
                exit;
            }

            $data['password'] = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
            $sql .= ", password = :password";
        }

        $sql .= " WHERE id = :id";

        $stmt = $db->prepare($sql);
        $stmt->execute($data);

        // Update session
        $_SESSION['admin_name'] = $data['full_name'];

        setFlash('success', 'Profil berhasil diperbarui');
    } catch (PDOException $e) {
        setFlash('error', 'Gagal menyimpan: ' . $e->getMessage());
    }

    header('Location: profile.php');
    exit;
}

$csrfToken = generateCSRFToken();

// NOW include header - after all redirects are done
$pageTitle = 'Profil Saya';
require_once __DIR__ . '/includes/header.php';
?>

<div class="max-w-lg mx-auto space-y-4 lg:space-y-6">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 lg:p-6">
        <div class="flex items-center gap-3 lg:gap-4 mb-4 lg:mb-6">
            <div class="w-14 h-14 lg:w-16 lg:h-16 rounded-full bg-primary/20 flex items-center justify-center text-primary font-bold text-xl lg:text-2xl">
                <?php echo strtoupper(substr($user['full_name'] ?: $user['username'], 0, 1)); ?>
            </div>
            <div>
                <h2 class="text-lg lg:text-xl font-semibold text-gray-800"><?php echo e($user['full_name'] ?: $user['username']); ?></h2>
                <p class="text-gray-500 text-sm"><?php echo ucfirst($user['role']); ?></p>
            </div>
        </div>

        <form method="POST" class="space-y-4 lg:space-y-6">
            <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Username</label>
                <input type="text" value="<?php echo e($user['username']); ?>" disabled
                    class="w-full px-3 lg:px-4 py-2 border border-gray-200 rounded-lg bg-gray-50 text-gray-500 text-sm lg:text-base">
                <p class="text-xs text-gray-500 mt-1">Username tidak dapat diubah</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                <input type="text" name="full_name" value="<?php echo e($user['full_name']); ?>"
                    class="w-full px-3 lg:px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary text-sm lg:text-base">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                <input type="email" name="email" value="<?php echo e($user['email']); ?>"
                    class="w-full px-3 lg:px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary text-sm lg:text-base">
            </div>

            <div class="pt-4 border-t">
                <button type="submit" class="w-full sm:w-auto px-6 py-2 bg-primary text-dark font-medium rounded-lg hover:bg-primary-dark transition-colors text-sm lg:text-base">
                    Simpan Profil
                </button>
            </div>
        </form>
    </div>

    <!-- Change Password -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 lg:p-6">
        <h3 class="text-base lg:text-lg font-semibold text-gray-800 mb-4 lg:mb-6">Ubah Password</h3>

        <form method="POST" class="space-y-4 lg:space-y-6">
            <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
            <input type="hidden" name="full_name" value="<?php echo e($user['full_name']); ?>">
            <input type="hidden" name="email" value="<?php echo e($user['email']); ?>">

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Password Saat Ini</label>
                <input type="password" name="current_password"
                    class="w-full px-3 lg:px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary text-sm lg:text-base">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Password Baru</label>
                <input type="password" name="new_password"
                    class="w-full px-3 lg:px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary text-sm lg:text-base">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Password Baru</label>
                <input type="password" name="confirm_password"
                    class="w-full px-3 lg:px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary text-sm lg:text-base">
            </div>

            <div class="pt-4 border-t">
                <button type="submit" class="w-full sm:w-auto px-6 py-2 bg-gray-800 text-white font-medium rounded-lg hover:bg-gray-900 transition-colors text-sm lg:text-base">
                    Ubah Password
                </button>
            </div>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>