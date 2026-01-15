    <!-- Footer -->
    <footer class="bg-[#0D0D0D] py-16 md:py-24 border-t border-white/5">
        <div class="max-w-[1200px] mx-auto px-6">
            <div class="flex flex-col md:flex-row justify-between items-start gap-12">
                <!-- Brand -->
                <div class="flex flex-col gap-6" data-aos="fade-up">
                    <a href="<?php echo SITE_URL; ?>" class="flex items-center gap-3">
                        <svg class="w-8 h-8 text-primary" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 3L4 9v12h5v-7h6v7h5V9l-8-6z"></path>
                        </svg>
                        <span class="brand-font text-2xl font-bold text-white uppercase tracking-tight">
                            Home Putra <span class="text-primary italic normal-case">Interior</span>
                        </span>
                    </a>
                    <p class="text-gray-500 text-sm max-w-xs font-light leading-relaxed">
                        Menciptakan ruang abadi yang mencerminkan kepribadian dan aspirasi unik klien kami.
                    </p>
                </div>

                <!-- Footer Links -->
                <div class="grid grid-cols-2 lg:grid-cols-3 gap-10 md:gap-16">
                    <div data-aos="fade-up" data-aos-delay="100">
                        <h5 class="text-white text-[10px] uppercase tracking-[0.3em] font-bold mb-6">Jelajahi</h5>
                        <div class="flex flex-col gap-4 text-sm text-gray-500 font-medium">
                            <a class="hover:text-primary transition-colors" href="<?php echo SITE_URL; ?>/#portfolio">Portfolio</a>
                            <a class="hover:text-primary transition-colors" href="<?php echo SITE_URL; ?>/#services">Layanan</a>
                            <a class="hover:text-primary transition-colors" href="<?php echo SITE_URL; ?>/#calculator">Kalkulator</a>
                        </div>
                    </div>
                    <div data-aos="fade-up" data-aos-delay="200">
                        <h5 class="text-white text-[10px] uppercase tracking-[0.3em] font-bold mb-6">Perusahaan</h5>
                        <div class="flex flex-col gap-4 text-sm text-gray-500 font-medium">
                            <a class="hover:text-primary transition-colors" href="<?php echo SITE_URL; ?>/index.php">Tentang</a>
                            <a class="hover:text-primary transition-colors" href="<?php echo SITE_URL; ?>/#testimonials">Testimoni</a>
                            <a class="hover:text-primary transition-colors" href="<?php echo SITE_URL; ?>/#contact">Kontak</a>
                        </div>
                    </div>
                    <div data-aos="fade-up" data-aos-delay="300">
                        <h5 class="text-white text-[10px] uppercase tracking-[0.3em] font-bold mb-6">Hubungi</h5>
                        <div class="flex flex-col gap-4 text-sm text-gray-500 font-medium">
                            <p>Jl. Desain No. 123, Jakarta</p>
                            <p>hello@homeputra.com</p>
                            <p>+62 812 3456 7890</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Copyright -->
            <div class="mt-16 md:mt-20 pt-10 border-t border-white/5 flex flex-col md:flex-row justify-between items-center text-center md:text-left gap-6 md:gap-4">
                <div class="text-[10px] uppercase tracking-widest text-gray-600 font-bold">
                    © <?php echo date('Y'); ?> Home Putra Interior. Hak Cipta Dilindungi.
                </div>
                <div class="flex gap-8 text-[10px] uppercase tracking-widest text-gray-600 font-bold">
                    <a class="hover:text-white transition-colors" href="#">Kebijakan Privasi</a>
                    <a class="hover:text-white transition-colors" href="#">Syarat & Ketentuan</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- WhatsApp Floating Button -->
    <a id="whatsapp-btn" href="https://wa.me/6281234567890" target="_blank" class="fixed bottom-10 right-10 z-50 group">
        <div class="relative w-16 h-16 bg-[#25D366] rounded-full flex items-center justify-center text-white shadow-2xl hover:scale-110 transition-transform">
            <div class="pulse-ring" style="background-color: #25D366;"></div>
            <svg class="relative z-10" fill="currentColor" height="32" viewBox="0 0 16 16" width="32">
                <path d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z" />
            </svg>
        </div>
    </a>

    <!-- Back to Top Button -->
    <button id="back-to-top" class="fixed bottom-10 left-10 z-50 w-12 h-12 bg-surface-dark border border-white/10 rounded-full flex items-center justify-center text-primary hover:bg-primary hover:text-black transition-all opacity-0 pointer-events-none">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
        </svg>
    </button>

    <!-- GSAP -->
    <script src="<?php echo SITE_URL; ?>/assets/js/gsap.min.js"></script>
    <script src="<?php echo SITE_URL; ?>/assets/js/ScrollTrigger.min.js"></script>

    <!-- Main Logic -->
    <script src="<?php echo SITE_URL; ?>/assets/js/main.js"></script>
    </body>

    </html>