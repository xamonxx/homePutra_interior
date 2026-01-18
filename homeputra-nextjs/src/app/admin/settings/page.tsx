"use client";

import { useState, useEffect } from "react";

interface Setting {
  id: number;
  setting_key: string;
  setting_value: string;
  setting_type: string;
  setting_group: string;
}

export default function AdminSettingsPage() {
  const [settings, setSettings] = useState<Setting[]>([]);
  const [loading, setLoading] = useState(true);
  const [saving, setSaving] = useState(false);
  const [message, setMessage] = useState<{ type: string; text: string } | null>(null);

  useEffect(() => {
    fetchSettings();
  }, []);

  const fetchSettings = async () => {
    try {
      const res = await fetch("/api/admin/settings");
      const data = await res.json();
      if (data.success) {
        setSettings(data.data);
      }
    } catch (error) {
      console.error("Error fetching settings:", error);
    } finally {
      setLoading(false);
    }
  };

  const handleChange = (key: string, value: string) => {
    setSettings(
      settings.map((s) =>
        s.setting_key === key ? { ...s, setting_value: value } : s
      )
    );
  };

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    setSaving(true);
    setMessage(null);

    try {
      const res = await fetch("/api/admin/settings", {
        method: "PUT",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ settings }),
      });

      const data = await res.json();
      if (data.success) {
        setMessage({ type: "success", text: "Pengaturan berhasil disimpan!" });
      } else {
        setMessage({ type: "error", text: "Gagal menyimpan pengaturan" });
      }
    } catch {
      setMessage({ type: "error", text: "Terjadi kesalahan" });
    } finally {
      setSaving(false);
      setTimeout(() => setMessage(null), 3000);
    }
  };

  const getSettingLabel = (key: string) => {
    const labels: Record<string, string> = {
      site_name: "Nama Website",
      site_tagline: "Tagline",
      site_description: "Deskripsi Website",
      contact_email: "Email Kontak",
      contact_phone: "Nomor Telepon",
      contact_address: "Alamat",
      whatsapp_number: "Nomor WhatsApp",
      instagram_url: "URL Instagram",
      facebook_url: "URL Facebook",
      logo_image: "URL Logo",
    };
    return labels[key] || key;
  };

  const groupSettings = (group: string) =>
    settings.filter((s) => s.setting_group === group);

  if (loading) {
    return (
      <div className="flex items-center justify-center h-64">
        <div className="text-gray-400">Memuat...</div>
      </div>
    );
  }

  return (
    <div className="max-w-3xl mx-auto space-y-6">
      {/* Header */}
      <div>
        <h2 className="text-2xl text-white font-semibold">Pengaturan</h2>
        <p className="text-gray-500 text-sm">
          Kelola pengaturan website Anda
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
        {/* General Settings */}
        <div className="bg-gradient-to-br from-white/[0.06] to-transparent border border-white/[0.08] rounded-2xl overflow-hidden">
          <div className="p-5 border-b border-white/[0.08]">
            <h3 className="text-white font-semibold flex items-center gap-2">
              <span className="material-symbols-outlined text-[#ffb204]">
                settings
              </span>
              Pengaturan Umum
            </h3>
          </div>
          <div className="p-6 space-y-5">
            {groupSettings("general").map((setting) => (
              <div key={setting.setting_key} className="space-y-2">
                <label className="text-gray-400 text-sm">
                  {getSettingLabel(setting.setting_key)}
                </label>
                {setting.setting_type === "textarea" ? (
                  <textarea
                    value={setting.setting_value}
                    onChange={(e) =>
                      handleChange(setting.setting_key, e.target.value)
                    }
                    className="w-full bg-[#0a0c10] border border-white/10 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-[#ffb204]/50 outline-none resize-none"
                    rows={3}
                  />
                ) : (
                  <input
                    type="text"
                    value={setting.setting_value}
                    onChange={(e) =>
                      handleChange(setting.setting_key, e.target.value)
                    }
                    className="w-full bg-[#0a0c10] border border-white/10 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-[#ffb204]/50 outline-none"
                  />
                )}
              </div>
            ))}
          </div>
        </div>

        {/* Contact Settings */}
        <div className="bg-gradient-to-br from-white/[0.06] to-transparent border border-white/[0.08] rounded-2xl overflow-hidden">
          <div className="p-5 border-b border-white/[0.08]">
            <h3 className="text-white font-semibold flex items-center gap-2">
              <span className="material-symbols-outlined text-[#ffb204]">
                contact_mail
              </span>
              Informasi Kontak
            </h3>
          </div>
          <div className="p-6 space-y-5">
            {groupSettings("contact").map((setting) => (
              <div key={setting.setting_key} className="space-y-2">
                <label className="text-gray-400 text-sm">
                  {getSettingLabel(setting.setting_key)}
                </label>
                {setting.setting_key === "whatsapp_number" ? (
                  <div className="relative">
                    <input
                      type="text"
                      value={setting.setting_value}
                      onChange={(e) =>
                        handleChange(setting.setting_key, e.target.value)
                      }
                      className="w-full bg-[#0a0c10] border border-white/10 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-[#ffb204]/50 outline-none"
                      placeholder="6281234567890"
                    />
                    <span className="text-gray-500 text-xs mt-1 block">
                      Format: 62xxxxxxxxx (tanpa + atau 0)
                    </span>
                  </div>
                ) : setting.setting_type === "textarea" ? (
                  <textarea
                    value={setting.setting_value}
                    onChange={(e) =>
                      handleChange(setting.setting_key, e.target.value)
                    }
                    className="w-full bg-[#0a0c10] border border-white/10 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-[#ffb204]/50 outline-none resize-none"
                    rows={3}
                  />
                ) : (
                  <input
                    type="text"
                    value={setting.setting_value}
                    onChange={(e) =>
                      handleChange(setting.setting_key, e.target.value)
                    }
                    className="w-full bg-[#0a0c10] border border-white/10 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-[#ffb204]/50 outline-none"
                  />
                )}
              </div>
            ))}
          </div>
        </div>

        {/* Social Settings */}
        <div className="bg-gradient-to-br from-white/[0.06] to-transparent border border-white/[0.08] rounded-2xl overflow-hidden">
          <div className="p-5 border-b border-white/[0.08]">
            <h3 className="text-white font-semibold flex items-center gap-2">
              <span className="material-symbols-outlined text-[#ffb204]">
                share
              </span>
              Media Sosial
            </h3>
          </div>
          <div className="p-6 space-y-5">
            {groupSettings("social").map((setting) => (
              <div key={setting.setting_key} className="space-y-2">
                <label className="text-gray-400 text-sm">
                  {getSettingLabel(setting.setting_key)}
                </label>
                <input
                  type="url"
                  value={setting.setting_value}
                  onChange={(e) =>
                    handleChange(setting.setting_key, e.target.value)
                  }
                  className="w-full bg-[#0a0c10] border border-white/10 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-[#ffb204]/50 outline-none"
                  placeholder="https://..."
                />
              </div>
            ))}
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
              Simpan Pengaturan
            </>
          )}
        </button>
      </form>
    </div>
  );
}
