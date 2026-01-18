"use client";

import { useState, useEffect } from "react";
import Image from "next/image";

interface Portfolio {
  id: number;
  title: string;
  category: string;
  description: string;
  image: string;
  display_order: number;
  is_active: number;
}

export default function AdminPortfolioPage() {
  const [portfolios, setPortfolios] = useState<Portfolio[]>([]);
  const [loading, setLoading] = useState(true);
  const [showModal, setShowModal] = useState(false);
  const [editingItem, setEditingItem] = useState<Portfolio | null>(null);
  const [formData, setFormData] = useState({
    title: "",
    category: "",
    description: "",
    image: "",
    display_order: 0,
  });

  useEffect(() => {
    fetchPortfolios();
  }, []);

  const fetchPortfolios = async () => {
    try {
      const res = await fetch("/api/admin/portfolio");
      const data = await res.json();
      if (data.success) {
        setPortfolios(data.data);
      }
    } catch (error) {
      console.error("Error fetching portfolios:", error);
    } finally {
      setLoading(false);
    }
  };

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    try {
      const url = editingItem
        ? `/api/admin/portfolio/${editingItem.id}`
        : "/api/admin/portfolio";
      const method = editingItem ? "PUT" : "POST";

      const res = await fetch(url, {
        method,
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(formData),
      });

      const data = await res.json();
      if (data.success) {
        fetchPortfolios();
        closeModal();
      }
    } catch (error) {
      console.error("Error saving portfolio:", error);
    }
  };

  const handleDelete = async (id: number) => {
    if (!confirm("Yakin ingin menghapus item ini?")) return;

    try {
      const res = await fetch(`/api/admin/portfolio/${id}`, {
        method: "DELETE",
      });
      const data = await res.json();
      if (data.success) {
        fetchPortfolios();
      }
    } catch (error) {
      console.error("Error deleting portfolio:", error);
    }
  };

  const openModal = (item?: Portfolio) => {
    if (item) {
      setEditingItem(item);
      setFormData({
        title: item.title,
        category: item.category,
        description: item.description,
        image: item.image,
        display_order: item.display_order,
      });
    } else {
      setEditingItem(null);
      setFormData({
        title: "",
        category: "",
        description: "",
        image: "",
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
          <h2 className="text-2xl text-white font-semibold">Portfolio</h2>
          <p className="text-gray-500 text-sm">Kelola galeri portfolio Anda</p>
        </div>
        <button
          onClick={() => openModal()}
          className="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-[#ffb204] to-yellow-500 text-black rounded-xl font-bold text-sm hover:shadow-lg hover:shadow-[#ffb204]/30 transition-all"
        >
          <span className="material-symbols-outlined">add</span>
          Tambah Portfolio
        </button>
      </div>

      {/* Grid */}
      <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        {portfolios.map((item) => (
          <div
            key={item.id}
            className="group bg-gradient-to-br from-white/[0.06] to-transparent border border-white/[0.08] rounded-2xl overflow-hidden hover:border-[#ffb204]/30 transition-all"
          >
            <div className="aspect-[4/3] relative overflow-hidden">
              {item.image ? (
                <Image
                  src={item.image}
                  alt={item.title}
                  fill
                  className="object-cover group-hover:scale-105 transition-transform duration-500"
                  unoptimized
                />
              ) : (
                <div className="w-full h-full bg-gray-800 flex items-center justify-center">
                  <span className="material-symbols-outlined text-4xl text-gray-600">
                    image
                  </span>
                </div>
              )}
              <div className="absolute top-3 right-3 flex gap-2">
                <button
                  onClick={() => openModal(item)}
                  className="w-10 h-10 bg-white/90 rounded-lg flex items-center justify-center text-gray-700 hover:bg-[#ffb204] hover:text-black transition-colors"
                >
                  <span className="material-symbols-outlined text-lg">
                    edit
                  </span>
                </button>
                <button
                  onClick={() => handleDelete(item.id)}
                  className="w-10 h-10 bg-white/90 rounded-lg flex items-center justify-center text-gray-700 hover:bg-red-500 hover:text-white transition-colors"
                >
                  <span className="material-symbols-outlined text-lg">
                    delete
                  </span>
                </button>
              </div>
            </div>
            <div className="p-5">
              <div className="flex items-center justify-between mb-2">
                <span className="text-[#ffb204] text-xs uppercase tracking-wider font-bold">
                  {item.category}
                </span>
                <span
                  className={`px-2 py-1 rounded text-xs ${
                    item.is_active
                      ? "bg-green-500/20 text-green-400"
                      : "bg-red-500/20 text-red-400"
                  }`}
                >
                  {item.is_active ? "Aktif" : "Nonaktif"}
                </span>
              </div>
              <h3 className="text-white font-semibold text-lg">{item.title}</h3>
            </div>
          </div>
        ))}
      </div>

      {portfolios.length === 0 && (
        <div className="text-center py-12">
          <span className="material-symbols-outlined text-5xl text-gray-600 mb-4 block">
            photo_library
          </span>
          <h3 className="text-white font-semibold mb-2">Belum Ada Portfolio</h3>
          <p className="text-gray-500 text-sm">
            Klik tombol di atas untuk menambah portfolio pertama
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
                {editingItem ? "Edit Portfolio" : "Tambah Portfolio"}
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
                <label className="text-gray-400 text-sm">Judul</label>
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
                <label className="text-gray-400 text-sm">Kategori</label>
                <select
                  value={formData.category}
                  onChange={(e) =>
                    setFormData({ ...formData, category: e.target.value })
                  }
                  className="w-full bg-[#0a0c10] border border-white/10 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-[#ffb204]/50 outline-none"
                >
                  <option value="">Pilih Kategori</option>
                  <option value="Residensial">Residensial</option>
                  <option value="Komersial">Komersial</option>
                  <option value="Kantor">Kantor</option>
                  <option value="Dapur">Dapur</option>
                  <option value="Kamar">Kamar</option>
                  <option value="Ruang Tamu">Ruang Tamu</option>
                </select>
              </div>
              <div className="space-y-2">
                <label className="text-gray-400 text-sm">URL Gambar</label>
                <input
                  type="url"
                  value={formData.image}
                  onChange={(e) =>
                    setFormData({ ...formData, image: e.target.value })
                  }
                  className="w-full bg-[#0a0c10] border border-white/10 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-[#ffb204]/50 outline-none"
                  placeholder="https://..."
                />
              </div>
              <div className="space-y-2">
                <label className="text-gray-400 text-sm">Deskripsi</label>
                <textarea
                  value={formData.description}
                  onChange={(e) =>
                    setFormData({ ...formData, description: e.target.value })
                  }
                  className="w-full bg-[#0a0c10] border border-white/10 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-[#ffb204]/50 outline-none resize-none"
                  rows={3}
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
