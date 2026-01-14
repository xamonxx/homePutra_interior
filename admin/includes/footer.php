            </main>

            <!-- Footer -->
            <footer class="p-4 text-center text-[10px] font-bold text-gray-600 border-t border-white/5 bg-surface-dark uppercase tracking-widest mt-auto">
                © <?php echo date('Y'); ?> Home Putra Interior. CMS v2.0
            </footer>
            </div> <!-- End Main Content -->
            </div> <!-- End Flex Container -->

            <script>
                // --- Sidebar ---
                function toggleSidebar() {
                    const sidebar = document.getElementById('admin-sidebar');
                    const overlay = document.getElementById('sidebar-overlay');
                    sidebar.classList.toggle('-translate-x-full');
                    overlay.classList.toggle('hidden');
                }

                // --- Image Preview ---
                window.setupImagePreview = function(inputId, previewContainerId) {
                    const input = document.getElementById(inputId);
                    const container = document.getElementById(previewContainerId);
                    if (!input || !container) return;

                    const previewImg = container.querySelector('img');

                    input.addEventListener('change', function() {
                        const file = this.files[0];
                        if (file) {
                            const reader = new FileReader();
                            reader.onload = function(e) {
                                previewImg.src = e.target.result;
                                container.style.display = 'block';
                            }
                            reader.readAsDataURL(file);
                        }
                    });
                };

                // --- Utility ---
                function confirmDelete(message = 'Apakah Anda yakin ingin menghapus item ini?') {
                    return confirm(message);
                }

                document.querySelectorAll('[role="alert"]').forEach(alert => {
                    setTimeout(() => {
                        alert.style.opacity = '0';
                        setTimeout(() => alert.remove(), 300);
                    }, 5000);
                });

                // Drag and Drop
                document.querySelectorAll('.file-upload-wrapper').forEach(wrapper => {
                    const input = wrapper.querySelector('input[type="file"]');
                    wrapper.addEventListener('dragover', (e) => {
                        e.preventDefault();
                        wrapper.classList.add('dragover');
                    });
                    wrapper.addEventListener('dragleave', () => {
                        wrapper.classList.remove('dragover');
                    });
                    wrapper.addEventListener('drop', (e) => {
                        e.preventDefault();
                        wrapper.classList.remove('dragover');
                        if (e.dataTransfer.files.length) {
                            input.files = e.dataTransfer.files;
                            input.dispatchEvent(new Event('change'));
                        }
                    });
                });
            </script>
            </body>

            </html>