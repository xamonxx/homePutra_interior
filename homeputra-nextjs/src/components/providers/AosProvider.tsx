"use client";

import { useEffect } from "react";
import AOS from "aos";
import "aos/dist/aos.css";

interface AosProviderProps {
  children: React.ReactNode;
}

export default function AosProvider({ children }: AosProviderProps) {
  useEffect(() => {
    // Check if user prefers reduced motion
    const prefersReducedMotion = window.matchMedia("(prefers-reduced-motion: reduce)").matches;
    
    // Check if device is low-end (rough heuristic)
    // Use fallback values if APIs are not available (e.g. in Safari/Firefox)
    const hardwareConcurrency = navigator.hardwareConcurrency || 4;
    // Cast to any to access non-standard deviceMemory property safely
    // eslint-disable-next-line @typescript-eslint/no-explicit-any
    const deviceMemory = (navigator as any).deviceMemory || 8;

    const isMobile = window.innerWidth < 768;
    // User request: Animations only on Desktop (disable on mobile/Android)
    const shouldDisable = isMobile || prefersReducedMotion;

    AOS.init({
      duration: 800,
      easing: "ease-out",
      once: true,
      offset: 50,
      disable: shouldDisable, 
      throttleDelay: 99,
      debounceDelay: 50,
    });
  }, []);

  return <>{children}</>;
}
