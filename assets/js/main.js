/**
 * Home Putra Interior - Main JS Logic
 * Menangani interaksi umum website, navigasi, dan animasi reveal.
 */

// Custom Reveal Animation (Intersection Observer)
const initReveal = () => {
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('aos-animate');
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    document.querySelectorAll('[data-aos]').forEach(el => observer.observe(el));
};

// Inisialisasi animasi pada desktop
if (window.innerWidth >= 1024) {
    document.addEventListener('DOMContentLoaded', initReveal);
}

// Preloader Handler
window.addEventListener('load', function () {
    const preloader = document.getElementById('preloader');
    if (preloader) {
        preloader.style.opacity = '0';
        setTimeout(() => {
            preloader.style.display = 'none';
        }, 500);
    }
});

/**
 * Navigation Scroll Effects
 */
const nav = document.getElementById('main-nav');
const backToTop = document.getElementById('back-to-top');

window.addEventListener('scroll', () => {
    if (nav) {
        if (window.pageYOffset > 100) nav.classList.add('scrolled');
        else nav.classList.remove('scrolled');
    }

    if (backToTop) {
        if (window.pageYOffset > 500) {
            backToTop.classList.remove('opacity-0', 'pointer-events-none');
        } else {
            backToTop.classList.add('opacity-0', 'pointer-events-none');
        }
    }
});

if (backToTop) {
    backToTop.addEventListener('click', () => window.scrollTo({
        top: 0,
        behavior: 'smooth'
    }));
}

/**
 * Mobile Menu Logic
 */
const mobileMenuBtn = document.getElementById('mobile-menu-btn');
const mobileMenu = document.getElementById('mobile-menu');
const mobileMenuClose = document.getElementById('mobile-menu-close');
const mobileMenuOverlay = document.getElementById('mobile-menu-overlay');

if (mobileMenuBtn && mobileMenu && mobileMenuOverlay) {
    mobileMenuBtn.addEventListener('click', () => {
        mobileMenu.classList.add('active');
        mobileMenuOverlay.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    });

    const closeMenu = () => {
        mobileMenu.classList.remove('active');
        mobileMenuOverlay.classList.add('hidden');
        document.body.style.overflow = '';
    };

    if (mobileMenuClose) mobileMenuClose.addEventListener('click', closeMenu);
    mobileMenuOverlay.addEventListener('click', closeMenu);
}

/**
 * Smooth Scroll for Hash Links
 */
document.querySelectorAll('a').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        const href = this.getAttribute('href');
        if (!href || href === '#' || href.startsWith('javascript:')) return;

        try {
            const url = new URL(href, window.location.origin);
            const currentPath = window.location.pathname.replace(/\/index\.php$/, '/');
            const targetPath = url.pathname.replace(/\/index\.php$/, '/');

            if (currentPath === targetPath && url.hash) {
                const targetId = url.hash.slice(1);
                const target = document.getElementById(targetId);

                if (target) {
                    e.preventDefault();
                    window.scrollTo({
                        top: target.offsetTop - 80,
                        behavior: 'smooth'
                    });

                    // Update URL without hash after scroll
                    setTimeout(() => {
                        history.replaceState(null, null, window.location.pathname + window.location.search);
                    }, 1000);

                    // Close mobile menu if open
                    if (mobileMenu && mobileMenu.classList.contains('active')) {
                        mobileMenu.classList.remove('active');
                        mobileMenuOverlay.classList.add('hidden');
                        document.body.style.overflow = '';
                    }
                }
            }
        } catch (err) {
            if (href.startsWith('#')) {
                const targetId = href.slice(1);
                const target = document.getElementById(targetId);
                if (target) {
                    e.preventDefault();
                    window.scrollTo({
                        top: target.offsetTop - 80,
                        behavior: 'smooth'
                    });
                }
            }
        }
    });
});

/**
 * Counter Animation
 */
const counters = document.querySelectorAll('.counter');

const animateCounter = (counter) => {
    const target = parseInt(counter.getAttribute('data-target')) || 0;
    const suffix = counter.getAttribute('data-suffix') || '';
    const duration = 2000;
    const step = target / (duration / 16);
    let current = 0;

    const updateCounter = () => {
        current += step;
        if (current < target) {
            counter.textContent = Math.floor(current) + suffix;
            requestAnimationFrame(updateCounter);
        } else {
            counter.textContent = target + suffix;
        }
    };

    updateCounter();
};

if (counters.length > 0) {
    const counterObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                animateCounter(entry.target);
                counterObserver.unobserve(entry.target);
            }
        });
    }, {
        threshold: 0.5
    });

    counters.forEach(counter => counterObserver.observe(counter));
}

// Clean URL on page load if hash exists
window.addEventListener('load', () => {
    if (window.location.hash) {
        setTimeout(() => {
            history.replaceState(null, null, window.location.pathname + window.location.search);
        }, 1000);
    }
});