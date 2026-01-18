"use client";

import { useState, useEffect } from "react";

interface HeroSection {
  id: number;
  title: string;
  subtitle: string;
  background_image: string;
  button1_text: string;
  button1_link: string;
  button2_text: string;
  button2_link: string;
  is_active: number;
}

export default function AdminHeroPage() {
  const [hero, setHero] = useState<HeroSection | null>(null);
  const [loading, setLoading] = useState(true);
  const [saving, setSaving] = useState(false);
  const [message, setMessage] = useState<{ type: string; text: string } | null>(null);

  useEffect(() => {
    fetchHero();
  }, []);

  const fetchHero = async () => {
    try {
      const res = await fetch("/api/admin/hero");
      const data = await res.json();
      if (data.success && data.data) {
        setHero(data.data);
      }
    } catch (error) {
      console.error("Error fetching hero:", error);
    } finally {
      setLoading(false);
    }
  };

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    if (!hero) return;

    setSaving(true);
    setMessage(null);

    try {
      const res = await fetch("/api/admin/hero", {
        method: "PUT",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(hero),
      });

      const data = await res.json();
      if (data.success) {
        setMessage({ type: "success", text: "Hero section berhasil disimpan!" });
      } else {
        setMessage({ type: "error", text: "Gagal menyimpan hero section" });
      }
    } catch {
      setMessage({ type: "error", text: "Terjadi kesalahan" });
    } finally {
      setSaving(false);
      setTimeout(() => setMessage(null), 3000);
    }
  };

  if (loading) {
    return (
      <div className="flex items-center justify-center h-64">
        <div className="text-gray-400">Memuat...</div>
      </div>
    );
  }

  if (!hero) {
    return (
      <div className="text-center py-12">
        <span className="material-symbols-outlined text-5xl text-gray-600 mb-4 block">
          image
        </span>
        <h3 className="text-white font-semibold mb-2">Data Hero Tidak Ditemukan</h3>
        <p className="text-gray-500 text-sm">
          Pastikan database sudah dikonfigurasi dengan benar
        </p>
      </div>
    );
  }

  return (
    <div className="max-w-3xl mx-auto space-y-6">
      {/* Header */}
      <div>
        <h2 className="text-2xl text-white font-semibold">Hero Section</h2>
        <p className="text-gray-500 text-sm">
          Kelola tampilan hero di halaman utama
        </p>
      </div>

      {message && (
        <div
          className={`p-4 rounded-xl flex items-center gap-2 ${
            message.type === "success"
              ? "bg-green-500/20 text-green-400"
              : "bg-red-500/20 text-red-400"
          }`}
        >
          <span className="material-symbols-outlined">
            {message.type === "success" ? "check_circle" : "error"}
          </span>
          {message.text}
        </div>
      )}

      <form onSubmit={handleSubmit} className="space-y-8">
        {/* Content Settings */}
        <div className="bg-gradient-to-br from-white/[0.06] to-transparent border border-white/[0.08] rounded-2xl overflow-hidden">
          <div className="p-5 border-b border-white/[0.08]">
            <h3 className="text-white font-semibold flex items-center gap-2">
              <span className="material-symbols-outlined text-[#ffb204]">
                title
              </span>
              Konten Hero
            </h3>
          </div>
          <div className="p-6 space-y-5">
            <div className="space-y-2">
              <label className="text-gray-400 text-sm">Judul</label>
              <input
                type="text"
                value={hero.title}
                onChange={(e) => setHero({ ...hero, title: e.target.value })}
                className="w-full bg-[#0a0c10] border border-white/10 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-[#ffb204]/50 outline-none"
              />
              <span className="text-gray-600 text-xs">
                Gunakan &lt;span class=&quot;text-gold-gradient italic&quot;&gt;...&lt;/span&gt; untuk highlight
              </span>
            </div>
            <div className="space-y-2">
              <label className="text-gray-400 text-sm">Subtitle</label>
              <textarea
                value={hero.subtitle}
                onChange={(e) => setHero({ ...hero, subtitle: e.target.value })}
                className="w-full bg-[#0a0c10] border border-white/10 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-[#ffb204]/50 outline-none resize-none"
                rows={3}
              />
            </div>
            <div className="space-y-2">
              <label className="text-gray-400 text-sm">URL Background Image</label>
              <input
                type="url"
                value={hero.background_image}
                onChange={(e) => setHero({ ...hero, background_image: e.target.value })}
                className="w-full bg-[#0a0c10] border border-white/10 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-[#ffb204]/50 outline-none"
                placeholder="https://..."
              />
            </div>
          </div>
        </div>

        {/* Button Settings */}
        <div className="bg-gradient-to-br from-white/[0.06] to-transparent border border-white/[0.08] rounded-2xl overflow-hidden">
          <div className="p-5 border-b border-white/[0.08]">
            <h3 className="text-white font-semibold flex items-center gap-2">
              <span className="material-symbols-outlined text-[#ffb204]">
                smart_button
              </span>
              Tombol CTA
            </h3>
          </div>
          <div className="p-6 space-y-5">
            <div className="grid grid-cols-2 gap-4">
              <div className="space-y-2">
                <label className="text-gray-400 text-sm">Teks Tombol 1</label>
                <input
                  type="text"
                  value={hero.button1_text}
                  onChange={(e) => setHero({ ...hero, button1_text: e.target.value })}
                  className="w-full bg-[#0a0c10] border border-white/10 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-[#ffb204]/50 outline-none"
                />
              </div>
              <div className="space-y-2">
                <label className="text-gray-400 text-sm">Link Tombol 1</label>
                <input
                  type="text"
                  value={hero.button1_link}
                  onChange={(e) => setHero({ ...hero, button1_link: e.target.value })}
                  className="w-full bg-[#0a0c10] border border-white/10 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-[#ffb204]/50 outline-none"
                  placeholder="#portfolio"
                />
              </div>
            </div>
            <div className="grid grid-cols-2 gap-4">
              <div className="space-y-2">
                <label className="text-gray-400 text-sm">Teks Tombol 2</label>
                <input
                  type="text"
                  value={hero.button2_text}
                  onChange={(e) => setHero({ ...hero, button2_text: e.target.value })}
                  className="w-full bg-[#0a0c10] border border-white/10 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-[#ffb204]/50 outline-none"
                />
              </div>
              <div className="space-y-2">
                <label className="text-gray-400 text-sm">Link Tombol 2</label>
                <input
                  type="text"
                  value={hero.button2_link}
                  onChange={(e) => setHero({ ...hero, button2_link: e.target.value })}
                  className="w-full bg-[#0a0c10] border border-white/10 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-[#ffb204]/50 outline-none"
                  placeholder="#contact"
                />
              </div>
            </div>
          </div>
        </div>

        {/* Submit */}
        <button
          type="submit"
          disabled={saving}
          className="w-full py-4 bg-gradient-to-r from-[#ffb204] to-yellow-500 text-black rounded-xl font-bold text-sm uppercase tracking-wider hover:shadow-2xl hover:shadow-[#ffb204]/30 transition-all disabled:opacity-50 flex items-center justify-center gap-2"
        >
          {saving ? (
            <>
              <span className="material-symbols-outlined animate-spin">
                progress_activity
              </span>
              Menyimpan...
            </>
          ) : (
            <>
              <span className="material-symbols-outlined">save</span>
              Simpan Perubahan
            </>
          )}
        </button>
      </form>
    </div>
  );
}
