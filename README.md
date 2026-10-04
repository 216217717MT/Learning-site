# CPUT Self-Service Training Portal

A self-service help portal built for the CPUT Service Desk, so students and
staff can solve common IT issues themselves — connecting to wifi, resetting
passwords, getting proof of registration, and more — without needing to call
or visit the Service Desk in person.

Built with **Laravel** (backend), **Filament** (admin panel), and
**PostgreSQL** (database).

---

## What this project does

**For students:**
- Browse or search step-by-step guides, grouped into 7 categories (Wifi,
  Registration, Email, Printing, Passwords, Learning Platforms, CRIMS)
- Watch real embedded YouTube videos per guide
- Open an uploaded PDF for guides with a document-based walkthrough instead
  of a plain text list
- Give quick feedback ("Yes, sorted" / "Still stuck") on whether a guide
  helped
- Enter their student number before viewing any guide, so the Service Desk
  can see what a student has watched if they call in
- Video-watching progress (started / completed, % watched) is tracked per
  student number — searchable by staff at `/staff/lookup` (login required)

**For Service Desk staff/admins:**
- Full admin panel at `/admin` to create, edit, publish/unpublish, and
  delete guides
- Manage each guide's step-by-step content and video links directly from
  its edit page
- Dashboard with real analytics: total guides, total views, helpful rate,
  guides needing review, most-viewed guides, and searches that returned no
  results (a live "content gap" list — shows exactly what new guides are
  worth writing)
- Export guide and feedback data to CSV
- CPUT branding throughout: logo, colours, category icons, background image

---

## Tech stack

| Layer | Technology |
|---|---|
| Backend framework | Laravel 12 |
| Admin panel | Filament 3.3.54 |
| Database | PostgreSQL 16 |
| Local dev server | PHP 8.2 (via XAMPP) |
| Frontend | Blade templates, plain CSS (no build step required) |
| Trend/analytics | `flowframe/laravel-trend` |

---

## Local setup

### 1. Requirements
- PHP 8.2+ with these extensions enabled in `php.ini`: `intl`, `pdo_pgsql`,
  `pgsql`
- PostgreSQL 16 installed and running
- Composer

### 2. Install dependencies
```powershell
composer install
```

### 3. Environment file
Copy `.env.example` to `.env` and set your database connection:
```
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=cput_training_portal
DB_USERNAME=postgres
DB_PASSWORD=your_postgres_password
```

Create the database first if it doesn't exist:
```powershell
& "C:\Program Files\PostgreSQL\16\bin\psql.exe" -U postgres
CREATE DATABASE cput_training_portal;
\q
```

### 4. Generate an app key
```powershell
php artisan key:generate
```

### 5. Run migrations and seed real starter data
```powershell
php artisan migrate --seed
```
This creates all tables and loads the 7 real categories plus 19 real guides
(with steps and video links) — not fake/test data.

### 6. Link public storage (needed for uploaded PDFs)
```powershell
php artisan storage:link
```

### 7. Create your admin login
```powershell
php artisan make:filament-user
```

### 8. Start the server
```powershell
php artisan serve
```
Visit:
- Student site: `http://127.0.0.1:8000/`
- Admin panel: `http://127.0.0.1:8000/admin`
- Staff lookup tool: `http://127.0.0.1:8000/staff/lookup` (requires admin
  login)

---

## Project structure (short version)

A full, detailed breakdown — including a "where do I go to fix X" lookup
table — lives in `PROJECT_GUIDE.md` in this same folder. Quick summary:

```
app/Http/Controllers/     — student-facing page logic
app/Models/                — one file per database table
app/Filament/Resources/    — admin CRUD screens (Guides, Categories)
app/Filament/Widgets/      — dashboard boxes (KPIs, tables)
resources/views/           — all Blade templates (student site + admin customisations)
database/migrations/       — database structure, in order
database/seeders/          — real starter data
routes/web.php             — every URL the site responds to
```

---

## Known limitations / things to know

- **No real CPUT login (SSO) yet.** Students self-report their student
  number on a simple form before viewing a guide — it is not verified
  against a real CPUT account. The `users` table already has the extra
  columns (`sso_subject_id`, `student_number`, `role`) ready for when real
  SSO integration happens.
- **Video tracking only works for YouTube videos.** It uses YouTube's own
  player API to detect start/pause/finish. Vimeo or uploaded videos are not
  tracked the same way.
- **"Needs review" and "Helpful rate" depend on real student feedback.**
  These will show little or no data until real students start using the
  site and clicking the feedback buttons.
- **Local dev uses a self-reported date filter**, not a fully wired
  date-range filter across every dashboard box yet — only the main KPI
  cards use the `flowframe/laravel-trend` package for real week-over-week
  comparisons.

---

## Content accuracy warning

The step-by-step instructions in the 19 seeded guides (menu names, URLs,
specific deadlines) were written as realistic placeholders during
development — **they have not been verified against the real CPUT systems
(myCPUT, CRIMS, Blackboard, etc.)**. Before this goes live for real
students, someone needs to walk through each guide and correct anything
that doesn't match the actual interface.

---

## Documentation

For anyone picking up this project:

- **[Functional & Non-Functional Requirements](docs/CPUT_Training_Portal_FRD.docx)** —
  the original requirements document, covering scope, user stories, and
  priorities for every feature.
- **[Project Guide](docs/PROJECT_GUIDE.md)** — a full breakdown of every
  file and folder, plus a "where do I go to fix X" lookup table.
- **[Database schema reference](docs/schema.sql)** — the original planned
  database design (note: the actual live schema, built via Laravel
  migrations, uses simpler auto-incrementing IDs rather than the UUIDs
  shown here — see `database/migrations/` for the real, current structure).

## Credits

Built by Tshepang Molefe, CPUT Service Desk.
