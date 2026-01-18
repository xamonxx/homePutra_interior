export default function AdminCalculatorPage() {
  return (
    <div className="max-w-3xl mx-auto space-y-6">
      {/* Header */}
      <div>
        <h2 className="text-2xl text-white font-semibold">Pengaturan Kalkulator</h2>
        <p className="text-gray-500 text-sm">
          Kelola harga dan konfigurasi kalkulator
        </p>
      </div>

      {/* Info Card */}
      <div className="bg-gradient-to-br from-blue-500/10 to-transparent border border-blue-500/20 rounded-2xl p-6">
        <div className="flex items-start gap-4">
          <span className="material-symbols-outlined text-blue-400 text-3xl">
            info
          </span>
          <div>
            <h3 className="text-white font-semibold mb-2">Konfigurasi Harga</h3>
            <p className="text-gray-400 text-sm leading-relaxed">
              Harga kalkulator saat ini menggunakan nilai default yang sudah dikonfigurasi. 
              Untuk mengubah harga produk, Anda dapat menambahkan tabel <code className="text-[#ffb204]">calculator_items</code> 
              ke database dengan kolom: product_type, material_type, price_per_meter, is_active.
            </p>
          </div>
        </div>
      </div>

      {/* Default Prices */}
      <div className="bg-gradient-to-br from-white/[0.06] to-transparent border border-white/[0.08] rounded-2xl overflow-hidden">
        <div className="p-5 border-b border-white/[0.08]">
          <h3 className="text-white font-semibold flex items-center gap-2">
            <span className="material-symbols-outlined text-[#ffb204]">
              payments
            </span>
            Harga Default
          </h3>
        </div>
        <div className="p-6">
          <div className="overflow-x-auto">
            <table className="w-full">
              <thead>
                <tr className="text-left border-b border-white/10">
                  <th className="pb-4 text-gray-400 text-sm font-medium">Produk</th>
                  <th className="pb-4 text-gray-400 text-sm font-medium">Material</th>
                  <th className="pb-4 text-gray-400 text-sm font-medium text-right">Harga/m</th>
                </tr>
              </thead>
              <tbody className="divide-y divide-white/5">
                <tr>
                  <td className="py-4 text-white">Kitchen Set</td>
                  <td className="py-4 text-gray-400">Aluminium</td>
                  <td className="py-4 text-[#ffb204] text-right font-semibold">Rp 2.000.000</td>
                </tr>
                <tr>
                  <td className="py-4 text-white">Lemari & Wardrobe</td>
                  <td className="py-4 text-gray-400">Multipleks HPL</td>
                  <td className="py-4 text-[#ffb204] text-right font-semibold">Rp 2.300.000</td>
                </tr>
                <tr>
                  <td className="py-4 text-white">Backdrop TV</td>
                  <td className="py-4 text-gray-400">HPL Premium</td>
                  <td className="py-4 text-[#ffb204] text-right font-semibold">Rp 2.100.000</td>
                </tr>
                <tr>
                  <td className="py-4 text-white">Wallpanel</td>
                  <td className="py-4 text-gray-400">WPC</td>
                  <td className="py-4 text-[#ffb204] text-right font-semibold">Rp 850.000</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      {/* Location Multipliers */}
      <div className="bg-gradient-to-br from-white/[0.06] to-transparent border border-white/[0.08] rounded-2xl overflow-hidden">
        <div className="p-5 border-b border-white/[0.08]">
          <h3 className="text-white font-semibold flex items-center gap-2">
            <span className="material-symbols-outlined text-[#ffb204]">
              location_on
            </span>
            Multiplier Lokasi
          </h3>
        </div>
        <div className="p-6">
          <div className="grid grid-cols-2 md:grid-cols-3 gap-4">
            {[
              { name: "Jawa Barat", multiplier: "1.00x" },
              { name: "Jawa Tengah", multiplier: "1.05x" },
              { name: "Jawa Timur", multiplier: "1.10x" },
              { name: "Jakarta", multiplier: "1.15x" },
              { name: "Bali", multiplier: "1.20x" },
              { name: "Luar Jawa", multiplier: "1.25x" },
            ].map((loc) => (
              <div
                key={loc.name}
                className="p-4 bg-white/[0.03] rounded-xl text-center"
              >
                <p className="text-white font-medium">{loc.name}</p>
                <p className="text-[#ffb204] font-bold">{loc.multiplier}</p>
              </div>
            ))}
          </div>
        </div>
      </div>
    </div>
  );
}
