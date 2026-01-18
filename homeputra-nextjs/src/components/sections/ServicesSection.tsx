import Link from "next/link";
import { getServiceMaterialIcon } from "@/lib/helpers";

interface Service {
  id: number;
  title: string;
  description: string;
  icon: string;
}

interface ServicesSectionProps {
  services: Service[];
}

export default function ServicesSection({ services }: ServicesSectionProps) {
  const defaultServices: Service[] = [
    {
      id: 1,
      title: "Desain Residensial",
      description:
        "Renovasi skala penuh dan desain bangunan baru untuk rumah mewah, fokus pada aliran ruang, pencahayaan, dan materialitas.",
      icon: "home",
    },
    {
      id: 2,
      title: "Ruang Komersial",
      description:
        "Menciptakan pengalaman brand yang berdampak melalui desain tata ruang cerdas untuk ritel, perhotelan, dan kantor.",
      icon: "storefront",
    },
    {
      id: 3,
      title: "Furniture Custom",
      description:
        "Desain dan koordinasi fabrikasi furniture eksklusif untuk memastikan setiap produk cocok sempurna dengan ruang Anda.",
      icon: "chair",
    },
    {
      id: 4,
      title: "Konsultasi Desain",
      description:
        "Konsultasi profesional untuk membantu Anda merencanakan proyek interior dengan budget dan timeline yang tepat.",
      icon: "chat",
    },
  ];

  const items = services.length > 0 ? services : defaultServices;

  return (
    <section
      className="py-24 md:py-32 lg:py-40 bg-[#0a0c10] relative overflow-hidden"
      id="services"
    >
      {/* Background Effects */}
      <div className="absolute inset-0 pointer-events-none">
        <div className="absolute top-0 left-0 w-96 h-96 bg-[#ffb204]/10 blur-[150px] rounded-full"></div>
        <div className="absolute bottom-0 right-0 w-80 h-80 bg-[#ffb204]/5 blur-[120px] rounded-full"></div>
        <div
          className="absolute inset-0 opacity-[0.02]"
          style={{
            backgroundImage:
              "linear-gradient(rgba(255,255,255,.1) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,.1) 1px, transparent 1px)",
            backgroundSize: "60px 60px",
          }}
        ></div>
      </div>

      <div className="max-w-[1200px] mx-auto px-6 relative z-10">
        {/* Premium Header */}
        <div className="text-center mb-16 md:mb-20" data-aos="fade-up">
          <div className="inline-flex items-center gap-3 px-5 py-2.5 bg-[#ffb204]/10 border border-[#ffb204]/20 rounded-full mb-6">
            <span className="w-1.5 h-1.5 bg-[#ffb204] rounded-full animate-pulse"></span>
            <span className="text-[#ffb204] text-[10px] font-bold uppercase tracking-[0.2em]">
              Layanan Kami
            </span>
          </div>
          <h2 className="text-4xl md:text-5xl lg:text-6xl text-white font-serif mb-6">
            Solusi{" "}
            <span className="text-transparent bg-clip-text bg-gradient-to-r from-[#ffb204] via-yellow-400 to-[#ffb204]">
              Interior
            </span>{" "}
            Lengkap
          </h2>
          <p className="text-gray-400 max-w-2xl mx-auto text-base md:text-lg font-light leading-relaxed">
            Dari konsep hingga realisasi, kami menghadirkan keahlian desain
            interior premium untuk mewujudkan ruang impian Anda
          </p>
        </div>

        {/* Services Grid */}
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
          {items.map((service, index) => (
            <div
              key={service.id}
              className="group relative cursor-pointer"
              data-aos="fade-up"
              data-aos-delay={index * 100}
            >
              {/* Card Container */}
              <div className="relative h-full transition-all duration-300 ease-out group-hover:-translate-y-2">
                {/* Glowing Border Effect */}
                <div className="absolute -inset-[1px] bg-gradient-to-r from-[#ffb204] via-yellow-500 to-[#ffb204] rounded-2xl opacity-0 group-hover:opacity-100 transition-all duration-300"></div>

                {/* Glow Shadow */}
                <div className="absolute inset-0 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300 shadow-[0_0_30px_rgba(255,178,4,0.3)]"></div>

                {/* Card Content */}
                <div className="relative h-full p-8 bg-[#12151c] border border-white/[0.08] rounded-2xl overflow-hidden group-hover:border-transparent transition-all duration-300">
                  {/* Background Glow */}
                  <div className="absolute inset-0 bg-gradient-to-br from-[#ffb204]/5 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

                  {/* Floating Decoration */}
                  <div className="absolute -top-16 -right-16 w-40 h-40 bg-[#ffb204]/5 rounded-full blur-3xl opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>

                  <div className="relative z-10">
                    {/* Icon */}
                    <div className="w-16 h-16 rounded-2xl bg-gradient-to-br from-[#ffb204]/20 to-[#ffb204]/5 border border-[#ffb204]/20 flex items-center justify-center mb-6 transition-all duration-300 group-hover:scale-110 group-hover:bg-gradient-to-br group-hover:from-[#ffb204]/30 group-hover:to-[#ffb204]/10 group-hover:shadow-lg group-hover:shadow-[#ffb204]/30">
                      <span className="material-symbols-outlined text-[#ffb204] text-3xl transition-transform duration-300 group-hover:scale-110">
                        {getServiceMaterialIcon(service.icon)}
                      </span>
                    </div>

                    {/* Number Badge */}
                    <span className="absolute top-0 right-0 w-8 h-8 flex items-center justify-center text-white/10 text-sm font-bold group-hover:text-[#ffb204]/30 transition-colors duration-300">
                      0{index + 1}
                    </span>

                    {/* Content */}
                    <h3 className="text-xl md:text-2xl text-white mb-4 font-semibold transition-colors duration-300 group-hover:text-[#ffb204]">
                      {service.title}
                    </h3>
                    <p className="text-gray-500 text-sm leading-relaxed mb-6 font-light transition-colors duration-300 group-hover:text-gray-400">
                      {service.description}
                    </p>

                    {/* CTA Link */}
                    <div className="inline-flex items-center gap-2 text-[#ffb204]/70 text-xs uppercase tracking-widest font-bold transition-all duration-300 group-hover:text-[#ffb204] group-hover:gap-3">
                      <span>Selengkapnya</span>
                      <span className="material-symbols-outlined text-base">
                        arrow_forward
                      </span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          ))}
        </div>

        {/* Process Section */}
        <div className="mt-24 md:mt-32" data-aos="fade-up">
          <div className="text-center mb-16">
            <div className="inline-flex items-center gap-3 px-5 py-2.5 bg-[#ffb204]/10 border border-[#ffb204]/20 rounded-full mb-6">
              <span className="text-[#ffb204] text-[10px] font-bold uppercase tracking-[0.2em]">
                Proses Kami
              </span>
            </div>
            <h3 className="text-3xl md:text-4xl text-white font-serif">
              4 Langkah Menuju Interior Impian
            </h3>
          </div>

          <div className="relative">
            {/* Connection Lines for Desktop */}
            <div className="hidden lg:block absolute top-10 left-[12.5%] right-[12.5%]">
              <div className="h-[2px] w-full bg-gradient-to-r from-[#ffb204]/50 via-[#ffb204] to-[#ffb204]/50"></div>
              <div className="absolute inset-0 h-[2px] bg-gradient-to-r from-transparent via-[#ffb204] to-transparent animate-pulse"></div>
            </div>

            <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 lg:gap-6">
              {[
                { num: "01", title: "Konsultasi", desc: "Diskusi kebutuhan dan budget proyek Anda" },
                { num: "02", title: "Desain", desc: "Pembuatan konsep dan visualisasi 3D" },
                { num: "03", title: "Produksi", desc: "Fabrikasi dengan material berkualitas" },
                { num: "04", title: "Instalasi", desc: "Pemasangan rapi dan bergaransi" },
              ].map((step, index) => (
                <div
                  key={step.num}
                  className="relative text-center group"
                  data-aos="fade-up"
                  data-aos-delay={(index + 1) * 100}
                >
                  {/* Connector Dot */}
                  <div className="hidden lg:block absolute top-10 left-1/2 -translate-x-1/2 -translate-y-1/2 w-4 h-4 bg-[#ffb204] rounded-full z-10 shadow-lg shadow-[#ffb204]/50"></div>

                  <div className="relative inline-flex items-center justify-center w-20 h-20 rounded-full bg-[#12151c] mb-6 group-hover:scale-110 transition-transform duration-300">
                    <div className="absolute inset-0 rounded-full border-2 border-[#ffb204]/40 group-hover:border-[#ffb204] transition-colors duration-300"></div>
                    <div className="absolute inset-2 rounded-full bg-gradient-to-br from-[#ffb204]/20 to-transparent"></div>
                    <span className="relative text-2xl font-serif text-[#ffb204] font-bold">
                      {step.num}
                    </span>
                  </div>
                  <h4 className="text-white font-semibold text-lg mb-2 group-hover:text-[#ffb204] transition-colors">
                    {step.title}
                  </h4>
                  <p className="text-gray-500 text-sm font-light max-w-[200px] mx-auto">
                    {step.desc}
                  </p>
                </div>
              ))}
            </div>
          </div>
        </div>

        {/* CTA Banner */}
        <div className="mt-20 md:mt-24 relative" data-aos="fade-up">
          <div className="absolute -inset-px bg-gradient-to-r from-[#ffb204] via-yellow-500 to-[#ffb204] rounded-3xl blur-sm opacity-60"></div>

          <div className="relative rounded-3xl overflow-hidden">
            <div
              className="absolute inset-0 bg-fixed bg-cover bg-center"
              style={{
                backgroundImage:
                  "url('https://images.unsplash.com/photo-1618221195710-dd6b41faaea6?ixlib=rb-4.0.3&auto=format&fit=crop&w=2000&q=80')",
              }}
            ></div>

            <div className="absolute inset-0 bg-black/70"></div>
            <div className="absolute inset-0 bg-gradient-to-r from-[#ffb204]/20 via-transparent to-[#ffb204]/20"></div>
            <div className="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-black/60"></div>

            <div className="absolute top-0 left-1/4 w-60 h-60 bg-[#ffb204]/20 blur-[80px] rounded-full"></div>
            <div className="absolute bottom-0 right-1/4 w-60 h-60 bg-[#ffb204]/10 blur-[80px] rounded-full"></div>

            <div className="absolute top-6 left-6 w-20 h-20 border-t-2 border-l-2 border-[#ffb204]/50 rounded-tl-xl"></div>
            <div className="absolute bottom-6 right-6 w-20 h-20 border-b-2 border-r-2 border-[#ffb204]/50 rounded-br-xl"></div>

            <div className="relative py-16 md:py-24 px-8 md:px-12 text-center">
              <div className="inline-flex items-center gap-2 px-4 py-2 bg-[#ffb204]/20 border border-[#ffb204]/30 rounded-full mb-6 backdrop-blur-sm">
                <span className="w-2 h-2 bg-[#ffb204] rounded-full animate-pulse"></span>
                <span className="text-[#ffb204] text-xs font-bold uppercase tracking-wider">
                  Free Consultation
                </span>
              </div>

              <h3 className="text-3xl md:text-5xl lg:text-6xl text-white font-serif mb-6 leading-tight">
                Siap Wujudkan Interior
                <br />
                <span className="text-transparent bg-clip-text bg-gradient-to-r from-[#ffb204] via-yellow-400 to-[#ffb204]">
                  Impian Anda?
                </span>
              </h3>
              <p className="text-gray-300 mb-10 max-w-2xl mx-auto text-base md:text-lg font-light leading-relaxed">
                Konsultasi gratis dengan tim desainer profesional kami. Dapatkan
                estimasi biaya dalam 24 jam dan mulai perjalanan menuju rumah
                impian Anda.
              </p>

              <div className="flex flex-col sm:flex-row gap-4 justify-center items-center">
                <Link
                  href="#contact"
                  className="group relative inline-flex items-center gap-3 px-10 py-5 bg-gradient-to-r from-[#ffb204] to-yellow-500 text-black rounded-xl font-bold text-sm uppercase tracking-wider overflow-hidden transition-all hover:shadow-2xl hover:shadow-[#ffb204]/40"
                >
                  <div className="absolute inset-0 bg-gradient-to-r from-transparent via-white/30 to-transparent -translate-x-full group-hover:translate-x-full transition-transform duration-700"></div>
                  <span className="material-symbols-outlined text-xl">chat</span>
                  Konsultasi Gratis
                  <span className="material-symbols-outlined text-xl transition-transform group-hover:translate-x-1">
                    arrow_forward
                  </span>
                </Link>
                <Link
                  href="https://wa.me/6283137554972"
                  className="inline-flex items-center gap-3 px-10 py-5 bg-white/10 backdrop-blur-sm border border-white/30 text-white rounded-xl font-bold text-sm uppercase tracking-wider hover:bg-white/20 hover:border-white/50 transition-all"
                >
                  <span className="material-symbols-outlined text-xl text-green-400">
                    chat
                  </span>
                  WhatsApp Kami
                </Link>
              </div>

              <div className="flex flex-wrap items-center justify-center gap-8 mt-12 pt-8 border-t border-white/10">
                <div className="flex items-center gap-2 text-gray-400">
                  <span className="material-symbols-outlined text-[#ffb204]">
                    verified
                  </span>
                  <span className="text-sm">12+ Tahun Pengalaman</span>
                </div>
                <div className="flex items-center gap-2 text-gray-400">
                  <span className="material-symbols-outlined text-[#ffb204]">
                    workspace_premium
                  </span>
                  <span className="text-sm">Garansi 2 Tahun</span>
                </div>
                <div className="flex items-center gap-2 text-gray-400">
                  <span className="material-symbols-outlined text-[#ffb204]">
                    thumb_up
                  </span>
                  <span className="text-sm">500+ Proyek Selesai</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  );
}
