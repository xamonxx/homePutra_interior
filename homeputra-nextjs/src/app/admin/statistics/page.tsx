"use client";

import { useState, useEffect } from "react";

interface Statistic {
  id: number;
  stat_number: string;
  stat_suffix: string;
  stat_label: string;
  display_order: number;
  is_active: number;
}

export default function AdminStatisticsPage() {
  const [statistics, setStatistics] = useState<Statistic[]>([]);
  const [loading, setLoading] = useState(true);
  const [showModal, setShowModal] = useState(false);
  const [editingItem, setEditingItem] = useState<Statistic | null>(null);
  const [formData, setFormData] = useState({
    stat_number: "",
    stat_suffix: "",
    stat_label: "",
    display_order: 0,
  });

  useEffect(() => {
    fetchStatistics();
  }, []);

  const fetchStatistics = async () => {
    try {
      const res = await fetch("/api/admin/statistics");
      const data = await res.json();
      if (data.success) {
        setStatistics(data.data);
      }
    } catch (error) {
      console.error("Error fetching statistics:", error);
    } finally {
      setLoading(false);
    }
  };

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    try {
      const url = editingItem
        ? `/api/admin/statistics/${editingItem.id}`
        : "/api/admin/statistics";
      const method = editingItem ? "PUT" : "POST";

      const res = await fetch(url, {
        method,
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(formData),
      });

      const data = await res.json();
      if (data.success) {
        fetchStatistics();
        closeModal();
      }
    } catch (error) {
      console.error("Error saving statistic:", error);
    }
  };

  const handleDelete = async (id: number) => {
    if (!confirm("Yakin ingin menghapus statistik ini?")) return;

    try {
      const res = await fetch(`/api/admin/statistics/${id}`, {
        method: "DELETE",
      });
      const data = await res.json();
      if (data.success) {
        fetchStatistics();
      }
    } catch (error) {
      console.error("Error deleting statistic:", error);
    }
  };

  const openModal = (item?: Statistic) => {
    if (item) {
      setEditingItem(item);
      setFormData({
        stat_number: item.stat_number,
        stat_suffix: item.stat_suffix,
        stat_label: item.stat_label,
        display_order: item.display_order,
      });
    } else {
      setEditingItem(null);
      setFormData({
        stat_number: "",
        stat_suffix: "",
        stat_label: "",
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
          <h2 className="text-2xl text-white font-semibold">Statistik</h2>
          <p className="text-gray-500 text-sm">
            Kelola angka statistik yang ditampilkan di website
          </p>
        </div>
        <button
          onClick={() => openModal()}
          className="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-[#ffb204] to-yellow-500 text-black rounded-xl font-bold text-sm hover:shadow-lg hover:shadow-[#ffb204]/30 transition-all"
        >
          <span className="material-symbols-outlined">add</span>
          Tambah Statistik
        </button>
      </div>

      {/* Grid */}
      <div className="grid grid-cols-2 lg:grid-cols-4 gap-6">
        {statistics.map((item) => (
          <div
            key={item.id}
            className="bg-gradient-to-br from-white/[0.06] to-transparent border border-white/[0.08] rounded-2xl p-6 hover:border-[#ffb204]/30 transition-all text-center group"
          >
            <div className="flex justify-end gap-2 mb-4 opacity-0 group-hover:opacity-100 transition-opacity">
              <button
                onClick={() => openModal(item)}
                className="p-1.5 text-gray-400 hover:text-[#ffb204] transition-colors"
              >
                <span className="material-symbols-outlined text-lg">edit</span>
              </button>
              <button
                onClick={() => handleDelete(item.id)}
                className="p-1.5 text-gray-400 hover:text-red-400 transition-colors"
              >
                <span className="material-symbols-outlined text-lg">delete</span>
              </button>
            </div>
            <div className="text-4xl md:text-5xl font-serif text-[#ffb204] font-bold mb-2">
              {item.stat_number}
              <span className="text-2xl">{item.stat_suffix}</span>
            </div>
            <div className="text-gray-500 text-sm uppercase tracking-wider">
              {item.stat_label}
            </div>
          </div>
        ))}
      </div>

      {statistics.length === 0 && (
        <div className="text-center py-12">
          <span className="material-symbols-outlined text-5xl text-gray-600 mb-4 block">
            analytics
          </span>
          <h3 className="text-white font-semibold mb-2">
            Belum Ada Statistik
          </h3>
          <p className="text-gray-500 text-sm">
            Klik tombol di atas untuk menambah statistik pertama
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
          <div className="relative w-full max-w-md bg-[#161B22] border border-white/10 rounded-2xl overflow-hidden">
            <div className="flex items-center justify-between p-6 border-b border-white/10">
              <h3 className="text-white font-semibold text-lg">
                {editingItem ? "Edit Statistik" : "Tambah Statistik"}
              </h3>
              <button
                onClick={closeModal}
                className="text-gray-400 hover:text-white"
              >
                <span className="material-symbols-outlined">close</span>
              </button>
            </div>
            <form onSubmit={handleSubmit} className="p-6 space-y-5">
              <div className="grid grid-cols-2 gap-4">
                <div className="space-y-2">
                  <label className="text-gray-400 text-sm">Angka</label>
                  <input
                    type="text"
                    value={formData.stat_number}
                    onChange={(e) =>
                      setFormData({ ...formData, stat_number: e.target.value })
                    }
                    className="w-full bg-[#0a0c10] border border-white/10 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-[#ffb204]/50 outline-none"
                    placeholder="500"
                    required
                  />
                </div>
                <div className="space-y-2">
                  <label className="text-gray-400 text-sm">Suffix</label>
                  <input
                    type="text"
                    value={formData.stat_suffix}
                    onChange={(e) =>
                      setFormData({ ...formData, stat_suffix: e.target.value })
                    }
                    className="w-full bg-[#0a0c10] border border-white/10 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-[#ffb204]/50 outline-none"
                    placeholder="+, %, th"
                  />
                </div>
              </div>
              <div className="space-y-2">
                <label className="text-gray-400 text-sm">Label</label>
                <input
                  type="text"
                  value={formData.stat_label}
                  onChange={(e) =>
                    setFormData({ ...formData, stat_label: e.target.value })
                  }
                  className="w-full bg-[#0a0c10] border border-white/10 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-[#ffb204]/50 outline-none"
                  placeholder="Proyek Selesai"
                  required
                />
              </div>
              <div className="space-y-2">
                <label className="text-gray-400 text-sm">Urutan</label>
                <input
                  type="number"
                  value={formData.display_order}
                  onChange={(e) =>
                    setFormData({
                      ...formData,
                      display_order: parseInt(e.target.value) || 0,
                    })
                  }
                  className="w-full bg-[#0a0c10] border border-white/10 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-[#ffb204]/50 outline-none"
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
