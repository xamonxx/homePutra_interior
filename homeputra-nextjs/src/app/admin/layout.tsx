"use client";

import { useSession, signOut } from "next-auth/react";
import Link from "next/link";
import { usePathname, useRouter } from "next/navigation";
import { useEffect, useState } from "react";
import AuthProvider from "@/components/providers/AuthProvider";

const menuItems = [
  { icon: "dashboard", label: "Dashboard", href: "/admin" },
  { icon: "image", label: "Hero", href: "/admin/hero" },
  { icon: "analytics", label: "Statistik", href: "/admin/statistics" },
  { icon: "photo_library", label: "Portfolio", href: "/admin/portfolio" },
  { icon: "design_services", label: "Layanan", href: "/admin/services" },
  { icon: "format_quote", label: "Testimoni", href: "/admin/testimonials" },
  { icon: "mail", label: "Kontak", href: "/admin/contacts" },
  { icon: "calculate", label: "Kalkulator", href: "/admin/calculator" },
  { icon: "settings", label: "Pengaturan", href: "/admin/settings" },
  { icon: "people", label: "Pengguna", href: "/admin/users" },
];

function AdminLayoutContent({ children }: { children: React.ReactNode }) {
  const { data: session, status } = useSession();
  const pathname = usePathname();
  const router = useRouter();
  const [sidebarOpen, setSidebarOpen] = useState(false);

  useEffect(() => {
    if (status === "unauthenticated" && pathname !== "/admin/login") {
      router.push("/admin/login");
    }
  }, [status, pathname, router]);

  // Login page - render without sidebar
  if (pathname === "/admin/login") {
    return <>{children}</>;
  }

  // Loading state
  if (status === "loading") {
    return (
      <div className="min-h-screen bg-[#0B0D11] flex items-center justify-center">
        <div className="text-center">
          <div className="relative w-16 h-16 mx-auto mb-4">
            <div className="absolute inset-0 border-4 border-[#ffb204]/20 rounded-full"></div>
            <div className="absolute inset-0 border-4 border-transparent border-t-[#ffb204] rounded-full animate-spin"></div>
          </div>
          <p className="text-gray-400">Memuat...</p>
        </div>
      </div>
    );
  }

  // Not authenticated
  if (!session) {
    return null;
  }

  return (
    <div className="min-h-screen bg-[#0a0c10] flex">
      {/* Sidebar Overlay (Mobile) */}
      <div
        onClick={() => setSidebarOpen(false)}
        className={`fixed inset-0 bg-black/50 z-40 lg:hidden transition-opacity ${
          sidebarOpen ? "opacity-100" : "opacity-0 pointer-events-none"
        }`}
      ></div>

      {/* Sidebar */}
      <aside
        className={`fixed lg:static inset-y-0 left-0 z-50 w-64 bg-[#0B0D11] border-r border-white/[0.05] flex flex-col transform transition-transform lg:transform-none ${
          sidebarOpen ? "translate-x-0" : "-translate-x-full lg:translate-x-0"
        }`}
      >
        {/* Logo */}
        <div className="p-6 border-b border-white/[0.05]">
          <Link href="/admin" className="flex items-center gap-3">
            <svg
              className="w-8 h-8 text-[#ffb204]"
              fill="currentColor"
              viewBox="0 0 24 24"
            >
              <path d="M12 3L4 9v12h5v-7h6v7h5V9l-8-6z" />
            </svg>
            <div>
              <span className="text-white font-bold text-lg">Home Putra</span>
              <span className="text-gray-500 text-xs block">Admin Panel</span>
            </div>
          </Link>
        </div>

        {/* Menu Items */}
        <nav className="flex-1 p-4 space-y-1 overflow-y-auto">
          {menuItems.map((item) => {
            const isActive = pathname === item.href || 
              (item.href !== "/admin" && pathname.startsWith(item.href));
            
            return (
              <Link
                key={item.href}
                href={item.href}
                onClick={() => setSidebarOpen(false)}
                className={`flex items-center gap-3 px-4 py-3 rounded-xl transition-all ${
                  isActive
                    ? "bg-[#ffb204]/10 text-[#ffb204] border border-[#ffb204]/20"
                    : "text-gray-400 hover:bg-white/[0.05] hover:text-white"
                }`}
              >
                <span className="material-symbols-outlined text-xl">
                  {item.icon}
                </span>
                <span className="text-sm font-medium">{item.label}</span>
              </Link>
            );
          })}
        </nav>

        {/* User Info */}
        <div className="p-4 border-t border-white/[0.05]">
          <div className="flex items-center gap-3 p-3 bg-white/[0.02] rounded-xl">
            <div className="w-10 h-10 rounded-full bg-gradient-to-br from-[#ffb204] to-yellow-600 flex items-center justify-center text-black font-bold">
              {session.user?.name?.[0] || "A"}
            </div>
            <div className="flex-1 min-w-0">
              <p className="text-white text-sm font-medium truncate">
                {session.user?.name || "Admin"}
              </p>
              <p className="text-gray-500 text-xs capitalize truncate">
                {(session.user as { role?: string })?.role || "admin"}
              </p>
            </div>
            <button
              onClick={() => signOut({ callbackUrl: "/admin/login" })}
              className="text-gray-500 hover:text-red-400 transition-colors"
              title="Logout"
            >
              <span className="material-symbols-outlined text-xl">logout</span>
            </button>
          </div>
        </div>
      </aside>

      {/* Main Content */}
      <div className="flex-1 flex flex-col min-h-screen">
        {/* Top Bar */}
        <header className="bg-[#0B0D11] border-b border-white/[0.05] px-4 lg:px-8 py-4">
          <div className="flex items-center justify-between">
            <div className="flex items-center gap-4">
              <button
                onClick={() => setSidebarOpen(true)}
                className="lg:hidden text-gray-400 hover:text-white"
              >
                <span className="material-symbols-outlined text-2xl">menu</span>
              </button>
              <div>
                <h1 className="text-white font-semibold text-lg">
                  {menuItems.find((item) => 
                    pathname === item.href || 
                    (item.href !== "/admin" && pathname.startsWith(item.href))
                  )?.label || "Dashboard"}
                </h1>
                <p className="text-gray-500 text-xs">
                  Kelola konten website Anda
                </p>
              </div>
            </div>
            <div className="flex items-center gap-4">
              <Link
                href="/"
                target="_blank"
                className="text-gray-400 hover:text-[#ffb204] transition-colors flex items-center gap-2 text-sm"
              >
                <span className="material-symbols-outlined text-lg">
                  open_in_new
                </span>
                <span className="hidden sm:inline">Lihat Website</span>
              </Link>
            </div>
          </div>
        </header>

        {/* Page Content */}
        <main className="flex-1 p-4 lg:p-8">{children}</main>
      </div>
    </div>
  );
}

export default function AdminLayout({
  children,
}: {
  children: React.ReactNode;
}) {
  return (
    <AuthProvider>
      <AdminLayoutContent>{children}</AdminLayoutContent>
    </AuthProvider>
  );
}
