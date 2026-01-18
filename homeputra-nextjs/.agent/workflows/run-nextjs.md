---
description: How to run the Next.js project
---

# Running the Home Putra Interior Next.js Project

## Prerequisites
- Node.js 18 or higher
- MySQL database with the homeputra_cms schema

## Development Mode

// turbo
1. Navigate to the project directory:
```bash
cd homeputra-nextjs
```

// turbo
2. Install dependencies (if not done):
```bash
npm install
```

3. Make sure `.env.local` is configured with correct database credentials:
```
DB_HOST=localhost
DB_USER=root
DB_PASSWORD=
DB_NAME=homeputra_cms
NEXTAUTH_URL=http://localhost:3000
NEXTAUTH_SECRET=your-secret-key
```

// turbo
4. Start the development server:
```bash
npm run dev
```

5. Open http://localhost:3000 in your browser

## Production Build

// turbo
1. Build the project:
```bash
npm run build
```

// turbo
2. Start production server:
```bash
npm run start
```

## Admin Panel

1. Go to http://localhost:3000/admin/login
2. Login with:
   - Username: `admin`
   - Password: `admin123`

## Available Pages

### Public Pages
- `/` - Landing page
- `/portfolio` - Portfolio gallery
- `/services` - Services page
- `/calculator` - Price calculator

### Admin Pages
- `/admin` - Dashboard
- `/admin/hero` - Hero section
- `/admin/statistics` - Statistics management
- `/admin/portfolio` - Portfolio CRUD
- `/admin/services` - Services CRUD
- `/admin/testimonials` - Testimonials CRUD
- `/admin/contacts` - Contact submissions
- `/admin/settings` - Site settings
- `/admin/users` - Admin users
- `/admin/calculator` - Calculator settings info
