"use client";

import Link from "next/link";
import Image from "next/image";
import { useState } from "react";

// Material data
const materials = [
  {
    id: "aluminium-acp",
    name: "Aluminium + ACP",
    grade: "A",
    image: "https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=800&q=80",
    badge: "Best Seller",
    badgeIcon: "workspace_premium",
    features: ["Anti Air", "Anti Rayap", "Tahan Lama"],
    description: "Rangka aluminium kokoh dengan panel ACP 4mm. Material premium dengan daya tahan tertinggi.",
    priceSame: true,
    prices: [
      { type: "Minimalis", dalam: 3500000, luar: 3500000 },
      { type: "Premium", dalam: 4500000, luar: 4500000 },
      { type: "Semi Klasik", dalam: 5000000, luar: 5000000 },
      { type: "Luxury", dalam: 5500000, luar: 5500000 },
    ],
  },
  {
    id: "pvc-board",
    name: "PVC Board",
    grade: "B",
    image: "https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?auto=format&fit=crop&w=800&q=80",
    badge: "Tahan Air",
    badgeIcon: "water_drop",
    features: ["Anti Air", "Anti Rayap", "Ringan"],
    description: "Material PVC tebal 18mm dengan finishing HPL. Tahan air dan rayap sempurna.",
    priceSame: false,
    diff: "+100rb",
    prices: [
      { type: "Minimalis", dalam: 4000000, luar: 4100000 },
      { type: "Semi Klasik", dalam: 4500000, luar: 4600000 },
      { type: "Klasik", dalam: 5000000, luar: 5100000 },
      { type: "Luxury", dalam: 5500000, luar: 5600000 },
    ],
  },
  {
    id: "multipleks-hpl",
    name: "Multipleks HPL",
    grade: "B",
    image: "https://images.unsplash.com/photo-1600210492486-724fe5c67fb0?auto=format&fit=crop&w=800&q=80",
    badge: "Populer",
    badgeIcon: "star",
    features: ["Struktur Kuat", "Finishing HPL", "Tahan Lama"],
    description: "Plywood 18mm dengan finishing HPL berkualitas. Pilihan populer untuk berbagai gaya.",
    priceSame: false,
    diff: "+100rb",
    prices: [
      { type: "Minimalis", dalam: 2500000, luar: 2600000 },
      { type: "Semi Klasik", dalam: 2800000, luar: 2900000 },
      { type: "Klasik", dalam: 3200000, luar: 3300000 },
      { type: "Luxury", dalam: 3500000, luar: 3600000 },
    ],
  },
  {
    id: "multipleks-duco",
    name: "Multipleks Duco",
    grade: "B",
    image: "https://images.unsplash.com/photo-1616594039964-ae9021a400a0?auto=format&fit=crop&w=800&q=80",
    badge: "Premium",
    badgeIcon: "diamond",
    features: ["Glossy Finish", "Cat Duco", "Premium Look"],
    description: "Plywood dengan finishing cat Duco glossy premium. Tampilan mewah dan elegan.",
    priceSame: false,
    diff: "+500rb",
    prices: [
      { type: "Minimalis", dalam: 4500000, luar: 5000000 },
      { type: "Semi Klasik", dalam: 5000000, luar: 5500000 },
      { type: "Klasik", dalam: 5500000, luar: 6000000 },
      { type: "Luxury", dalam: 6000000, luar: 6500000 },
    ],
  },
  {
    id: "blockboard",
    name: "Blockboard",
    grade: "C",
    image: "https://images.unsplash.com/photo-1617806118233-18e1de247200?auto=format&fit=crop&w=800&q=80",
    badge: "Ekonomis",
    badgeIcon: "savings",
    features: ["Harga Terjangkau", "Finishing HPL", "Opsi Ekonomis"],
    description: "Material blockboard 18mm dengan finishing HPL. Pilihan ekonomis dengan kualitas baik.",
    priceSame: false,
    diff: "+300rb",
    prices: [
      { type: "Minimalis", dalam: 2000000, luar: 2300000 },
      { type: "Semi Klasik", dalam: 2300000, luar: 2600000 },
      { type: "Klasik", dalam: 2600000, luar: 2900000 },
      { type: "Luxury", dalam: 2900000, luar: 3200000 },
    ],
  },
];

const formatRupiah = (n: number) => {
  return "Rp " + n.toLocaleString("id-ID");
};

const gradeColors: Record<string, { bg: string; border: string; text: string }> = {
  A: { bg: "bg-emerald-500/20", border: "border-emerald-500/50", text: "text-emerald-400" },
  B: { bg: "bg-blue-500/20", border: "border-blue-500/50", text: "text-blue-400" },
  C: { bg: "bg-amber-500/20", border: "border-amber-500/50", text: "text-amber-400" },
};

export default function PricingPage() {
  const [activeModal, setActiveModal] = useState<string | null>(null);
  const [hoveredCard, setHoveredCard] = useState<string | null>(null);
  const [expandedTable, setExpandedTable] = useState<string | null>(null);

  const openModal = (id: string) => {
    setActiveModal(id);
    document.body.style.overflow = "hidden";
  };

  const closeModal = () => {
    setActiveModal(null);
    document.body.style.overflow = "auto";
  };

  return (
    <div className="min-h-screen bg-[#0a0c10]">
      {/* Hero Section */}
      <section className="relative pt-24 pb-8 sm:pt-28 sm:pb-12 lg:pt-32 lg:pb-20 overflow-hidden">
        {/* Background Elements */}
        <div className="absolute inset-0 pointer-events-none">
          <div className="absolute top-0 left-1/4 w-64 sm:w-96 h-64 sm:h-96 bg-[#ffb204]/5 rounded-full blur-[100px] sm:blur-[150px]"></div>
        </div>

        <div className="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          {/* Back Link */}
          <Link
            href="/"
            className="inline-flex items-center gap-2 text-gray-400 hover:text-[#ffb204] text-sm mb-6 transition-colors duration-300"
          >
            <span className="material-symbols-outlined text-lg">arrow_back</span>
            <span className="hidden sm:inline">Kembali ke Beranda</span>
            <span className="sm:hidden">Kembali</span>
          </Link>

          {/* Header */}
          <div className="text-center max-w-3xl mx-auto">
            <div className="inline-flex items-center gap-2 px-3 py-1.5 sm:px-4 sm:py-2 rounded-full bg-[#ffb204]/10 border border-[#ffb204]/30 mb-4 sm:mb-6">
              <span className="material-symbols-outlined text-[#ffb204] text-base sm:text-lg">inventory_2</span>
              <span className="text-[#ffb204] text-[10px] sm:text-xs font-bold uppercase tracking-widest">Katalog Material</span>
            </div>
            <h1 className="text-3xl sm:text-4xl lg:text-5xl xl:text-6xl text-white font-serif mb-3 sm:mb-4">
              Material <span className="text-[#ffb204] italic">Premium</span>
            </h1>
            <p className="text-gray-400 text-sm sm:text-base lg:text-lg max-w-2xl mx-auto px-2">
              Koleksi material furniture berkualitas tinggi dengan harga transparan.
            </p>
          </div>

          {/* Region Pills - Stacked on Mobile */}
          <div className="flex flex-col sm:flex-row flex-wrap justify-center gap-2 sm:gap-4 mt-6 sm:mt-10">
            <div className="flex items-center justify-center gap-2 px-4 py-2.5 sm:px-6 sm:py-3 rounded-xl sm:rounded-2xl bg-[#ffb204]/10 border border-[#ffb204]/30">
              <div className="w-2.5 h-2.5 rounded-full bg-[#ffb204]"></div>
              <span className="text-white text-sm font-medium">Dalam Kota</span>
              <span className="text-gray-500 text-xs">(Bandung)</span>
            </div>
            <div className="flex items-center justify-center gap-2 px-4 py-2.5 sm:px-6 sm:py-3 rounded-xl sm:rounded-2xl bg-white/5 border border-white/10">
              <div className="w-2.5 h-2.5 rounded-full bg-gray-400"></div>
              <span className="text-white text-sm font-medium">Luar Kota</span>
              <span className="text-gray-500 text-xs">(Jabodetabek, dll)</span>
            </div>
          </div>
        </div>
      </section>

      {/* Materials Grid */}
      <section className="py-6 sm:py-12 lg:py-20">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 lg:gap-8">
            {materials.map((m, i) => (
              <div
                key={m.id}
                className="group relative max-lg:opacity-100! max-lg:transform-none!"
                onMouseEnter={() => setHoveredCard(m.id)}
                onMouseLeave={() => setHoveredCard(null)}
                data-aos="fade-up"
                data-aos-delay={i * 80}
              >
                {/* Glow Effect - Desktop Only */}
                <div className={`hidden sm:block absolute -inset-0.5 bg-linear-to-r from-[#ffb204]/50 to-[#ffb204]/20 rounded-2xl sm:rounded-3xl blur-lg transition-opacity duration-500 ${hoveredCard === m.id ? "opacity-100" : "opacity-0"}`}></div>
                
                {/* Card */}
                <div className="relative bg-[#12151a] border border-white/10 rounded-2xl sm:rounded-3xl overflow-hidden transition-all duration-500 hover:border-[#ffb204]/30">
                  {/* Image */}
                  <div className="relative aspect-16/10 sm:aspect-4/3 overflow-hidden">
                    <Image
                      src={m.image}
                      alt={m.name}
                      fill
                      // OPTIMASI: Set ukuran responsif akurat untuk menghemat bandwidth
                      sizes="(max-width: 640px) 90vw, (max-width: 1024px) 50vw, 33vw"
                      className={`object-cover transition-all duration-700 ease-out ${hoveredCard === m.id ? "scale-110" : "scale-100"}`}
                      unoptimized={false} // Enable optimasi Next.js (jangan unoptimized)
                    />
                    {/* Overlay */}
                    <div className="absolute inset-0 bg-linear-to-t from-[#12151a] via-transparent to-transparent opacity-70"></div>
                    
                    {/* Badges */}
                    <div className="absolute top-3 sm:top-4 left-3 sm:left-4 right-3 sm:right-4 flex justify-between items-start">
                      <div className="flex items-center gap-1.5 px-2.5 py-1 sm:px-3 sm:py-1.5 bg-[#ffb204] text-black rounded-lg text-[11px] sm:text-xs font-bold shadow-lg">
                        <span className="material-symbols-outlined text-xs sm:text-sm">{m.badgeIcon}</span>
                        <span className="hidden xs:inline">{m.badge}</span>
                      </div>
                      <div className={`px-2.5 py-1 sm:px-3 sm:py-1.5 rounded-lg text-[11px] sm:text-xs font-bold ${gradeColors[m.grade].bg} ${gradeColors[m.grade].border} ${gradeColors[m.grade].text} border`}>
                        Grade {m.grade}
                      </div>
                    </div>

                    {/* Mobile Tap Button */}
                    <button
                      onClick={() => openModal(m.id)}
                      className="sm:hidden absolute inset-0 z-10"
                      aria-label={`Lihat detail ${m.name}`}
                    ></button>

                    {/* Desktop Hover Button */}
                    <button
                      onClick={() => openModal(m.id)}
                      className={`hidden sm:flex absolute left-1/2 -translate-x-1/2 bottom-6 items-center gap-2 px-5 py-2.5 bg-white text-black rounded-xl text-sm font-bold shadow-2xl transition-all duration-500 ease-out ${
                        hoveredCard === m.id ? "translate-y-0 opacity-100" : "translate-y-4 opacity-0"
                      }`}
                    >
                      <span className="material-symbols-outlined text-lg">visibility</span>
                      Lihat Detail
                    </button>
                  </div>

                  {/* Content */}
                  <div className="p-4 sm:p-5 lg:p-6">
                    <div className="flex items-start justify-between gap-2 mb-2">
                      <h3 className="text-base sm:text-lg lg:text-xl text-white font-bold">{m.name}</h3>
                      {/* Mobile View Button */}
                      <button
                        onClick={() => openModal(m.id)}
                        className="sm:hidden shrink-0 w-8 h-8 flex items-center justify-center rounded-lg bg-white/10 text-white"
                      >
                        <span className="material-symbols-outlined text-lg">arrow_forward</span>
                      </button>
                    </div>
                    <p className="text-gray-500 text-xs sm:text-sm mb-3 sm:mb-4 line-clamp-2">{m.description}</p>
                    
                    {/* Features - Horizontal Scroll on Mobile */}
                    <div className="flex gap-1.5 sm:gap-2 mb-4 sm:mb-5 overflow-x-auto pb-1 -mx-1 px-1 scrollbar-hide">
                      {m.features.map((f) => (
                        <span key={f} className="inline-flex items-center gap-1 px-2 py-1 sm:px-2.5 bg-white/5 rounded-lg text-[10px] sm:text-xs text-gray-400 whitespace-nowrap shrink-0">
                          <span className="text-[#ffb204] text-[8px] sm:text-[10px]">●</span> {f}
                        </span>
                      ))}
                    </div>
                    
                    {/* Price Box */}
                    <div className="relative bg-linear-to-br from-[#ffb204]/15 to-[#ffb204]/5 border border-[#ffb204]/20 rounded-xl sm:rounded-2xl p-3.5 sm:p-4 lg:p-5 overflow-hidden">
                      <div className="absolute top-0 right-0 w-16 h-16 bg-[#ffb204]/10 rounded-full blur-2xl"></div>
                      <div className="relative flex items-center justify-between">
                        <div>
                          <div className="text-gray-500 text-[10px] sm:text-xs uppercase tracking-wider mb-0.5">Mulai dari</div>
                          <div className="text-xl sm:text-2xl font-bold text-white">{formatRupiah(m.prices[0].dalam)}</div>
                          <div className="text-gray-500 text-[10px] sm:text-xs">/meter</div>
                        </div>
                        <div className="text-right">
                          {m.priceSame ? (
                            <div className="flex items-center gap-1 text-emerald-400">
                              <span className="material-symbols-outlined text-sm">check_circle</span>
                              <span className="text-[10px] sm:text-xs font-medium">Sama</span>
                            </div>
                          ) : (
                            <div className="text-right">
                              <span className="text-gray-500 text-[10px] sm:text-xs block">Luar:</span>
                              <span className="text-amber-400 text-xs sm:text-sm font-bold">{m.diff}</span>
                            </div>
                          )}
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* Detailed Price Tables - Accordion on Mobile */}
      <section className="py-8 sm:py-12 lg:py-20 bg-[#0d1015]">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="text-center mb-8 sm:mb-12">
            <span className="inline-flex items-center gap-2 px-3 py-1.5 sm:px-4 sm:py-2 rounded-full bg-[#ffb204]/10 border border-[#ffb204]/30 mb-3 sm:mb-4">
              <span className="material-symbols-outlined text-[#ffb204] text-sm sm:text-base">table_chart</span>
              <span className="text-[#ffb204] text-[10px] sm:text-xs font-bold uppercase tracking-widest">Detail Harga</span>
            </span>
            <h2 className="text-2xl sm:text-3xl lg:text-4xl text-white font-serif">
              Perbandingan <span className="text-[#ffb204] italic">Lengkap</span>
            </h2>
          </div>

          <div className="space-y-3 sm:space-y-4 lg:space-y-6">
            {materials.map((m) => (
              <div key={m.id} className="bg-[#12151a] border border-white/5 rounded-xl sm:rounded-2xl overflow-hidden">
                {/* Header - Clickable on Mobile */}
                <button
                  onClick={() => setExpandedTable(expandedTable === m.id ? null : m.id)}
                  className="w-full flex items-center gap-3 sm:gap-4 p-4 sm:p-5 lg:p-6 bg-white/2 text-left sm:cursor-default"
                >
                  <div className="w-12 h-12 sm:w-14 sm:h-14 lg:w-16 lg:h-16 rounded-lg sm:rounded-xl overflow-hidden relative flex-shrink-0">
                    <Image src={m.image} alt={m.name} fill className="object-cover" unoptimized />
                  </div>
                  <div className="flex-1 min-w-0">
                    <h3 className="text-base sm:text-lg lg:text-xl text-white font-bold truncate">{m.name}</h3>
                    <p className="text-gray-500 text-xs sm:text-sm mt-0.5 truncate hidden sm:block">{m.description}</p>
                  </div>
                  <div className="flex items-center gap-2 sm:gap-3">
                    <div className={`px-2.5 py-1 sm:px-3 sm:py-1.5 rounded-lg text-[10px] sm:text-xs font-bold ${m.priceSame ? "bg-emerald-500/10 border border-emerald-500/30 text-emerald-400" : "bg-amber-500/10 border border-amber-500/30 text-amber-400"}`}>
                      {m.priceSame ? "Sama" : m.diff}
                    </div>
                    <span className={`material-symbols-outlined text-gray-400 text-xl sm:hidden transition-transform duration-300 ${expandedTable === m.id ? "rotate-180" : ""}`}>
                      expand_more
                    </span>
                  </div>
                </button>

                {/* Table - Always visible on Desktop, Collapsible on Mobile */}
                <div className={`overflow-hidden transition-all duration-300 sm:max-h-none! sm:opacity-100! ${expandedTable === m.id ? "max-h-96 opacity-100" : "max-h-0 opacity-0 sm:max-h-none! sm:opacity-100!"}`}>
                  <div className="overflow-x-auto">
                    <table className="w-full min-w-[300px]">
                      <thead>
                        <tr className="border-t border-b border-white/5">
                          <th className="px-4 sm:px-5 py-2.5 sm:py-3 text-left text-gray-500 text-[10px] sm:text-xs uppercase tracking-wider font-medium">Model</th>
                          <th className="px-4 sm:px-5 py-2.5 sm:py-3 text-right text-gray-500 text-[10px] sm:text-xs uppercase tracking-wider font-medium">Dalam</th>
                          <th className="px-4 sm:px-5 py-2.5 sm:py-3 text-right text-gray-500 text-[10px] sm:text-xs uppercase tracking-wider font-medium">Luar</th>
                        </tr>
                      </thead>
                      <tbody>
                        {m.prices.map((p) => (
                          <tr key={p.type} className="border-b border-white/5 last:border-b-0">
                            <td className="px-4 sm:px-5 py-3 sm:py-3.5 text-white text-sm sm:text-base font-medium">{p.type}</td>
                            <td className="px-4 sm:px-5 py-3 sm:py-3.5 text-right text-gray-300 text-sm sm:text-base">{formatRupiah(p.dalam)}</td>
                            <td className="px-4 sm:px-5 py-3 sm:py-3.5 text-right text-[#ffb204] text-sm sm:text-base font-semibold">{formatRupiah(p.luar)}</td>
                          </tr>
                        ))}
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* Shipping Info */}
      <section className="py-8 sm:py-12 lg:py-20">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="text-center mb-8 sm:mb-12">
            <span className="inline-flex items-center gap-2 px-3 py-1.5 sm:px-4 sm:py-2 rounded-full bg-[#ffb204]/10 border border-[#ffb204]/30 mb-3 sm:mb-4">
              <span className="material-symbols-outlined text-[#ffb204] text-sm sm:text-base">local_shipping</span>
              <span className="text-[#ffb204] text-[10px] sm:text-xs font-bold uppercase tracking-widest">Pengiriman</span>
            </span>
            <h2 className="text-2xl sm:text-3xl lg:text-4xl text-white font-serif">
              Ongkos <span className="text-[#ffb204] italic">Kirim</span>
            </h2>
          </div>

          <div className="grid grid-cols-1 sm:grid-cols-3 gap-3 sm:gap-4 lg:gap-5">
            {[
              { icon: "local_shipping", price: "Rp 500rb", desc: "Proyek < Rp 15jt", label: "Dalam Kota", colorClass: "amber" },
              { icon: "flight", price: "Rp 1 juta", desc: "Proyek 15-20jt", label: "Luar Area", colorClass: "blue" },
              { icon: "verified", price: "GRATIS", desc: "Proyek ≥ Rp 20jt", label: "Free Ongkir", colorClass: "emerald", highlight: true },
            ].map((item, idx) => (
              <div
                key={idx}
                className={`group relative p-5 sm:p-6 lg:p-8 rounded-xl sm:rounded-2xl bg-[#12151a] border text-center transition-all duration-300 hover:-translate-y-1 ${
                  item.highlight ? "border-emerald-500/30" : "border-white/5"
                }`}
              >
                <div className={`w-12 h-12 sm:w-14 sm:h-14 lg:w-16 lg:h-16 rounded-xl sm:rounded-2xl flex items-center justify-center mx-auto mb-3 sm:mb-4 lg:mb-5 transition-transform duration-300 group-hover:scale-110 ${
                  item.colorClass === "amber" ? "bg-amber-500/10" : item.colorClass === "blue" ? "bg-blue-500/10" : "bg-emerald-500/10"
                }`}>
                  <span className={`material-symbols-outlined text-2xl sm:text-3xl ${
                    item.colorClass === "amber" ? "text-amber-400" : item.colorClass === "blue" ? "text-blue-400" : "text-emerald-400"
                  }`}>{item.icon}</span>
                </div>
                <div className={`text-xl sm:text-2xl lg:text-3xl font-bold mb-1 sm:mb-2 ${item.highlight ? "text-emerald-400" : "text-white"}`}>
                  {item.price}
                </div>
                <div className="text-gray-500 text-xs sm:text-sm mb-2 sm:mb-3">{item.desc}</div>
                <span className={`inline-block px-3 py-1 sm:px-4 sm:py-1.5 rounded-full text-[10px] sm:text-xs font-bold ${
                  item.colorClass === "amber" ? "bg-amber-500/10 text-amber-400" : 
                  item.colorClass === "blue" ? "bg-blue-500/10 text-blue-400" : 
                  "bg-emerald-500/10 text-emerald-400"
                }`}>
                  {item.label}
                </span>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* CTA Section */}
      <section className="py-8 sm:py-12 lg:py-20">
        <div className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="relative rounded-2xl sm:rounded-3xl overflow-hidden">
            {/* Background */}
            <div className="absolute inset-0 bg-linear-to-r from-[#ffb204]/20 to-[#ffb204]/5"></div>
            <div className="absolute top-0 right-0 w-40 sm:w-64 h-40 sm:h-64 bg-[#ffb204]/20 rounded-full blur-[80px] sm:blur-[100px]"></div>
            
            <div className="relative p-6 sm:p-10 lg:p-16 text-center">
              <span className="material-symbols-outlined text-[#ffb204] text-4xl sm:text-5xl mb-4 sm:mb-6">calculate</span>
              <h2 className="text-2xl sm:text-3xl lg:text-4xl text-white font-serif mb-3 sm:mb-4">
                Siap <span className="text-[#ffb204] italic">Memulai</span>?
              </h2>
              <p className="text-gray-400 text-sm sm:text-base max-w-lg mx-auto mb-6 sm:mb-8">
                Hitung estimasi biaya proyek Anda secara instan dengan kalkulator interaktif.
              </p>
              <div className="flex flex-col sm:flex-row gap-3 sm:gap-4 justify-center">
                <Link
                  href="/calculator"
                  className="inline-flex items-center justify-center gap-2 h-12 sm:h-14 px-6 sm:px-8 bg-[#ffb204] hover:bg-[#e6a000] text-black font-bold rounded-xl transition-all duration-300 hover:shadow-xl hover:shadow-[#ffb204]/30"
                >
                  <span className="material-symbols-outlined text-xl">calculate</span>
                  Hitung Estimasi
                </Link>
                <Link
                  href="/#contact"
                  className="inline-flex items-center justify-center gap-2 h-12 sm:h-14 px-6 sm:px-8 bg-white/10 border border-white/20 text-white font-bold rounded-xl transition-all duration-300 hover:border-[#ffb204]/50"
                >
                  <span className="material-symbols-outlined text-xl">chat</span>
                  Konsultasi
                </Link>
              </div>
            </div>
          </div>
        </div>
      </section>

      {/* Modal - Full screen on Mobile */}
      {materials.map((m) => (
        <div key={`modal-${m.id}`}>
          {/* Overlay */}
          <div
            className={`fixed inset-0 bg-black/90 backdrop-blur-md z-[1000] transition-all duration-500 ${
              activeModal === m.id ? "opacity-100 visible" : "opacity-0 invisible"
            }`}
            onClick={closeModal}
          ></div>
          
          {/* Modal Content - Full height on mobile */}
          <div
            className={`fixed inset-x-0 bottom-0 sm:inset-auto sm:top-1/2 sm:left-1/2 sm:-translate-x-1/2 w-full sm:w-[95%] sm:max-w-[900px] max-h-[90vh] sm:max-h-[85vh] overflow-y-auto bg-[#12151a] border-t sm:border border-white/10 rounded-t-3xl sm:rounded-3xl z-1001 transition-all duration-500 ease-out ${
              activeModal === m.id 
                ? "opacity-100 visible translate-y-0 sm:-translate-y-1/2 scale-100" 
                : "opacity-0 invisible translate-y-full sm:translate-y-0 sm:-translate-y-[45%] sm:scale-95"
            }`}
          >
            {/* Mobile Drag Handle */}
            <div className="sm:hidden flex justify-center py-3">
              <div className="w-10 h-1 bg-white/20 rounded-full"></div>
            </div>

            {/* Close Button */}
            <button
              onClick={closeModal}
              className="absolute top-3 right-3 sm:top-4 sm:right-4 z-10 w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-white/10 hover:bg-white/20 flex items-center justify-center text-white transition-all duration-300"
            >
              <span className="material-symbols-outlined text-xl">close</span>
            </button>

            <div className="grid sm:grid-cols-2">
            {/* Image - Hidden on small mobile */}
              <div className="hidden sm:block relative aspect-square sm:aspect-auto bg-slate-800">
                <Image 
                  src={m.image} 
                  alt={m.name} 
                  fill 
                  sizes="(max-width: 640px) 100vw, 50vw" // Optimasi sizes untuk modal
                  className="object-cover" 
                  unoptimized={false} // Enable optimasi
                />
                <div className="absolute inset-0 bg-linear-to-t from-[#12151a] to-transparent opacity-50"></div>
              </div>

              {/* Content */}
              <div className="p-5 sm:p-6 lg:p-8">
                <div className={`inline-block px-2.5 py-1 sm:px-3 sm:py-1.5 rounded-lg ${gradeColors[m.grade].bg} ${gradeColors[m.grade].border} ${gradeColors[m.grade].text} text-[10px] sm:text-xs font-bold border mb-3 sm:mb-4`}>
                  Grade {m.grade}
                </div>
                <h3 className="text-xl sm:text-2xl lg:text-3xl text-white font-bold mb-2 sm:mb-3">{m.name}</h3>
                <p className="text-gray-400 text-sm sm:text-base mb-4 sm:mb-6">{m.description}</p>
                
                <div className="flex flex-wrap gap-1.5 sm:gap-2 mb-5 sm:mb-6">
                  {m.features.map((f) => (
                    <span key={f} className="inline-flex items-center gap-1 px-2.5 py-1 sm:px-3 sm:py-1.5 bg-white/5 border border-white/10 rounded-lg text-[10px] sm:text-xs text-gray-400">
                      <span className="text-[#ffb204]">✓</span> {f}
                    </span>
                  ))}
                </div>

                <div className="border-t border-white/10 pt-4 sm:pt-6">
                  <h4 className="text-white font-bold mb-3 sm:mb-4 flex items-center gap-2 text-sm sm:text-base">
                    <span className="material-symbols-outlined text-[#ffb204] text-lg sm:text-xl">payments</span>
                    Daftar Harga
                  </h4>
                  <div className="space-y-2 sm:space-y-3">
                    {m.prices.map((p) => (
                      <div key={p.type} className="flex justify-between items-center py-2 px-3 rounded-lg bg-white/2">
                        <span className="text-gray-400 text-sm">{p.type}</span>
                        <span className="text-white font-bold text-sm sm:text-base">{formatRupiah(p.dalam)}</span>
                      </div>
                    ))}
                  </div>
                </div>

                <Link
                  href="/calculator"
                  onClick={closeModal}
                  className="w-full mt-5 sm:mt-6 h-11 sm:h-12 inline-flex items-center justify-center gap-2 bg-[#ffb204] hover:bg-[#e6a000] text-black font-bold rounded-xl transition-all duration-300 text-sm sm:text-base"
                >
                  <span className="material-symbols-outlined text-lg sm:text-xl">calculate</span>
                  Hitung Estimasi
                </Link>
              </div>
            </div>
          </div>
        </div>
      ))}

      {/* Custom Scrollbar Hide */}
      <style jsx global>{`
        .scrollbar-hide::-webkit-scrollbar {
          display: none;
        }
        .scrollbar-hide {
          -ms-overflow-style: none;
          scrollbar-width: none;
        }
      `}</style>
    </div>
  );
}
