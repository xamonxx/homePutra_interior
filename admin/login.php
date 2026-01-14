<?php

/**
 * Admin Login Page
 * Home Putra Interior CMS
 */

// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../config/database.php';

// Simple functions for login page
function e($string)
{
    return htmlspecialchars($string ?? '', ENT_QUOTES, 'UTF-8');
}

function loginUser($username, $password)
{
    try {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM admin_users WHERE username = :username AND is_active = 1");
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['admin_id'] = $user['id'];
            $_SESSION['admin_username'] = $user['username'];
            $_SESSION['admin_name'] = $user['full_name'];
            $_SESSION['admin_role'] = $user['role'];

            // Update last login
            $stmt = $db->prepare("UPDATE admin_users SET last_login = NOW() WHERE id = :id");
            $stmt->execute(['id' => $user['id']]);

            return true;
        }
        return false;
    } catch (PDOException $e) {
        return false;
    }
}

// Redirect if already logged in
if (isset($_SESSION['admin_id']) && !empty($_SESSION['admin_id'])) {
    header('Location: index.php');
    exit;
}

$error = '';

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        $error = 'Silakan masukkan username dan password';
    } elseif (loginUser($username, $password)) {
        header('Location: index.php');
        exit;
    } else {
        $error = 'Username atau password salah';
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Admin Panel | Home Putra Interior</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght@300" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#ffb204',
                        'primary-dark': '#e6a000',
                        dark: '#1A1A1A',
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                }
            }
        }
    </script>
</head>

<body class="min-h-screen bg-dark flex items-center justify-center p-4 font-sans">
    <!-- Background Pattern -->
    <div class="fixed inset-0 opacity-5">
        <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=&quot;60&quot; height=&quot;60&quot; viewBox=&quot;0 0 60 60&quot; xmlns=&quot;http://www.w3.org/2000/svg&quot;%3E%3Cg fill=&quot;none&quot; fill-rule=&quot;evenodd&quot;%3E%3Cg fill=&quot;%23ffffff&quot; fill-opacity=&quot;0.4&quot;%3E%3Cpath d=&quot;M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z&quot;/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
    </div>

    <div class="relative w-full max-w-sm sm:max-w-md">
        <!-- Logo -->
        <div class="text-center mb-6 lg:mb-8">
            <div class="inline-flex items-center justify-center w-14 h-14 lg:w-16 lg:h-16 bg-primary/10 rounded-2xl mb-3 lg:mb-4">
                <span class="material-symbols-outlined text-3xl lg:text-4xl text-primary">other_houses</span>
            </div>
            <h1 class="text-xl lg:text-2xl font-bold text-white">Home Putra <span class="text-primary">CMS</span></h1>
            <p class="text-gray-400 text-xs lg:text-sm mt-1 lg:mt-2">Masuk ke panel administrasi</p>
        </div>

        <!-- Login Card -->
        <div class="bg-white/5 backdrop-blur-xl rounded-2xl p-5 lg:p-8 border border-white/10 shadow-2xl">
            <?php if ($error): ?>
                <div class="mb-4 lg:mb-6 p-3 lg:p-4 bg-red-500/10 border border-red-500/30 rounded-lg text-red-400 text-xs lg:text-sm flex items-center gap-2">
                    <span class="material-symbols-outlined text-base lg:text-lg">error</span>
                    <?php echo e($error); ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="" class="space-y-4 lg:space-y-6">
                <div>
                    <label class="block text-xs lg:text-sm font-medium text-gray-300 mb-1.5 lg:mb-2">Username</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3 lg:left-4 top-1/2 -translate-y-1/2 text-gray-400 text-lg lg:text-xl">person</span>
                        <input
                            type="text"
                            name="username"
                            value="<?php echo e($_POST['username'] ?? ''); ?>"
                            class="w-full pl-10 lg:pl-12 pr-4 py-2.5 lg:py-3 bg-white/5 border border-white/10 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors text-sm lg:text-base"
                            placeholder="Masukkan username"
                            required
                            autofocus>
                    </div>
                </div>

                <div>
                    <label class="block text-xs lg:text-sm font-medium text-gray-300 mb-1.5 lg:mb-2">Password</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3 lg:left-4 top-1/2 -translate-y-1/2 text-gray-400 text-lg lg:text-xl">lock</span>
                        <input
                            type="password"
                            name="password"
                            class="w-full pl-10 lg:pl-12 pr-4 py-2.5 lg:py-3 bg-white/5 border border-white/10 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors text-sm lg:text-base"
                            placeholder="Masukkan password"
                            required>
                    </div>
                </div>

                <button
                    type="submit"
                    class="w-full py-2.5 lg:py-3 bg-primary hover:bg-primary-dark text-dark font-semibold rounded-lg transition-colors flex items-center justify-center gap-2 text-sm lg:text-base">
                    <span class="material-symbols-outlined text-lg lg:text-xl">login</span>
                    Masuk
                </button>
            </form>
        </div>

        <!-- Footer -->
        <p class="text-center text-gray-500 text-xs lg:text-sm mt-6 lg:mt-8">
            © <?php echo date('Y'); ?> Home Putra Interior
        </p>
    </div>
</body>

</html>