import Link from "next/link";

export default function CalculatorSection() {
  return (
    <section
      className="py-16 sm:py-20 md:py-28 lg:py-36 bg-[#0a0c10] relative overflow-hidden"
      id="calculator"
    >
      {/* Background Effects */}
      <div className="absolute inset-0 pointer-events-none overflow-hidden">
        <div className="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[400px] sm:w-[600px] lg:w-[1000px] h-[300px] sm:h-[400px] lg:h-[600px] bg-gradient-to-r from-[#ffb204]/20 via-[#ffb204]/10 to-[#ffb204]/5 blur-[100px] lg:blur-[150px] rounded-full opacity-60"></div>
        <div className="absolute top-0 right-0 w-48 sm:w-72 lg:w-96 h-48 sm:h-72 lg:h-96 bg-[#ffb204]/10 blur-[60px] sm:blur-[80px] lg:blur-[100px] rounded-full hidden sm:block"></div>
        <div className="absolute bottom-0 left-0 w-36 sm:w-56 lg:w-72 h-36 sm:h-56 lg:h-72 bg-[#ffb204]/5 blur-[50px] lg:blur-[80px] rounded-full hidden sm:block"></div>
        <div
          className="absolute inset-0 opacity-[0.02]"
          style={{
            backgroundImage:
              "linear-gradient(rgba(255,255,255,.1) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,.1) 1px, transparent 1px)",
            backgroundSize: "40px 40px",
          }}
        ></div>
      </div>

      <div className="max-w-[1200px] mx-auto px-4 sm:px-6 relative z-10">
        {/* Premium Header */}
        <div
          className="text-center mb-10 sm:mb-14 md:mb-16 lg:mb-20"
          data-aos="fade-up"
        >
          <div className="inline-flex items-center gap-2 sm:gap-3 px-4 sm:px-6 py-2 sm:py-3 bg-gradient-to-r from-[#ffb204]/20 via-[#ffb204]/10 to-[#ffb204]/20 border border-[#ffb204]/30 rounded-full mb-5 sm:mb-8 backdrop-blur-sm">
            <span className="w-1.5 sm:w-2 h-1.5 sm:h-2 bg-[#ffb204] rounded-full animate-pulse"></span>
            <span className="text-[#ffb204] text-[10px] sm:text-xs font-bold uppercase tracking-[0.15em] sm:tracking-[0.2em]">
              Kalkulator Premium
            </span>
            <span className="w-1.5 sm:w-2 h-1.5 sm:h-2 bg-[#ffb204] rounded-full animate-pulse"></span>
          </div>
          <h2 className="text-2xl sm:text-3xl md:text-4xl lg:text-5xl xl:text-6xl text-white font-serif mb-4 sm:mb-6 leading-tight px-2">
            Wujudkan{" "}
            <span className="text-transparent bg-clip-text bg-gradient-to-r from-[#ffb204] via-yellow-400 to-[#ffb204]">
              Interior Impian
            </span>
          </h2>
          <p className="text-gray-400 max-w-xl lg:max-w-2xl mx-auto text-sm sm:text-base md:text-lg font-light leading-relaxed px-2">
            Hitung estimasi biaya proyek Anda dalam hitungan detik
          </p>
        </div>

        {/* Main Content */}
        <div className="relative" data-aos="fade-up" data-aos-delay="100">
          {/* Floating Decorations - Desktop only */}
          <div className="absolute -top-6 -left-6 w-24 h-24 border border-[#ffb204]/20 rounded-2xl rotate-12 hidden xl:block"></div>
          <div className="absolute -bottom-8 -right-8 w-32 h-32 border border-[#ffb204]/10 rounded-full hidden xl:block"></div>

          {/* Glass Card Container */}
          <div className="relative bg-gradient-to-br from-white/[0.08] via-white/[0.04] to-transparent backdrop-blur-xl border border-white/[0.1] rounded-2xl sm:rounded-3xl overflow-hidden shadow-[0_16px_32px_-8px_rgba(0,0,0,0.5)] sm:shadow-[0_32px_64px_-12px_rgba(0,0,0,0.6)]">
            {/* Premium Header Bar */}
            <div className="relative bg-gradient-to-r from-white/[0.05] via-white/[0.02] to-white/[0.05] border-b border-white/[0.08] px-4 sm:px-6 md:px-8 py-3 sm:py-4 md:py-5">
              <div className="flex items-center justify-between">
                <div className="flex items-center gap-2 sm:gap-3 md:gap-4">
                  <div className="hidden sm:flex items-center gap-1.5 sm:gap-2">
                    <div className="w-2.5 sm:w-3 h-2.5 sm:h-3 rounded-full bg-red-500/80"></div>
                    <div className="w-2.5 sm:w-3 h-2.5 sm:h-3 rounded-full bg-yellow-500/80"></div>
                    <div className="w-2.5 sm:w-3 h-2.5 sm:h-3 rounded-full bg-green-500/80"></div>
                  </div>
                  <div className="hidden sm:block h-5 w-px bg-white/10"></div>
                  <div className="flex items-center gap-2 sm:gap-3">
                    <div className="w-8 sm:w-9 md:w-10 h-8 sm:h-9 md:h-10 rounded-lg sm:rounded-xl bg-gradient-to-br from-[#ffb204] to-[#ffb204]/70 flex items-center justify-center shadow-lg shadow-[#ffb204]/30">
                      <span className="material-symbols-outlined text-black text-base sm:text-lg md:text-xl">
                        calculate
                      </span>
                    </div>
                    <div>
                      <h3 className="text-white font-semibold text-xs sm:text-sm md:text-base">
                        Budget Calculator
                      </h3>
                      <p className="text-gray-500 text-[10px] sm:text-xs hidden sm:block">
                        AI Estimation
                      </p>
                    </div>
                  </div>
                </div>
                <div className="flex items-center gap-2 px-2 sm:px-3 md:px-4 py-1.5 sm:py-2 bg-green-500/10 border border-green-500/30 rounded-full">
                  <span className="relative flex h-1.5 sm:h-2 w-1.5 sm:w-2">
                    <span className="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                    <span className="relative inline-flex rounded-full h-1.5 sm:h-2 w-1.5 sm:w-2 bg-green-500"></span>
                  </span>
                  <span className="text-green-400 text-[10px] sm:text-xs font-semibold">
                    Gratis
                  </span>
                </div>
              </div>
            </div>

            {/* Content Area */}
            <div className="p-4 sm:p-6 md:p-8 lg:p-10 xl:p-12">
              <div className="grid lg:grid-cols-5 gap-6 sm:gap-8 lg:gap-10 xl:gap-12">
                {/* Left Column - Products */}
                <div className="lg:col-span-3 order-2 lg:order-1">
                  <div className="flex items-center gap-2 sm:gap-3 mb-5 sm:mb-6 md:mb-8">
                    <div className="w-1 h-6 sm:h-8 bg-gradient-to-b from-[#ffb204] to-[#ffb204]/30 rounded-full"></div>
                    <h4 className="text-white text-base sm:text-lg font-semibold">
                      Pilih Produk Anda
                    </h4>
                  </div>

                  <div className="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                    {/* Product Cards */}
                    {[
                      {
                        name: "Kitchen Set",
                        desc: "Aluminium, Multipleks, PVC",
                        price: "Rp 2jt",
                        icon: "countertops",
                        badge: "Popular",
                        badgeColor: "bg-[#ffb204]/20 text-[#ffb204]",
                      },
                      {
                        name: "Lemari & Wardrobe",
                        desc: "Custom sesuai ukuran",
                        price: "Rp 2.3jt",
                        icon: "door_sliding",
                        badge: "Custom",
                        badgeColor: "bg-blue-500/20 text-blue-400",
                      },
                      {
                        name: "Backdrop TV",
                        desc: "Modern & minimalis",
                        price: "Rp 2.1jt",
                        icon: "tv",
                        badge: "Modern",
                        badgeColor: "bg-purple-500/20 text-purple-400",
                      },
                      {
                        name: "Wallpanel",
                        desc: "WPC & PVC Board",
                        price: "Rp 850rb",
                        icon: "dashboard",
                        badge: "Ekonomis",
                        badgeColor: "bg-green-500/20 text-green-400",
                      },
                    ].map((product) => (
                      <div
                        key={product.name}
                        className="group relative p-4 sm:p-5 bg-gradient-to-br from-white/[0.06] to-transparent border border-white/[0.08] rounded-xl sm:rounded-2xl cursor-pointer hover:border-[#ffb204]/50 hover:shadow-xl hover:shadow-[#ffb204]/10 transition-all duration-500 overflow-hidden"
                      >
                        <div className="absolute inset-0 bg-gradient-to-br from-[#ffb204]/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                        <div className="relative">
                          <div className="flex items-start justify-between mb-3 sm:mb-4">
                            <div className="w-11 sm:w-12 md:w-14 h-11 sm:h-12 md:h-14 rounded-xl sm:rounded-2xl bg-gradient-to-br from-[#ffb204]/30 to-[#ffb204]/10 flex items-center justify-center group-hover:scale-110 transition-transform duration-500">
                              <span className="material-symbols-outlined text-[#ffb204] text-2xl sm:text-3xl">
                                {product.icon}
                              </span>
                            </div>
                            <span
                              className={`px-2 sm:px-3 py-1 ${product.badgeColor} text-[9px] sm:text-[10px] font-bold rounded-full uppercase`}
                            >
                              {product.badge}
                            </span>
                          </div>
                          <h5 className="text-white font-semibold text-base sm:text-lg mb-1 group-hover:text-[#ffb204] transition-colors">
                            {product.name}
                          </h5>
                          <p className="text-gray-500 text-xs sm:text-sm mb-3 sm:mb-4">
                            {product.desc}
                          </p>
                          <div className="flex items-baseline gap-1">
                            <span className="text-xl sm:text-2xl font-bold text-white">
                              {product.price}
                            </span>
                            <span className="text-gray-500 text-xs sm:text-sm">
                              /meter
                            </span>
                          </div>
                        </div>
                      </div>
                    ))}
                  </div>
                </div>

                {/* Right Column - Calculator Preview */}
                <div className="lg:col-span-2 order-1 lg:order-2">
                  <div className="flex items-center gap-2 sm:gap-3 mb-5 sm:mb-6 md:mb-8">
                    <div className="w-1 h-6 sm:h-8 bg-gradient-to-b from-[#ffb204] to-[#ffb204]/30 rounded-full"></div>
                    <h4 className="text-white text-base sm:text-lg font-semibold">
                      Preview Estimasi
                    </h4>
                  </div>

                  {/* Calculator Preview Card */}
                  <div className="relative">
                    <div className="absolute -inset-px bg-gradient-to-r from-[#ffb204]/50 via-[#ffb204]/20 to-[#ffb204]/50 rounded-xl sm:rounded-2xl blur-sm"></div>

                    <div className="relative bg-[#0c0e12] rounded-xl sm:rounded-2xl p-4 sm:p-5 md:p-6 border border-white/[0.1]">
                      {/* Selected Product */}
                      <div className="flex items-center gap-3 sm:gap-4 p-3 sm:p-4 bg-gradient-to-r from-[#ffb204]/15 to-[#ffb204]/5 border border-[#ffb204]/30 rounded-lg sm:rounded-xl mb-4 sm:mb-6">
                        <div className="w-10 sm:w-12 h-10 sm:h-12 rounded-lg sm:rounded-xl bg-[#ffb204]/20 flex items-center justify-center">
                          <span className="material-symbols-outlined text-[#ffb204] text-xl sm:text-2xl">
                            countertops
                          </span>
                        </div>
                        <div className="flex-1 min-w-0">
                          <span className="text-white font-semibold text-sm sm:text-base block truncate">
                            Kitchen Set Aluminium
                          </span>
                          <span className="text-gray-400 text-[10px] sm:text-xs">
                            Grade A • Anti Air
                          </span>
                        </div>
                        <span className="material-symbols-outlined text-green-400 text-xl sm:text-2xl flex-shrink-0">
                          verified
                        </span>
                      </div>

                      {/* Specifications */}
                      <div className="grid grid-cols-3 gap-2 sm:gap-3 mb-4 sm:mb-6">
                        {[
                          { icon: "straighten", value: "3.5", label: "meter" },
                          { icon: "style", value: "Minimalis", label: "model" },
                          { icon: "location_on", value: "Jabar", label: "lokasi" },
                        ].map((spec) => (
                          <div
                            key={spec.icon}
                            className="text-center p-2 sm:p-3 md:p-4 bg-white/[0.03] rounded-lg sm:rounded-xl border border-white/[0.05]"
                          >
                            <span className="material-symbols-outlined text-[#ffb204] text-sm sm:text-base md:text-lg mb-1 sm:mb-2 block">
                              {spec.icon}
                            </span>
                            <span className="text-white font-bold text-base sm:text-lg md:text-xl block">
                              {spec.value}
                            </span>
                            <span className="text-gray-500 text-[10px] sm:text-xs">
                              {spec.label}
                            </span>
                          </div>
                        ))}
                      </div>

                      {/* Price Display */}
                      <div className="relative bg-gradient-to-br from-[#ffb204]/20 via-[#ffb204]/10 to-transparent rounded-xl sm:rounded-2xl p-4 sm:p-5 md:p-6 mb-4 sm:mb-6 overflow-hidden">
                        <div className="absolute top-0 right-0 w-20 sm:w-24 md:w-32 h-20 sm:h-24 md:h-32 bg-[#ffb204]/20 blur-2xl sm:blur-3xl rounded-full"></div>
                        <div className="relative text-center">
                          <span className="text-gray-400 text-[10px] sm:text-xs uppercase tracking-widest block mb-2 sm:mb-3">
                            Total Estimasi
                          </span>
                          <div className="flex items-baseline justify-center gap-1 sm:gap-2 mb-2 sm:mb-3">
                            <span className="text-white text-lg sm:text-xl md:text-2xl font-bold">
                              Rp
                            </span>
                            <span className="text-2xl sm:text-3xl md:text-4xl text-white font-bold">
                              12.250.000
                            </span>
                          </div>
                          <div className="flex flex-wrap items-center justify-center gap-2 sm:gap-3">
                            <span className="px-3 sm:px-4 py-1 sm:py-1.5 bg-[#ffb204]/30 text-[#ffb204] rounded-full text-[10px] sm:text-xs font-bold">
                              Best Value
                            </span>
                            <span className="text-gray-500 text-[10px] sm:text-xs">
                              ±10% akurasi
                            </span>
                          </div>
                        </div>
                      </div>

                      {/* CTA Button */}
                      <Link
                        href="/calculator"
                        className="group relative flex items-center justify-center gap-2 sm:gap-3 w-full py-3.5 sm:py-4 md:py-5 bg-gradient-to-r from-[#ffb204] to-yellow-500 text-black rounded-lg sm:rounded-xl font-bold text-xs sm:text-sm uppercase tracking-wider overflow-hidden transition-all hover:shadow-2xl hover:shadow-[#ffb204]/40"
                      >
                        <div className="absolute inset-0 bg-gradient-to-r from-transparent via-white/30 to-transparent -translate-x-full group-hover:translate-x-full transition-transform duration-1000"></div>
                        <span className="material-symbols-outlined text-base sm:text-lg md:text-xl">
                          calculate
                        </span>
                        <span className="hidden md:block">
                          Hitung Estimasi Lengkap
                        </span>
                        <span className="block md:hidden">Hitung Sekarang</span>
                        <span className="material-symbols-outlined text-base sm:text-lg md:text-xl transition-transform group-hover:translate-x-2">
                          arrow_forward
                        </span>
                      </Link>
                    </div>
                  </div>

                  {/* Trust Badges */}
                  <div className="flex items-center justify-center gap-4 sm:gap-6 mt-4 sm:mt-6">
                    {[
                      { icon: "shield", label: "Aman" },
                      { icon: "speed", label: "Cepat" },
                      { icon: "thumb_up", label: "Gratis" },
                    ].map((badge) => (
                      <div
                        key={badge.icon}
                        className="flex items-center gap-1.5 sm:gap-2 text-gray-400 text-[10px] sm:text-xs"
                      >
                        <span className="material-symbols-outlined text-green-400 text-sm sm:text-base">
                          {badge.icon}
                        </span>
                        {badge.label}
                      </div>
                    ))}
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        {/* Premium Stats */}
        <div
          className="grid grid-cols-2 md:grid-cols-4 gap-3 sm:gap-4 md:gap-6 mt-10 sm:mt-14 md:mt-16 lg:mt-20"
          data-aos="fade-up"
          data-aos-delay="200"
        >
          {[
            { value: "500", suffix: "+", label: "Proyek Selesai" },
            { value: "98", suffix: "%", label: "Kepuasan" },
            { value: "2", suffix: "th", label: "Garansi" },
            { value: "12", suffix: "+", label: "Tahun" },
          ].map((stat) => (
            <div
              key={stat.label}
              className="group relative p-4 sm:p-5 md:p-6 bg-gradient-to-br from-white/[0.05] to-transparent border border-white/[0.08] rounded-xl sm:rounded-2xl text-center hover:border-[#ffb204]/30 transition-all overflow-hidden"
            >
              <div className="absolute inset-0 bg-gradient-to-br from-[#ffb204]/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
              <div className="relative">
                <span className="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-serif text-white font-bold block mb-1 sm:mb-2">
                  {stat.value}
                  <span className="text-[#ffb204]">{stat.suffix}</span>
                </span>
                <span className="text-gray-500 text-[10px] sm:text-xs uppercase tracking-wider">
                  {stat.label}
                </span>
              </div>
            </div>
          ))}
        </div>
      </div>
    </section>
  );
}
