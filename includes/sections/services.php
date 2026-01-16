<!-- Services Section - Premium Design -->
<?php
// Fetch services from database
$services = [];
try {
    $db = getDB();
    $stmt = $db->query("SELECT * FROM services WHERE is_active = 1 ORDER BY display_order ASC");
    $services = $stmt->fetchAll();
} catch (PDOException $e) {
    $services = [];
}

// Material icons for services
function getServiceMaterialIcon($iconName)
{
    $icons = [
        'home' => 'home',
        'storefront' => 'storefront',
        'chair' => 'chair',
        'chat' => 'chat',
        'engineering' => 'engineering',
        'brush' => 'brush',
        'palette' => 'palette',
        'lightbulb' => 'lightbulb',
        'construction' => 'construction',
        'architecture' => 'architecture'
    ];
    return $icons[$iconName] ?? 'home';
}

// Fallback data if empty
if (empty($services)) {
    $services = [
        [
            'title' => 'Desain Residensial',
            'description' => 'Renovasi skala penuh dan desain bangunan baru untuk rumah mewah, fokus pada aliran ruang, pencahayaan, dan materialitas.',
            'icon' => 'home'
        ],
        [
            'title' => 'Ruang Komersial',
            'description' => 'Menciptakan pengalaman brand yang berdampak melalui desain tata ruang cerdas untuk ritel, perhotelan, dan kantor.',
            'icon' => 'storefront'
        ],
        [
            'title' => 'Furniture Custom',
            'description' => 'Desain dan koordinasi fabrikasi furniture eksklusif untuk memastikan setiap produk cocok sempurna dengan ruang Anda.',
            'icon' => 'chair'
        ],
        [
            'title' => 'Konsultasi Desain',
            'description' => 'Konsultasi profesional untuk membantu Anda merencanakan proyek interior dengan budget dan timeline yang tepat.',
            'icon' => 'chat'
        ]
    ];
}
?>

<section class="py-24 md:py-32 lg:py-40 bg-[#0a0c10] relative overflow-hidden" id="services">
    <!-- Background Effects -->
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-0 left-0 w-96 h-96 bg-primary/10 blur-[150px] rounded-full"></div>
        <div class="absolute bottom-0 right-0 w-80 h-80 bg-primary/5 blur-[120px] rounded-full"></div>
        <!-- Grid Pattern -->
        <div class="absolute inset-0 opacity-[0.02]" style="background-image: linear-gradient(rgba(255,255,255,.1) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,.1) 1px, transparent 1px); background-size: 60px 60px;"></div>
    </div>

    <div class="max-w-[1200px] mx-auto px-6 relative z-10">
        <!-- Premium Header -->
        <div class="text-center mb-16 md:mb-20" data-aos="fade-up">
            <div class="inline-flex items-center gap-3 px-5 py-2.5 bg-primary/10 border border-primary/20 rounded-full mb-6">
                <span class="w-1.5 h-1.5 bg-primary rounded-full animate-pulse"></span>
                <span class="text-primary text-[10px] font-bold uppercase tracking-[0.2em]">Layanan Kami</span>
            </div>
            <h2 class="text-4xl md:text-5xl lg:text-6xl text-white font-serif mb-6">
                Solusi <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary via-yellow-400 to-primary">Interior</span> Lengkap
            </h2>
            <p class="text-gray-400 max-w-2xl mx-auto text-base md:text-lg font-light leading-relaxed">
                Dari konsep hingga realisasi, kami menghadirkan keahlian desain interior premium untuk mewujudkan ruang impian Anda
            </p>
        </div>

        <!-- Services Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <?php foreach ($services as $index => $service): ?>
                <div class="group relative cursor-pointer" data-aos="fade-up" data-aos-delay="<?php echo $index * 100; ?>">
                    <!-- Card Container with Hover Transform -->
                    <div class="relative h-full transition-all duration-300 ease-out group-hover:-translate-y-2">
                        <!-- Glowing Border Effect -->
                        <div class="absolute -inset-[1px] bg-gradient-to-r from-primary via-yellow-500 to-primary rounded-2xl opacity-0 group-hover:opacity-100 transition-all duration-300"></div>

                        <!-- Glow Shadow -->
                        <div class="absolute inset-0 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300 shadow-[0_0_30px_rgba(212,175,55,0.3)]"></div>

                        <!-- Card Content -->
                        <div class="relative h-full p-8 bg-[#12151c] border border-white/[0.08] rounded-2xl overflow-hidden group-hover:border-transparent transition-all duration-300">
                            <!-- Background Glow -->
                            <div class="absolute inset-0 bg-gradient-to-br from-primary/5 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

                            <!-- Floating Decoration -->
                            <div class="absolute -top-16 -right-16 w-40 h-40 bg-primary/5 rounded-full blur-3xl opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>

                            <div class="relative z-10">
                                <!-- Icon -->
                                <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-primary/20 to-primary/5 border border-primary/20 flex items-center justify-center mb-6 transition-all duration-300 group-hover:scale-110 group-hover:bg-gradient-to-br group-hover:from-primary/30 group-hover:to-primary/10 group-hover:shadow-lg group-hover:shadow-primary/30">
                                    <span class="material-symbols-outlined text-primary text-3xl transition-transform duration-300 group-hover:scale-110"><?php echo getServiceMaterialIcon($service['icon']); ?></span>
                                </div>

                                <!-- Number Badge -->
                                <span class="absolute top-0 right-0 w-8 h-8 flex items-center justify-center text-white/10 text-sm font-bold group-hover:text-primary/30 transition-colors duration-300">0<?php echo $index + 1; ?></span>

                                <!-- Content -->
                                <h3 class="text-xl md:text-2xl text-white mb-4 font-semibold transition-colors duration-300 group-hover:text-primary"><?php echo e($service['title']); ?></h3>
                                <p class="text-gray-500 text-sm leading-relaxed mb-6 font-light transition-colors duration-300 group-hover:text-gray-400">
                                    <?php echo e($service['description']); ?>
                                </p>

                                <!-- CTA Link -->
                                <div class="inline-flex items-center gap-2 text-primary/70 text-xs uppercase tracking-widest font-bold transition-all duration-300 group-hover:text-primary group-hover:gap-3">
                                    <span>Selengkapnya</span>
                                    <span class="material-symbols-outlined text-base">arrow_forward</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Process Section -->
        <div class="mt-24 md:mt-32" data-aos="fade-up">
            <div class="text-center mb-16">
                <div class="inline-flex items-center gap-3 px-5 py-2.5 bg-primary/10 border border-primary/20 rounded-full mb-6">
                    <span class="text-primary text-[10px] font-bold uppercase tracking-[0.2em]">Proses Kami</span>
                </div>
                <h3 class="text-3xl md:text-4xl text-white font-serif">4 Langkah Menuju Interior Impian</h3>
            </div>

            <div class="relative">
                <!-- Connection Lines for Desktop -->
                <div class="hidden lg:block absolute top-10 left-[12.5%] right-[12.5%]">
                    <!-- Main Line -->
                    <div class="h-[2px] w-full bg-gradient-to-r from-primary/50 via-primary to-primary/50"></div>
                    <!-- Animated Glow -->
                    <div class="absolute inset-0 h-[2px] bg-gradient-to-r from-transparent via-primary to-transparent animate-pulse"></div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 lg:gap-6">
                    <!-- Step 1 -->
                    <div class="relative text-center group" data-aos="fade-up" data-aos-delay="100">
                        <!-- Connector Dot -->
                        <div class="hidden lg:block absolute top-10 left-1/2 -translate-x-1/2 -translate-y-1/2 w-4 h-4 bg-primary rounded-full z-10 shadow-lg shadow-primary/50"></div>

                        <div class="relative inline-flex items-center justify-center w-20 h-20 rounded-full bg-[#12151c] mb-6 group-hover:scale-110 transition-transform duration-300">
                            <!-- Outer Ring -->
                            <div class="absolute inset-0 rounded-full border-2 border-primary/40 group-hover:border-primary transition-colors duration-300"></div>
                            <!-- Inner Glow -->
                            <div class="absolute inset-2 rounded-full bg-gradient-to-br from-primary/20 to-transparent"></div>
                            <span class="relative text-2xl font-serif text-primary font-bold">01</span>
                        </div>
                        <h4 class="text-white font-semibold text-lg mb-2 group-hover:text-primary transition-colors">Konsultasi</h4>
                        <p class="text-gray-500 text-sm font-light max-w-[200px] mx-auto">Diskusi kebutuhan dan budget proyek Anda</p>
                    </div>

                    <!-- Step 2 -->
                    <div class="relative text-center group" data-aos="fade-up" data-aos-delay="200">
                        <!-- Connector Dot -->
                        <div class="hidden lg:block absolute top-10 left-1/2 -translate-x-1/2 -translate-y-1/2 w-4 h-4 bg-primary rounded-full z-10 shadow-lg shadow-primary/50"></div>

                        <div class="relative inline-flex items-center justify-center w-20 h-20 rounded-full bg-[#12151c] mb-6 group-hover:scale-110 transition-transform duration-300">
                            <!-- Outer Ring -->
                            <div class="absolute inset-0 rounded-full border-2 border-primary/40 group-hover:border-primary transition-colors duration-300"></div>
                            <!-- Inner Glow -->
                            <div class="absolute inset-2 rounded-full bg-gradient-to-br from-primary/20 to-transparent"></div>
                            <span class="relative text-2xl font-serif text-primary font-bold">02</span>
                        </div>
                        <h4 class="text-white font-semibold text-lg mb-2 group-hover:text-primary transition-colors">Desain</h4>
                        <p class="text-gray-500 text-sm font-light max-w-[200px] mx-auto">Pembuatan konsep dan visualisasi 3D</p>
                    </div>

                    <!-- Step 3 -->
                    <div class="relative text-center group" data-aos="fade-up" data-aos-delay="300">
                        <!-- Connector Dot -->
                        <div class="hidden lg:block absolute top-10 left-1/2 -translate-x-1/2 -translate-y-1/2 w-4 h-4 bg-primary rounded-full z-10 shadow-lg shadow-primary/50"></div>

                        <div class="relative inline-flex items-center justify-center w-20 h-20 rounded-full bg-[#12151c] mb-6 group-hover:scale-110 transition-transform duration-300">
                            <!-- Outer Ring -->
                            <div class="absolute inset-0 rounded-full border-2 border-primary/40 group-hover:border-primary transition-colors duration-300"></div>
                            <!-- Inner Glow -->
                            <div class="absolute inset-2 rounded-full bg-gradient-to-br from-primary/20 to-transparent"></div>
                            <span class="relative text-2xl font-serif text-primary font-bold">03</span>
                        </div>
                        <h4 class="text-white font-semibold text-lg mb-2 group-hover:text-primary transition-colors">Produksi</h4>
                        <p class="text-gray-500 text-sm font-light max-w-[200px] mx-auto">Fabrikasi dengan material berkualitas</p>
                    </div>

                    <!-- Step 4 -->
                    <div class="relative text-center group" data-aos="fade-up" data-aos-delay="400">
                        <!-- Connector Dot -->
                        <div class="hidden lg:block absolute top-10 left-1/2 -translate-x-1/2 -translate-y-1/2 w-4 h-4 bg-primary rounded-full z-10 shadow-lg shadow-primary/50"></div>

                        <div class="relative inline-flex items-center justify-center w-20 h-20 rounded-full bg-[#12151c] mb-6 group-hover:scale-110 transition-transform duration-300">
                            <!-- Outer Ring -->
                            <div class="absolute inset-0 rounded-full border-2 border-primary/40 group-hover:border-primary transition-colors duration-300"></div>
                            <!-- Inner Glow -->
                            <div class="absolute inset-2 rounded-full bg-gradient-to-br from-primary/20 to-transparent"></div>
                            <span class="relative text-2xl font-serif text-primary font-bold">04</span>
                        </div>
                        <h4 class="text-white font-semibold text-lg mb-2 group-hover:text-primary transition-colors">Instalasi</h4>
                        <p class="text-gray-500 text-sm font-light max-w-[200px] mx-auto">Pemasangan rapi dan bergaransi</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- CTA Banner with Parallax -->
        <div class="mt-20 md:mt-24 relative" data-aos="fade-up">
            <!-- Glowing Border -->
            <div class="absolute -inset-px bg-gradient-to-r from-primary via-yellow-500 to-primary rounded-3xl blur-sm opacity-60"></div>

            <div class="relative rounded-3xl overflow-hidden">
                <!-- Parallax Background Image -->
                <div class="absolute inset-0 bg-fixed bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1618221195710-dd6b41faaea6?ixlib=rb-4.0.3&auto=format&fit=crop&w=2000&q=80');"></div>

                <!-- Dark Overlay -->
                <div class="absolute inset-0 bg-black/70"></div>

                <!-- Gradient Overlays -->
                <div class="absolute inset-0 bg-gradient-to-r from-primary/20 via-transparent to-primary/20"></div>
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-black/60"></div>

                <!-- Decorative Elements -->
                <div class="absolute top-0 left-1/4 w-60 h-60 bg-primary/20 blur-[80px] rounded-full"></div>
                <div class="absolute bottom-0 right-1/4 w-60 h-60 bg-primary/10 blur-[80px] rounded-full"></div>

                <!-- Corner Decorations -->
                <div class="absolute top-6 left-6 w-20 h-20 border-t-2 border-l-2 border-primary/50 rounded-tl-xl"></div>
                <div class="absolute bottom-6 right-6 w-20 h-20 border-b-2 border-r-2 border-primary/50 rounded-br-xl"></div>

                <!-- Content -->
                <div class="relative py-16 md:py-24 px-8 md:px-12 text-center">
                    <!-- Badge -->
                    <div class="inline-flex items-center gap-2 px-4 py-2 bg-primary/20 border border-primary/30 rounded-full mb-6 backdrop-blur-sm">
                        <span class="w-2 h-2 bg-primary rounded-full animate-pulse"></span>
                        <span class="text-primary text-xs font-bold uppercase tracking-wider">Free Consultation</span>
                    </div>

                    <h3 class="text-3xl md:text-5xl lg:text-6xl text-white font-serif mb-6 leading-tight">
                        Siap Wujudkan Interior<br>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary via-yellow-400 to-primary">Impian Anda?</span>
                    </h3>
                    <p class="text-gray-300 mb-10 max-w-2xl mx-auto text-base md:text-lg font-light leading-relaxed">
                        Konsultasi gratis dengan tim desainer profesional kami. Dapatkan estimasi biaya dalam 24 jam dan mulai perjalanan menuju rumah impian Anda.
                    </p>

                    <!-- CTA Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                        <a href="#contact" class="group relative inline-flex items-center gap-3 px-10 py-5 bg-gradient-to-r from-primary to-yellow-500 text-black rounded-xl font-bold text-sm uppercase tracking-wider overflow-hidden transition-all hover:shadow-2xl hover:shadow-primary/40">
                            <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/30 to-transparent -translate-x-full group-hover:translate-x-full transition-transform duration-700"></div>
                            <span class="material-symbols-outlined text-xl">chat</span>
                            Konsultasi Gratis
                            <span class="material-symbols-outlined text-xl transition-transform group-hover:translate-x-1">arrow_forward</span>
                        </a>
                        <a href="https://wa.me/<?php echo getWhatsAppNumber(); ?>" class="inline-flex items-center gap-3 px-10 py-5 bg-white/10 backdrop-blur-sm border border-white/30 text-white rounded-xl font-bold text-sm uppercase tracking-wider hover:bg-white/20 hover:border-white/50 transition-all">
                            <span class="material-symbols-outlined text-xl text-green-400">chat</span>
                            WhatsApp Kami
                        </a>
                    </div>

                    <!-- Trust Indicators -->
                    <div class="flex flex-wrap items-center justify-center gap-8 mt-12 pt-8 border-t border-white/10">
                        <div class="flex items-center gap-2 text-gray-400">
                            <span class="material-symbols-outlined text-primary">verified</span>
                            <span class="text-sm">12+ Tahun Pengalaman</span>
                        </div>
                        <div class="flex items-center gap-2 text-gray-400">
                            <span class="material-symbols-outlined text-primary">workspace_premium</span>
                            <span class="text-sm">Garansi 2 Tahun</span>
                        </div>
                        <div class="flex items-center gap-2 text-gray-400">
                            <span class="material-symbols-outlined text-primary">thumb_up</span>
                            <span class="text-sm">500+ Proyek Selesai</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>