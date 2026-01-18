"use client";

import { useEffect, useRef } from "react";

interface Statistic {
  id: number;
  stat_number: string;
  stat_suffix: string;
  stat_label: string;
}

interface StatisticsSectionProps {
  statistics: Statistic[];
}

export default function StatisticsSection({ statistics }: StatisticsSectionProps) {
  const countersRef = useRef<HTMLSpanElement[]>([]);

  useEffect(() => {
    const observerOptions = {
      threshold: 0.5,
    };

    const animateCounter = (counter: HTMLSpanElement) => {
      const target = parseInt(counter.getAttribute("data-target") || "0");
      const suffix = counter.getAttribute("data-suffix") || "";
      const duration = 2000;
      const step = target / (duration / 16);
      let current = 0;

      const updateCounter = () => {
        current += step;
        if (current < target) {
          counter.textContent = Math.floor(current) + suffix;
          requestAnimationFrame(updateCounter);
        } else {
          counter.textContent = target + suffix;
        }
      };

      updateCounter();
    };

    const observer = new IntersectionObserver((entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          animateCounter(entry.target as HTMLSpanElement);
          observer.unobserve(entry.target);
        }
      });
    }, observerOptions);

    countersRef.current.forEach((counter) => {
      if (counter) observer.observe(counter);
    });

    return () => observer.disconnect();
  }, []);

  // Fallback data
  const defaultStats: Statistic[] = [
    { id: 1, stat_number: "500", stat_suffix: "+", stat_label: "Proyek Selesai" },
    { id: 2, stat_number: "12", stat_suffix: "+", stat_label: "Tahun Pengalaman" },
    { id: 3, stat_number: "98", stat_suffix: "%", stat_label: "Kepuasan Klien" },
    { id: 4, stat_number: "2", stat_suffix: "th", stat_label: "Garansi" },
  ];

  const stats = statistics.length > 0 ? statistics : defaultStats;

  return (
    <section className="border-y border-white/5 bg-[#171717]">
      <div className="max-w-[1200px] mx-auto px-6 py-12">
        <div className="grid grid-cols-2 md:grid-cols-4 gap-8 md:divide-x divide-white/5">
          {stats.map((stat, index) => (
            <div
              key={stat.id}
              className="flex flex-col items-center justify-center text-center gap-2"
              data-aos="fade-up"
              data-aos-delay={index > 0 ? index * 100 : undefined}
            >
              <span className="font-serif text-4xl md:text-5xl text-[#ffb204]">
                {stat.stat_suffix.toLowerCase() === "th" ? (
                  <>
                    <span
                      ref={(el) => {
                        if (el) countersRef.current[index] = el;
                      }}
                      className="counter"
                      data-target={stat.stat_number}
                      data-suffix=""
                    >
                      0
                    </span>
                    <span className="text-2xl ml-0.5 italic">th</span>
                  </>
                ) : (
                  <span
                    ref={(el) => {
                      if (el) countersRef.current[index] = el;
                    }}
                    className="counter"
                    data-target={stat.stat_number}
                    data-suffix={stat.stat_suffix}
                  >
                    0
                  </span>
                )}
              </span>
              <span className="text-[10px] uppercase tracking-[0.2em] font-semibold text-gray-500">
                {stat.stat_label}
              </span>
            </div>
          ))}
        </div>
      </div>
    </section>
  );
}
