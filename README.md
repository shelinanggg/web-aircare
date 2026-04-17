# AIRCARE — Lost & Found System
**Airlangga Library Care & Return Service**

> Found with Care, Returned with Heart

A Laravel + MySQL digital system for managing lost & found items across all three campuses of Universitas Airlangga.

---

## Features

- 🔍 **Public search** — Anyone can search for lost items without logging in
- 📦 **Item management** — Register, track, and manage found items with QR codes
- 🏫 **Multi-campus** — Integrated across Kampus A (Dharmawangsa), B (Mulyorejo), C (Merr)
- 📷 **Photo upload** — Attach photos to items for easier identification
- 🔄 **Status tracking** — Found → Claimed → Disposed workflow
- 📊 **Dashboard** — Real-time stats and activity log
- 🔐 **Role-based auth** — Admin and Staff roles
- 📋 **Activity log** — Full audit trail of all actions

---

## Requirements

- PHP 8.2+
- Composer
- MySQL 8.0+
- Node.js (optional, for asset compilation)

---

## Installation

### 1. Clone & install dependencies

```bash
git clone <repo-url> aircare
cd aircare
composer install
```

### 2. Environment setup

```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env` and configure your database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=aircare_db
DB_USERNAME=root
DB_PASSWORD=your_password
```

### 3. Create the database

```sql
CREATE DATABASE aircare_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 4. Run migrations & seed data

```bash
php artisan migrate
php artisan db:seed
```

### 5. Create storage symlink (for uploaded images)

```bash
php artisan storage:link
```

### 6. Start the development server

```bash
php artisan serve
```

Visit: http://localhost:8000

---

## Default Accounts

| Role  | Email                            | Password |
|-------|----------------------------------|----------|
| Admin | admin@aircare.unair.ac.id        | password |
| Staff A | staff.a@aircare.unair.ac.id  | password |
| Staff B | staff.b@aircare.unair.ac.id  | password |
| Staff C | staff.c@aircare.unair.ac.id  | password |

---

## Directory Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── AuthController.php
│   │   ├── DashboardController.php
│   │   └── ItemController.php
│   ├── Middleware/
│   │   └── Authenticate.php
│   └── Kernel.php
├── Models/
│   ├── ActivityLog.php
│   ├── Item.php
│   └── User.php
└── Providers/
    └── AppServiceProvider.php

database/
├── migrations/
│   ├── 2024_01_01_000000_create_users_table.php
│   ├── 2024_01_01_000001_create_items_table.php
│   └── 2024_01_01_000002_create_activity_logs_table.php
└── seeders/
    └── DatabaseSeeder.php

resources/views/
├── auth/
│   └── login.blade.php
├── dashboard/
│   └── index.blade.php
├── items/
│   ├── index.blade.php
│   ├── create.blade.php
│   ├── edit.blade.php
│   ├── show.blade.php
│   └── public.blade.php
├── layouts/
│   ├── app.blade.php
│   └── public.blade.php
├── vendor/pagination/
│   └── custom.blade.php
└── welcome.blade.php

public/css/
└── app.css

routes/
└── web.php
```

---

## Pages

| Route | Description | Auth? |
|-------|-------------|-------|
| `/` | Landing page with AIRCARE info | No |
| `/cari-barang` | Public item search | No |
| `/login` | Staff/Admin login | No |
| `/dashboard` | Stats dashboard | Yes |
| `/barang` | Item list with filters | Yes |
| `/barang/tambah` | Register new found item | Yes |
| `/barang/{id}` | Item detail + claim/dispose | Yes |
| `/barang/{id}/edit` | Edit item | Yes |

---

## Design System

The UI uses a custom dark teal design system (`public/css/app.css`) inspired by the AIRCARE presentation:

- **Colors**: Dark teal (`#0d2b2b`) background, `#00BFA5` accent
- **Typography**: Syne (headings) + Space Grotesk (body)
- **Components**: Cards, badges, modals, tables, progress bars
- **Responsive**: Mobile-first with collapsible sidebar

---

## License

MIT — Universitas Airlangga Library System
