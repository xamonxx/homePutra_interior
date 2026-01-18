import { query } from "@/lib/db";
import HeroSection from "@/components/sections/HeroSection";
import StatisticsSection from "@/components/sections/StatisticsSection";
import PortfolioSection from "@/components/sections/PortfolioSection";
import ServicesSection from "@/components/sections/ServicesSection";
import CalculatorSection from "@/components/sections/CalculatorSection";
import TestimonialsSection from "@/components/sections/TestimonialsSection";
import ContactSection from "@/components/sections/ContactSection";
import { Statistic, Portfolio, Service, Testimonial } from "@/types";

async function getStatistics(): Promise<Statistic[]> {
  try {
    return await query<Statistic[]>(
      "SELECT * FROM statistics WHERE is_active = 1 ORDER BY display_order ASC LIMIT 4"
    );
  } catch {
    return [];
  }
}

async function getPortfolios(): Promise<Portfolio[]> {
  try {
    return await query<Portfolio[]>(
      "SELECT * FROM portfolio WHERE is_active = 1 ORDER BY display_order ASC, created_at DESC LIMIT 6"
    );
  } catch {
    return [];
  }
}

async function getServices(): Promise<Service[]> {
  try {
    return await query<Service[]>(
      "SELECT * FROM services WHERE is_active = 1 ORDER BY display_order ASC"
    );
  } catch {
    return [];
  }
}

async function getTestimonials(): Promise<Testimonial[]> {
  try {
    return await query<Testimonial[]>(
      "SELECT * FROM testimonials WHERE is_active = 1 ORDER BY display_order ASC"
    );
  } catch {
    return [];
  }
}

export default async function HomePage() {
  const [statistics, portfolios, services, testimonials] = await Promise.all([
    getStatistics(),
    getPortfolios(),
    getServices(),
    getTestimonials(),
  ]);

  return (
    <>
      <HeroSection />
      <StatisticsSection statistics={statistics} />
      <PortfolioSection portfolios={portfolios} />
      <ServicesSection services={services} />
      <CalculatorSection />
      <TestimonialsSection testimonials={testimonials} />
      <ContactSection />
    </>
  );
}
