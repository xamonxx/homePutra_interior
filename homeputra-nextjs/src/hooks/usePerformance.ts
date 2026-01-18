"use client";

import { useState, useEffect } from "react";

interface PerformanceSettings {
  isLowEnd: boolean;
  prefersReducedMotion: boolean;
  shouldReduceAnimations: boolean;
  connectionType: string;
}

export function usePerformance(): PerformanceSettings {
  const [settings, setSettings] = useState<PerformanceSettings>({
    isLowEnd: false,
    prefersReducedMotion: false,
    shouldReduceAnimations: false,
    connectionType: "4g",
  });

  useEffect(() => {
    // Check for reduced motion preference
    const prefersReducedMotion = window.matchMedia("(prefers-reduced-motion: reduce)").matches;

    // Check hardware capabilities
    const cores = navigator.hardwareConcurrency || 4;
    const memory = (navigator as unknown as { deviceMemory?: number }).deviceMemory || 8;
    const isLowEnd = cores <= 4 || memory <= 4;

    // Check connection type
    const connection = (navigator as unknown as { connection?: { effectiveType?: string } }).connection;
    const connectionType = connection?.effectiveType || "4g";
    const isSlowConnection = connectionType === "slow-2g" || connectionType === "2g" || connectionType === "3g";

    // Determine if we should reduce animations
    const shouldReduceAnimations = prefersReducedMotion || isLowEnd || isSlowConnection;

    setSettings({
      isLowEnd,
      prefersReducedMotion,
      shouldReduceAnimations,
      connectionType,
    });
  }, []);

  return settings;
}

// Lazy load images only when they're about to enter viewport
export function useLazyLoad(threshold = 0.1) {
  const [isVisible, setIsVisible] = useState(false);

  useEffect(() => {
    const observer = new IntersectionObserver(
      ([entry]) => {
        if (entry.isIntersecting) {
          setIsVisible(true);
          observer.disconnect();
        }
      },
      { threshold, rootMargin: "100px" }
    );

    return () => observer.disconnect();
  }, [threshold]);

  return isVisible;
}

// Debounce for scroll handlers
export function useDebounce<T>(value: T, delay: number): T {
  const [debouncedValue, setDebouncedValue] = useState<T>(value);

  useEffect(() => {
    const timer = setTimeout(() => setDebouncedValue(value), delay);
    return () => clearTimeout(timer);
  }, [value, delay]);

  return debouncedValue;
}
