"use client";

import { useState, useEffect } from "react";

interface Testimonial {
  id: number;
  client_name: string;
  client_location: string;
  client_image: string;
  testimonial_text: string;
  rating: number;
  display_order: number;
  is_active: number;
}

export default function AdminTestimonialsPage() {
  const [testimonials, setTestimonials] = useState<Testimonial[]>([]);
  const [loading, setLoading] = useState(true);
  const [showModal, setShowModal] = useState(false);
  const [editingItem, setEditingItem] = useState<Testimonial | null>(null);
  const [formData, setFormData] = useState({
    client_name: "",
    client_location: "",
    client_image: "",
    testimonial_text: "",
    rating: 5,
    display_order: 0,
  });

  useEffect(() => {
    fetchTestimonials();
  }, []);

  const fetchTestimonials = async () => {
    try {
      const res = await fetch("/api/admin/testimonials");
      const data = await res.json();
      if (data.success) {
        setTestimonials(data.data);
      }
    } catch (error) {
      console.error("Error fetching testimonials:", error);
    } finally {
      setLoading(false);
    }
  };

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    try {
      const url = editingItem
        ? `/api/admin/testimonials/${editingItem.id}`
        : "/api/admin/testimonials";
      const method = editingItem ? "PUT" : "POST";

      const res = await fetch(url, {
        method,
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(formData),
      });

      const data = await res.json();
      if (data.success) {
        fetchTestimonials();
        closeModal();
      }
    } catch (error) {
      console.error("Error saving testimonial:", error);
    }
  };

  const handleDelete = async (id: number) => {
    if (!confirm("Yakin ingin menghapus testimoni ini?")) return;

    try {
      const res = await fetch(`/api/admin/testimonials/${id}`, {
        method: "DELETE",
      });
      const data = await res.json();
      if (data.success) {
        fetchTestimonials();
      }
    } catch (error) {
      console.error("Error deleting testimonial:", error);
    }
  };

  const openModal = (item?: Testimonial) => {
    if (item) {
      setEditingItem(item);
      setFormData({
        client_name: item.client_name,
        client_location: item.client_location,
        client_image: item.client_image,
        testimonial_text: item.testimonial_text,
        rating: item.rating,
        display_order: item.display_order,
      });
    } else {
      setEditingItem(null);
      setFormData({
        client_name: "",
        client_location: "",
        client_image: "",
        testimonial_text: "",
        rating: 5,
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
          <h2 className="text-2xl text-white font-semibold">Testimoni</h2>
          <p className="text-gray-500 text-sm">
            Kelola testimoni dari klien Anda
          </p>
        </div>
        <button
          onClick={() => openModal()}
          className="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-[#ffb204] to-yellow-500 text-black rounded-xl font-bold text-sm hover:shadow-lg hover:shadow-[#ffb204]/30 transition-all"
        >
          <span className="material-symbols-outlined">add</span>
          Tambah Testimoni
        </button>
      </div>

      {/* List */}
      <div className="space-y-4">
        {testimonials.map((item) => (
          <div
            key={item.id}
            className="bg-gradient-to-br from-white/[0.06] to-transparent border border-white/[0.08] rounded-2xl p-5 hover:border-[#ffb204]/30 transition-all"
          >
            <div className="flex items-start gap-4">
              <div className="w-14 h-14 rounded-full bg-gradient-to-br from-[#ffb204] to-yellow-600 flex items-center justify-center text-black font-bold text-xl flex-shrink-0">
                {item.client_name[0]}
              </div>
              <div className="flex-1 min-w-0">
                <div className="flex items-center justify-between gap-4 mb-2">
                  <div>
                    <h3 className="text-white font-semibold">
                      {item.client_name}
                    </h3>
                    <p className="text-gray-500 text-sm">
                      {item.client_location}
                    </p>
                  </div>
                  <div className="flex items-center gap-2">
                    <div className="flex">
                      {[...Array(item.rating)].map((_, i) => (
                        <span
                          key={i}
                          className="material-symbols-outlined text-[#ffb204] text-sm"
                        >
                          star
                        </span>
                      ))}
                    </div>
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
                  &ldquo;{item.testimonial_text}&rdquo;
                </p>
              </div>
            </div>
          </div>
        ))}
      </div>

      {testimonials.length === 0 && (
        <div className="text-center py-12">
          <span className="material-symbols-outlined text-5xl text-gray-600 mb-4 block">
            format_quote
          </span>
          <h3 className="text-white font-semibold mb-2">
            Belum Ada Testimoni
          </h3>
          <p className="text-gray-500 text-sm">
            Klik tombol di atas untuk menambah testimoni pertama
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
          <div className="relative w-full max-w-lg bg-[#161B22] border border-white/10 rounded-2xl overflow-hidden max-h-[90vh] overflow-y-auto">
            <div className="flex items-center justify-between p-6 border-b border-white/10 sticky top-0 bg-[#161B22]">
              <h3 className="text-white font-semibold text-lg">
                {editingItem ? "Edit Testimoni" : "Tambah Testimoni"}
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
                <label className="text-gray-400 text-sm">Nama Klien</label>
                <input
                  type="text"
                  value={formData.client_name}
                  onChange={(e) =>
                    setFormData({ ...formData, client_name: e.target.value })
                  }
                  className="w-full bg-[#0a0c10] border border-white/10 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-[#ffb204]/50 outline-none"
                  required
                />
              </div>
              <div className="space-y-2">
                <label className="text-gray-400 text-sm">Lokasi</label>
                <input
                  type="text"
                  value={formData.client_location}
                  onChange={(e) =>
                    setFormData({
                      ...formData,
                      client_location: e.target.value,
                    })
                  }
                  className="w-full bg-[#0a0c10] border border-white/10 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-[#ffb204]/50 outline-none"
                  placeholder="Jakarta Selatan"
                />
              </div>
              <div className="space-y-2">
                <label className="text-gray-400 text-sm">Testimoni</label>
                <textarea
                  value={formData.testimonial_text}
                  onChange={(e) =>
                    setFormData({
                      ...formData,
                      testimonial_text: e.target.value,
                    })
                  }
                  className="w-full bg-[#0a0c10] border border-white/10 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-[#ffb204]/50 outline-none resize-none"
                  rows={4}
                  required
                />
              </div>
              <div className="space-y-2">
                <label className="text-gray-400 text-sm">Rating</label>
                <div className="flex gap-2">
                  {[1, 2, 3, 4, 5].map((star) => (
                    <button
                      key={star}
                      type="button"
                      onClick={() => setFormData({ ...formData, rating: star })}
                      className="p-1"
                    >
                      <span
                        className={`material-symbols-outlined text-2xl ${
                          star <= formData.rating
                            ? "text-[#ffb204]"
                            : "text-gray-600"
                        }`}
                      >
                        star
                      </span>
                    </button>
                  ))}
                </div>
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
