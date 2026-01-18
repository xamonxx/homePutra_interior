"use client";

import { useEffect, useState } from "react";

export default function Preloader() {
  const [isLoading, setIsLoading] = useState(true);

  useEffect(() => {
    const timer = setTimeout(() => {
      setIsLoading(false);
    }, 500);

    return () => clearTimeout(timer);
  }, []);

  if (!isLoading) return null;

  return (
    <div
      className={`fixed inset-0 z-[100] bg-[#0B0D11] flex items-center justify-center transition-opacity duration-500 ${
        isLoading ? "opacity-100" : "opacity-0 pointer-events-none"
      }`}
    >
      <div className="text-center">
        <div className="relative w-24 h-24 mx-auto mb-6">
          <div className="absolute inset-0 border-4 border-[#ffb204]/20 rounded-full"></div>
          <div className="absolute inset-0 border-4 border-transparent border-t-[#ffb204] rounded-full animate-spin"></div>
          <svg
            className="w-10 h-10 text-[#ffb204] absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2"
            fill="currentColor"
            viewBox="0 0 24 24"
          >
            <path d="M12 3L4 9v12h5v-7h6v7h5V9l-8-6z" />
          </svg>
        </div>
        <p className="text-gray-400 text-sm uppercase tracking-widest">
          Memuat...
        </p>
      </div>
    </div>
  );
}
