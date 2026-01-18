"use client";

import { useState } from "react";
import { signIn } from "next-auth/react";
import { useRouter } from "next/navigation";
import Link from "next/link";

export default function AdminLoginPage() {
  const router = useRouter();
  const [credentials, setCredentials] = useState({
    username: "",
    password: "",
  });
  const [error, setError] = useState("");
  const [isLoading, setIsLoading] = useState(false);

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    setIsLoading(true);
    setError("");

    try {
      const result = await signIn("credentials", {
        username: credentials.username,
        password: credentials.password,
        redirect: false,
      });

      if (result?.error) {
        setError("Username atau password salah");
      } else {
        router.push("/admin");
        router.refresh();
      }
    } catch {
      setError("Terjadi kesalahan");
    } finally {
      setIsLoading(false);
    }
  };

  return (
    <div className="min-h-screen bg-[#0B0D11] flex items-center justify-center px-4">
      <div className="absolute inset-0 pointer-events-none overflow-hidden">
        <div className="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[400px] bg-[#ffb204]/10 blur-[150px] rounded-full"></div>
      </div>

      <div className="relative w-full max-w-md">
        {/* Logo */}
        <div className="text-center mb-10">
          <Link href="/" className="inline-flex items-center gap-3">
            <svg
              className="w-10 h-10 text-[#ffb204]"
              fill="currentColor"
              viewBox="0 0 24 24"
            >
              <path d="M12 3L4 9v12h5v-7h6v7h5V9l-8-6z" />
            </svg>
            <span className="text-2xl font-bold text-white">
              Home Putra <span className="text-[#ffb204] italic">Interior</span>
            </span>
          </Link>
        </div>

        {/* Login Card */}
        <div className="bg-gradient-to-br from-white/[0.08] via-white/[0.04] to-transparent backdrop-blur-xl border border-white/[0.1] rounded-2xl overflow-hidden">
          {/* Header */}
          <div className="bg-white/[0.02] border-b border-white/[0.06] px-6 py-4">
            <div className="flex items-center gap-3">
              <div className="w-10 h-10 rounded-xl bg-gradient-to-br from-[#ffb204] to-[#ffb204]/70 flex items-center justify-center">
                <span className="material-symbols-outlined text-black text-xl">
                  admin_panel_settings
                </span>
              </div>
              <div>
                <h2 className="text-white font-semibold">Admin Panel</h2>
                <p className="text-gray-500 text-xs">Login untuk melanjutkan</p>
              </div>
            </div>
          </div>

          {/* Form */}
          <form onSubmit={handleSubmit} className="p-6 space-y-5">
            {error && (
              <div className="p-4 bg-red-500/20 border border-red-500/30 rounded-xl text-red-400 text-sm flex items-center gap-2">
                <span className="material-symbols-outlined text-lg">error</span>
                {error}
              </div>
            )}

            <div className="space-y-2">
              <label className="text-gray-400 text-sm font-medium">
                Username
              </label>
              <div className="relative">
                <span className="absolute left-4 top-1/2 -translate-y-1/2 material-symbols-outlined text-gray-500 text-xl">
                  person
                </span>
                <input
                  type="text"
                  value={credentials.username}
                  onChange={(e) =>
                    setCredentials({ ...credentials, username: e.target.value })
                  }
                  className="w-full bg-[#0a0c10] border border-white/[0.08] rounded-xl pl-12 pr-4 py-4 text-white focus:ring-2 focus:ring-[#ffb204]/50 focus:border-[#ffb204]/50 outline-none"
                  placeholder="admin"
                  required
                />
              </div>
            </div>

            <div className="space-y-2">
              <label className="text-gray-400 text-sm font-medium">
                Password
              </label>
              <div className="relative">
                <span className="absolute left-4 top-1/2 -translate-y-1/2 material-symbols-outlined text-gray-500 text-xl">
                  lock
                </span>
                <input
                  type="password"
                  value={credentials.password}
                  onChange={(e) =>
                    setCredentials({ ...credentials, password: e.target.value })
                  }
                  className="w-full bg-[#0a0c10] border border-white/[0.08] rounded-xl pl-12 pr-4 py-4 text-white focus:ring-2 focus:ring-[#ffb204]/50 focus:border-[#ffb204]/50 outline-none"
                  placeholder="••••••••"
                  required
                />
              </div>
            </div>

            <button
              type="submit"
              disabled={isLoading}
              className="w-full py-4 bg-gradient-to-r from-[#ffb204] to-yellow-500 text-black rounded-xl font-bold text-sm uppercase tracking-wider hover:shadow-2xl hover:shadow-[#ffb204]/30 transition-all disabled:opacity-50 flex items-center justify-center gap-2"
            >
              {isLoading ? (
                <>
                  <span className="material-symbols-outlined animate-spin">
                    progress_activity
                  </span>
                  Memproses...
                </>
              ) : (
                <>
                  <span className="material-symbols-outlined">login</span>
                  Masuk
                </>
              )}
            </button>
          </form>
        </div>

        {/* Footer */}
        <div className="text-center mt-8 text-gray-600 text-sm">
          <Link href="/" className="hover:text-[#ffb204] transition-colors">
            ← Kembali ke Website
          </Link>
        </div>
      </div>
    </div>
  );
}
