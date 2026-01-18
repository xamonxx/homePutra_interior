import { Metadata } from "next";
import Link from "next/link";
import { query } from "@/lib/db";
import { Service } from "@/types";
import { getServiceMaterialIcon } from "@/lib/helpers";

export const metadata: Metadata = {
  title: "Layanan",
  description: "Layanan desain interior premium untuk mewujudkan ruang impian Anda",
};

async function getServices(): Promise<Service[]> {
  try {
    return await query<Service[]>(
      "SELECT * FROM services WHERE is_active = 1 ORDER BY display_order ASC"
    );
  } catch {
    return [];
  }
}

export default async function ServicesPage() {
  const services = await getServices();

  const defaultServices: Service[] = [
    {
      id: 1,
      title: "Desain Residensial",
      description: "Renovasi skala penuh dan desain bangunan baru untuk rumah mewah, fokus pada aliran ruang, pencahayaan, dan materialitas.",
      icon: "home",
      display_order: 1,
      is_active: 1,
    },
    {
      id: 2,
      title: "Ruang Komersial",
      description: "Menciptakan pengalaman brand yang berdampak melalui desain tata ruang cerdas untuk ritel, perhotelan, dan kantor.",
      icon: "storefront",
      display_order: 2,
      is_active: 1,
    },
    {
      id: 3,
      title: "Furniture Custom",
      description: "Desain dan koordinasi fabrikasi furniture eksklusif untuk memastikan setiap produk cocok sempurna dengan ruang Anda.",
      icon: "chair",
      display_order: 3,
      is_active: 1,
    },
    {
      id: 4,
      title: "Konsultasi Desain",
      description: "Konsultasi profesional untuk membantu Anda merencanakan proyek interior dengan budget dan timeline yang tepat.",
      icon: "chat",
      display_order: 4,
      is_active: 1,
    },
  ];

  const items = services.length > 0 ? services : defaultServices;

  return (
    <div className="min-h-screen bg-[#0B0D11] pt-24">
      {/* Hero */}
      <section className="py-16 md:py-24 relative overflow-hidden">
        <div className="absolute inset-0 pointer-events-none">
          <div className="absolute top-0 left-0 w-96 h-96 bg-[#ffb204]/10 blur-[150px] rounded-full"></div>
        </div>

        <div className="max-w-[1200px] mx-auto px-6 relative z-10">
          <div className="text-center" data-aos="fade-up">
            <div className="inline-flex items-center gap-3 px-5 py-2.5 bg-[#ffb204]/10 border border-[#ffb204]/20 rounded-full mb-6">
              <span className="w-1.5 h-1.5 bg-[#ffb204] rounded-full animate-pulse"></span>
              <span className="text-[#ffb204] text-[10px] font-bold uppercase tracking-[0.2em]">
                Layanan Kami
              </span>
            </div>
            <h1 className="text-4xl md:text-5xl lg:text-6xl text-white font-serif mb-6">
              Solusi{" "}
              <span className="text-transparent bg-clip-text bg-gradient-to-r from-[#ffb204] via-yellow-400 to-[#ffb204]">
                Interior
              </span>{" "}
              Lengkap
            </h1>
            <p className="text-gray-400 max-w-2xl mx-auto text-base md:text-lg font-light leading-relaxed">
              Dari konsep hingga realisasi, kami menghadirkan keahlian desain
              interior premium untuk mewujudkan ruang impian Anda
            </p>
          </div>
        </div>
      </section>

      {/* Services Grid */}
      <section className="py-12 md:py-20">
        <div className="max-w-[1200px] mx-auto px-6">
          <div className="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-8">
            {items.map((service, index) => (
              <div
                key={service.id}
                className="group relative p-8 md:p-10 bg-gradient-to-br from-white/[0.06] to-transparent border border-white/[0.08] rounded-2xl hover:border-[#ffb204]/30 transition-all duration-500"
                data-aos="fade-up"
                data-aos-delay={index * 100}
              >
                <div className="absolute inset-0 bg-gradient-to-br from-[#ffb204]/5 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 rounded-2xl"></div>

                <div className="relative z-10">
                  <div className="w-20 h-20 rounded-2xl bg-gradient-to-br from-[#ffb204]/20 to-[#ffb204]/5 border border-[#ffb204]/20 flex items-center justify-center mb-8 group-hover:scale-110 transition-transform duration-300">
                    <span className="material-symbols-outlined text-[#ffb204] text-4xl">
                      {getServiceMaterialIcon(service.icon)}
                    </span>
                  </div>

                  <h3 className="text-2xl md:text-3xl text-white mb-4 font-semibold group-hover:text-[#ffb204] transition-colors">
                    {service.title}
                  </h3>
                  <p className="text-gray-400 leading-relaxed mb-6">
                    {service.description}
                  </p>

                  <Link
                    href="/#contact"
                    className="inline-flex items-center gap-2 text-[#ffb204] text-sm uppercase tracking-widest font-bold group-hover:gap-3 transition-all"
                  >
                    Konsultasi
                    <span className="material-symbols-outlined text-base">
                      arrow_forward
                    </span>
                  </Link>
                </div>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* Process Section */}
      <section className="py-16 md:py-24 bg-[#0a0c10]">
        <div className="max-w-[1200px] mx-auto px-6">
          <div className="text-center mb-16" data-aos="fade-up">
            <div className="inline-flex items-center gap-3 px-5 py-2.5 bg-[#ffb204]/10 border border-[#ffb204]/20 rounded-full mb-6">
              <span className="text-[#ffb204] text-[10px] font-bold uppercase tracking-[0.2em]">
                Proses Kami
              </span>
            </div>
            <h2 className="text-3xl md:text-4xl text-white font-serif">
              4 Langkah Menuju Interior Impian
            </h2>
          </div>

          <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            {[
              { num: "01", title: "Konsultasi", desc: "Diskusi kebutuhan dan budget proyek Anda" },
              { num: "02", title: "Desain", desc: "Pembuatan konsep dan visualisasi 3D" },
              { num: "03", title: "Produksi", desc: "Fabrikasi dengan material berkualitas" },
              { num: "04", title: "Instalasi", desc: "Pemasangan rapi dan bergaransi" },
            ].map((step, index) => (
              <div
                key={step.num}
                className="text-center group"
                data-aos="fade-up"
                data-aos-delay={index * 100}
              >
                <div className="relative inline-flex items-center justify-center w-24 h-24 rounded-full bg-[#12151c] mb-6 group-hover:scale-110 transition-transform duration-300">
                  <div className="absolute inset-0 rounded-full border-2 border-[#ffb204]/40 group-hover:border-[#ffb204] transition-colors"></div>
                  <div className="absolute inset-2 rounded-full bg-gradient-to-br from-[#ffb204]/20 to-transparent"></div>
                  <span className="relative text-3xl font-serif text-[#ffb204] font-bold">
                    {step.num}
                  </span>
                </div>
                <h4 className="text-white font-semibold text-xl mb-3 group-hover:text-[#ffb204] transition-colors">
                  {step.title}
                </h4>
                <p className="text-gray-500 font-light">
                  {step.desc}
                </p>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* CTA */}
      <section className="py-16 md:py-24">
        <div className="max-w-[800px] mx-auto px-6 text-center">
          <h2 className="text-3xl md:text-4xl text-white font-serif mb-6">
            Siap Wujudkan Interior Impian?
          </h2>
          <p className="text-gray-400 mb-8 font-light">
            Konsultasi gratis dengan tim desainer profesional kami
          </p>
          <div className="flex flex-col sm:flex-row gap-4 justify-center">
            <Link
              href="/#contact"
              className="inline-flex items-center justify-center gap-3 px-10 py-5 bg-gradient-to-r from-[#ffb204] to-yellow-500 text-black rounded-xl font-bold text-sm uppercase tracking-wider hover:shadow-2xl hover:shadow-[#ffb204]/40 transition-all"
            >
              <span className="material-symbols-outlined">chat</span>
              Konsultasi Gratis
            </Link>
            <Link
              href="/calculator"
              className="inline-flex items-center justify-center gap-3 px-10 py-5 bg-white/10 border border-white/20 text-white rounded-xl font-bold text-sm uppercase tracking-wider hover:bg-white/20 transition-all"
            >
              <span className="material-symbols-outlined">calculate</span>
              Hitung Estimasi
            </Link>
          </div>
        </div>
      </section>
    </div>
  );
}
