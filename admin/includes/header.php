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

    <!-- CSS (Local) -->
    <link href="<?php echo SITE_URL; ?>/assets/css/material-symbols.css" rel="stylesheet">

    <!-- Tailwind CSS (Local) -->
    <script src="<?php echo SITE_URL; ?>/assets/js/tailwind.min.js"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: '#ffb204',
                        'primary-hover': '#e6a000',
                        'background-dark': '#0B0D11',
                        'surface-dark': '#161B22',
                        'dark-lighter': '#1A1D23',
                        'dark-light': '#2D333B',
                    },
                    fontFamily: {
                        sans: ['ui-sans-serif', 'system-ui', '-apple-system', 'BlinkMacSystemFont', '"Segoe UI"', 'Roboto', '"Helvetica Neue"', 'Arial', 'sans-serif'],
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
            background: rgba(255, 178, 4, 0.05);
            color: white;
        }

        .sidebar-link:hover:not(.active) span:first-child {
            color: #ffb204;
        }

        /* Sidebar transitions */
        #admin-sidebar {
            transition: transform 0.3s ease, width 0.3s ease;
        }

        /* Overlay */
        #sidebar-overlay {
            transition: opacity 0.3s ease;
        }

        #sidebar-overlay.hidden {
            opacity: 0 !important;
            pointer-events: none !important;
        }

        /* Scrollbar for sidebar */
        #admin-sidebar::-webkit-scrollbar {
            width: 4px;
        }

        #admin-sidebar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 2px;
        }

        /* Admin Theme Overrides */
        body {
            background-color: #0B0D11 !important;
            color: #9ca3af !important;
        }

        .bg-white {
            background-color: #161B22 !important;
        }

        .bg-gray-50 {
            background-color: rgba(255, 255, 255, 0.02) !important;
        }

        .bg-gray-100 {
            background-color: #0B0D11 !important;
        }

        .text-gray-800,
        .text-gray-900 {
            color: #ffffff !important;
        }

        .text-gray-700 {
            color: #d1d5db !important;
        }

        .text-gray-600 {
            color: #9ca3af !important;
        }

        .border-gray-100,
        .border-gray-200 {
            border-color: rgba(255, 255, 255, 0.05) !important;
        }

        .shadow-sm,
        .shadow-md,
        .shadow-lg {
            box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.5) !important;
        }

        /* --- Luxury Button Overrides --- */
        .bg-primary {
            background: linear-gradient(135deg, #ffb204, #e6a000) !important;
            color: #000000 !important;
            font-weight: 600 !important;
            box-shadow: 0 4px 12px rgba(255, 178, 4, 0.2) !important;
        }

        .bg-primary:hover {
            background: linear-gradient(135deg, #ffc84d, #ffb204) !important;
            box-shadow: 0 6px 20px rgba(255, 178, 4, 0.4) !important;
            transform: translateY(-1px);
        }

        /* Custom File Upload UI */
        .file-upload-wrapper {
            position: relative;
            border: 2px dashed rgba(255, 255, 255, 0.1);
            border-radius: 0.75rem;
            padding: 1.5rem;
            text-align: center;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.02);
        }

        /* Quill Dark Theme Overrides */
        .ql-toolbar.ql-snow {
            background: #1A1D23 !important;
            border-color: rgba(255, 255, 255, 0.1) !important;
            border-top-left-radius: 0.5rem;
            border-top-right-radius: 0.5rem;
        }

        .ql-container.ql-snow {
            background: rgba(255, 255, 255, 0.03) !important;
            border-color: rgba(255, 255, 255, 0.1) !important;
            color: #d1d5db !important;
            border-bottom-left-radius: 0.5rem;
            border-bottom-right-radius: 0.5rem;
            min-height: 150px;
            font-family: inherit;
        }

        .ql-snow .ql-stroke {
            stroke: #9ca3af !important;
        }

        .ql-snow .ql-fill {
            fill: #9ca3af !important;
        }

        .ql-snow.ql-toolbar button:hover .ql-stroke,
        .ql-snow.ql-toolbar button.ql-active .ql-stroke {
            stroke: #ffb204 !important;
        }

        /* Preview Card Text Auto-Wrap */
        [id^="preview_"],
        .preview-text,
        .line-clamp-2,
        .line-clamp-3,
        .line-clamp-4 {
            white-space: normal !important;
            word-wrap: break-word !important;
            overflow-wrap: break-word !important;
            -webkit-line-clamp: unset !important;
            line-clamp: unset !important;
            display: block !important;
        }

        /* Textarea auto-expand */
        textarea {
            resize: vertical;
            min-height: 100px;
        }
    </style>
</head>

<body class="bg-background-dark text-gray-300 font-sans">
    <!-- Sidebar Overlay (Mobile only) -->
    <div id="sidebar-overlay" class="fixed inset-0 bg-black/50 z-[60] hidden" onclick="toggleSidebar()"></div>

    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside id="admin-sidebar" class="w-64 bg-surface-dark text-white fixed lg:static h-full z-[70] overflow-y-auto -translate-x-full lg:translate-x-0 transition-transform duration-300 border-r border-white/5 shadow-2xl">
            <!-- Logo Section -->
            <div class="h-16 flex items-center justify-between px-4 border-b border-white/5 sticky top-0 bg-surface-dark z-10">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">other_houses</span>
                    <span class="logo-text font-bold text-lg">Home Putra <span class="text-primary">CMS</span></span>
                </div>
                <button onclick="toggleSidebar()" class="lg:hidden text-gray-400 hover:text-white p-1">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>

            <!-- Navigation -->
            <nav class="py-4">
                <div class="sidebar-heading px-4 mb-2 text-[10px] font-bold text-gray-500 uppercase tracking-widest">Menu Utama</div>

                <a href="index.php" class="sidebar-link flex items-center gap-3 px-4 py-3 text-gray-300 transition-colors <?php echo $currentPage === 'index' ? 'active' : ''; ?>">
                    <span class="material-symbols-outlined text-xl">dashboard</span>
                    <span class="sidebar-text text-sm font-medium">Dashboard</span>
                </a>

                <a href="hero.php" class="sidebar-link flex items-center gap-3 px-4 py-3 text-gray-300 transition-colors <?php echo $currentPage === 'hero' ? 'active' : ''; ?>">
                    <span class="material-symbols-outlined text-xl">home</span>
                    <span class="sidebar-text text-sm font-medium">Hero Section</span>
                </a>

                <a href="portfolio.php" class="sidebar-link flex items-center gap-3 px-4 py-3 text-gray-300 transition-colors <?php echo $currentPage === 'portfolio' ? 'active' : ''; ?>">
                    <span class="material-symbols-outlined text-xl">photo_library</span>
                    <span class="sidebar-text text-sm font-medium">Portfolio</span>
                </a>

                <a href="services.php" class="sidebar-link flex items-center gap-3 px-4 py-3 text-gray-300 transition-colors <?php echo $currentPage === 'services' ? 'active' : ''; ?>">
                    <span class="material-symbols-outlined text-xl">design_services</span>
                    <span class="sidebar-text text-sm font-medium">Layanan</span>
                </a>

                <a href="testimonials.php" class="sidebar-link flex items-center gap-3 px-4 py-3 text-gray-300 transition-colors <?php echo $currentPage === 'testimonials' ? 'active' : ''; ?>">
                    <span class="material-symbols-outlined text-xl">rate_review</span>
                    <span class="sidebar-text text-sm font-medium">Testimoni</span>
                </a>

                <a href="statistics.php" class="sidebar-link flex items-center gap-3 px-4 py-3 text-gray-300 transition-colors <?php echo $currentPage === 'statistics' ? 'active' : ''; ?>">
                    <span class="material-symbols-outlined text-xl">analytics</span>
                    <span class="sidebar-text text-sm font-medium">Statistik</span>
                </a>

                <div class="mt-8 px-4">
                    <a href="../" target="_blank" class="flex items-center gap-3 px-4 py-3 text-[10px] text-gray-400 hover:text-primary transition-colors border-t border-white/5 uppercase tracking-widest font-bold">
                        <span class="material-symbols-outlined text-lg">open_in_new</span>
                        <span>Lihat Website</span>
                    </a>
                </div>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
            <!-- Top Header -->
            <header class="h-16 bg-surface-dark border-b border-white/5 flex items-center justify-between px-4 lg:px-8 sticky top-0 z-30 shadow-sm flex-shrink-0">
                <div class="flex items-center gap-4">
                    <button onclick="toggleSidebar()" class="lg:hidden text-gray-400 hover:text-white p-1">
                        <span class="material-symbols-outlined">menu</span>
                    </button>
                    <h1 class="text-xs font-bold text-white uppercase tracking-widest hidden sm:block">
                        <?php echo $pageTitle ?? 'Dashboard'; ?>
                    </h1>
                </div>

                <div class="flex items-center gap-4">
                    <!-- User Profile -->
                    <div class="relative group">
                        <button class="flex items-center gap-2 py-1.5 px-2 rounded-lg hover:bg-white/5 transition-colors">
                            <div class="w-8 h-8 rounded-full bg-primary/20 flex items-center justify-center text-primary font-bold text-xs">
                                <?php echo strtoupper(substr($_SESSION['admin_name'] ?? 'A', 0, 1)); ?>
                            </div>
                            <span class="material-symbols-outlined text-gray-500 text-lg">expand_more</span>
                        </button>
                        <div class="absolute right-0 top-full mt-2 w-48 bg-surface-dark rounded-xl shadow-2xl border border-white/5 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all z-50 overflow-hidden">
                            <a href="logout.php" class="flex items-center gap-2 px-4 py-3 text-xs text-red-400 hover:bg-red-400/10 transition-colors">
                                <span class="material-symbols-outlined text-lg">logout</span>
                                <span>Keluar</span>
                            </a>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Scrollable Content -->
            <main class="flex-1 p-4 lg:p-8 overflow-y-auto">
                <?php if ($flash): ?>
                    <div class="mb-6 p-4 rounded-xl border <?php echo $flash['type'] === 'success' ? 'bg-green-500/10 border-green-500/20 text-green-500' : 'bg-red-500/10 border-red-500/20 text-red-500'; ?> flex items-center gap-3">
                        <span class="material-symbols-outlined"><?php echo $flash['type'] === 'success' ? 'check_circle' : 'error'; ?></span>
                        <p class="text-xs font-bold uppercase tracking-wide"><?php echo e($flash['message']); ?></p>
                    </div>
                <?php endif; ?>