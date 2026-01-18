"use client";

import { useEffect, useState } from "react";
import Link from "next/link";
import Image from "next/image";
import { usePerformance } from "@/hooks/usePerformance";

const heroImages = [
  "https://images.unsplash.com/photo-1618221195710-dd6b41faaea6?auto=format&fit=crop&w=2000&q=80",
  "https://images.unsplash.com/photo-1600210492486-724fe5c67fb0?auto=format&fit=crop&w=2000&q=80",
  "https://images.unsplash.com/photo-1616486338812-3dadae4b4ace?auto=format&fit=crop&w=2000&q=80",
];

export default function HeroSection() {
  const { shouldReduceAnimations, isLowEnd } = usePerformance();
  const [currentBg, setCurrentBg] = useState(0);
  const [isLoaded, setIsLoaded] = useState(false);

  useEffect(() => {
    setIsLoaded(true);
    
    // Disable slideshow on low-end devices or reduced motion preference
    if (shouldReduceAnimations) return;

    const interval = setInterval(() => {
      setCurrentBg((prev) => (prev + 1) % heroImages.length);
    }, 6000);
    return () => clearInterval(interval);
  }, [shouldReduceAnimations]);

  return (
    <section className="relative min-h-screen flex items-center overflow-hidden bg-[#0a0c10]">
      {/* Background Slideshow */}
      <div className="absolute inset-0 z-0">
        {heroImages.map((img, idx) => (
          <div
            key={idx}
            className={`absolute inset-0 transition-opacity duration-2000 ease-out ${
              currentBg === idx ? "opacity-100" : "opacity-0"
            }`}
          >
            <Image
              src={img}
              alt="Hero Background"
              fill
              priority={idx === 0}
              quality={isLowEnd ? 60 : 85}
              // OPTIMASI PENTING: Mobile cuma download size kecil (640px), Tablet (1024px), Desktop (full)
              sizes="(max-width: 640px) 640px, (max-width: 1024px) 1024px, 100vw"
              className={`object-cover ${!shouldReduceAnimations ? (currentBg === idx ? "scale-100" : "scale-105") : ""} transition-transform duration-2000`}
            />
          </div>
        ))}
        {/* Overlay Gradients - Simplified for low end */}
        <div className="absolute inset-0 bg-linear-to-r from-black/90 via-black/60 to-black/40 z-10"></div>
        <div className="absolute inset-0 bg-linear-to-t from-[#0a0c10] via-transparent to-black/40 z-10"></div>
        
        {/* Decorative Grid - Disable on mobile/low-end for performance */}
        {!isLowEnd && (
          <div className="hidden sm:block absolute inset-0 z-10 opacity-[0.02]" style={{
            backgroundImage: `linear-gradient(rgba(255,255,255,0.1) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,0.1) 1px, transparent 1px)`,
            backgroundSize: '60px 60px'
          }}></div>
        )}
      </div>

      {/* Decorative Elements - Hide on mobile & low end to save GPU */}
      {!isLowEnd && (
        <>
          <div className="hidden lg:block absolute top-1/4 right-10 w-64 h-64 bg-[#ffb204]/10 rounded-full blur-[120px] z-0"></div>
          <div className="hidden lg:block absolute bottom-1/4 left-10 w-48 h-48 bg-[#ffb204]/5 rounded-full blur-[100px] z-0"></div>
        </>
      )}

      {/* Main Content */}
      <div className="relative z-20 w-full max-w-7xl mx-auto px-6 lg:px-8 pt-24 pb-20">
        <div className="grid lg:grid-cols-2 gap-12 lg:gap-16 items-center">
          {/* Left Content */}
          <div className="text-center lg:text-left">
            {/* Badge */}
            <div
              className={`inline-flex items-center gap-3 px-5 py-2 rounded-full border border-[#ffb204]/30 bg-[#ffb204]/5 backdrop-blur-sm mb-8 transition-all duration-1000 ${
                isLoaded ? "opacity-100 translate-y-0" : "opacity-0 translate-y-4"
              }`}
            >
              <span className="relative flex h-2.5 w-2.5">
                {/* Disable ping animation on low end */}
                {!shouldReduceAnimations && (
                  <span className="animate-ping absolute inline-flex h-full w-full rounded-full bg-[#ffb204] opacity-75"></span>
                )}
                <span className="relative inline-flex rounded-full h-2.5 w-2.5 bg-[#ffb204]"></span>
              </span>
              <span className="text-[10px] uppercase tracking-[0.25em] text-[#ffb204] font-bold">
                Studio Desain Premium
              </span>
            </div>

            {/* Main Title */}
            <h1
              className={`text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-serif leading-[1.1] mb-6 transition-all duration-1000 delay-200 ${
                isLoaded ? "opacity-100 translate-y-0" : "opacity-0 translate-y-8"
              }`}
            >
              <span className="text-white">Wujudkan</span>
              <br />
              <span className="relative">
                <span className="text-transparent bg-clip-text bg-linear-to-r from-[#ffb204] via-yellow-400 to-[#ffb204] italic">
                  Rumah Impian
                </span>
                <svg className="absolute -bottom-2 left-0 w-full h-3 text-[#ffb204]/30" viewBox="0 0 200 12" preserveAspectRatio="none">
                  <path d="M0,8 Q50,0 100,8 T200,8" stroke="currentColor" strokeWidth="3" fill="none"/>
                </svg>
              </span>
              <br />
              <span className="text-white/90">Anda</span>
            </h1>

            {/* Subtitle */}
            <p
              className={`text-gray-400 text-lg lg:text-xl max-w-xl mx-auto lg:mx-0 leading-relaxed mb-10 transition-all duration-1000 delay-300 ${
                isLoaded ? "opacity-100 translate-y-0" : "opacity-0 translate-y-8"
              }`}
            >
              Kami menghadirkan solusi interior <span className="text-white font-medium">custom furniture</span> dengan 
              kualitas premium dan harga transparan. Kitchen set, wardrobe, backdrop TV, dan lainnya.
            </p>

            {/* CTA Buttons */}
            <div
              className={`flex flex-wrap gap-4 justify-center lg:justify-start mb-12 transition-all duration-1000 delay-400 ${
                isLoaded ? "opacity-100 translate-y-0" : "opacity-0 translate-y-8"
              }`}
            >
              <Link
                href="/calculator"
                className="group relative overflow-hidden h-14 px-8 flex items-center justify-center gap-3 bg-[#ffb204] text-black font-bold rounded-xl transition-all duration-300 hover:shadow-2xl hover:shadow-[#ffb204]/30 hover:-translate-y-0.5"
              >
                <span className="absolute inset-0 bg-linear-to-r from-yellow-400 to-[#ffb204] opacity-0 group-hover:opacity-100 transition-opacity"></span>
                <span className="relative flex items-center gap-2">
                  <span className="material-symbols-outlined text-xl">calculate</span>
                  Hitung Estimasi
                </span>
              </Link>
              <Link
                href="#portfolio"
                className="h-14 px-8 flex items-center justify-center gap-3 border-2 border-white/20 bg-white/5 backdrop-blur-sm text-white font-semibold rounded-xl transition-all duration-300 hover:bg-white/10 hover:border-white/30"
              >
                <span className="material-symbols-outlined text-xl">photo_library</span>
                Lihat Portfolio
              </Link>
            </div>
          </div>

          {/* Right Content - Featured Card */}
          <div
            className={`hidden lg:block transition-all duration-1000 delay-500 ${
              isLoaded ? "opacity-100 translate-x-0" : "opacity-0 translate-x-12"
            }`}
          >
            <div className="relative">
              {/* Glow Effect - Disable on low end */}
              {!isLowEnd && (
                <div className="absolute -inset-4 bg-linear-to-r from-[#ffb204]/20 to-transparent rounded-3xl blur-2xl"></div>
              )}
              
              {/* Card - Solid background on low end for performance */}
              <div className={`relative rounded-3xl p-8 overflow-hidden border border-white/10 ${
                isLowEnd ? "bg-[#0a0c10]" : "bg-linear-to-br from-white/10 to-white/2 backdrop-blur-xl"
              }`}>
                {/* Corner Accents */}
                <div className="absolute top-0 left-0 w-20 h-20 border-t-2 border-l-2 border-[#ffb204]/50 rounded-tl-3xl"></div>
                <div className="absolute bottom-0 right-0 w-20 h-20 border-b-2 border-r-2 border-[#ffb204]/50 rounded-br-3xl"></div>
                
                {/* Content */}
                <div className="relative z-10">
                  <div className="flex items-center gap-4 mb-6">
                    <div className="w-14 h-14 rounded-2xl bg-[#ffb204]/20 flex items-center justify-center">
                      <span className="material-symbols-outlined text-[#ffb204] text-3xl">verified</span>
                    </div>
                    <div>
                      <h3 className="text-white font-bold text-lg">Konsultasi Gratis</h3>
                      <p className="text-gray-400 text-sm">Survey lokasi tanpa biaya</p>
                    </div>
                  </div>

                  <div className="space-y-4 mb-8">
                    {[
                      { icon: "workspace_premium", text: "Garansi 2 Tahun" },
                      { icon: "payments", text: "Harga Transparan" },
                      { icon: "local_shipping", text: "Gratis Ongkir ≥20jt" },
                      { icon: "handyman", text: "Tukang Profesional" },
                    ].map((item, idx) => (
                      <div key={idx} className="flex items-center gap-3 text-gray-300">
                        <span className="material-symbols-outlined text-[#ffb204] text-xl">{item.icon}</span>
                        <span className="text-sm">{item.text}</span>
                      </div>
                    ))}
                  </div>

                  <Link
                    href="#contact"
                    className="w-full h-12 flex items-center justify-center gap-2 bg-white/10 border border-white/10 rounded-xl text-white font-semibold hover:bg-white/20 transition-all"
                  >
                    <span className="material-symbols-outlined">chat</span>
                    Hubungi Kami
                  </Link>
                </div>

                {/* Background Pattern */}
                <div className="absolute bottom-0 right-0 w-32 h-32 opacity-5">
                  <svg viewBox="0 0 100 100" fill="currentColor" className="w-full h-full text-white">
                    <path d="M50 5L5 30v40l45 25 45-25V30L50 5z"/>
                  </svg>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      {/* Slide Indicators */}
      <div className="absolute bottom-10 left-1/2 -translate-x-1/2 z-20 flex items-center gap-3">
        {heroImages.map((_, idx) => (
          <button
            key={idx}
            onClick={() => setCurrentBg(idx)}
            className={`transition-all duration-300 rounded-full ${
              currentBg === idx
                ? "w-8 h-2 bg-[#ffb204]"
                : "w-2 h-2 bg-white/30 hover:bg-white/50"
            }`}
            aria-label={`Slide ${idx + 1}`}
          />
        ))}
      </div>

      {/* Scroll Indicator - Hide on low end / reduced motion */}
      {!shouldReduceAnimations && (
        <div className="absolute bottom-10 right-10 z-20 hidden lg:flex flex-col items-center gap-2">
          <div className="w-px h-16 bg-linear-to-b from-transparent via-white/30 to-transparent relative overflow-hidden">
            <div className="absolute top-0 left-0 w-full h-1/2 bg-[#ffb204] animate-scroll-down"></div>
          </div>
          <span className="text-[9px] uppercase tracking-[0.3em] text-white/50 rotate-90 origin-center translate-y-6">
            Scroll
          </span>
        </div>
      )}

      {/* Mobile Bottom Gradient */}
      <div className="absolute bottom-0 left-0 right-0 h-32 bg-linear-to-t from-[#0a0c10] to-transparent z-10 pointer-events-none"></div>

      <style jsx>{`
        @keyframes scroll-down {
          0% { transform: translateY(-100%); }
          100% { transform: translateY(200%); }
        }
        .animate-scroll-down {
          animation: scroll-down 2s ease-in-out infinite;
        }
      `}</style>
    </section>
  );
}
