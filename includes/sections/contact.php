<!-- Contact Section -->
<section class="py-32 bg-background-dark relative" id="contact">
    <div class="max-w-[1200px] mx-auto px-6">
        <div class="bg-primary/[0.03] rounded-sm p-10 md:p-20 border border-primary/10 relative" data-aos="fade-up">
            <!-- Corner Decoration -->
            <div class="absolute top-0 right-0 w-32 h-32 border-t border-r border-primary/20"></div>

            <div class="grid md:grid-cols-2 gap-20">
                <!-- Left Side - Info -->
                <div data-aos="fade-right" data-aos-delay="100">
                    <h2 class="text-4xl md:text-5xl text-white mb-8 leading-tight font-serif">
                        Mari Ciptakan <br />Sesuatu yang <span class="italic text-primary">Indah</span>
                    </h2>
                    <p class="text-gray-400 mb-12 font-light leading-relaxed text-lg">
                        Siap untuk mengubah ruang Anda? Tim desain kami akan menghubungi Anda dalam 24 jam untuk menjadwalkan konsultasi pribadi Anda.
                    </p>

                    <!-- Contact Info -->
                    <div class="space-y-8">
                        <div class="flex items-start gap-6">
                            <div class="w-12 h-12 rounded-full bg-surface-dark flex items-center justify-center text-primary border border-white/10">
                                <span class="material-symbols-outlined text-xl">location_on</span>
                            </div>
                            <div>
                                <h4 class="text-white font-semibold text-sm uppercase tracking-widest">Kunjungi Studio Kami</h4>
                                <p class="text-gray-500 text-sm mt-2 font-light">
                                    Jl. Desain Interior No. 123<br />Jakarta Selatan 12345
                                </p>
                            </div>
                        </div>

                        <div class="flex items-start gap-6">
                            <div class="w-12 h-12 rounded-full bg-surface-dark flex items-center justify-center text-primary border border-white/10">
                                <span class="material-symbols-outlined text-xl">mail</span>
                            </div>
                            <div>
                                <h4 class="text-white font-semibold text-sm uppercase tracking-widest">Email Kami</h4>
                                <p class="text-gray-500 text-sm mt-2 font-light">hello@homeputra.com</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-6">
                            <div class="w-12 h-12 rounded-full bg-surface-dark flex items-center justify-center text-primary border border-white/10">
                                <span class="material-symbols-outlined text-xl">phone</span>
                            </div>
                            <div>
                                <h4 class="text-white font-semibold text-sm uppercase tracking-widest">Telepon</h4>
                                <p class="text-gray-500 text-sm mt-2 font-light">+62 812 3456 7890</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Side - Form -->
                <form id="contact-form" class="space-y-6" data-aos="fade-left" data-aos-delay="200">
                    <!-- Name Fields -->
                    <div class="grid grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-[10px] uppercase tracking-[0.2em] text-gray-500 font-bold">Nama Depan</label>
                            <input name="first_name" class="w-full bg-white/[0.03] border border-white/10 rounded-sm p-4 text-white focus:ring-1 focus:ring-primary focus:border-primary outline-none text-sm placeholder-gray-700 transition-all" placeholder="John" type="text" required />
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] uppercase tracking-[0.2em] text-gray-500 font-bold">Nama Belakang</label>
                            <input name="last_name" class="w-full bg-white/[0.03] border border-white/10 rounded-sm p-4 text-white focus:ring-1 focus:ring-primary focus:border-primary outline-none text-sm placeholder-gray-700 transition-all" placeholder="Doe" type="text" />
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="space-y-2">
                        <label class="text-[10px] uppercase tracking-[0.2em] text-gray-500 font-bold">Alamat Email</label>
                        <input name="email" class="w-full bg-white/[0.03] border border-white/10 rounded-sm p-4 text-white focus:ring-1 focus:ring-primary focus:border-primary outline-none text-sm placeholder-gray-700 transition-all" placeholder="john@example.com" type="email" required />
                    </div>

                    <!-- Phone -->
                    <div class="space-y-2">
                        <label class="text-[10px] uppercase tracking-[0.2em] text-gray-500 font-bold">Nomor Telepon</label>
                        <input name="phone" class="w-full bg-white/[0.03] border border-white/10 rounded-sm p-4 text-white focus:ring-1 focus:ring-primary focus:border-primary outline-none text-sm placeholder-gray-700 transition-all" placeholder="+62 812 xxx xxxx" type="tel" />
                    </div>

                    <!-- Service Select -->
                    <div class="space-y-2">
                        <label class="text-[10px] uppercase tracking-[0.2em] text-gray-500 font-bold">Layanan yang Diminati</label>
                        <select name="service_type" class="w-full bg-white/[0.03] border border-white/10 rounded-sm p-4 text-white focus:ring-1 focus:ring-primary focus:border-primary outline-none text-sm transition-all">
                            <option value="residential">Desain Residensial</option>
                            <option value="commercial">Desain Komersial</option>
                            <option value="furniture">Furniture Custom</option>
                            <option value="consultation">Konsultasi Saja</option>
                        </select>
                    </div>

                    <!-- Message -->
                    <div class="space-y-2">
                        <label class="text-[10px] uppercase tracking-[0.2em] text-gray-500 font-bold">Pesan</label>
                        <textarea name="message" class="w-full bg-white/[0.03] border border-white/10 rounded-sm p-4 text-white focus:ring-1 focus:ring-primary focus:border-primary outline-none text-sm placeholder-gray-700 resize-none transition-all" placeholder="Ceritakan tentang proyek Anda..." rows="4"></textarea>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="w-full py-5 bg-white text-black font-bold text-[10px] uppercase tracking-[0.3em] rounded-sm hover:bg-primary transition-all duration-300 mt-6 shadow-xl magnetic-btn">
                        Kirim Permintaan
                    </button>

                    <!-- Form Message -->
                    <div id="form-message" class="hidden text-center p-4 rounded-sm"></div>
                </form>
            </div>
        </div>
    </div>
</section>

<script>
    document.getElementById('contact-form').addEventListener('submit', function(e) {
        e.preventDefault();

        const formMessage = document.getElementById('form-message');
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalText = submitBtn.textContent;

        // Show loading state
        submitBtn.textContent = 'Mengirim...';
        submitBtn.disabled = true;

        // Simulate form submission (replace with actual AJAX call)
        setTimeout(() => {
            formMessage.classList.remove('hidden', 'bg-red-500/20', 'text-red-400');
            formMessage.classList.add('bg-green-500/20', 'text-green-400');
            formMessage.textContent = 'Terima kasih! Pesan Anda telah terkirim. Kami akan menghubungi Anda segera.';

            // Reset form
            this.reset();
            submitBtn.textContent = originalText;
            submitBtn.disabled = false;

            // Hide message after 5 seconds
            setTimeout(() => {
                formMessage.classList.add('hidden');
            }, 5000);
        }, 1500);
    });
</script>