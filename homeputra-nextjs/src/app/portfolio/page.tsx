import { Metadata } from "next";
import Image from "next/image";
import Link from "next/link";
import { query } from "@/lib/db";
import { Portfolio } from "@/types";

export const metadata: Metadata = {
  title: "Portfolio",
  description: "Jelajahi koleksi proyek desain interior pilihan kami",
};

async function getPortfolios(): Promise<Portfolio[]> {
  try {
    return await query<Portfolio[]>(
      "SELECT * FROM portfolio WHERE is_active = 1 ORDER BY display_order ASC, created_at DESC"
    );
  } catch {
    return [];
  }
}

export default async function PortfolioPage() {
  const portfolios = await getPortfolios();

  const fallbackImages = [
    "https://images.unsplash.com/photo-1600210492486-724fe5c67fb0?auto=format&fit=crop&w=800&q=80",
    "https://images.unsplash.com/photo-1497366216548-37526070297c?auto=format&fit=crop&w=800&q=80",
    "https://images.unsplash.com/photo-1616594039964-ae9021a400a0?auto=format&fit=crop&w=800&q=80",
    "https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?auto=format&fit=crop&w=800&q=80",
    "https://images.unsplash.com/photo-1617806118233-18e1de247200?auto=format&fit=crop&w=800&q=80",
    "https://images.unsplash.com/photo-1618221195710-dd6b41faaea6?auto=format&fit=crop&w=800&q=80",
  ];

  const defaultPortfolios: Portfolio[] = [
    { id: 1, title: "The Penthouse Edit", category: "Residensial", description: "", image: fallbackImages[0], display_order: 1, is_featured: 1, is_active: 1, created_at: "", updated_at: "" },
    { id: 2, title: "Executive Study", category: "Kantor", description: "", image: fallbackImages[1], display_order: 2, is_featured: 1, is_active: 1, created_at: "", updated_at: "" },
    { id: 3, title: "Serene Master Suite", category: "Residensial", description: "", image: fallbackImages[2], display_order: 3, is_featured: 1, is_active: 1, created_at: "", updated_at: "" },
    { id: 4, title: "Marble & Gold Kitchen", category: "Dapur", description: "", image: fallbackImages[3], display_order: 4, is_featured: 1, is_active: 1, created_at: "", updated_at: "" },
    { id: 5, title: "The Grand Hall", category: "Ruang Makan", description: "", image: fallbackImages[4], display_order: 5, is_featured: 1, is_active: 1, created_at: "", updated_at: "" },
    { id: 6, title: "Modern Living Space", category: "Residensial", description: "", image: fallbackImages[5], display_order: 6, is_featured: 1, is_active: 1, created_at: "", updated_at: "" },
  ];

  const items = portfolios.length > 0 ? portfolios : defaultPortfolios;

  return (
    <div className="min-h-screen bg-[#0B0D11] pt-24">
      {/* Hero */}
      <section className="py-16 md:py-24 relative overflow-hidden">
        <div className="absolute inset-0 pointer-events-none">
          <div className="absolute top-0 right-0 w-96 h-96 bg-[#ffb204]/10 blur-[150px] rounded-full"></div>
        </div>

        <div className="max-w-[1200px] mx-auto px-6 relative z-10">
          <div className="text-center" data-aos="fade-up">
            <div className="inline-flex items-center gap-3 px-5 py-2.5 bg-[#ffb204]/10 border border-[#ffb204]/20 rounded-full mb-6">
              <span className="w-1.5 h-1.5 bg-[#ffb204] rounded-full animate-pulse"></span>
              <span className="text-[#ffb204] text-[10px] font-bold uppercase tracking-[0.2em]">
                Karya Kami
              </span>
            </div>
            <h1 className="text-4xl md:text-5xl lg:text-6xl text-white font-serif mb-6">
              Portfolio{" "}
              <span className="text-transparent bg-clip-text bg-linear-to-r from-[#ffb204] via-yellow-400 to-[#ffb204]">
                Pilihan
              </span>
            </h1>
            <p className="text-gray-400 max-w-2xl mx-auto text-base md:text-lg font-light leading-relaxed">
              Jelajahi koleksi proyek pilihan kami yang menampilkan komitmen
              kami pada keanggunan dan detail
            </p>
          </div>
        </div>
      </section>

      {/* Portfolio Grid */}
      <section className="py-12 md:py-20">
        <div className="max-w-[1400px] mx-auto px-6">
          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
            {items.map((portfolio, index) => {
              const imageSrc = portfolio.image || fallbackImages[index % fallbackImages.length];

              return (
                <div
                  key={portfolio.id}
                  className="group relative overflow-hidden rounded-2xl cursor-pointer img-hover-zoom card-hover max-lg:opacity-100! max-lg:transform-none!"
                  data-aos="fade-up"
                  data-aos-delay={index > 0 ? (index % 3) * 100 : undefined}
                >
                  <div className="relative aspect-4/5 w-full">
                    <Image
                      alt={portfolio.title}
                      className="object-cover"
                      src={imageSrc}
                      fill
                      sizes="(max-width: 640px) 100vw, (max-width: 1024px) 50vw, 33vw"
                      unoptimized={false}
                    />
                  </div>
                  <div className="absolute inset-0 bg-linear-to-t from-black/90 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex flex-col justify-end p-8">
                    <span className="text-[#ffb204] text-[10px] uppercase tracking-[0.3em] font-bold mb-2">
                      {portfolio.category || "Interior"}
                    </span>
                    <h3 className="text-2xl md:text-3xl text-white italic font-serif mb-3">
                      {portfolio.title}
                    </h3>
                    {portfolio.description && (
                      <p className="text-gray-400 text-sm font-light line-clamp-2">
                        {portfolio.description}
                      </p>
                    )}
                  </div>
                </div>
              );
            })}
          </div>
        </div>
      </section>

      {/* CTA */}
      <section className="py-16 md:py-24">
        <div className="max-w-[800px] mx-auto px-6 text-center">
          <h2 className="text-3xl md:text-4xl text-white font-serif mb-6">
            Siap Untuk Proyek Anda?
          </h2>
          <p className="text-gray-400 mb-8 font-light">
            Konsultasi gratis dengan tim desainer profesional kami
          </p>
          <Link
            href="/#contact"
            className="inline-flex items-center gap-3 px-10 py-5 bg-linear-to-r from-[#ffb204] to-yellow-500 text-black rounded-xl font-bold text-sm uppercase tracking-wider hover:shadow-2xl hover:shadow-[#ffb204]/40 transition-all"
          >
            <span className="material-symbols-outlined">chat</span>
            Mulai Konsultasi
          </Link>
        </div>
      </section>
    </div>
  );
}
