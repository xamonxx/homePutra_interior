<!-- Testimonials Section - Premium Design -->
<?php
// Fetch testimonials from database
$testimonials = [];
try {
    $db = getDB();
    $stmt = $db->query("SELECT * FROM testimonials WHERE is_active = 1 ORDER BY display_order ASC");
    $testimonials = $stmt->fetchAll();
} catch (PDOException $e) {
    $testimonials = [];
}

// Default testimonials if database is empty
if (empty($testimonials)) {
    $testimonials = [
        [
            'client_name' => 'Sarah Putri',
            'client_location' => 'Jakarta Selatan',
            'client_image' => '',
            'testimonial_text' => 'Home Putra Interior mengubah apartemen kami menjadi tempat tinggal yang penuh cahaya. Perhatian terhadap detail sungguh luar biasa dan hasilnya melebihi ekspektasi.',
            'rating' => 5
        ],
        [
            'client_name' => 'Michael Hartono',
            'client_location' => 'Surabaya',
            'client_image' => '',
            'testimonial_text' => 'Tim yang sangat profesional! Ruang kerja kayu oak hangat sekarang menjadi ruangan favorit saya. Prosesnya lancar dan komunikatif.',
            'rating' => 5
        ],
        [
            'client_name' => 'Lisa Wijaya',
            'client_location' => 'Bandung',
            'client_image' => '',
            'testimonial_text' => 'Profesional, tepat waktu, dan sangat berbakat. Mereka mengelola semuanya mulai dari desain hingga instalasi dengan sempurna.',
            'rating' => 5
        ],
        [
            'client_name' => 'Budi Santoso',
            'client_location' => 'Malang',
            'client_image' => '',
            'testimonial_text' => 'Kitchen set aluminium yang dibuat sangat presisi dan berkualitas tinggi. Garansi 2 tahun membuat kami tenang. Highly recommended!',
            'rating' => 5
        ],
        [
            'client_name' => 'Dewi Anggara',
            'client_location' => 'Sidoarjo',
            'client_image' => '',
            'testimonial_text' => 'Lemari sliding yang dibuatkan sangat fungsional dan elegan. Tim instalasi sangat rapi dan bersih dalam bekerja.',
            'rating' => 5
        ],
    ];
}

// Helper function to get initials
function getInitials($name)
{
    $words = explode(' ', $name);
    $initials = '';
    foreach ($words as $word) {
        $initials .= strtoupper(substr($word, 0, 1));
    }
    return substr($initials, 0, 2);
}
?>

<style>
    /* Premium Marquee Animation */
    .testimonial-track {
        display: flex;
        gap: 1.5rem;
        width: max-content;
    }

    .marquee-wrapper {
        overflow: hidden;
        mask-image: linear-gradient(to right, transparent, black 10%, black 90%, transparent);
        -webkit-mask-image: linear-gradient(to right, transparent, black 10%, black 90%, transparent);
    }

    .marquee-left .testimonial-track {
        animation: marquee-left 40s linear infinite;
    }

    .marquee-right .testimonial-track {
        animation: marquee-right 40s linear infinite;
    }

    .marquee-wrapper:hover .testimonial-track {
        animation-play-state: paused;
    }

    @keyframes marquee-left {
        0% {
            transform: translateX(0);
        }

        100% {
            transform: translateX(-50%);
        }
    }

    @keyframes marquee-right {
        0% {
            transform: translateX(-50%);
        }

        100% {
            transform: translateX(0);
        }
    }

    /* Premium Card Styles */
    .testimonial-card {
        flex-shrink: 0;
        width: 420px;
        position: relative;
        overflow: hidden;
    }

    .testimonial-card-inner {
        background: linear-gradient(145deg, rgba(255, 255, 255, 0.08), rgba(255, 255, 255, 0.02));
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 1.5rem;
        padding: 2rem;
        height: 100%;
        transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }

    .testimonial-card-inner::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, transparent, var(--color-primary), transparent);
        opacity: 0;
        transition: opacity 0.4s ease;
    }

    .testimonial-card:hover .testimonial-card-inner {
        transform: translateY(-8px);
        border-color: rgba(212, 175, 55, 0.3);
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.4), 0 0 40px rgba(212, 175, 55, 0.1);
    }

    .testimonial-card:hover .testimonial-card-inner::before {
        opacity: 1;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .testimonial-card {
            width: 320px;
        }

        .testimonial-card-inner {
            padding: 1.5rem;
        }
    }

    @media (max-width: 480px) {
        .testimonial-card {
            width: 280px;
        }
    }
</style>

<section class="py-24 md:py-32 lg:py-40 bg-[#0a0c10] relative overflow-hidden" id="testimonials">
    <!-- Background Effects -->
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[500px] bg-primary/5 blur-[150px] rounded-full"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-primary/5 blur-[100px] rounded-full"></div>
    </div>

    <div class="relative z-10">
        <!-- Premium Header -->
        <div class="text-center mb-16 md:mb-20 px-6" data-aos="fade-up">
            <div class="inline-flex items-center gap-3 px-5 py-2.5 bg-primary/10 border border-primary/20 rounded-full mb-6">
                <span class="material-symbols-outlined text-primary text-lg">format_quote</span>
                <span class="text-primary text-[10px] font-bold uppercase tracking-[0.2em]">Testimonial</span>
            </div>
            <h2 class="text-4xl md:text-5xl lg:text-6xl text-white font-serif mb-6">
                Apa Kata <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary via-yellow-400 to-primary italic">Klien</span> Kami
            </h2>
            <p class="text-gray-400 max-w-2xl mx-auto text-base md:text-lg font-light leading-relaxed">
                Kepuasan klien adalah prioritas utama kami. Dengarkan pengalaman mereka bekerja bersama Home Putra Interior
            </p>
        </div>

        <!-- Rating Summary -->
        <div class="max-w-4xl mx-auto px-6 mb-16" data-aos="fade-up">
            <div class="flex flex-col md:flex-row items-center justify-center gap-8 md:gap-16 p-8 bg-gradient-to-r from-white/[0.05] via-white/[0.02] to-white/[0.05] border border-white/[0.08] rounded-2xl">
                <div class="text-center">
                    <div class="text-5xl md:text-6xl font-serif text-white font-bold mb-2">4.9</div>
                    <div class="flex items-center justify-center gap-1 mb-2">
                        <?php for ($i = 0; $i < 5; $i++): ?>
                            <span class="material-symbols-outlined text-primary text-lg">star</span>
                        <?php endfor; ?>
                    </div>
                    <div class="text-gray-500 text-xs uppercase tracking-wider">Rating Rata-rata</div>
                </div>
                <div class="hidden md:block w-px h-20 bg-white/10"></div>
                <div class="flex items-center gap-8 text-center">
                    <div>
                        <div class="text-3xl md:text-4xl font-serif text-white font-bold">500+</div>
                        <div class="text-gray-500 text-xs uppercase tracking-wider mt-1">Proyek</div>
                    </div>
                    <div>
                        <div class="text-3xl md:text-4xl font-serif text-white font-bold">98%</div>
                        <div class="text-gray-500 text-xs uppercase tracking-wider mt-1">Kepuasan</div>
                    </div>
                    <div>
                        <div class="text-3xl md:text-4xl font-serif text-white font-bold">12+</div>
                        <div class="text-gray-500 text-xs uppercase tracking-wider mt-1">Tahun</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Marquee Row 1 - Scroll Left -->
        <div class="marquee-wrapper marquee-left mb-6" data-aos="fade-up">
            <div class="testimonial-track py-4">
                <?php
                $testimonialsDouble = array_merge($testimonials, $testimonials);
                foreach ($testimonialsDouble as $index => $t):
                ?>
                    <div class="testimonial-card">
                        <div class="testimonial-card-inner">
                            <!-- Quote Icon & Rating -->
                            <div class="flex items-start justify-between mb-6">
                                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-primary/30 to-primary/10 flex items-center justify-center">
                                    <span class="material-symbols-outlined text-primary text-2xl">format_quote</span>
                                </div>
                                <div class="flex items-center gap-1">
                                    <?php for ($i = 0; $i < ($t['rating'] ?? 5); $i++): ?>
                                        <span class="material-symbols-outlined text-primary text-sm">star</span>
                                    <?php endfor; ?>
                                </div>
                            </div>

                            <!-- Testimonial Text -->
                            <p class="text-gray-300 text-base leading-relaxed mb-6 line-clamp-4 font-light italic">
                                "<?php echo e($t['testimonial_text']); ?>"
                            </p>

                            <!-- Client Info -->
                            <div class="flex items-center gap-4 pt-6 border-t border-white/[0.06]">
                                <div class="w-12 h-12 rounded-full bg-gradient-to-br from-primary to-yellow-600 flex items-center justify-center text-black font-bold shadow-lg shadow-primary/30">
                                    <?php if (!empty($t['client_image'])): ?>
                                        <img src="<?php echo e($t['client_image']); ?>" alt="<?php echo e($t['client_name']); ?>" class="w-full h-full object-cover rounded-full">
                                    <?php else: ?>
                                        <?php echo e(getInitials($t['client_name'])); ?>
                                    <?php endif; ?>
                                </div>
                                <div>
                                    <p class="text-white font-semibold"><?php echo e($t['client_name']); ?></p>
                                    <p class="text-gray-500 text-xs uppercase tracking-wider"><?php echo e($t['client_location'] ?? ''); ?></p>
                                </div>
                                <span class="ml-auto material-symbols-outlined text-green-400 text-xl">verified</span>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Marquee Row 2 - Scroll Right -->
        <div class="marquee-wrapper marquee-right" data-aos="fade-up" data-aos-delay="100">
            <div class="testimonial-track py-4">
                <?php
                $testimonialsReversed = array_reverse($testimonials);
                $testimonialsDouble2 = array_merge($testimonialsReversed, $testimonialsReversed);
                foreach ($testimonialsDouble2 as $index => $t):
                ?>
                    <div class="testimonial-card">
                        <div class="testimonial-card-inner">
                            <!-- Quote Icon & Rating -->
                            <div class="flex items-start justify-between mb-6">
                                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-primary/30 to-primary/10 flex items-center justify-center">
                                    <span class="material-symbols-outlined text-primary text-2xl">format_quote</span>
                                </div>
                                <div class="flex items-center gap-1">
                                    <?php for ($i = 0; $i < ($t['rating'] ?? 5); $i++): ?>
                                        <span class="material-symbols-outlined text-primary text-sm">star</span>
                                    <?php endfor; ?>
                                </div>
                            </div>

                            <!-- Testimonial Text -->
                            <p class="text-gray-300 text-base leading-relaxed mb-6 line-clamp-4 font-light italic">
                                "<?php echo e($t['testimonial_text']); ?>"
                            </p>

                            <!-- Client Info -->
                            <div class="flex items-center gap-4 pt-6 border-t border-white/[0.06]">
                                <div class="w-12 h-12 rounded-full bg-gradient-to-br from-primary to-yellow-600 flex items-center justify-center text-black font-bold shadow-lg shadow-primary/30">
                                    <?php if (!empty($t['client_image'])): ?>
                                        <img src="<?php echo e($t['client_image']); ?>" alt="<?php echo e($t['client_name']); ?>" class="w-full h-full object-cover rounded-full">
                                    <?php else: ?>
                                        <?php echo e(getInitials($t['client_name'])); ?>
                                    <?php endif; ?>
                                </div>
                                <div>
                                    <p class="text-white font-semibold"><?php echo e($t['client_name']); ?></p>
                                    <p class="text-gray-500 text-xs uppercase tracking-wider"><?php echo e($t['client_location'] ?? ''); ?></p>
                                </div>
                                <span class="ml-auto material-symbols-outlined text-green-400 text-xl">verified</span>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Trust Badges -->
        <div class="max-w-[1200px] mx-auto px-6 mt-20 md:mt-24">
            <div class="text-center" data-aos="fade-up">
                <p class="text-gray-500 text-[10px] uppercase tracking-[0.2em] font-bold mb-10">Platform Terpercaya</p>
                <div class="flex flex-wrap justify-center items-center gap-8 md:gap-12">
                    <div class="group flex flex-col items-center gap-2 opacity-40 hover:opacity-100 transition-all cursor-default">
                        <span class="material-symbols-outlined text-4xl text-gray-400 group-hover:text-primary transition-colors">verified</span>
                        <span class="text-xs text-gray-500 group-hover:text-white transition-colors">Google Review</span>
                    </div>
                    <div class="group flex flex-col items-center gap-2 opacity-40 hover:opacity-100 transition-all cursor-default">
                        <span class="material-symbols-outlined text-4xl text-gray-400 group-hover:text-primary transition-colors">storefront</span>
                        <span class="text-xs text-gray-500 group-hover:text-white transition-colors">Tokopedia</span>
                    </div>
                    <div class="group flex flex-col items-center gap-2 opacity-40 hover:opacity-100 transition-all cursor-default">
                        <span class="material-symbols-outlined text-4xl text-gray-400 group-hover:text-primary transition-colors">shopping_bag</span>
                        <span class="text-xs text-gray-500 group-hover:text-white transition-colors">Shopee</span>
                    </div>
                    <div class="group flex flex-col items-center gap-2 opacity-40 hover:opacity-100 transition-all cursor-default">
                        <span class="material-symbols-outlined text-4xl text-gray-400 group-hover:text-primary transition-colors">thumb_up</span>
                        <span class="text-xs text-gray-500 group-hover:text-white transition-colors">Facebook</span>
                    </div>
                    <div class="group flex flex-col items-center gap-2 opacity-40 hover:opacity-100 transition-all cursor-default">
                        <span class="material-symbols-outlined text-4xl text-gray-400 group-hover:text-primary transition-colors">photo_camera</span>
                        <span class="text-xs text-gray-500 group-hover:text-white transition-colors">Instagram</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>