# Home Putra Interior - Next.js

Migrasi project dari PHP ke Next.js dengan TypeScript dan Tailwind CSS.

## Fitur

### Frontend (Public)
- ✅ Landing Page (Hero, Statistics, Portfolio, Services, Calculator, Testimonials, Contact)
- ✅ Portfolio Gallery Page
- ✅ Services Page
- ✅ Calculator Page (Interactive)
- ✅ Responsive Design
- ✅ AOS Animations
- ✅ Material Symbols Icons

### Admin Panel
- ✅ Login dengan NextAuth.js
- ✅ Dashboard
- ✅ Portfolio Management (CRUD)
- ✅ Services Management (CRUD)
- ✅ Testimonials Management (CRUD)
- ✅ Contact Submissions
- ✅ Site Settings

### Backend
- ✅ MySQL Database (sama dengan PHP version)
- ✅ REST API Routes
- ✅ NextAuth Authentication

## Instalasi

### Prerequisites
- Node.js 18+
- MySQL Database (dengan data dari PHP version)

### Setup

1. Install dependencies:
```bash
npm install
```

2. Copy `.env.local` dan sesuaikan:
```env
DB_HOST=localhost
DB_USER=root
DB_PASSWORD=
DB_NAME=homeputra_cms

NEXTAUTH_URL=http://localhost:3000
NEXTAUTH_SECRET=your-secret-key-change-this
```

3. Pastikan database MySQL sudah ada dengan tabel dari `schema.sql`

4. Jalankan development server:
```bash
npm run dev
```

5. Buka http://localhost:3000

### Build Production
```bash
npm run build
npm run start
```

## Struktur Folder

```
src/
├── app/
│   ├── admin/           # Admin panel pages
│   ├── api/             # API routes
│   ├── calculator/      # Calculator page
│   ├── portfolio/       # Portfolio page
│   ├── services/        # Services page
│   ├── globals.css      # Global styles
│   ├── layout.tsx       # Root layout
│   └── page.tsx         # Home page
├── components/
│   ├── layout/          # Navbar, Footer
│   ├── providers/       # Context providers
│   ├── sections/        # Page sections
│   └── ui/              # UI components
├── lib/
│   ├── db.ts            # Database connection
│   └── helpers.ts       # Helper functions
└── types/
    └── index.ts         # TypeScript types
```

## Login Admin
- URL: /admin/login
- Username: admin
- Password: admin123

## Deployment

### Node.js Server
1. Build: `npm run build`
2. Start: `npm run start`
3. Gunakan PM2 untuk production

### Vercel
1. Push ke GitHub
2. Connect dengan Vercel
3. Set environment variables
4. Deploy

## Catatan Migrasi

- Database: Menggunakan database MySQL yang sama dengan PHP version
- Autentikasi: Dari PHP sessions ke NextAuth.js JWT
- Styling: Tailwind CSS tetap sama
- Animasi: AOS dan custom CSS animations

## Stack Teknologi
- Next.js 15
- React 19
- TypeScript
- Tailwind CSS v4
- MySQL2
- NextAuth.js
- AOS (Animate on Scroll)

---
Dibuat dengan ❤️ oleh Home Putra Interior
