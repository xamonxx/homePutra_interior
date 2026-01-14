            </main>

            <!-- Footer -->
            <footer class="px-4 lg:px-6 py-4 text-center text-xs lg:text-sm text-gray-500 border-t bg-white">
                © <?php echo date('Y'); ?> Home Putra Interior. Admin Panel v1.0
            </footer>
            </div>
            </div>

            <!-- Alpine.js for interactivity -->
            <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

            <!-- Custom Scripts -->
            <script>
                // Toggle sidebar
                function toggleSidebar() {
                    const sidebar = document.getElementById('admin-sidebar');
                    const overlay = document.getElementById('sidebar-overlay');

                    sidebar.classList.toggle('sidebar-closed');
                    overlay.classList.toggle('hidden');

                    // Prevent body scroll when sidebar is open on mobile
                    if (!sidebar.classList.contains('sidebar-closed')) {
                        document.body.style.overflow = 'hidden';
                    } else {
                        document.body.style.overflow = '';
                    }
                }

                // Close sidebar when clicking a link (mobile)
                document.querySelectorAll('#admin-sidebar a').forEach(link => {
                    link.addEventListener('click', () => {
                        if (window.innerWidth < 1024) {
                            toggleSidebar();
                        }
                    });
                });

                // Close sidebar on window resize if open
                window.addEventListener('resize', () => {
                    if (window.innerWidth >= 1024) {
                        document.getElementById('sidebar-overlay').classList.add('hidden');
                        document.body.style.overflow = '';
                    }
                });

                // Confirm delete
                function confirmDelete(message = 'Apakah Anda yakin ingin menghapus item ini?') {
                    return confirm(message);
                }

                // Image preview
                function previewImage(input, previewId) {
                    const preview = document.getElementById(previewId);
                    if (input.files && input.files[0]) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            preview.src = e.target.result;
                            preview.classList.remove('hidden');
                        }
                        reader.readAsDataURL(input.files[0]);
                    }
                }

                // Auto-hide alerts after 5 seconds
                document.querySelectorAll('[role="alert"]').forEach(alert => {
                    setTimeout(() => {
                        alert.style.opacity = '0';
                        setTimeout(() => alert.remove(), 300);
                    }, 5000);
                });
            </script>
            </body>

            </html>