<!-- Testimonials Section -->
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
            'testimonial_text' => 'Home Putra Interior mengubah apartemen gelap dan kuno kami menjadi tempat tinggal yang penuh cahaya. Perhatian terhadap detail sungguh luar biasa.',
            'rating' => 5
        ],
        [
            'client_name' => 'Michael Hartono',
            'client_location' => 'Surabaya',
            'client_image' => '',
            'testimonial_text' => 'Tim ini memahami visi kami lebih baik dari kami sendiri. Ruang kerja kayu oak hangat sekarang menjadi ruangan favorit saya di seluruh rumah.',
            'rating' => 5
        ],
        [
            'client_name' => 'Lisa Wijaya',
            'client_location' => 'Bandung',
            'client_image' => '',
            'testimonial_text' => 'Profesional, tepat waktu, dan sangat berbakat. Mereka mengelola semuanya mulai dari kontraktor hingga styling dengan sempurna.',
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
    /* Marquee Animation Styles */
    .testimonial-track {
        display: flex;
        gap: 1.5rem;
        width: max-content;
    }

    .marquee-wrapper {
        overflow: hidden;
        mask-image: linear-gradient(to right, transparent, black 5%, black 95%, transparent);
        -webkit-mask-image: linear-gradient(to right, transparent, black 5%, black 95%, transparent);
    }

    .marquee-left .testimonial-track {
        animation: marquee-left 35s linear infinite;
    }

    .marquee-right .testimonial-track {
        animation: marquee-right 35s linear infinite;
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

    /* Elegant Card Styles */
    .testimonial-card {
        flex-shrink: 0;
        width: 400px;
        background: linear-gradient(145deg, rgba(30, 30, 30, 0.9), rgba(20, 20, 20, 0.95));
        border: 1px solid rgba(212, 175, 55, 0.1);
        border-radius: 1rem;
        padding: 2rem;
        position: relative;
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        backdrop-filter: blur(10px);
    }

    .testimonial-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, transparent, #D4AF37, transparent);
        opacity: 0;
        transition: opacity 0.4s ease;
    }

    .testimonial-card::after {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(212, 175, 55, 0.03) 0%, transparent 70%);
        opacity: 0;
        transition: opacity 0.4s ease;
        pointer-events: none;
    }

    .testimonial-card:hover {
        transform: translateY(-5px) scale(1.02);
        border-color: rgba(212, 175, 55, 0.3);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3), 0 0 30px rgba(212, 175, 55, 0.1);
    }

    .testimonial-card:hover::before,
    .testimonial-card:hover::after {
        opacity: 1;
    }

    /* Quote Icon Elegant */
    .quote-icon {
        position: absolute;
        top: 1.5rem;
        right: 1.5rem;
        width: 50px;
        height: 50px;
        background: linear-gradient(135deg, rgba(212, 175, 55, 0.15), rgba(212, 175, 55, 0.05));
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid rgba(212, 175, 55, 0.2);
    }

    .quote-icon span {
        color: #D4AF37;
        font-size: 1.5rem;
    }

    /* Stars */
    .stars-wrapper {
        display: flex;
        gap: 2px;
        margin-bottom: 1rem;
    }

    .star-icon {
        color: #D4AF37;
        font-size: 0.875rem;
        filter: drop-shadow(0 0 2px rgba(212, 175, 55, 0.5));
    }

    /* Testimonial text with line clamp */
    .testimonial-text {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        min-height: 4.5em;
        max-height: 4.5em;
        color: #E5E5E5;
        font-style: italic;
        font-family: 'Georgia', serif;
        font-size: 1rem;
        line-height: 1.6;
        margin-bottom: 1.5rem;
        position: relative;
        z-index: 10;
    }

    /* Client Info */
    .client-wrapper {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding-top: 1rem;
        border-top: 1px solid rgba(255, 255, 255, 0.05);
    }

    .client-avatar {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background: linear-gradient(135deg, #D4AF37, #B8860B);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        color: #000;
        font-size: 1rem;
        box-shadow: 0 4px 15px rgba(212, 175, 55, 0.3);
        border: 2px solid rgba(212, 175, 55, 0.3);
    }

    .client-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 50%;
    }

    .client-name {
        color: #fff;
        font-family: 'Georgia', serif;
        font-size: 1rem;
        font-weight: 500;
        margin-bottom: 2px;
    }

    .client-location {
        color: #888;
        font-size: 0.65rem;
        text-transform: uppercase;
        letter-spacing: 0.15em;
        font-weight: 600;
    }

    /* Responsive */
    @media (max-width: 1024px) {
        .testimonial-card {
            width: 360px;
            padding: 1.5rem;
        }
    }

    @media (max-width: 768px) {
        .testimonial-card {
            width: 320px;
            padding: 1.25rem;
        }

        .testimonial-text {
            font-size: 0.9rem;
            min-height: 4em;
            max-height: 4em;
        }

        .marquee-left .testimonial-track,
        .marquee-right .testimonial-track {
            animation-duration: 28s;
        }
    }

    @media (max-width: 480px) {
        .testimonial-card {
            width: 280px;
            padding: 1rem;
        }

        .testimonial-text {
            font-size: 0.85rem;
            min-height: 3.5em;
            max-height: 3.5em;
        }

        .quote-icon {
            width: 40px;
            height: 40px;
            top: 1rem;
            right: 1rem;
        }

        .quote-icon span {
            font-size: 1.25rem;
        }

        .marquee-left .testimonial-track,
        .marquee-right .testimonial-track {
            animation-duration: 22s;
        }
    }
</style>

<section class="py-16 md:py-24 lg:py-32 bg-surface-dark border-t border-white/5 overflow-hidden" id="testimonials">
    <div class="max-w-[1400px] mx-auto px-4 md:px-6">
        <!-- Section Header -->
        <div class="text-center mb-12 md:mb-16" data-aos="fade-up">
            <span class="text-primary uppercase tracking-[0.3em] md:tracking-[0.4em] text-[9px] md:text-[10px] font-bold">Testimoni</span>
            <h2 class="text-3xl md:text-5xl lg:text-6xl text-white mt-3 md:mt-5 italic font-serif">Cerita Klien Kami</h2>
            <p class="text-gray-400 mt-3 md:mt-4 max-w-xl mx-auto text-sm md:text-base px-4">Lihat apa yang klien kami katakan tentang pengalaman mereka bekerja dengan Home Putra Interior</p>
        </div>

        <!-- Marquee Row 1 - Scroll Left -->
        <div class="marquee-wrapper py-10 marquee-left mb-5 md:mb-6 " data-aos="fade-up">
            <div class="testimonial-track">
                <?php
                $testimonialsDouble = array_merge($testimonials, $testimonials);
                foreach ($testimonialsDouble as $index => $t):
                ?>
                    <div class="testimonial-card">
                        <!-- Stars -->
                        <div class="stars-wrapper">
                            <?php for ($i = 0; $i < ($t['rating'] ?? 5); $i++): ?>
                                <span class="material-symbols-outlined star-icon">star</span>
                            <?php endfor; ?>
                        </div>

                        <!-- Testimonial Text -->
                        <p class="testimonial-text">
                            "<?php echo htmlspecialchars($t['testimonial_text']); ?>"
                        </p>

                        <!-- Client Info -->
                        <div class="client-wrapper">
                            <div class="client-avatar">
                                <?php if (!empty($t['client_image'])): ?>
                                    <img src="<?php echo htmlspecialchars($t['client_image']); ?>" alt="<?php echo htmlspecialchars($t['client_name']); ?>">
                                <?php else: ?>
                                    <?php echo getInitials($t['client_name']); ?>
                                <?php endif; ?>
                            </div>
                            <div>
                                <p class="client-name"><?php echo htmlspecialchars($t['client_name']); ?></p>
                                <p class="client-location"><?php echo htmlspecialchars($t['client_location'] ?? ''); ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Marquee Row 2 - Scroll Right -->
        <div class="marquee-wrapper pb-6 marquee-right" data-aos="fade-up" data-aos-delay="100">
            <div class="testimonial-track  py-2">
                <?php
                $testimonialsReversed = array_reverse($testimonials);
                $testimonialsDouble2 = array_merge($testimonialsReversed, $testimonialsReversed);
                foreach ($testimonialsDouble2 as $index => $t):
                ?>
                    <div class="testimonial-card">
                        <!-- Stars -->
                        <div class="stars-wrapper">
                            <?php for ($i = 0; $i < ($t['rating'] ?? 5); $i++): ?>
                                <span class="material-symbols-outlined star-icon">star</span>
                            <?php endfor; ?>
                        </div>

                        <!-- Testimonial Text -->
                        <p class="testimonial-text">
                            "<?php echo htmlspecialchars($t['testimonial_text']); ?>"
                        </p>

                        <!-- Client Info -->
                        <div class="client-wrapper">
                            <div class="client-avatar">
                                <?php if (!empty($t['client_image'])): ?>
                                    <img src="<?php echo htmlspecialchars($t['client_image']); ?>" alt="<?php echo htmlspecialchars($t['client_name']); ?>">
                                <?php else: ?>
                                    <?php echo getInitials($t['client_name']); ?>
                                <?php endif; ?>
                            </div>
                            <div>
                                <p class="client-name"><?php echo htmlspecialchars($t['client_name']); ?></p>
                                <p class="client-location"><?php echo htmlspecialchars($t['client_location'] ?? ''); ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Trust Badges -->
        <div class="mt-16 md:mt-24 pt-12 md:pt-16 border-t border-white/5">
            <p class="text-center text-gray-500 text-[9px] md:text-[10px] uppercase tracking-widest font-bold mb-8 md:mb-12" data-aos="fade-up">Dipercaya oleh brand terkemuka</p>
            <div class="flex flex-wrap justify-center items-center gap-8 md:gap-16 opacity-30">
                <div class="text-xl md:text-3xl font-serif text-gray-400 hover:text-primary hover:opacity-100 transition-all cursor-default" data-aos="fade-up" data-aos-delay="100">TOKOPEDIA</div>
                <div class="text-xl md:text-3xl font-serif text-gray-400 hover:text-primary hover:opacity-100 transition-all cursor-default" data-aos="fade-up" data-aos-delay="200">GOJEK</div>
                <div class="text-xl md:text-3xl font-serif text-gray-400 hover:text-primary hover:opacity-100 transition-all cursor-default" data-aos="fade-up" data-aos-delay="300">GRAB</div>
                <div class="text-xl md:text-3xl font-serif text-gray-400 hover:text-primary hover:opacity-100 transition-all cursor-default" data-aos="fade-up" data-aos-delay="400">SHOPEE</div>
            </div>
        </div>
    </div>
</section>