"use client";

import { useState } from "react";
import Link from "next/link";

export default function ContactSection() {
  const [formData, setFormData] = useState({
    first_name: "",
    last_name: "",
    email: "",
    phone: "",
    service_type: "kitchen",
    message: "",
  });
  const [isSubmitting, setIsSubmitting] = useState(false);
  const [formMessage, setFormMessage] = useState<{
    type: "success" | "error";
    text: string;
  } | null>(null);

  const handleChange = (
    e: React.ChangeEvent<
      HTMLInputElement | HTMLSelectElement | HTMLTextAreaElement
    >
  ) => {
    setFormData({
      ...formData,
      [e.target.name]: e.target.value,
    });
  };

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    setIsSubmitting(true);
    setFormMessage(null);

    try {
      const response = await fetch("/api/contact", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify(formData),
      });

      const data = await response.json();

      if (data.success) {
        setFormMessage({ type: "success", text: data.message });
        setFormData({
          first_name: "",
          last_name: "",
          email: "",
          phone: "",
          service_type: "kitchen",
          message: "",
        });
      } else {
        setFormMessage({
          type: "error",
          text: data.message || "Terjadi kesalahan",
        });
      }
    } catch {
      setFormMessage({
        type: "error",
        text: "Terjadi kesalahan pada server.",
      });
    } finally {
      setIsSubmitting(false);
      setTimeout(() => setFormMessage(null), 5000);
    }
  };

  return (
    <section
      className="py-16 sm:py-20 md:py-28 lg:py-36 bg-[#0a0c10] relative overflow-hidden"
      id="contact"
    >
      {/* Background Effects */}
      <div className="absolute inset-0 pointer-events-none">
        <div className="absolute top-0 right-0 w-[250px] sm:w-[350px] lg:w-[500px] h-[250px] sm:h-[350px] lg:h-[500px] bg-[#ffb204]/5 blur-[100px] lg:blur-[150px] rounded-full"></div>
        <div className="absolute bottom-0 left-0 w-[200px] sm:w-[300px] lg:w-[400px] h-[200px] sm:h-[300px] lg:h-[400px] bg-[#ffb204]/5 blur-[80px] lg:blur-[120px] rounded-full"></div>
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
          <div className="inline-flex items-center gap-2 sm:gap-3 px-4 sm:px-5 py-2 sm:py-2.5 bg-[#ffb204]/10 border border-[#ffb204]/20 rounded-full mb-4 sm:mb-6">
            <span className="w-1.5 h-1.5 bg-[#ffb204] rounded-full animate-pulse"></span>
            <span className="text-[#ffb204] text-[10px] sm:text-xs font-bold uppercase tracking-[0.15em] sm:tracking-[0.2em]">
              Hubungi Kami
            </span>
          </div>
          <h2 className="text-2xl sm:text-3xl md:text-4xl lg:text-5xl xl:text-6xl text-white font-serif mb-4 sm:mb-6 leading-tight px-2">
            Mari Ciptakan Sesuatu yang{" "}
            <br className="sm:hidden" />
            <span className="text-transparent bg-clip-text bg-gradient-to-r from-[#ffb204] via-yellow-400 to-[#ffb204]">
              Indah
            </span>
          </h2>
          <p className="text-gray-400 max-w-xl lg:max-w-2xl mx-auto text-sm sm:text-base md:text-lg font-light leading-relaxed px-2">
            Siap untuk mengubah ruang Anda? Tim desain kami akan menghubungi
            Anda dalam 24 jam.
          </p>
        </div>

        {/* Main Card */}
        <div className="relative" data-aos="fade-up" data-aos-delay="100">
          {/* Floating Decorations - Desktop only */}
          <div className="absolute -top-6 -left-6 w-24 h-24 border border-[#ffb204]/20 rounded-2xl rotate-12 hidden xl:block"></div>
          <div className="absolute -bottom-8 -right-8 w-32 h-32 border border-[#ffb204]/10 rounded-full hidden xl:block"></div>

          {/* Glass Card */}
          <div className="relative bg-gradient-to-br from-white/[0.08] via-white/[0.04] to-transparent backdrop-blur-xl border border-white/[0.1] rounded-2xl sm:rounded-3xl overflow-hidden shadow-[0_16px_32px_-8px_rgba(0,0,0,0.5)] sm:shadow-[0_32px_64px_-12px_rgba(0,0,0,0.6)]">
            {/* Card Header */}
            <div className="bg-white/[0.02] border-b border-white/[0.06] px-4 sm:px-6 md:px-8 py-3 sm:py-4 md:py-5">
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
                      mail
                    </span>
                  </div>
                  <div>
                    <h3 className="text-white font-semibold text-sm sm:text-base">
                      Formulir Kontak
                    </h3>
                    <p className="text-gray-500 text-[10px] sm:text-xs hidden sm:block">
                      Konsultasi Gratis
                    </p>
                  </div>
                </div>
              </div>
            </div>

            <div className="p-4 sm:p-6 md:p-8 lg:p-10 xl:p-12">
              <div className="grid lg:grid-cols-2 gap-8 sm:gap-10 lg:gap-12 xl:gap-16">
                {/* Left Side - Info */}
                <div className="order-2 lg:order-1">
                  <div className="flex items-center gap-2 sm:gap-3 mb-5 sm:mb-6 md:mb-8">
                    <div className="w-1 h-6 sm:h-8 bg-gradient-to-b from-[#ffb204] to-[#ffb204]/30 rounded-full"></div>
                    <h4 className="text-white text-base sm:text-lg font-semibold">
                      Informasi Kontak
                    </h4>
                  </div>

                  <p className="text-gray-400 mb-6 sm:mb-8 md:mb-10 font-light leading-relaxed text-sm sm:text-base">
                    Tim desain kami siap membantu mewujudkan ruang impian Anda.
                    Hubungi kami melalui channel berikut.
                  </p>

                  {/* Contact Details */}
                  <div className="space-y-3 sm:space-y-4">
                    <Link
                      href="https://wa.me/6283137554972"
                      className="group flex items-center gap-3 sm:gap-4 p-3 sm:p-4 md:p-5 bg-gradient-to-br from-white/[0.06] to-transparent border border-white/[0.08] rounded-xl sm:rounded-2xl cursor-pointer hover:border-[#ffb204]/30 transition-all duration-300"
                    >
                      <div className="w-11 sm:w-12 md:w-14 h-11 sm:h-12 md:h-14 rounded-xl sm:rounded-2xl bg-gradient-to-br from-green-500/30 to-green-500/10 flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform duration-300">
                        <span className="material-symbols-outlined text-green-400 text-xl sm:text-2xl">
                          chat
                        </span>
                      </div>
                      <div className="flex-1 min-w-0">
                        <h5 className="text-white font-medium text-sm sm:text-base group-hover:text-[#ffb204] transition-colors">
                          WhatsApp
                        </h5>
                        <p className="text-gray-500 text-xs sm:text-sm truncate">
                          +62 812 3456 7890
                        </p>
                      </div>
                      <span className="material-symbols-outlined text-gray-600 text-lg sm:text-xl group-hover:text-[#ffb204] group-hover:translate-x-1 transition-all flex-shrink-0">
                        arrow_forward
                      </span>
                    </Link>

                    <Link
                      href="mailto:hello@homeputra.com"
                      className="group flex items-center gap-3 sm:gap-4 p-3 sm:p-4 md:p-5 bg-gradient-to-br from-white/[0.06] to-transparent border border-white/[0.08] rounded-xl sm:rounded-2xl cursor-pointer hover:border-[#ffb204]/30 transition-all duration-300"
                    >
                      <div className="w-11 sm:w-12 md:w-14 h-11 sm:h-12 md:h-14 rounded-xl sm:rounded-2xl bg-gradient-to-br from-blue-500/30 to-blue-500/10 flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform duration-300">
                        <span className="material-symbols-outlined text-blue-400 text-xl sm:text-2xl">
                          mail
                        </span>
                      </div>
                      <div className="flex-1 min-w-0">
                        <h5 className="text-white font-medium text-sm sm:text-base group-hover:text-[#ffb204] transition-colors">
                          Email
                        </h5>
                        <p className="text-gray-500 text-xs sm:text-sm truncate">
                          hello@homeputra.com
                        </p>
                      </div>
                      <span className="material-symbols-outlined text-gray-600 text-lg sm:text-xl group-hover:text-[#ffb204] group-hover:translate-x-1 transition-all flex-shrink-0">
                        arrow_forward
                      </span>
                    </Link>

                    <div className="flex items-center gap-3 sm:gap-4 p-3 sm:p-4 md:p-5 bg-gradient-to-br from-white/[0.06] to-transparent border border-white/[0.08] rounded-xl sm:rounded-2xl">
                      <div className="w-11 sm:w-12 md:w-14 h-11 sm:h-12 md:h-14 rounded-xl sm:rounded-2xl bg-gradient-to-br from-[#ffb204]/30 to-[#ffb204]/10 flex items-center justify-center flex-shrink-0">
                        <span className="material-symbols-outlined text-[#ffb204] text-xl sm:text-2xl">
                          location_on
                        </span>
                      </div>
                      <div className="flex-1 min-w-0">
                        <h5 className="text-white font-medium text-sm sm:text-base">
                          Studio Kami
                        </h5>
                        <p className="text-gray-500 text-xs sm:text-sm">
                          Surabaya, Jawa Timur
                        </p>
                      </div>
                    </div>
                  </div>

                  {/* Social Links */}
                  <div className="mt-6 sm:mt-8 md:mt-10">
                    <p className="text-gray-500 text-[10px] sm:text-xs uppercase tracking-wider mb-3 sm:mb-4">
                      Ikuti Kami
                    </p>
                    <div className="flex items-center gap-2 sm:gap-3">
                      {["photo_camera", "thumb_up", "play_circle"].map(
                        (icon) => (
                          <Link
                            key={icon}
                            href="#"
                            className="w-9 sm:w-10 md:w-11 h-9 sm:h-10 md:h-11 rounded-lg sm:rounded-xl bg-white/[0.05] border border-white/[0.08] flex items-center justify-center text-gray-400 hover:text-[#ffb204] hover:border-[#ffb204]/30 hover:scale-110 transition-all"
                          >
                            <span className="material-symbols-outlined text-base sm:text-lg md:text-xl">
                              {icon}
                            </span>
                          </Link>
                        )
                      )}
                    </div>
                  </div>
                </div>

                {/* Right Side - Form */}
                <div className="order-1 lg:order-2">
                  <div className="flex items-center gap-2 sm:gap-3 mb-5 sm:mb-6 md:mb-8">
                    <div className="w-1 h-6 sm:h-8 bg-gradient-to-b from-[#ffb204] to-[#ffb204]/30 rounded-full"></div>
                    <h4 className="text-white text-base sm:text-lg font-semibold">
                      Kirim Pesan
                    </h4>
                  </div>

                  <form onSubmit={handleSubmit} className="space-y-4 sm:space-y-5">
                    {/* Name Fields */}
                    <div className="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                      <div className="space-y-1.5 sm:space-y-2">
                        <label className="text-gray-400 text-[11px] sm:text-xs font-medium">
                          Nama Depan
                        </label>
                        <input
                          name="first_name"
                          value={formData.first_name}
                          onChange={handleChange}
                          className="w-full bg-[#0a0c10] border border-white/[0.08] rounded-lg sm:rounded-xl px-3 sm:px-4 py-3 sm:py-4 text-white focus:ring-2 focus:ring-[#ffb204]/50 focus:border-[#ffb204]/50 outline-none text-sm placeholder-gray-600 transition-all"
                          placeholder="John"
                          type="text"
                          required
                        />
                      </div>
                      <div className="space-y-1.5 sm:space-y-2">
                        <label className="text-gray-400 text-[11px] sm:text-xs font-medium">
                          Nama Belakang
                        </label>
                        <input
                          name="last_name"
                          value={formData.last_name}
                          onChange={handleChange}
                          className="w-full bg-[#0a0c10] border border-white/[0.08] rounded-lg sm:rounded-xl px-3 sm:px-4 py-3 sm:py-4 text-white focus:ring-2 focus:ring-[#ffb204]/50 focus:border-[#ffb204]/50 outline-none text-sm placeholder-gray-600 transition-all"
                          placeholder="Doe"
                          type="text"
                        />
                      </div>
                    </div>

                    {/* Email & Phone */}
                    <div className="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                      <div className="space-y-1.5 sm:space-y-2">
                        <label className="text-gray-400 text-[11px] sm:text-xs font-medium">
                          Email
                        </label>
                        <input
                          name="email"
                          value={formData.email}
                          onChange={handleChange}
                          className="w-full bg-[#0a0c10] border border-white/[0.08] rounded-lg sm:rounded-xl px-3 sm:px-4 py-3 sm:py-4 text-white focus:ring-2 focus:ring-[#ffb204]/50 focus:border-[#ffb204]/50 outline-none text-sm placeholder-gray-600 transition-all"
                          placeholder="john@example.com"
                          type="email"
                          required
                        />
                      </div>
                      <div className="space-y-1.5 sm:space-y-2">
                        <label className="text-gray-400 text-[11px] sm:text-xs font-medium">
                          Telepon
                        </label>
                        <input
                          name="phone"
                          value={formData.phone}
                          onChange={handleChange}
                          className="w-full bg-[#0a0c10] border border-white/[0.08] rounded-lg sm:rounded-xl px-3 sm:px-4 py-3 sm:py-4 text-white focus:ring-2 focus:ring-[#ffb204]/50 focus:border-[#ffb204]/50 outline-none text-sm placeholder-gray-600 transition-all"
                          placeholder="+62 812 xxx xxxx"
                          type="tel"
                        />
                      </div>
                    </div>

                    {/* Service Select */}
                    <div className="space-y-1.5 sm:space-y-2">
                      <label className="text-gray-400 text-[11px] sm:text-xs font-medium">
                        Layanan yang Diminati
                      </label>
                      <select
                        name="service_type"
                        value={formData.service_type}
                        onChange={handleChange}
                        className="w-full bg-[#0a0c10] border border-white/[0.08] rounded-lg sm:rounded-xl px-3 sm:px-4 py-3 sm:py-4 text-white focus:ring-2 focus:ring-[#ffb204]/50 focus:border-[#ffb204]/50 outline-none text-sm transition-all appearance-none cursor-pointer"
                        style={{
                          backgroundImage: `url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%236b7280' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e")`,
                          backgroundRepeat: "no-repeat",
                          backgroundPosition: "right 1rem center",
                          backgroundSize: "1em",
                        }}
                      >
                        <option value="kitchen">Kitchen Set</option>
                        <option value="wardrobe">Lemari & Wardrobe</option>
                        <option value="backdrop">Backdrop TV</option>
                        <option value="wallpanel">Wallpanel</option>
                        <option value="furniture">Furniture Custom</option>
                        <option value="consultation">Konsultasi Saja</option>
                      </select>
                    </div>

                    {/* Message */}
                    <div className="space-y-1.5 sm:space-y-2">
                      <label className="text-gray-400 text-[11px] sm:text-xs font-medium">
                        Pesan
                      </label>
                      <textarea
                        name="message"
                        value={formData.message}
                        onChange={handleChange}
                        className="w-full bg-[#0a0c10] border border-white/[0.08] rounded-lg sm:rounded-xl px-3 sm:px-4 py-3 sm:py-4 text-white focus:ring-2 focus:ring-[#ffb204]/50 focus:border-[#ffb204]/50 outline-none text-sm placeholder-gray-600 resize-none transition-all"
                        placeholder="Ceritakan tentang proyek Anda..."
                        rows={3}
                      />
                    </div>

                    {/* Submit Button */}
                    <button
                      type="submit"
                      disabled={isSubmitting}
                      className="group relative w-full py-3.5 sm:py-4 md:py-5 bg-gradient-to-r from-[#ffb204] to-yellow-500 text-black rounded-lg sm:rounded-xl font-bold text-xs sm:text-sm uppercase tracking-wider overflow-hidden transition-all hover:shadow-2xl hover:shadow-[#ffb204]/30 disabled:opacity-50"
                    >
                      <div className="absolute inset-0 bg-gradient-to-r from-transparent via-white/30 to-transparent -translate-x-full group-hover:translate-x-full transition-transform duration-1000"></div>
                      <span className="relative flex items-center justify-center gap-2 sm:gap-3">
                        {isSubmitting ? (
                          <>
                            <span className="material-symbols-outlined animate-spin text-base sm:text-lg">
                              progress_activity
                            </span>
                            <span>Mengirim...</span>
                          </>
                        ) : (
                          <>
                            <span className="material-symbols-outlined text-base sm:text-lg">
                              send
                            </span>
                            <span className="hidden sm:inline">
                              Kirim Permintaan
                            </span>
                            <span className="sm:hidden">Kirim</span>
                            <span className="material-symbols-outlined text-base sm:text-lg transition-transform group-hover:translate-x-1">
                              arrow_forward
                            </span>
                          </>
                        )}
                      </span>
                    </button>

                    {/* Form Message */}
                    {formMessage && (
                      <div
                        className={`text-center p-3 sm:p-4 rounded-lg sm:rounded-xl text-sm ${
                          formMessage.type === "success"
                            ? "bg-green-500/20 text-green-400"
                            : "bg-red-500/20 text-red-400"
                        }`}
                      >
                        <span className="flex items-center justify-center gap-2">
                          <span className="material-symbols-outlined text-sm">
                            {formMessage.type === "success"
                              ? "check_circle"
                              : "error"}
                          </span>
                          {formMessage.text}
                        </span>
                      </div>
                    )}

                    {/* Trust Note */}
                    <div className="flex flex-wrap items-center justify-center gap-3 sm:gap-4 md:gap-6 pt-2 sm:pt-4 text-gray-500 text-[10px] sm:text-xs">
                      {["Aman", "24 Jam", "Gratis"].map((label) => (
                        <span
                          key={label}
                          className="flex items-center gap-1 sm:gap-1.5"
                        >
                          <span className="material-symbols-outlined text-green-400 text-sm sm:text-base">
                            check_circle
                          </span>
                          {label}
                        </span>
                      ))}
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>

        {/* WhatsApp CTA */}
        <div
          className="mt-8 sm:mt-10 md:mt-12 text-center"
          data-aos="fade-up"
          data-aos-delay="200"
        >
          <p className="text-gray-500 text-xs sm:text-sm mb-4 sm:mb-6">
            Butuh respons cepat?
          </p>
          <Link
            href="https://wa.me/6283137554972"
            className="inline-flex items-center gap-2 sm:gap-3 px-5 sm:px-6 md:px-8 py-3 sm:py-4 bg-green-500 hover:bg-green-600 text-white rounded-lg sm:rounded-xl font-bold text-xs sm:text-sm uppercase tracking-wider transition-all hover:shadow-xl hover:shadow-green-500/30 group"
          >
            <span className="material-symbols-outlined text-base sm:text-lg">
              chat
            </span>
            <span className="hidden sm:inline">Chat WhatsApp Sekarang</span>
            <span className="sm:hidden">WhatsApp</span>
            <span className="material-symbols-outlined text-base sm:text-lg transition-transform group-hover:translate-x-1">
              arrow_forward
            </span>
          </Link>
        </div>
      </div>
    </section>
  );
}
