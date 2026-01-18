"use client";

import { useState, useEffect } from "react";
import Link from "next/link";
import AOS from "aos";
import "aos/dist/aos.css";

// Data produk
const products = [
  { id: 1, name: "Kitchen Set", slug: "kitchen-set", icon: "countertops", minPrice: 2000000 },
  { id: 2, name: "Lemari & Wardrobe", slug: "wardrobe", icon: "door_sliding", minPrice: 2300000 },
  { id: 3, name: "Backdrop TV", slug: "backdrop-tv", icon: "tv", minPrice: 2100000 },
  { id: 4, name: "Wallpanel", slug: "wallpanel", icon: "dashboard", minPrice: 850000 },
];

// Data material
const materials = [
  { id: 1, name: "Aluminium + ACP", grade: "A", isWaterproof: true, isTermiteResistant: true, prices: { 1: 3500000, 2: 4000000, 3: 4500000, 4: 5000000 } },
  { id: 2, name: "PVC Board", grade: "B", isWaterproof: true, isTermiteResistant: true, prices: { 1: 4000000, 2: 4500000, 3: 5000000, 4: 5500000 } },
  { id: 3, name: "Multipleks HPL", grade: "B", isWaterproof: false, isTermiteResistant: false, prices: { 1: 2500000, 2: 2800000, 3: 3200000, 4: 3500000 } },
  { id: 4, name: "Multipleks Duco", grade: "B", isWaterproof: false, isTermiteResistant: false, prices: { 1: 4500000, 2: 5000000, 3: 5500000, 4: 6000000 } },
  { id: 5, name: "Blockboard", grade: "C", isWaterproof: false, isTermiteResistant: false, prices: { 1: 2000000, 2: 2300000, 3: 2600000, 4: 2900000 } },
];

// Data model
const models = [
  { id: 1, name: "Minimalis" },
  { id: 2, name: "Semi Klasik" },
  { id: 3, name: "Klasik" },
  { id: 4, name: "Luxury" },
];

// Data lokasi Jawa Barat
const jabarLocations = [
  "Kota Bandung", "Kota Bekasi", "Kota Bogor", "Kota Cimahi", "Kota Cirebon", 
  "Kota Depok", "Kota Sukabumi", "Kota Tasikmalaya",
  "Kabupaten Bandung", "Kabupaten Bandung Barat", "Kabupaten Bekasi", "Kabupaten Bogor",
  "Kabupaten Ciamis", "Kabupaten Cianjur", "Kabupaten Cirebon", "Kabupaten Garut",
  "Kabupaten Indramayu", "Kabupaten Karawang", "Kabupaten Kuningan", "Kabupaten Majalengka",
  "Kabupaten Pangandaran", "Kabupaten Purwakarta", "Kabupaten Subang", "Kabupaten Sukabumi",
  "Kabupaten Sumedang", "Kabupaten Tasikmalaya"
];

const gradeColors: Record<string, string> = {
  A: "bg-green-500/20 text-green-400",
  B: "bg-blue-500/20 text-blue-400",
  C: "bg-yellow-500/20 text-yellow-400",
};

export default function CalculatorPage() {
  const [currentStep, setCurrentStep] = useState(1);
  const [customerName, setCustomerName] = useState("");
  const [locationType, setLocationType] = useState<"dalam_kota" | "luar_kota">("dalam_kota");
  const [selectedJabarLocation, setSelectedJabarLocation] = useState("");
  const [provinsi, setProvinsi] = useState("");
  const [kota, setKota] = useState("");
  const [selectedProduct, setSelectedProduct] = useState(products[0]);
  const [selectedMaterial, setSelectedMaterial] = useState(materials[0]);
  const [selectedModel, setSelectedModel] = useState(models[0]);
  const [length, setLength] = useState(3);
  const [includeShipping, setIncludeShipping] = useState(true);
  const [showResult, setShowResult] = useState(false);
  const [jabarDropdownOpen, setJabarDropdownOpen] = useState(false);
  const [jabarSearch, setJabarSearch] = useState("");

  const filteredLocations = jabarLocations.filter(loc => 
    loc.toLowerCase().includes(jabarSearch.toLowerCase())
  );

  const formatCurrency = (amount: number) => {
    return new Intl.NumberFormat("id-ID", {
      style: "currency",
      currency: "IDR",
      minimumFractionDigits: 0,
    }).format(amount);
  };

  const getPricePerMeter = (materialId: number, modelId: number) => {
    const material = materials.find(m => m.id === materialId);
    if (!material) return 0;
    return material.prices[modelId as keyof typeof material.prices] || 0;
  };

  const calculateEstimate = () => {
    const pricePerMeter = getPricePerMeter(selectedMaterial.id, selectedModel.id);
    const subtotal = pricePerMeter * length;
    
    // Shipping calculation
    let shippingCost = 0;
    let shippingLabel = "Gratis Ongkir";
    
    if (includeShipping) {
      if (subtotal < 15000000) {
        shippingCost = locationType === "dalam_kota" ? 500000 : 1000000;
        shippingLabel = formatCurrency(shippingCost);
      } else if (subtotal < 20000000) {
        shippingCost = locationType === "dalam_kota" ? 250000 : 750000;
        shippingLabel = formatCurrency(shippingCost);
      }
    }
    
    const total = subtotal + shippingCost;
    const minTotal = Math.round(total * 0.9);
    const maxTotal = Math.round(total * 1.1);

    return {
      pricePerMeter,
      subtotal,
      shippingCost,
      shippingLabel,
      total,
      minTotal,
      maxTotal,
    };
  };

  const estimate = calculateEstimate();

  const getLocationLabel = () => {
    if (locationType === "dalam_kota") {
      return selectedJabarLocation || "Jawa Barat";
    }
    return [kota, provinsi].filter(Boolean).join(", ") || "Luar Jawa Barat";
  };

  const getBadge = () => {
    if (estimate.total < 10000000) return { text: "Ekonomis", color: "bg-green-500/20 text-green-400" };
    if (estimate.total > 30000000) return { text: "Premium", color: "bg-purple-500/20 text-purple-400" };
    return { text: "Best Value", color: "bg-[#ffb204]/20 text-[#ffb204]" };
  };

  const badge = getBadge();

  const handleNextStep = () => {
    if (currentStep === 1) {
      if (!customerName.trim()) {
        alert("Mohon masukkan nama Anda");
        return;
      }
      if (locationType === "dalam_kota" && !selectedJabarLocation) {
        alert("Mohon pilih kota/kabupaten");
        return;
      }
      if (locationType === "luar_kota" && (!provinsi || !kota)) {
        alert("Mohon lengkapi lokasi Anda");
        return;
      }
    }
    if (currentStep < 3) {
      setCurrentStep(currentStep + 1);
    }
  };

  const handleCalculate = () => {
    setShowResult(true);
  };

  const handleReset = () => {
    setCurrentStep(1);
    setShowResult(false);
    setCustomerName("");
    setSelectedJabarLocation("");
    setProvinsi("");
    setKota("");
    setLength(3);
  };

  const sendToWhatsApp = () => {
    const waNumber = "6283137554972";
    const today = new Date().toLocaleDateString("id-ID", { 
      day: "numeric", month: "long", year: "numeric" 
    });
    
    // Build complete address
    let alamatLengkap = "";
    if (locationType === "dalam_kota") {
      alamatLengkap = selectedJabarLocation ? `${selectedJabarLocation}, Jawa Barat` : "Jawa Barat";
    } else {
      alamatLengkap = [kota, provinsi].filter(Boolean).join(", ") || "Luar Jawa Barat";
    }
    
    // Build message
    let message = `*FORMULIR ESTIMASI PROYEK*\n`;
    message += `📅 Tanggal: ${today}\n\n`;
    
    message += `*👤 DATA PELANGGAN*\n`;
    message += `Nama: ${customerName || "Belum diisi"}\n`;
    message += `Alamat: ${alamatLengkap}\n`;
    message += `Wilayah: ${locationType === "dalam_kota" ? "Jawa Barat" : "Luar Jawa Barat"}\n\n`;
    
    message += `*📦 DETAIL PESANAN*\n`;
    message += `Produk: ${selectedProduct.name}\n`;
    message += `Material: ${selectedMaterial.name} (Grade ${selectedMaterial.grade})\n`;
    message += `Model: ${selectedModel.name}\n`;
    message += `Panjang: ${length} meter lari\n\n`;
    
    message += `*💰 RINCIAN BIAYA*\n`;
    message += `Harga/meter: ${formatCurrency(estimate.pricePerMeter)}\n`;
    message += `Subtotal: ${formatCurrency(estimate.subtotal)}\n`;
    message += `Ongkos Kirim: ${estimate.shippingLabel}\n`;
    message += `─────────────────\n`;
    message += `*ESTIMASI TOTAL:*\n`;
    message += `${formatCurrency(estimate.minTotal)} – ${formatCurrency(estimate.maxTotal)}\n\n`;
    
    message += `📌 _Estimasi ±10%, harga final setelah survey lokasi_\n\n`;
    message += `Saya tertarik dengan penawaran ini. Mohon konfirmasi untuk jadwal survey lokasi. Terima kasih! 🙏`;

    const text = encodeURIComponent(message);
    window.open(`https://wa.me/${waNumber}?text=${text}`, "_blank");
  };

  return (
    <div className="min-h-screen bg-[#0a0c10] pt-24 text-white">
      {/* Hero */}
      <section className="py-12 relative overflow-hidden">
        <div className="absolute inset-0 pointer-events-none">
          <div className="absolute top-0 right-0 w-1/2 h-full bg-linear-to-l from-[#ffb204]/10 to-transparent"></div>
          <div className="absolute top-20 left-1/4 w-72 h-72 bg-[#ffb204]/5 rounded-full blur-[100px]"></div>
        </div>

        <div className="max-w-[1200px] mx-auto px-6 relative z-10 text-center">
          <div className="mb-8" data-aos="fade-up">
            <span className="inline-flex items-center gap-2 px-4 py-2 bg-[#ffb204]/10 border border-[#ffb204]/20 rounded-full text-[#ffb204] text-xs font-bold uppercase tracking-widest mb-6">
              <span className="material-symbols-outlined text-sm">calculate</span>
              Kalkulator Anggaran
            </span>
            <h1 className="text-4xl md:text-5xl lg:text-6xl text-white font-serif mb-6">
              Hitung <span className="text-[#ffb204] italic">Estimasi</span> Proyek Anda
            </h1>
            <p className="text-gray-400 max-w-2xl mx-auto font-light leading-relaxed text-lg">
              Masukkan spesifikasi proyek dan dapatkan estimasi harga yang transparan secara instan.
            </p>
          </div>

          <div className="flex flex-wrap justify-center gap-4 mb-8" data-aos="fade-up" data-aos-delay="100">
            {[
              { icon: "verified", text: "Harga Transparan" },
              { icon: "speed", text: "Hasil Instan" },
              { icon: "support_agent", text: "Konsultasi Gratis" },
            ].map((item) => (
              <div key={item.text} className="flex items-center gap-2 px-4 py-2 bg-white/5 border border-white/10 rounded-full text-sm text-gray-300">
                <span className="material-symbols-outlined text-[#ffb204] text-lg">{item.icon}</span>
                {item.text}
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* Calculator Form */}
      <section className="py-8 sm:py-12 lg:pb-16">
        <div className="max-w-[1200px] mx-auto px-4 sm:px-6">
          <div className="grid grid-cols-1 lg:grid-cols-5 gap-6 lg:gap-8">
            
            <div className="lg:col-span-3">
              <div className="bg-linear-to-br from-[#1a1d26] to-[#14171f] border border-white/10 rounded-2xl p-4 sm:p-6 lg:p-8 shadow-2xl relative overflow-hidden">
                <div className="absolute -top-3 -left-3 w-12 h-12 border-t-2 border-l-2 border-[#ffb204]/50"></div>
                <div className="absolute -bottom-3 -right-3 w-12 h-12 border-b-2 border-r-2 border-[#ffb204]/50"></div>

                {/* Step Indicator */}
                <div className="flex items-center justify-center gap-2 sm:gap-4 mb-8 relative z-10">
                  {[1, 2, 3].map((step) => (
                    <div key={step} className="flex items-center gap-2">
                       <div className="flex items-center gap-1 sm:gap-2">
                          <div className={`w-10 h-10 sm:w-12 sm:h-12 rounded-full flex items-center justify-center text-sm font-bold transition-all ${
                            step === currentStep 
                              ? "bg-[#ffb204] text-black shadow-lg shadow-[#ffb204]/30"
                              : step < currentStep
                              ? "bg-[#ffb204] text-black shadow-lg shadow-[#ffb204]/30"
                              : "bg-white/10 text-white/50"
                          }`}>
                            {step < currentStep ? (
                              <span className="material-symbols-outlined text-lg">check</span>
                            ) : step}
                          </div>
                          <span className={`hidden sm:block text-xs font-medium ${
                            step <= currentStep ? "text-white" : "text-gray-500"
                          }`}>
                            {step === 1 ? "Lokasi" : step === 2 ? "Material" : "Ukuran"}
                          </span>
                       </div>
                       {step < 3 && (
                          <div className="h-0.5 w-8 sm:w-16 bg-white/10 rounded-full overflow-hidden">
                            <div className={`h-full bg-[#ffb204] transition-all duration-500`} 
                                 style={{ width: step < currentStep ? "100%" : "0%" }}></div>
                          </div>
                       )}
                    </div>
                  ))}
                </div>

                {/* Step 1 */}
                {currentStep === 1 && (
                  <div className="space-y-6 relative z-10">
                     <h3 className="text-xl text-white font-semibold flex items-center gap-3">
                        <span className="w-10 h-10 rounded-xl bg-[#ffb204]/20 flex items-center justify-center">
                          <span className="material-symbols-outlined text-[#ffb204]">location_on</span>
                        </span>
                        Pilih Lokasi & Produk
                     </h3>
                     
                     <div>
                        <label className="block text-xs uppercase tracking-widest font-bold text-gray-300 mb-2">Nama Lengkap</label>
                        <div className="relative">
                          <input
                            type="text"
                            value={customerName}
                            onChange={(e) => setCustomerName(e.target.value)}
                            className="w-full bg-[#0a0c10] border border-white/10 rounded-xl p-4 pl-12 text-white focus:border-[#ffb204] focus:ring-1 focus:ring-[#ffb204] outline-none"
                            placeholder="Masukkan nama Anda..."
                          />
                          <span className="absolute left-4 top-1/2 -translate-y-1/2 material-symbols-outlined text-gray-500">person</span>
                        </div>
                     </div>

                     <div>
                        <label className="block text-xs uppercase tracking-widest font-bold text-gray-300 mb-2">Jangkauan Lokasi</label>
                        <div className="grid grid-cols-1 sm:grid-cols-2 gap-3">
                           {[
                              { id: "dalam_kota", name: "Jawa Barat", desc: "Area Cakupan Utama", icon: "home_pin" },
                              { id: "luar_kota", name: "Luar Jawa Barat", desc: "Nasional & Global", icon: "local_shipping" }
                           ].map((loc) => (
                              <label key={loc.id} className={`cursor-pointer border border-white/10 rounded-xl p-4 flex items-center gap-3 transition-all ${
                                 locationType === loc.id ? "bg-[#ffb204]/10 border-[#ffb204]" : "hover:border-white/30"
                              }`}>
                                 <input type="radio" className="hidden" name="locationType" checked={locationType === loc.id} onChange={() => setLocationType(loc.id as any)} />
                                 <div className={`w-10 h-10 rounded-lg flex items-center justify-center ${locationType === loc.id ? "bg-[#ffb204]/20 text-[#ffb204]" : "bg-white/5 text-gray-400"}`}>
                                    <span className="material-symbols-outlined">{loc.icon}</span>
                                 </div>
                                 <div>
                                    <div className="font-semibold text-white">{loc.name}</div>
                                    <div className="text-xs text-gray-400">{loc.desc}</div>
                                 </div>
                              </label>
                           ))}
                        </div>
                     </div>

                     {locationType === "dalam_kota" ? (
                        <div className="relative">
                           <label className="block text-xs uppercase tracking-widest font-bold text-gray-300 mb-2">Kota / Kabupaten</label>
                           <input
                              type="text"
                              value={jabarSearch || selectedJabarLocation}
                              onChange={(e) => { setJabarSearch(e.target.value); setJabarDropdownOpen(true); }}
                              onFocus={() => setJabarDropdownOpen(true)}
                              className="w-full bg-[#0a0c10] border border-white/10 rounded-xl p-4 pl-12 text-white focus:border-[#ffb204] outline-none"
                              placeholder="Cari lokasi..."
                           />
                           <span className="absolute left-4 top-[48px] material-symbols-outlined text-gray-500">search</span>
                           {jabarDropdownOpen && (
                              <div className="absolute left-0 right-0 top-full mt-2 bg-[#1a1d26] border border-white/10 rounded-xl max-h-48 overflow-y-auto z-50">
                                 {filteredLocations.map(loc => (
                                    <div key={loc} onClick={() => { setSelectedJabarLocation(loc); setJabarSearch(""); setJabarDropdownOpen(false); }} className="px-4 py-3 hover:bg-white/5 cursor-pointer text-gray-300 hover:text-[#ffb204]">
                                       {loc}
                                    </div>
                                 ))}
                              </div>
                           )}
                        </div>
                     ) : (
                        <div className="space-y-4">
                           <div>
                              <label className="block text-xs uppercase tracking-widest font-bold text-gray-300 mb-2">Provinsi</label>
                              <input type="text" value={provinsi} onChange={(e) => setProvinsi(e.target.value)} className="w-full bg-[#0a0c10] border border-white/10 rounded-xl p-4 text-white focus:border-[#ffb204] outline-none" placeholder="Contoh: Jawa Tengah" />
                           </div>
                           <div>
                              <label className="block text-xs uppercase tracking-widest font-bold text-gray-300 mb-2">Kota / Kabupaten</label>
                              <input type="text" value={kota} onChange={(e) => setKota(e.target.value)} className="w-full bg-[#0a0c10] border border-white/10 rounded-xl p-4 text-white focus:border-[#ffb204] outline-none" placeholder="Contoh: Semarang" />
                           </div>
                        </div>
                     )}

                     <div>
                        <label className="block text-xs uppercase tracking-widest font-bold text-gray-300 mb-2">Jenis Produk</label>
                        <div className="grid grid-cols-2 gap-3">
                           {products.map(prod => (
                              <button key={prod.id} onClick={() => setSelectedProduct(prod)} className={`p-4 border rounded-xl text-left transition-all ${
                                 selectedProduct.id === prod.id ? "border-[#ffb204] bg-[#ffb204]/10" : "border-white/10 hover:border-white/30"
                              }`}>
                                 <span className={`material-symbols-outlined text-3xl block mb-2 ${selectedProduct.id === prod.id ? "text-[#ffb204]" : "text-gray-400"}`}>{prod.icon}</span>
                                 <span className="text-sm font-bold text-white">{prod.name}</span>
                              </button>
                           ))}
                        </div>
                     </div>
                  </div>
                )}

                {/* Step 2 */}
                {currentStep === 2 && (
                  <div className="space-y-6 relative z-10">
                     <h3 className="text-xl text-white font-semibold flex items-center gap-3">
                        <span className="w-10 h-10 rounded-xl bg-[#ffb204]/20 flex items-center justify-center">
                          <span className="material-symbols-outlined text-[#ffb204]">category</span>
                        </span>
                        Pilih Material & Model
                     </h3>
                     
                     <div className="grid grid-cols-1 gap-3">
                        {materials.map(mat => (
                           <button key={mat.id} onClick={() => setSelectedMaterial(mat)} className={`p-4 border rounded-xl text-left transition-all ${
                              selectedMaterial.id === mat.id ? "border-[#ffb204] bg-[#ffb204]/10" : "border-white/10 hover:border-white/30"
                           }`}>
                              <div className="flex justify-between items-center mb-1">
                                 <span className="font-bold text-white">{mat.name}</span>
                                 <span className={`text-[10px] px-2 py-0.5 rounded ${gradeColors[mat.grade]}`}>Grade {mat.grade}</span>
                              </div>
                              <div className="flex gap-2">
                                 {mat.isWaterproof && <span className="text-[10px] text-blue-400">💧 Anti Air</span>}
                                 {mat.isTermiteResistant && <span className="text-[10px] text-green-400">🛡️ Anti Rayap</span>}
                              </div>
                           </button>
                        ))}
                     </div>

                     <div>
                        <label className="block text-xs uppercase tracking-widest font-bold text-gray-300 mb-2">Model</label>
                        <div className="grid grid-cols-2 gap-3">
                           {models.map(mod => (
                              <button key={mod.id} onClick={() => setSelectedModel(mod)} className={`p-3 border rounded-xl text-center text-sm font-medium transition-all ${
                                 selectedModel.id === mod.id ? "border-[#ffb204] bg-[#ffb204]/10 text-white" : "border-white/10 text-gray-400 hover:text-white"
                              }`}>
                                 {mod.name}
                              </button>
                           ))}
                        </div>
                     </div>
                     
                     <div className="bg-linear-to-br from-[#ffb204]/20 to-transparent p-5 rounded-xl border border-[#ffb204]/30">
                        <div className="text-xs text-[#ffb204] font-bold uppercase tracking-widest mb-1">Estimasi Harga Per Meter</div>
                        <div className="text-2xl font-bold text-white">{formatCurrency(getPricePerMeter(selectedMaterial.id, selectedModel.id))}</div>
                     </div>
                  </div>
                )}

                {/* Step 3 */}
                {currentStep === 3 && (
                  <div className="space-y-6 relative z-10">
                     <h3 className="text-xl text-white font-semibold flex items-center gap-3">
                        <span className="w-10 h-10 rounded-xl bg-[#ffb204]/20 flex items-center justify-center">
                          <span className="material-symbols-outlined text-[#ffb204]">straighten</span>
                        </span>
                        Ukuran & Biaya Tambahan
                     </h3>
                     
                     <div>
                        <label className="block text-xs uppercase tracking-widest font-bold text-gray-300 mb-2">Panjang (Meter)</label>
                        <div className="flex items-center gap-4">
                           <button onClick={() => setLength(Math.max(0.5, length - 0.5))} className="w-12 h-12 bg-white/5 rounded-xl border border-white/10 text-xl font-bold hover:bg-[#ffb204] hover:text-black transition-all">-</button>
                           <div className="flex-1 bg-[#0a0c10] border border-white/10 rounded-xl h-12 flex items-center justify-center text-xl font-bold text-white">
                              {length} m
                           </div>
                           <button onClick={() => setLength(length + 0.5)} className="w-12 h-12 bg-white/5 rounded-xl border border-white/10 text-xl font-bold hover:bg-[#ffb204] hover:text-black transition-all">+</button>
                        </div>
                        <input type="range" min="0.5" max="20" step="0.5" value={length} onChange={(e) => setLength(parseFloat(e.target.value))} className="w-full mt-4 accent-[#ffb204]" />
                     </div>
                     
                     <label className="flex items-center gap-3 p-4 border border-white/10 rounded-xl cursor-pointer hover:bg-white/5 transition-all">
                        <input type="checkbox" checked={includeShipping} onChange={(e) => setIncludeShipping(e.target.checked)} className="w-5 h-5 accent-[#ffb204]" />
                        <div className="flex-1">
                           <div className="font-bold text-white">Termasuk Ongkir & Pasang</div>
                           <div className="text-xs text-gray-400">Estimasi biaya pengiriman dan instalasi</div>
                        </div>
                     </label>
                  </div>
                )}

                {/* Navigation */}
                <div className="flex justify-between items-center mt-8 pt-6 border-t border-white/10">
                   {currentStep > 1 ? (
                      <button onClick={() => setCurrentStep(currentStep - 1)} className="px-6 py-3 bg-white/5 hover:bg-white/10 rounded-xl font-medium transition-all">Kembali</button>
                   ) : (
                      <button onClick={handleReset} className="px-6 py-3 text-gray-400 hover:text-white transition-all">Reset</button>
                   )}
                   
                   {currentStep < 3 ? (
                      <button onClick={handleNextStep} className="px-8 py-3 bg-[#ffb204] text-black font-bold rounded-xl hover:shadow-[0_0_20px_rgba(255,178,4,0.3)] transition-all">Lanjut</button>
                   ) : (
                      <button onClick={handleCalculate} className="px-8 py-3 bg-[#ffb204] text-black font-bold rounded-xl hover:shadow-[0_0_20px_rgba(255,178,4,0.3)] transition-all">Hitung</button>
                   )}
                </div>

              </div>
            </div>

            {/* Result Panel */}
            <div className="lg:col-span-2">
               <div className="bg-linear-to-br from-[#1a1d26] to-[#14171f] border border-white/10 rounded-2xl p-6 shadow-2xl sticky top-24">
                  <h3 className="text-lg font-bold text-white mb-6 flex items-center gap-2">
                     <span className="material-symbols-outlined text-[#ffb204]">receipt_long</span> Ringkasan
                  </h3>
                  
                  {!showResult ? (
                     <div className="py-10 text-center text-gray-500">
                        <span className="material-symbols-outlined text-4xl mb-2 opacity-50">calculate</span>
                        <p className="text-sm">Lengkapi data untuk melihat estimasi</p>
                     </div>
                  ) : (
                     <div className="space-y-4 animate-fade-in">
                        <div className="space-y-2 text-sm border-b border-white/10 pb-4">
                           <div className="flex justify-between"><span className="text-gray-400">Produk</span> <span className="text-white font-medium">{selectedProduct.name}</span></div>
                           <div className="flex justify-between"><span className="text-gray-400">Material</span> <span className="text-white font-medium">{selectedMaterial.name}</span></div>
                           <div className="flex justify-between"><span className="text-gray-400">Model</span> <span className="text-white font-medium">{selectedModel.name}</span></div>
                           <div className="flex justify-between"><span className="text-gray-400">Panjang</span> <span className="text-white font-medium">{length} m</span></div>
                           <div className="flex justify-between"><span className="text-gray-400">Lokasi</span> <span className="text-white font-medium">{locationType === 'dalam_kota' ? 'Jawa Barat' : 'Luar Jawa Barat'}</span></div>
                        </div>

                        <div className="bg-white/5 rounded-xl p-4 space-y-2">
                           <div className="flex justify-between text-sm"><span className="text-gray-400">Subtotal</span> <span className="text-white">{formatCurrency(estimate.subtotal)}</span></div>
                           <div className="flex justify-between text-sm"><span className="text-gray-400">Ongkir</span> <span className="text-white">{estimate.shippingLabel}</span></div>
                           <div className="pt-2 mt-2 border-t border-white/10">
                              <div className="text-xs text-[#ffb204] font-bold uppercase mb-1">Estimasi Total</div>
                              <div className="text-xl font-bold text-white">{formatCurrency(estimate.minTotal)} - {formatCurrency(estimate.maxTotal)}</div>
                           </div>
                        </div>

                        <div className="flex gap-2 mt-4">
                           <button onClick={sendToWhatsApp} className="flex-1 py-3 bg-green-600 hover:bg-green-500 text-white font-bold rounded-xl transition-all flex items-center justify-center gap-2 shadow-lg">
                              <svg className="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg> 
                              Pesan
                           </button>
                        </div>
                     </div>
                  )}
               </div>
            </div>
            
          </div>
        </div>
      </section>
    </div>
  );
}
