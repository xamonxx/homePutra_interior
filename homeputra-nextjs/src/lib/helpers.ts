/**
 * Helper Functions - Home Putra Interior
 */

import { query } from './db';

interface SiteSetting {
  setting_value: string;
}

// Cache untuk settings
const settingsCache: Record<string, string> = {};

/**
 * Format Currency IDR
 */
export function formatIDR(amount: number): string {
  return new Intl.NumberFormat('id-ID', {
    style: 'currency',
    currency: 'IDR',
    minimumFractionDigits: 0,
    maximumFractionDigits: 0,
  }).format(amount);
}

/**
 * Get Site Setting from Database
 */
export async function getSetting(key: string, defaultValue: string = ''): Promise<string> {
  if (settingsCache[key]) {
    return settingsCache[key];
  }

  try {
    const results = await query<SiteSetting[]>(
      'SELECT setting_value FROM site_settings WHERE setting_key = ? LIMIT 1',
      [key]
    );

    const value = results[0]?.setting_value || defaultValue;
    settingsCache[key] = value;
    return value;
  } catch {
    return defaultValue;
  }
}

/**
 * Get WhatsApp Number
 */
export async function getWhatsAppNumber(): Promise<string> {
  let number = await getSetting('whatsapp_number', '6283137554972');
  
  // Ensure international format
  number = number.replace(/[^0-9]/g, '');
  if (number.startsWith('0')) {
    number = '62' + number.substring(1);
  }
  
  return number;
}

/**
 * Get Initials from Name
 */
export function getInitials(name: string): string {
  return name
    .split(' ')
    .map(word => word[0])
    .join('')
    .toUpperCase()
    .substring(0, 2);
}

/**
 * Escape HTML (XSS Protection)
 */
export function escapeHtml(str: string): string {
  const htmlEscapes: Record<string, string> = {
    '&': '&amp;',
    '<': '&lt;',
    '>': '&gt;',
    '"': '&quot;',
    "'": '&#39;',
  };
  return str.replace(/[&<>"']/g, char => htmlEscapes[char]);
}

/**
 * Truncate Text
 */
export function truncate(str: string, length: number): string {
  if (str.length <= length) return str;
  return str.substring(0, length) + '...';
}

/**
 * Material Icons Map for Services
 */
export function getServiceMaterialIcon(iconName: string): string {
  const icons: Record<string, string> = {
    home: 'home',
    storefront: 'storefront',
    chair: 'chair',
    chat: 'chat',
    engineering: 'engineering',
    brush: 'brush',
    palette: 'palette',
    lightbulb: 'lightbulb',
    construction: 'construction',
    architecture: 'architecture',
  };
  return icons[iconName] || 'home';
}
