<?php
// This file should only be included AFTER all redirects are done
// requireLogin() is called here to ensure user is authenticated
requireLogin();

$currentPage = basename($_SERVER['PHP_SELF'], '.php');
$flash = getFlash();
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? $pageTitle . ' - ' : ''; ?>Admin Panel | Home Putra Interior</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght@300" rel="stylesheet">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#ffb204',
                        'primary-dark': '#e6a000',
                        dark: '#1A1A1A',
                        'dark-lighter': '#252525',
                        'dark-light': '#333333',
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                }
            }
        }
    </script>

    <style>
        .sidebar-link.active {
            background: rgba(255, 178, 4, 0.1);
            border-left: 3px solid #ffb204;
            color: #ffb204;
        }

        .sidebar-link:hover:not(.active) {
            background: rgba(255, 255, 255, 0.05);
        }

        /* Sidebar transitions */
        #admin-sidebar {
            transition: transform 0.3s ease, width 0.3s ease;
        }

        #admin-sidebar.sidebar-closed {
            transform: translateX(-100%);
        }

        /* Tablet: Mini sidebar (icons only) */
        @media (min-width: 768px) and (max-width: 1023px) {
            #admin-sidebar {
                width: 72px;
                transform: translateX(0) !important;
            }

            #admin-sidebar .sidebar-text,
            #admin-sidebar .sidebar-heading,
            #admin-sidebar .sidebar-footer-link span,
            #admin-sidebar .logo-text {
                display: none;
            }

            #admin-sidebar .sidebar-link {
                justify-content: center;
                padding-left: 0;
                padding-right: 0;
            }

            #admin-sidebar .logo-section {
                justify-content: center;
                padding-left: 0;
                padding-right: 0;
            }

            #admin-sidebar .sidebar-footer-link {
                justify-content: center;
            }

            .main-content {
                margin-left: 72px !important;
            }
        }

        /* Desktop: Full sidebar */
        @media (min-width: 1024px) {
            #admin-sidebar {
                transform: translateX(0) !important;
                width: 256px;
            }

            .main-content {
                margin-left: 256px !important;
            }
        }

        /* Mobile: No margin */
        @media (max-width: 767px) {
            .main-content {
                margin-left: 0 !important;
            }
        }

        /* Overlay */
        #sidebar-overlay {
            transition: opacity 0.3s ease;
        }

        #sidebar-overlay.hidden {
            opacity: 0;
            pointer-events: none;
        }

        /* Scrollbar for sidebar */
        #admin-sidebar::-webkit-scrollbar {
            width: 4px;
        }

        #admin-sidebar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 2px;
        }

        /* Tooltip for mini sidebar on tablet */
        @media (min-width: 768px) and (max-width: 1023px) {
            .sidebar-link {
                position: relative;
            }

            .sidebar-link:hover::after {
                content: attr(data-tooltip);
                position: absolute;
                left: 100%;
                top: 50%;
                transform: translateY(-50%);
                background: #333;
                color: white;
                padding: 6px 12px;
                border-radius: 6px;
                font-size: 12px;
                white-space: nowrap;
                margin-left: 8px;
                z-index: 100;
            }
        }
    </style>
</head>

<body class="bg-gray-100 font-sans">
    <div class="flex min-h-screen">

        <!-- Sidebar Overlay (Mobile only) -->
        <div id="sidebar-overlay" class="fixed inset-0 bg-black/50 z-40 md:hidden hidden" onclick="toggleSidebar()"></div>

        <!-- Sidebar -->
        <aside id="admin-sidebar" class="w-64 bg-dark text-white fixed h-full z-50 overflow-y-auto sidebar-closed md:translate-x-0">
            <!-- Logo -->
            <div class="logo-section h-16 flex items-center justify-between px-4 border-b border-white/10 sticky top-0 bg-dark z-10">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">other_houses</span>
                    <span class="logo-text font-bold text-lg">Home Putra <span class="text-primary">CMS</span></span>
                </div>
                <!-- Close button (Mobile only) -->
                <button onclick="toggleSidebar()" class="md:hidden text-gray-400 hover:text-white p-1">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>

            <!-- Navigation -->
            <nav class="py-4 pb-20">
                <div class="sidebar-heading px-4 mb-2 text-xs font-semibold text-gray-500 uppercase tracking-wider">Menu Utama</div>

                <a href="index.php" data-tooltip="Dashboard" class="sidebar-link flex items-center gap-3 px-4 py-3 text-gray-300 transition-colors <?php echo $currentPage === 'index' ? 'active' : ''; ?>">
                    <span class="material-symbols-outlined text-xl">dashboard</span>
                    <span class="sidebar-text">Dashboard</span>
                </a>

                <a href="hero.php" data-tooltip="Hero Section" class="sidebar-link flex items-center gap-3 px-4 py-3 text-gray-300 transition-colors <?php echo $currentPage === 'hero' ? 'active' : ''; ?>">
                    <span class="material-symbols-outlined text-xl">home</span>
                    <span class="sidebar-text">Hero Section</span>
                </a>

                <a href="portfolio.php" data-tooltip="Portfolio" class="sidebar-link flex items-center gap-3 px-4 py-3 text-gray-300 transition-colors <?php echo $currentPage === 'portfolio' ? 'active' : ''; ?>">
                    <span class="material-symbols-outlined text-xl">photo_library</span>
                    <span class="sidebar-text">Portfolio</span>
                </a>

                <a href="services.php" data-tooltip="Layanan" class="sidebar-link flex items-center gap-3 px-4 py-3 text-gray-300 transition-colors <?php echo $currentPage === 'services' ? 'active' : ''; ?>">
                    <span class="material-symbols-outlined text-xl">design_services</span>
                    <span class="sidebar-text">Layanan</span>
                </a>

                <a href="testimonials.php" data-tooltip="Testimoni" class="sidebar-link flex items-center gap-3 px-4 py-3 text-gray-300 transition-colors <?php echo $currentPage === 'testimonials' ? 'active' : ''; ?>">
                    <span class="material-symbols-outlined text-xl">rate_review</span>
                    <span class="sidebar-text">Testimoni</span>
                </a>

                <a href="statistics.php" data-tooltip="Statistik" class="sidebar-link flex items-center gap-3 px-4 py-3 text-gray-300 transition-colors <?php echo $currentPage === 'statistics' ? 'active' : ''; ?>">
                    <span class="material-symbols-outlined text-xl">analytics</span>
                    <span class="sidebar-text">Statistik</span>
                </a>

                <div class="sidebar-heading px-4 mt-6 mb-2 text-xs font-semibold text-gray-500 uppercase tracking-wider">Pengelolaan</div>

                <a href="contacts.php" data-tooltip="Pesan Masuk" class="sidebar-link flex items-center gap-3 px-4 py-3 text-gray-300 transition-colors <?php echo $currentPage === 'contacts' ? 'active' : ''; ?>">
                    <span class="material-symbols-outlined text-xl">mail</span>
                    <span class="sidebar-text">Pesan Masuk</span>
                </a>

                <a href="settings.php" data-tooltip="Pengaturan" class="sidebar-link flex items-center gap-3 px-4 py-3 text-gray-300 transition-colors <?php echo $currentPage === 'settings' ? 'active' : ''; ?>">
                    <span class="material-symbols-outlined text-xl">settings</span>
                    <span class="sidebar-text">Pengaturan</span>
                </a>

                <?php if (isAdmin()): ?>
                    <a href="users.php" data-tooltip="Pengguna" class="sidebar-link flex items-center gap-3 px-4 py-3 text-gray-300 transition-colors <?php echo $currentPage === 'users' ? 'active' : ''; ?>">
                        <span class="material-symbols-outlined text-xl">group</span>
                        <span class="sidebar-text">Pengguna</span>
                    </a>
                <?php endif; ?>

                <!-- View Website Link -->
                <div class="mt-6 px-4">
                    <a href="../" target="_blank" class="sidebar-footer-link flex items-center gap-2 text-sm text-gray-400 hover:text-primary transition-colors py-3 border-t border-white/10">
                        <span class="material-symbols-outlined text-lg">open_in_new</span>
                        <span>Lihat Website</span>
                    </a>
                </div>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="main-content flex-1 min-h-screen flex flex-col">
            <!-- Top Bar -->
            <header class="h-14 md:h-16 bg-white shadow-sm flex items-center justify-between px-3 md:px-4 lg:px-6 sticky top-0 z-30">
                <div class="flex items-center gap-2 md:gap-3">
                    <!-- Mobile Menu Button -->
                    <button onclick="toggleSidebar()" class="md:hidden text-gray-600 hover:text-gray-800 p-2 -ml-2">
                        <span class="material-symbols-outlined">menu</span>
                    </button>
                    <h1 class="text-base md:text-lg lg:text-xl font-semibold text-gray-800 truncate"><?php echo $pageTitle ?? 'Dashboard'; ?></h1>
                </div>

                <div class="flex items-center gap-2 md:gap-3 lg:gap-4">
                    <!-- User Dropdown -->
                    <div class="relative group">
                        <button class="flex items-center gap-1.5 md:gap-2 py-1.5 md:py-2 px-2 md:px-3 rounded-lg hover:bg-gray-100 transition-colors">
                            <div class="w-7 h-7 md:w-8 md:h-8 rounded-full bg-primary/20 flex items-center justify-center text-primary font-semibold text-xs md:text-sm">
                                <?php echo strtoupper(substr($_SESSION['admin_name'] ?? 'A', 0, 1)); ?>
                            </div>
                            <span class="text-sm font-medium text-gray-700 hidden md:block max-w-[100px] lg:max-w-none truncate"><?php echo e($_SESSION['admin_name'] ?? 'Admin'); ?></span>
                            <span class="material-symbols-outlined text-gray-400 text-base md:text-lg hidden md:block">expand_more</span>
                        </button>

                        <div class="absolute right-0 top-full mt-1 w-48 bg-white rounded-lg shadow-lg border opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all z-50">
                            <div class="px-4 py-3 border-b md:hidden">
                                <p class="text-sm font-medium text-gray-800"><?php echo e($_SESSION['admin_name'] ?? 'Admin'); ?></p>
                                <p class="text-xs text-gray-500"><?php echo e($_SESSION['admin_username'] ?? ''); ?></p>
                            </div>
                            <a href="profile.php" class="flex items-center gap-2 px-4 py-3 text-sm text-gray-600 hover:bg-gray-50">
                                <span class="material-symbols-outlined text-lg">person</span>
                                Profil Saya
                            </a>
                            <hr class="border-gray-100">
                            <a href="logout.php" class="flex items-center gap-2 px-4 py-3 text-sm text-red-600 hover:bg-red-50">
                                <span class="material-symbols-outlined text-lg">logout</span>
                                Keluar
                            </a>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 p-3 md:p-4 lg:p-6">
                <?php if ($flash): ?>
                    <div class="mb-3 md:mb-4 lg:mb-6 p-3 md:p-4 rounded-lg <?php echo $flash['type'] === 'success' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'; ?> text-xs md:text-sm lg:text-base">
                        <?php echo e($flash['message']); ?>
                    </div>
                <?php endif; ?>