import { getInitials } from "@/lib/helpers";

interface Testimonial {
  id: number;
  client_name: string;
  client_location: string;
  client_image: string;
  testimonial_text: string;
  rating: number;
}

interface TestimonialsSectionProps {
  testimonials: Testimonial[];
}

export default function TestimonialsSection({
  testimonials,
}: TestimonialsSectionProps) {
  const defaultTestimonials: Testimonial[] = [
    {
      id: 1,
      client_name: "Sarah Putri",
      client_location: "Jakarta Selatan",
      client_image: "",
      testimonial_text:
        "Home Putra Interior mengubah apartemen kami menjadi tempat tinggal yang penuh cahaya. Perhatian terhadap detail sungguh luar biasa dan hasilnya melebihi ekspektasi.",
      rating: 5,
    },
    {
      id: 2,
      client_name: "Michael Hartono",
      client_location: "Surabaya",
      client_image: "",
      testimonial_text:
        "Tim yang sangat profesional! Ruang kerja kayu oak hangat sekarang menjadi ruangan favorit saya. Prosesnya lancar dan komunikatif.",
      rating: 5,
    },
    {
      id: 3,
      client_name: "Lisa Wijaya",
      client_location: "Bandung",
      client_image: "",
      testimonial_text:
        "Profesional, tepat waktu, dan sangat berbakat. Mereka mengelola semuanya mulai dari desain hingga instalasi dengan sempurna.",
      rating: 5,
    },
    {
      id: 4,
      client_name: "Budi Santoso",
      client_location: "Malang",
      client_image: "",
      testimonial_text:
        "Kitchen set aluminium yang dibuat sangat presisi dan berkualitas tinggi. Garansi 2 tahun membuat kami tenang. Highly recommended!",
      rating: 5,
    },
    {
      id: 5,
      client_name: "Dewi Anggara",
      client_location: "Sidoarjo",
      client_image: "",
      testimonial_text:
        "Lemari sliding yang dibuatkan sangat fungsional dan elegan. Tim instalasi sangat rapi dan bersih dalam bekerja.",
      rating: 5,
    },
  ];

  const items = testimonials.length > 0 ? testimonials : defaultTestimonials;
  const doubledItems = [...items, ...items];
  const reversedDoubledItems = [...items].reverse().concat([...items].reverse());

  const TestimonialCard = ({ t }: { t: Testimonial }) => (
    <div className="testimonial-card">
      <div className="testimonial-card-inner">
        {/* Quote Icon & Rating */}
        <div className="flex items-start justify-between mb-6">
          <div className="w-12 h-12 rounded-xl bg-gradient-to-br from-[#ffb204]/30 to-[#ffb204]/10 flex items-center justify-center">
            <span className="material-symbols-outlined text-[#ffb204] text-2xl">
              format_quote
            </span>
          </div>
          <div className="flex items-center gap-1">
            {[...Array(t.rating || 5)].map((_, i) => (
              <span
                key={i}
                className="material-symbols-outlined text-[#ffb204] text-sm"
              >
                star
              </span>
            ))}
          </div>
        </div>

        {/* Testimonial Text */}
        <p className="text-gray-300 text-base leading-relaxed mb-6 line-clamp-4 font-light italic">
          &ldquo;{t.testimonial_text}&rdquo;
        </p>

        {/* Client Info */}
        <div className="flex items-center gap-4 pt-6 border-t border-white/[0.06]">
          <div className="w-12 h-12 rounded-full bg-gradient-to-br from-[#ffb204] to-yellow-600 flex items-center justify-center text-black font-bold shadow-lg shadow-[#ffb204]/30">
            {t.client_image ? (
              // eslint-disable-next-line @next/next/no-img-element
              <img
                src={t.client_image}
                alt={t.client_name}
                className="w-full h-full object-cover rounded-full"
              />
            ) : (
              getInitials(t.client_name)
            )}
          </div>
          <div>
            <p className="text-white font-semibold">{t.client_name}</p>
            <p className="text-gray-500 text-xs uppercase tracking-wider">
              {t.client_location || ""}
            </p>
          </div>
          <span className="ml-auto material-symbols-outlined text-green-400 text-xl">
            verified
          </span>
        </div>
      </div>
    </div>
  );

  return (
    <section
      className="py-24 md:py-32 lg:py-40 bg-[#0a0c10] relative overflow-hidden"
      id="testimonials"
    >
      {/* Background Effects */}
      <div className="absolute inset-0 pointer-events-none">
        <div className="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[500px] bg-[#ffb204]/5 blur-[150px] rounded-full"></div>
        <div className="absolute bottom-0 left-0 w-96 h-96 bg-[#ffb204]/5 blur-[100px] rounded-full"></div>
      </div>

      <div className="relative z-10">
        {/* Premium Header */}
        <div className="text-center mb-16 md:mb-20 px-6" data-aos="fade-up">
          <div className="inline-flex items-center gap-3 px-5 py-2.5 bg-[#ffb204]/10 border border-[#ffb204]/20 rounded-full mb-6">
            <span className="material-symbols-outlined text-[#ffb204] text-lg">
              format_quote
            </span>
            <span className="text-[#ffb204] text-[10px] font-bold uppercase tracking-[0.2em]">
              Testimonial
            </span>
          </div>
          <h2 className="text-4xl md:text-5xl lg:text-6xl text-white font-serif mb-6">
            Apa Kata{" "}
            <span className="text-transparent bg-clip-text bg-gradient-to-r from-[#ffb204] via-yellow-400 to-[#ffb204] italic">
              Klien
            </span>{" "}
            Kami
          </h2>
          <p className="text-gray-400 max-w-2xl mx-auto text-base md:text-lg font-light leading-relaxed">
            Kepuasan klien adalah prioritas utama kami. Dengarkan pengalaman
            mereka bekerja bersama Home Putra Interior
          </p>
        </div>

        {/* Rating Summary */}
        <div className="max-w-4xl mx-auto px-6 mb-16" data-aos="fade-up">
          <div className="flex flex-col md:flex-row items-center justify-center gap-8 md:gap-16 p-8 bg-gradient-to-r from-white/[0.05] via-white/[0.02] to-white/[0.05] border border-white/[0.08] rounded-2xl">
            <div className="text-center">
              <div className="text-5xl md:text-6xl font-serif text-white font-bold mb-2">
                4.9
              </div>
              <div className="flex items-center justify-center gap-1 mb-2">
                {[...Array(5)].map((_, i) => (
                  <span
                    key={i}
                    className="material-symbols-outlined text-[#ffb204] text-lg"
                  >
                    star
                  </span>
                ))}
              </div>
              <div className="text-gray-500 text-xs uppercase tracking-wider">
                Rating Rata-rata
              </div>
            </div>
            <div className="hidden md:block w-px h-20 bg-white/10"></div>
            <div className="flex items-center gap-8 text-center">
              <div>
                <div className="text-3xl md:text-4xl font-serif text-white font-bold">
                  500+
                </div>
                <div className="text-gray-500 text-xs uppercase tracking-wider mt-1">
                  Proyek
                </div>
              </div>
              <div>
                <div className="text-3xl md:text-4xl font-serif text-white font-bold">
                  98%
                </div>
                <div className="text-gray-500 text-xs uppercase tracking-wider mt-1">
                  Kepuasan
                </div>
              </div>
              <div>
                <div className="text-3xl md:text-4xl font-serif text-white font-bold">
                  12+
                </div>
                <div className="text-gray-500 text-xs uppercase tracking-wider mt-1">
                  Tahun
                </div>
              </div>
            </div>
          </div>
        </div>

        {/* Marquee Row 1 - Scroll Left */}
        <div className="marquee-wrapper marquee-left mb-6" data-aos="fade-up">
          <div className="testimonial-track py-4">
            {doubledItems.map((t, index) => (
              <TestimonialCard key={`left-${t.id}-${index}`} t={t} />
            ))}
          </div>
        </div>

        {/* Marquee Row 2 - Scroll Right */}
        <div
          className="marquee-wrapper marquee-right"
          data-aos="fade-up"
          data-aos-delay="100"
        >
          <div className="testimonial-track py-4">
            {reversedDoubledItems.map((t, index) => (
              <TestimonialCard key={`right-${t.id}-${index}`} t={t} />
            ))}
          </div>
        </div>

        {/* Trust Badges */}
        <div className="max-w-[1200px] mx-auto px-6 mt-20 md:mt-24">
          <div className="text-center" data-aos="fade-up">
            <p className="text-gray-500 text-[10px] uppercase tracking-[0.2em] font-bold mb-10">
              Platform Terpercaya
            </p>
            <div className="flex flex-wrap justify-center items-center gap-8 md:gap-12">
              {[
                { icon: "verified", label: "Google Review" },
                { icon: "storefront", label: "Tokopedia" },
                { icon: "shopping_bag", label: "Shopee" },
                { icon: "thumb_up", label: "Facebook" },
                { icon: "photo_camera", label: "Instagram" },
              ].map((platform) => (
                <div
                  key={platform.label}
                  className="group flex flex-col items-center gap-2 opacity-40 hover:opacity-100 transition-all cursor-default"
                >
                  <span className="material-symbols-outlined text-4xl text-gray-400 group-hover:text-[#ffb204] transition-colors">
                    {platform.icon}
                  </span>
                  <span className="text-xs text-gray-500 group-hover:text-white transition-colors">
                    {platform.label}
                  </span>
                </div>
              ))}
            </div>
          </div>
        </div>
      </div>
    </section>
  );
}
