import Link from "next/link";

export default function Footer() {
  const currentYear = new Date().getFullYear();

  return (
    <footer className="bg-[#0D0D0D] py-16 md:py-24 border-t border-white/5">
      <div className="max-w-[1200px] mx-auto px-6">
        <div className="flex flex-col md:flex-row justify-between items-start gap-12">
          {/* Brand */}
          <div className="flex flex-col gap-6" data-aos="fade-up">
            <Link href="/" className="flex items-center gap-3">
              <svg
                className="w-8 h-8 text-[#ffb204]"
                fill="currentColor"
                viewBox="0 0 24 24"
              >
                <path d="M12 3L4 9v12h5v-7h6v7h5V9l-8-6z" />
              </svg>
              <span className="brand-font text-2xl font-bold text-white uppercase tracking-tight">
                Home Putra{" "}
                <span className="text-[#ffb204] italic normal-case">
                  Interior
                </span>
              </span>
            </Link>
            <p className="text-gray-500 text-sm max-w-xs font-light leading-relaxed">
              Menciptakan ruang abadi yang mencerminkan kepribadian dan aspirasi
              unik klien kami.
            </p>
          </div>

          {/* Footer Links */}
          <div className="grid grid-cols-2 lg:grid-cols-3 gap-10 md:gap-16">
            <div data-aos="fade-up" data-aos-delay="100">
              <h5 className="text-white text-[10px] uppercase tracking-[0.3em] font-bold mb-6">
                Jelajahi
              </h5>
              <div className="flex flex-col gap-4 text-sm text-gray-500 font-medium">
                <Link
                  className="hover:text-[#ffb204] transition-colors"
                  href="/#portfolio"
                >
                  Portfolio
                </Link>
                <Link
                  className="hover:text-[#ffb204] transition-colors"
                  href="/#services"
                >
                  Layanan
                </Link>
                <Link
                  className="hover:text-[#ffb204] transition-colors"
                  href="/#calculator"
                >
                  Kalkulator
                </Link>
              </div>
            </div>
            <div data-aos="fade-up" data-aos-delay="200">
              <h5 className="text-white text-[10px] uppercase tracking-[0.3em] font-bold mb-6">
                Perusahaan
              </h5>
              <div className="flex flex-col gap-4 text-sm text-gray-500 font-medium">
                <Link
                  className="hover:text-[#ffb204] transition-colors"
                  href="/"
                >
                  Tentang
                </Link>
                <Link
                  className="hover:text-[#ffb204] transition-colors"
                  href="/#testimonials"
                >
                  Testimoni
                </Link>
                <Link
                  className="hover:text-[#ffb204] transition-colors"
                  href="/#contact"
                >
                  Kontak
                </Link>
              </div>
            </div>
            <div data-aos="fade-up" data-aos-delay="300">
              <h5 className="text-white text-[10px] uppercase tracking-[0.3em] font-bold mb-6">
                Hubungi
              </h5>
              <div className="flex flex-col gap-4 text-sm text-gray-500 font-medium">
                <p>Jl. Desain No. 123, Jakarta</p>
                <p>hello@homeputra.com</p>
                <p>+62 812 3456 7890</p>
              </div>
            </div>
          </div>
        </div>

        {/* Copyright */}
        <div className="mt-16 md:mt-20 pt-10 border-t border-white/5 flex flex-col md:flex-row justify-between items-center text-center md:text-left gap-6 md:gap-4">
          <div className="text-[10px] uppercase tracking-widest text-gray-600 font-bold">
            © {currentYear} Home Putra Interior. Hak Cipta Dilindungi.
          </div>
          <div className="flex gap-8 text-[10px] uppercase tracking-widest text-gray-600 font-bold">
            <Link className="hover:text-white transition-colors" href="#">
              Kebijakan Privasi
            </Link>
            <Link className="hover:text-white transition-colors" href="#">
              Syarat & Ketentuan
            </Link>
          </div>
        </div>
      </div>
    </footer>
  );
}
