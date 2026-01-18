"use client";

import Image from "next/image";
import Link from "next/link";
import { usePerformance } from "@/hooks/usePerformance";

interface Portfolio {
  id: number;
  title: string;
  category: string;
  image: string;
}

interface PortfolioSectionProps {
  portfolios: Portfolio[];
}

// Grid layout configurations for each item
const gridConfigs = [
  { colSpan: "lg:col-span-2", rowSpan: "lg:row-span-2", aspect: "aspect-square lg:aspect-auto" }, // Large featured
  { colSpan: "", rowSpan: "", aspect: "aspect-[4/5]" }, // Normal tall
  { colSpan: "", rowSpan: "", aspect: "aspect-[4/5]" }, // Normal tall
  { colSpan: "", rowSpan: "", aspect: "aspect-[4/3]" }, // Normal wide
  { colSpan: "lg:col-span-2", rowSpan: "", aspect: "aspect-[4/3] lg:aspect-[21/9]" }, // Wide panoramic
  { colSpan: "", rowSpan: "", aspect: "aspect-[4/3]" }, // Normal wide
];

export default function PortfolioSection({ portfolios }: PortfolioSectionProps) {
  const { isLowEnd, shouldReduceAnimations } = usePerformance();

  const fallbackImages = [
    "https://images.unsplash.com/photo-1600210492486-724fe5c67fb0?auto=format&fit=crop&w=1200&q=80",
    "https://images.unsplash.com/photo-1497366216548-37526070297c?auto=format&fit=crop&w=800&q=80",
    "https://images.unsplash.com/photo-1616594039964-ae9021a400a0?auto=format&fit=crop&w=800&q=80",
    "https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?auto=format&fit=crop&w=800&q=80",
    "https://images.unsplash.com/photo-1617806118233-18e1de247200?auto=format&fit=crop&w=1200&q=80",
    "https://images.unsplash.com/photo-1618221195710-dd6b41faaea6?auto=format&fit=crop&w=800&q=80",
  ];

  const defaultPortfolios: Portfolio[] = [
    { id: 1, title: "The Penthouse Edit", category: "Residensial", image: fallbackImages[0] },
    { id: 2, title: "Executive Study", category: "Kantor", image: fallbackImages[1] },
    { id: 3, title: "Serene Master Suite", category: "Residensial", image: fallbackImages[2] },
    { id: 4, title: "Marble & Gold Kitchen", category: "Dapur", image: fallbackImages[3] },
    { id: 5, title: "The Grand Hall", category: "Ruang Makan", image: fallbackImages[4] },
    { id: 6, title: "Modern Living Space", category: "Residensial", image: fallbackImages[5] },
  ];

  const items = portfolios.length > 0 ? portfolios : defaultPortfolios;

  return (
    <section className="py-16 md:py-24 lg:py-32 bg-[#0a0c10] relative overflow-hidden" id="portfolio">
      {/* Background Decorations - Disable on low end for performance */}
      {!isLowEnd && (
        <div className="absolute inset-0 pointer-events-none">
          <div className="absolute top-1/4 right-0 w-80 h-80 bg-[#ffb204]/5 rounded-full blur-[150px]"></div>
          <div className="absolute bottom-1/4 left-0 w-64 h-64 bg-[#ffb204]/3 rounded-full blur-[120px]"></div>
        </div>
      )}

      <div className="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {/* Section Header */}
        <div className="flex flex-col md:flex-row md:items-end justify-between gap-6 md:gap-8 mb-10 md:mb-16">
          <div data-aos="fade-right">
            <div className="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-[#ffb204]/10 border border-[#ffb204]/30 mb-4">
              <span className="material-symbols-outlined text-[#ffb204] text-base">photo_library</span>
              <span className="text-[#ffb204] text-[10px] font-bold uppercase tracking-[0.2em]">Portfolio</span>
            </div>
            <h2 className="text-3xl sm:text-4xl md:text-5xl lg:text-6xl text-white font-serif mb-4">
              Karya <span className="text-[#ffb204] italic">Terbaik</span>
            </h2>
            <p className="text-gray-400 max-w-md text-sm sm:text-base leading-relaxed">
              Jelajahi koleksi proyek pilihan kami yang menampilkan komitmen pada keanggunan dan detail.
            </p>
          </div>
          <Link
            href="/portfolio"
            className="self-start md:self-auto inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white hover:bg-[#ffb204] hover:text-black hover:border-[#ffb204] transition-all duration-300 text-sm font-semibold"
            data-aos="fade-left"
          >
            Lihat Semua
            <span className="material-symbols-outlined text-lg">arrow_forward</span>
          </Link>
        </div>

        {/* Bento Grid */}
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-5 lg:gap-6 auto-rows-[200px] sm:auto-rows-[220px] lg:auto-rows-[180px]">
          {items.slice(0, 6).map((portfolio, index) => {
            const imageSrc = portfolio.image || fallbackImages[index % fallbackImages.length];
            const config = gridConfigs[index] || gridConfigs[0];
            const isLarge = index === 0;
            const isWide = index === 4;

            return (
              <div
                key={portfolio.id}
                className={`group relative overflow-hidden rounded-2xl sm:rounded-3xl cursor-pointer ${config.colSpan} ${config.rowSpan} max-lg:opacity-100! max-lg:transform-none!`}
                data-aos={shouldReduceAnimations ? "" : "fade-up"}
                data-aos-delay={shouldReduceAnimations ? 0 : index * 80}
              >
                {/* Image Container */}
                <div className={`relative w-full h-full min-h-[200px] ${isLarge ? 'lg:min-h-[380px]' : ''} ${isWide ? 'lg:min-h-[180px]' : ''}`}>
                  <Image
                    alt={portfolio.title}
                    src={imageSrc}
                    fill
                    sizes="(max-width: 768px) 100vw, (max-width: 1200px) 50vw, 33vw"
                    className={`object-cover transition-transform duration-700 ease-out ${!isLowEnd ? 'group-hover:scale-110' : ''}`}
                    unoptimized={false}
                  />
                  
                  {/* Gradient Overlay - Simplified for low end */}
                  <div className={`absolute inset-0 bg-linear-to-t from-black/80 via-black/20 to-transparent transition-opacity duration-500 ${isLowEnd ? 'opacity-70' : 'opacity-60 group-hover:opacity-90'}`}></div>

                  {/* Glow Border - Disable on low end */}
                  {!isLowEnd && (
                    <div className="absolute inset-0 rounded-2xl sm:rounded-3xl border-2 border-transparent group-hover:border-[#ffb204]/40 transition-all duration-500"></div>
                  )}

                  {/* Category Badge */}
                  <div className="absolute top-3 left-3 sm:top-4 sm:left-4">
                    <span className={`inline-flex items-center gap-1.5 px-2.5 py-1 sm:px-3 sm:py-1.5 rounded-full border border-white/10 text-[10px] sm:text-xs text-[#ffb204] font-bold uppercase tracking-wider ${isLowEnd ? 'bg-black/80' : 'bg-black/40 backdrop-blur-sm'}`}>
                      {portfolio.category || "Interior"}
                    </span>
                  </div>

                  {/* Content */}
                  <div className="absolute inset-x-0 bottom-0 p-4 sm:p-5 lg:p-6">
                    <h3 className={`text-white font-serif italic transition-transform duration-500 ${!shouldReduceAnimations ? 'group-hover:translate-y-0 translate-y-1' : ''} ${
                      isLarge ? 'text-xl sm:text-2xl lg:text-3xl' : 'text-lg sm:text-xl lg:text-2xl'
                    }`}>
                      {portfolio.title}
                    </h3>
                    
                    {/* View Button - Disable animation logic on low end */}
                    {!isLowEnd && (
                      <div className="mt-3 opacity-0 translate-y-4 group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-500">
                        <span className="inline-flex items-center gap-2 px-4 py-2 bg-[#ffb204] text-black rounded-lg text-xs font-bold uppercase tracking-wider hover:bg-white transition-colors">
                          <span className="material-symbols-outlined text-sm">visibility</span>
                          Lihat
                        </span>
                      </div>
                    )}
                  </div>

                  {/* Corner Accent - Hide on low end */}
                  {!isLowEnd && (
                    <div className="absolute top-3 right-3 sm:top-4 sm:right-4 opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                      <div className="w-6 h-6 sm:w-8 sm:h-8 border-t-2 border-r-2 border-[#ffb204]/50 rounded-tr-lg"></div>
                    </div>
                  )}

                  {/* Index Number */}
                  <div className={`absolute bottom-3 right-3 sm:bottom-4 sm:right-4 opacity-20 transition-opacity duration-500 ${!isLowEnd ? 'group-hover:opacity-40' : ''}`}>
                    <span className={`font-bold text-white/50 font-serif ${isLarge ? 'text-4xl sm:text-5xl lg:text-6xl' : 'text-3xl sm:text-4xl'}`}>
                      {String(index + 1).padStart(2, '0')}
                    </span>
                  </div>
                </div>
              </div>
            );
          })}
        </div>

        {/* Mobile CTA */}
        <div className="mt-10 text-center md:hidden">
          <Link
            href="/portfolio"
            className="inline-flex items-center justify-center gap-2 h-12 px-8 bg-[#ffb204] text-black font-bold rounded-xl transition-all hover:shadow-lg hover:shadow-[#ffb204]/30"
          >
            <span className="material-symbols-outlined">photo_library</span>
            Lihat Semua Portfolio
          </Link>
        </div>
      </div>
    </section>
  );
}
