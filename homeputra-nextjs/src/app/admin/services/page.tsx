"use client";

import { useState, useEffect } from "react";

interface Service {
  id: number;
  title: string;
  description: string;
  icon: string;
  display_order: number;
  is_active: number;
}

const iconOptions = [
  { value: "home", label: "Rumah" },
  { value: "storefront", label: "Toko" },
  { value: "chair", label: "Furniture" },
  { value: "chat", label: "Konsultasi" },
  { value: "engineering", label: "Engineering" },
  { value: "brush", label: "Desain" },
  { value: "palette", label: "Warna" },
  { value: "lightbulb", label: "Ide" },
  { value: "construction", label: "Konstruksi" },
  { value: "architecture", label: "Arsitektur" },
];

export default function AdminServicesPage() {
  const [services, setServices] = useState<Service[]>([]);
  const [loading, setLoading] = useState(true);
  const [showModal, setShowModal] = useState(false);
  const [editingItem, setEditingItem] = useState<Service | null>(null);
  const [formData, setFormData] = useState({
    title: "",
    description: "",
    icon: "home",
    display_order: 0,
  });

  useEffect(() => {
    fetchServices();
  }, []);

  const fetchServices = async () => {
    try {
      const res = await fetch("/api/admin/services");
      const data = await res.json();
      if (data.success) {
        setServices(data.data);
      }
    } catch (error) {
      console.error("Error fetching services:", error);
    } finally {
      setLoading(false);
    }
  };

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    try {
      const url = editingItem
        ? `/api/admin/services/${editingItem.id}`
        : "/api/admin/services";
      const method = editingItem ? "PUT" : "POST";

      const res = await fetch(url, {
        method,
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(formData),
      });

      const data = await res.json();
      if (data.success) {
        fetchServices();
        closeModal();
      }
    } catch (error) {
      console.error("Error saving service:", error);
    }
  };

  const handleDelete = async (id: number) => {
    if (!confirm("Yakin ingin menghapus layanan ini?")) return;

    try {
      const res = await fetch(`/api/admin/services/${id}`, {
        method: "DELETE",
      });
      const data = await res.json();
      if (data.success) {
        fetchServices();
      }
    } catch (error) {
      console.error("Error deleting service:", error);
    }
  };

  const openModal = (item?: Service) => {
    if (item) {
      setEditingItem(item);
      setFormData({
        title: item.title,
        description: item.description,
        icon: item.icon,
        display_order: item.display_order,
      });
    } else {
      setEditingItem(null);
      setFormData({
        title: "",
        description: "",
        icon: "home",
        display_order: 0,
      });
    }
    setShowModal(true);
  };

  const closeModal = () => {
    setShowModal(false);
    setEditingItem(null);
  };

  if (loading) {
    return (
      <div className="flex items-center justify-center h-64">
        <div className="text-gray-400">Memuat...</div>
      </div>
    );
  }

  return (
    <div className="space-y-6">
      {/* Header */}
      <div className="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
          <h2 className="text-2xl text-white font-semibold">Layanan</h2>
          <p className="text-gray-500 text-sm">
            Kelola layanan yang Anda tawarkan
          </p>
        </div>
        <button
          onClick={() => openModal()}
          className="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-[#ffb204] to-yellow-500 text-black rounded-xl font-bold text-sm hover:shadow-lg hover:shadow-[#ffb204]/30 transition-all"
        >
          <span className="material-symbols-outlined">add</span>
          Tambah Layanan
        </button>
      </div>

      {/* Grid */}
      <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
        {services.map((item) => (
          <div
            key={item.id}
            className="bg-gradient-to-br from-white/[0.06] to-transparent border border-white/[0.08] rounded-2xl p-6 hover:border-[#ffb204]/30 transition-all group"
          >
            <div className="flex items-start gap-4">
              <div className="w-14 h-14 rounded-xl bg-gradient-to-br from-[#ffb204]/20 to-[#ffb204]/5 flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
                <span className="material-symbols-outlined text-[#ffb204] text-3xl">
                  {item.icon}
                </span>
              </div>
              <div className="flex-1 min-w-0">
                <div className="flex items-center justify-between gap-4 mb-2">
                  <h3 className="text-white font-semibold text-lg">
                    {item.title}
                  </h3>
                  <div className="flex items-center gap-2">
                    <span
                      className={`px-2 py-1 rounded text-xs ${
                        item.is_active
                          ? "bg-green-500/20 text-green-400"
                          : "bg-red-500/20 text-red-400"
                      }`}
                    >
                      {item.is_active ? "Aktif" : "Nonaktif"}
                    </span>
                    <button
                      onClick={() => openModal(item)}
                      className="p-2 text-gray-400 hover:text-[#ffb204] transition-colors"
                    >
                      <span className="material-symbols-outlined">edit</span>
                    </button>
                    <button
                      onClick={() => handleDelete(item.id)}
                      className="p-2 text-gray-400 hover:text-red-400 transition-colors"
                    >
                      <span className="material-symbols-outlined">delete</span>
                    </button>
                  </div>
                </div>
                <p className="text-gray-400 text-sm leading-relaxed">
                  {item.description}
                </p>
              </div>
            </div>
          </div>
        ))}
      </div>

      {services.length === 0 && (
        <div className="text-center py-12">
          <span className="material-symbols-outlined text-5xl text-gray-600 mb-4 block">
            design_services
          </span>
          <h3 className="text-white font-semibold mb-2">Belum Ada Layanan</h3>
          <p className="text-gray-500 text-sm">
            Klik tombol di atas untuk menambah layanan pertama
          </p>
        </div>
      )}

      {/* Modal */}
      {showModal && (
        <div className="fixed inset-0 z-50 flex items-center justify-center p-4">
          <div
            className="absolute inset-0 bg-black/70"
            onClick={closeModal}
          ></div>
          <div className="relative w-full max-w-lg bg-[#161B22] border border-white/10 rounded-2xl overflow-hidden">
            <div className="flex items-center justify-between p-6 border-b border-white/10">
              <h3 className="text-white font-semibold text-lg">
                {editingItem ? "Edit Layanan" : "Tambah Layanan"}
              </h3>
              <button
                onClick={closeModal}
                className="text-gray-400 hover:text-white"
              >
                <span className="material-symbols-outlined">close</span>
              </button>
            </div>
            <form onSubmit={handleSubmit} className="p-6 space-y-5">
              <div className="space-y-2">
                <label className="text-gray-400 text-sm">Judul Layanan</label>
                <input
                  type="text"
                  value={formData.title}
                  onChange={(e) =>
                    setFormData({ ...formData, title: e.target.value })
                  }
                  className="w-full bg-[#0a0c10] border border-white/10 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-[#ffb204]/50 outline-none"
                  required
                />
              </div>
              <div className="space-y-2">
                <label className="text-gray-400 text-sm">Ikon</label>
                <div className="grid grid-cols-5 gap-2">
                  {iconOptions.map((icon) => (
                    <button
                      key={icon.value}
                      type="button"
                      onClick={() =>
                        setFormData({ ...formData, icon: icon.value })
                      }
                      className={`p-3 rounded-xl border transition-all ${
                        formData.icon === icon.value
                          ? "bg-[#ffb204]/20 border-[#ffb204]/50"
                          : "bg-white/[0.03] border-white/10 hover:border-white/20"
                      }`}
                    >
                      <span
                        className={`material-symbols-outlined text-2xl ${
                          formData.icon === icon.value
                            ? "text-[#ffb204]"
                            : "text-gray-400"
                        }`}
                      >
                        {icon.value}
                      </span>
                    </button>
                  ))}
                </div>
              </div>
              <div className="space-y-2">
                <label className="text-gray-400 text-sm">Deskripsi</label>
                <textarea
                  value={formData.description}
                  onChange={(e) =>
                    setFormData({ ...formData, description: e.target.value })
                  }
                  className="w-full bg-[#0a0c10] border border-white/10 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-[#ffb204]/50 outline-none resize-none"
                  rows={4}
                  required
                />
              </div>
              <div className="flex gap-4">
                <button
                  type="button"
                  onClick={closeModal}
                  className="flex-1 py-3 bg-white/10 text-white rounded-xl font-semibold hover:bg-white/20 transition-colors"
                >
                  Batal
                </button>
                <button
                  type="submit"
                  className="flex-1 py-3 bg-gradient-to-r from-[#ffb204] to-yellow-500 text-black rounded-xl font-bold hover:shadow-lg transition-all"
                >
                  Simpan
                </button>
              </div>
            </form>
          </div>
        </div>
      )}
    </div>
  );
}
