/**
 * TypeScript Types - Home Putra Interior
 */

export interface Statistic {
  id: number;
  stat_number: string;
  stat_suffix: string;
  stat_label: string;
  display_order: number;
  is_active: number;
}

export interface Portfolio {
  id: number;
  title: string;
  category: string;
  description: string;
  image: string;
  display_order: number;
  is_featured: number;
  is_active: number;
  created_at: string;
  updated_at: string;
}

export interface Service {
  id: number;
  title: string;
  description: string;
  icon: string;
  display_order: number;
  is_active: number;
}

export interface Testimonial {
  id: number;
  client_name: string;
  client_location: string;
  client_image: string;
  testimonial_text: string;
  rating: number;
  display_order: number;
  is_active: number;
}

export interface ContactSubmission {
  id: number;
  first_name: string;
  last_name: string;
  email: string;
  phone: string;
  service_type: string;
  message: string;
  is_read: number;
  created_at: string;
}

export interface HeroSection {
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

export interface SiteSetting {
  id: number;
  setting_key: string;
  setting_value: string;
  setting_type: string;
  setting_group: string;
}

export interface AdminUser {
  id: number;
  username: string;
  password: string;
  full_name: string;
  email: string;
  role: 'admin' | 'editor';
  is_active: number;
  last_login: string;
}

export interface CalculatorItem {
  id: number;
  product_type: string;
  material_type: string;
  price_per_meter: number;
  min_length: number;
  max_length: number;
  is_active: number;
}
