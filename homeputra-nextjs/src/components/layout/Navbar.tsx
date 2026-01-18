"use client";

import { useState, useEffect, useCallback } from "react";
import Link from "next/link";
import { usePathname } from "next/navigation";
import { usePerformance } from "@/hooks/usePerformance";

const navItems = [
  {
    label: "Layanan",
    href: "/services",
    hasDropdown: true,
    icon: "design_services",
    dropdownItems: [
      { label: "Semua Layanan", href: "/services", icon: "apps", isMain: true },
      { label: "Kitchen Set", href: "/#services", icon: "countertops" },
      { label: "Wardrobe & Lemari", href: "/#services", icon: "door_sliding" },
      { label: "Backdrop TV", href: "/#services", icon: "tv" },
      { label: "Wallpanel", href: "/#services", icon: "dashboard" },
    ],
  },
  {
    label: "Portfolio",
    href: "/portfolio",
    hasDropdown: true,
    icon: "photo_library",
    dropdownItems: [
      { label: "Galeri Portfolio", href: "/portfolio", icon: "collections", isMain: true },
      { label: "Proyek Residensial", href: "/#portfolio", icon: "home" },
      { label: "Proyek Komersial", href: "/#portfolio", icon: "business" },
    ],
  },
  { label: "Harga", href: "/pricing", icon: "payments" },
  { label: "Kalkulator", href: "/calculator", icon: "calculate" },
  { label: "Testimoni", href: "/#testimonials", icon: "reviews" },
  { label: "Kontak", href: "/#contact", icon: "mail" },
];

export default function Navbar() {
  const { isLowEnd } = usePerformance();
  const [isScrolled, setIsScrolled] = useState(false);
  const [isMobileMenuOpen, setIsMobileMenuOpen] = useState(false);
  const [activeDropdown, setActiveDropdown] = useState<string | null>(null);
  const [mobileExpandedItem, setMobileExpandedItem] = useState<string | null>(null);
  const pathname = usePathname();

  const handleScroll = useCallback(() => {
    setIsScrolled(window.scrollY > 50);
  }, []);

  useEffect(() => {
    window.addEventListener("scroll", handleScroll, { passive: true });
    handleScroll();
    return () => window.removeEventListener("scroll", handleScroll);
  }, [handleScroll]);

  useEffect(() => {
    if (isMobileMenuOpen) {
      document.body.style.overflow = "hidden";
    } else {
      document.body.style.overflow = "";
    }
    return () => {
      document.body.style.overflow = "";
    };
  }, [isMobileMenuOpen]);

  const closeMobileMenu = () => {
    setIsMobileMenuOpen(false);
    setMobileExpandedItem(null);
  };

  const isActive = (href: string) => {
    if (href === "/") return pathname === "/";
    const basePath = href.split("#")[0];
    if (!basePath) return false;
    return pathname === basePath || pathname?.startsWith(basePath + "/");
  };

  return (
    <>
      {/* Navigation */}
      <nav
        className={`fixed top-0 left-0 right-0 z-9999 transition-all duration-300 ${
          isScrolled
            ? isLowEnd 
              ? "bg-[#0a0c10] border-b border-white/10 shadow-lg" // Solid bg for low-end (PERFORMA TINGGI)
              : "bg-[#0a0c10]/95 backdrop-blur-xl shadow-lg shadow-black/10" // Glassmorphism for high-end
            : "bg-linear-to-b from-black/50 to-transparent"
        }`}
      >
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className={`flex items-center justify-between transition-all duration-300 ${isScrolled ? "h-16" : "h-20"}`}>
            
            {/* Logo */}
            <Link href="/" className="flex items-center gap-2.5 group">
              <div className="relative">
                {/* Effect Blur: Disable on low end */}
                {!isLowEnd && (
                  <div className="absolute -inset-2 bg-[#ffb204]/20 rounded-full blur-lg opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                )}
                <svg
                  className="relative w-8 h-8 text-[#ffb204] transition-transform duration-300 group-hover:scale-110"
                  fill="currentColor"
                  viewBox="0 0 24 24"
                >
                  <path d="M12 3L4 9v12h5v-7h6v7h5V9l-8-6z" />
                </svg>
              </div>
              <div className="flex flex-col">
                <span className="text-lg font-bold text-white leading-tight">Home Putra</span>
                <span className="text-[9px] text-[#ffb204] font-medium tracking-[0.2em] uppercase">Interior</span>
              </div>
            </Link>

            {/* Desktop Menu */}
            <div className="hidden lg:flex items-center gap-1">
              {navItems.map((item) => (
                <div
                  key={item.label}
                  className="relative"
                  onMouseEnter={() => item.hasDropdown && setActiveDropdown(item.label)}
                  onMouseLeave={() => setActiveDropdown(null)}
                >
                  <Link
                    href={item.href}
                    className={`px-4 py-2.5 flex items-center gap-1.5 text-[11px] uppercase tracking-[0.12em] font-semibold rounded-lg transition-all duration-200 ${
                      isActive(item.href)
                        ? "text-[#ffb204] bg-[#ffb204]/10"
                        : "text-white/70 hover:text-white hover:bg-white/5"
                    }`}
                  >
                    {item.label}
                    {item.hasDropdown && (
                      <svg
                        className={`w-3 h-3 transition-transform duration-200 ${activeDropdown === item.label ? "rotate-180" : ""}`}
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                      >
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M19 9l-7 7-7-7" />
                      </svg>
                    )}
                  </Link>

                  {/* Dropdown */}
                  {item.hasDropdown && item.dropdownItems && (
                    <div
                      className={`absolute top-full left-0 pt-2 z-10000 transition-all duration-200 ${
                        activeDropdown === item.label
                          ? "opacity-100 visible translate-y-0"
                          : "opacity-0 invisible -translate-y-1 pointer-events-none"
                      }`}
                    >
                      <div className="w-56 bg-[#13161c] border border-white/10 rounded-xl shadow-2xl shadow-black/50 overflow-hidden">
                        <div className="p-1.5">
                          {item.dropdownItems.map((dropItem) => (
                            <Link
                              key={dropItem.label}
                              href={dropItem.href}
                              onClick={() => setActiveDropdown(null)}
                              className={`flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all duration-150 ${
                                dropItem.isMain
                                  ? "bg-[#ffb204]/10 text-[#ffb204] mb-1"
                                  : "text-gray-300 hover:bg-white/5 hover:text-white"
                              }`}
                            >
                              <span className={`w-7 h-7 rounded-lg flex items-center justify-center text-xs ${
                                dropItem.isMain ? "bg-[#ffb204] text-black" : "bg-white/5"
                              }`}>
                                <span className="material-symbols-outlined text-base">{dropItem.icon}</span>
                              </span>
                              <span className="text-sm font-medium">{dropItem.label}</span>
                            </Link>
                          ))}
                        </div>
                      </div>
                    </div>
                  )}
                </div>
              ))}

              {/* CTA Button */}
              <Link
                href="/#contact"
                className="ml-4 h-10 px-5 flex items-center justify-center gap-2 bg-[#ffb204] hover:bg-[#e6a000] text-black text-[11px] uppercase tracking-wider font-bold rounded-lg transition-all duration-200 shadow-lg shadow-[#ffb204]/20"
              >
                <span className="material-symbols-outlined text-base">chat</span>
                Konsultasi
              </Link>
            </div>

            {/* Mobile Toggle */}
            <button
              onClick={() => setIsMobileMenuOpen(!isMobileMenuOpen)}
              className="lg:hidden w-11 h-11 flex items-center justify-center rounded-lg bg-white/5 border border-white/10 text-white hover:bg-[#ffb204]/10 hover:text-[#ffb204] hover:border-[#ffb204]/30 transition-all"
              aria-label="Toggle menu"
            >
              <div className="w-5 h-4 flex flex-col justify-between">
                <span className={`block h-0.5 bg-current rounded transition-all duration-300 ${isMobileMenuOpen ? "rotate-45 translate-y-[7px]" : ""}`}></span>
                <span className={`block h-0.5 bg-current rounded transition-all duration-300 ${isMobileMenuOpen ? "opacity-0" : ""}`}></span>
                <span className={`block h-0.5 bg-current rounded transition-all duration-300 ${isMobileMenuOpen ? "-rotate-45 -translate-y-[7px]" : ""}`}></span>
              </div>
            </button>
          </div>
        </div>
      </nav>

      {/* Mobile Menu Overlay */}
      <div
        onClick={closeMobileMenu}
        className={`fixed inset-0 z-10000 lg:hidden transition-opacity duration-300 ${
          isLowEnd ? "bg-black/95" : "bg-black/80 backdrop-blur-sm"
        } ${
          isMobileMenuOpen ? "opacity-100" : "opacity-0 pointer-events-none"
        }`}
      ></div>

      {/* Mobile Menu Panel */}
      <div
        className={`fixed top-0 right-0 w-[300px] max-w-[85vw] h-full bg-[#0f1218] z-10001 lg:hidden transition-transform duration-300 shadow-2xl ${
          isMobileMenuOpen ? "translate-x-0" : "translate-x-full"
        }`}
      >
        {/* Header */}
        <div className="flex items-center justify-between p-5 border-b border-white/5">
          <Link href="/" onClick={closeMobileMenu} className="flex items-center gap-2">
            <svg className="w-7 h-7 text-[#ffb204]" fill="currentColor" viewBox="0 0 24 24">
              <path d="M12 3L4 9v12h5v-7h6v7h5V9l-8-6z" />
            </svg>
            <div>
              <span className="block text-white font-bold text-sm">Home Putra</span>
              <span className="text-[8px] text-[#ffb204] tracking-widest uppercase">Interior</span>
            </div>
          </Link>
          <button
            onClick={closeMobileMenu}
            className="w-9 h-9 flex items-center justify-center rounded-lg bg-white/5 text-white hover:bg-red-500/20 hover:text-red-400 transition-all"
          >
            <span className="material-symbols-outlined text-xl">close</span>
          </button>
        </div>

        {/* Menu Items */}
        <div className="h-[calc(100%-160px)] overflow-y-auto p-4 space-y-1">
          {navItems.map((item) => (
            <div key={item.label}>
              {item.hasDropdown ? (
                <>
                  <button
                    onClick={() => setMobileExpandedItem(mobileExpandedItem === item.label ? null : item.label)}
                    className={`w-full flex items-center justify-between p-3.5 rounded-xl transition-all ${
                      mobileExpandedItem === item.label
                        ? "bg-[#ffb204]/10 text-[#ffb204]"
                        : "bg-white/2 text-white hover:bg-white/5"
                    }`}
                  >
                    <div className="flex items-center gap-3">
                      <span className={`material-symbols-outlined text-xl ${mobileExpandedItem === item.label ? "text-[#ffb204]" : "text-gray-400"}`}>
                        {item.icon}
                      </span>
                      <span className="font-medium">{item.label}</span>
                    </div>
                    <span className={`material-symbols-outlined text-xl transition-transform duration-200 ${mobileExpandedItem === item.label ? "rotate-180" : ""}`}>
                      expand_more
                    </span>
                  </button>
                  <div className={`overflow-hidden transition-all duration-200 ${mobileExpandedItem === item.label ? "max-h-80 mt-1" : "max-h-0"}`}>
                    <div className="pl-4 space-y-1">
                      {item.dropdownItems?.map((dropItem) => (
                        <Link
                          key={dropItem.label}
                          href={dropItem.href}
                          onClick={closeMobileMenu}
                          className={`flex items-center gap-3 p-3 rounded-lg transition-all ${
                            dropItem.isMain ? "text-[#ffb204] bg-[#ffb204]/5" : "text-gray-400 hover:text-white hover:bg-white/5"
                          }`}
                        >
                          <span className="material-symbols-outlined text-lg">{dropItem.icon}</span>
                          <span className="text-sm">{dropItem.label}</span>
                        </Link>
                      ))}
                    </div>
                  </div>
                </>
              ) : (
                <Link
                  href={item.href}
                  onClick={closeMobileMenu}
                  className={`flex items-center gap-3 p-3.5 rounded-xl transition-all ${
                    isActive(item.href)
                      ? "bg-[#ffb204]/10 text-[#ffb204]"
                      : "bg-white/2 text-white hover:bg-white/5"
                  }`}
                >
                  <span className={`material-symbols-outlined text-xl ${isActive(item.href) ? "text-[#ffb204]" : "text-gray-400"}`}>
                    {item.icon}
                  </span>
                  <span className="font-medium">{item.label}</span>
                </Link>
              )}
            </div>
          ))}
        </div>

        {/* Footer CTA */}
        <div className="absolute bottom-0 left-0 right-0 p-4 bg-linear-to-t from-[#0f1218] to-transparent pt-8">
          <Link
            href="/#contact"
            onClick={closeMobileMenu}
            className="flex items-center justify-center gap-2 h-12 bg-[#ffb204] text-black font-bold rounded-xl transition-all hover:bg-[#e6a000]"
          >
            <span className="material-symbols-outlined">chat</span>
            Konsultasi Gratis
          </Link>
        </div>
      </div>
    </>
  );
}
