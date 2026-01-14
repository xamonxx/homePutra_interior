# Home Putra Interior - Landing Page CMS

Premium interior design landing page dengan sistem CMS lengkap menggunakan PHP, Tailwind CSS, dan animasi AOS.js.

## 🚀 Demo

- **Landing Page**: `http://localhost/landingpage_homeputra`
- **Admin Panel**: `http://localhost/landingpage_homeputra/admin`

## 🔐 Default Login

| Field | Value |
|-------|-------|
| Username | `admin` |
| Password | `admin123` |

## ✨ Fitur

### Landing Page
- ✅ Hero section dengan parallax background
- ✅ Statistik perusahaan dengan counter animation
- ✅ Portfolio gallery dengan hover effects
- ✅ Layanan dengan card animations
- ✅ Kalkulator estimasi harga interaktif (Rupiah)
- ✅ Testimoni klien dengan rating stars
- ✅ Form kontak dengan validasi
- ✅ WhatsApp floating button
- ✅ Back to top button
- ✅ Mobile responsive navigation
- ✅ Smooth scroll
- ✅ AOS scroll animations
- ✅ GSAP advanced animations
- ✅ Preloader

### Admin Panel CMS
- ✅ Dashboard dengan statistik dan pesan terbaru
- ✅ Manajemen Hero Section
- ✅ Manajemen Portfolio (CRUD + upload gambar)
- ✅ Manajemen Layanan (CRUD)
- ✅ Manajemen Testimoni (CRUD + upload foto)
- ✅ Manajemen Statistik Perusahaan
- ✅ Kelola Pesan Masuk dari contact form
- ✅ Pengaturan Situs
- ✅ Manajemen Pengguna (Admin only)
- ✅ Profil & Ganti Password
- ✅ CSRF Protection
- ✅ Password Hashing

## 🛠️ Teknologi

| Teknologi | Fungsi |
|-----------|--------|
| PHP 7.4+ | Backend & CMS |
| MySQL 5.7+ | Database |
| Tailwind CSS | Styling (CDN) |
| AOS.js | Scroll animations |
| GSAP | Advanced animations |
| Material Symbols | Icons |
| Alpine.js | Admin interactivity |

## 📁 Struktur Folder

```
landingpage_homeputra/
├── admin/                      # Admin Panel
│   ├── includes/
│   │   ├── auth.php           # Authentication functions
│   │   ├── header.php         # Admin header & sidebar
│   │   └── footer.php         # Admin footer & scripts
│   ├── index.php              # Dashboard
│   ├── login.php              # Login page
│   ├── logout.php             # Logout handler
│   ├── hero.php               # Hero section manager
│   ├── portfolio.php          # Portfolio manager
│   ├── services.php           # Services manager
│   ├── testimonials.php       # Testimonials manager
│   ├── statistics.php         # Statistics manager
│   ├── contacts.php           # Contact messages
│   ├── settings.php           # Site settings
│   ├── users.php              # User management
│   └── profile.php            # User profile
├── api/
│   └── contact.php            # Contact form API
├── assets/
│   ├── css/
│   │   └── custom.css         # Custom animations
│   └── images/
├── config/
│   ├── database.php           # Database connection
│   └── schema.sql             # Database schema
├── includes/
│   ├── header.php             # Site header
│   ├── footer.php             # Site footer
│   └── sections/              # Page sections
│       ├── services.php
│       ├── calculator.php
│       ├── testimonials.php
│       └── contact.php
├── uploads/                   # Uploaded files
├── index.php                  # Landing page
└── README.md
```

## 📦 Instalasi

### 1. Prasyarat
- Laragon/XAMPP/WAMP dengan PHP 7.4+ dan MySQL
- Web browser modern

### 2. Setup
1. Clone/copy folder ke direktori web server:
   ```
   C:\laragon\www\landingpage_homeputra
   ```

2. Buat database (opsional - akan auto-create):
   ```sql
   CREATE DATABASE homeputra_cms CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   ```

3. Konfigurasi database di `config/database.php`:
   ```php
   define('DB_HOST', 'localhost');
   define('DB_NAME', 'homeputra_cms');
   define('DB_USER', 'root');
   define('DB_PASS', '');
   ```

4. Akses landing page:
   ```
   http://localhost/landingpage_homeputra
   ```

5. Akses admin panel:
   ```
   http://localhost/landingpage_homeputra/admin
   ```

## 🎨 Customization

### Mengubah Warna Tema
Edit konfigurasi Tailwind di `includes/header.php`:
```javascript
colors: {
    "primary": "#ffb204",      // Warna utama (emas)
    "primary-hover": "#e6a000", // Hover state
}
```

### Mengubah Nomor WhatsApp
Edit di `includes/footer.php`:
```html
<a href="https://wa.me/6281234567890" ...>
```

### Mengubah Font
Update Google Fonts link di `includes/header.php`

## 📱 Responsiveness

Landing page dan admin panel sudah responsive untuk:
- Desktop (1200px+)
- Tablet (768px - 1199px)
- Mobile (< 768px)

## 🔒 Keamanan

- CSRF Token protection
- Password hashing dengan `password_hash()`
- Prepared statements untuk query database
- XSS prevention dengan `htmlspecialchars()`
- Session-based authentication

## 📄 License

© 2024 Home Putra Interior. All rights reserved.
