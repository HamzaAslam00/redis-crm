# Redis Solution CRM — Master Architecture & Planning Document
### Prepared by: Software Architect Review | Last Updated: 2026-05-13
### Version: 10.0.0 — Phase 3 COMPLETE · Dashboard + Projects + Budget + Investments + Hosting DONE

---

## TABLE OF CONTENTS

1. [Project Vision & Objectives](#1-project-vision--objectives)
2. [Tech Stack — Laravel + Blade + Livewire + Alpine.js](#2-tech-stack--full-justification)
3. [System Architecture Overview](#3-system-architecture-overview)
4. [Color System & Brand Identity (Real Colors)](#4-color-system--brand-identity)
5. [Database Architecture — Complete Schema](#5-database-architecture--complete-schema)
6. [Authentication (Laravel Breeze) + Spatie Roles & Permissions](#6-authentication--authorization)
7. [Laravel Routes & Controller Architecture](#7-laravel-routes--controller-architecture)
8. [Module 01 — Projects Management](#8-module-01--projects-management)
9. [Module 02 — Investments](#9-module-02--investments)
10. [Module 03 — Budget (Expenses & Income)](#10-module-03--budget-expenses--income)
11. [Module 04 — Hosting Clients](#11-module-04--hosting-clients)
12. [Module 05 — API Keys Vault](#12-module-05--api-keys-vault)
13. [Module 06 — Credentials Vault](#13-module-06--credentials-vault)
14. [Module 07 — Demo Projects](#14-module-07--demo-projects)
15. [Module 08 — Crypto Investment](#15-module-08--crypto-investment)
16. [Module 09 — User Personal Notes](#16-module-09--user-personal-notes)
17. [Module 10 — SEO Management (Dashboard + Own Site + Client Sites)](#17-module-10--seo-management-comprehensive)
18. [Module 11 — Blogging System (Backend + Frontend)](#18-module-11--blogging-system)
18B. [Module 12 — Website Content Management (Portfolio, Testimonials, FAQs, Contact)](#18b-module-12--website-content-management)
18C. [Module 13 — Products (Phase 2)](#18c-module-13--products-phase-2)
18D. [Module 14 — Activity Logs (Spatie Activitylog)](#18d-module-14--activity-logs)
19. [CRM Dashboard — Design & Data](#19-crm-dashboard--design--data)
20. [Frontend Public Website — All Pages (Dark Fire Agency Design)](#20-frontend-public-website--all-pages)
21. [UI/UX Design System — CRM Panel (Blade + Livewire)](#21-uiux-design-system--crm-panel)
22. [UI/UX Design System — Public Website](#22-uiux-design-system--public-website)
23. [Animation Strategy](#23-animation-strategy)
24. [Security Architecture](#24-security-architecture)
25. [File Storage & Media Management](#25-file-storage--media-management)
26. [Notification System](#26-notification-system)
27. [Folder & File Structure (Laravel)](#27-folder--file-structure-laravel)
28. [Development Phases & Timeline (8 Phases)](#28-development-phases--timeline-laravel)
29. [Environment & Deployment (Laravel + Nginx)](#29-environment--deployment-laravel)
30. [Module 15 — Settings (General + SMTP + Email Templates + Notifications + Anti-Bot)](#30-module-15--settings-system-configuration-center)
31. [Anti-Bot Protection (Contact Form — 3 Layers)](#31-anti-bot-protection-contact-form)
32. [Contact Message Reply System (Templates + History)](#32-contact-message-reply-system-enhanced)
33. [Proposal Builder (PDF + Email + Status Tracking)](#33-proposal-builder)
34. [Updated Database Additions v4.0](#34-updated-database-additions-v40)
35. [Updated CRM Navigation v4.0](#35-updated-crm-navigation-v40)
36. [Updated Development Phases v4.0](#36-updated-development-phases-v40)
37. [WhatsApp Integration (Website Widget + CRM Log)](#37-whatsapp-integration)
38. [Email Newsletter & Marketing Module (CRM)](#38-email-newsletter--marketing-module)
39. [Free Audit Tool & Lead Magnet (Website)](#39-free-audit-tool--lead-magnet)
40. [Public Case Studies & Social Proof Numbers (Website)](#40-public-case-studies--social-proof-numbers)
41. [common.js & Helper.php Architecture — Full Reference](#41-commonjs--helperphp-architecture)
42. [MASTER IMPLEMENTATION ROADMAP (Consolidated — All Phases)](#42-master-implementation-roadmap)
43. [Coding Standards, PSR & Laravel Best Practices](#43-coding-standards-psr--laravel-best-practices)

---

## CURRENT BUILD STATUS — 2026-05-13

> Quick reference for what is actually built and running vs. still pending.

### ✅ PHASE 1 — Foundation & Asset Pipeline — COMPLETE

| Item | Status | Notes |
|---|---|---|
| Laravel 13 + PHP 8.5 project created | ✅ Done | |
| Composer packages installed | ✅ Done | spatie/permission, activitylog, media-library, livewire, seotools, sitemap, etc. |
| NPM packages | ✅ Done | SASS, GSAP, Alpine (via Livewire), ApexCharts, Flatpickr, Axios, SweetAlert2 |
| Vite config (SCSS + JS dual entry) | ✅ Done | app.scss + public.scss + app.js + public.js |
| SCSS structure | ✅ Done | `backend/` and `frontend/` partials all created |
| `_variables.scss` — brand colors + CSS custom properties | ✅ Done | Dark + Light theme tokens, both CRM + frontend vars |
| `resources/js/bootstrap.js` — toast/axios/swal globals | ✅ Done | |
| `resources/js/app.js` — Alpine removed (Livewire owns it) | ✅ Done | Fixed: no double Alpine instance |
| `public/assets/js/common.js` | ✅ Done | |
| `app/Helpers/Helper.php` + autoload | ✅ Done | `setting()`, `isActive()`, etc. |
| `app/Services/FileService.php` | ✅ Done | |
| `app/Services/SeoAuditService.php` | ✅ Done | PSI API integration |
| Backend layout `components/layouts/backend.blade.php` | ✅ Done | Dark/light theme, Alpine sidebar |
| Backend components: sidebar, topbar, breadcrumb, stat-card, badge, page-header | ✅ Done | All CSS-variable-safe, no hardcoded colors |
| Livewire `NotificationBell` component | ✅ Done | Unread count badge |
| `routes/admin.php` registered in `bootstrap/app.php` | ✅ Done | |
| Migrations run | ✅ Done | `settings`, `system_notifications`, `contact_inquiries`, Spatie permission/activitylog/media tables |
| Seeders | ✅ Done | `RolesAndPermissionsSeeder`, `SuperAdminSeeder`, `SettingsSeeder` |
| Brand assets + white favicon variants | ✅ Done | `favicon-white-32.png`, `favicon-apple-white.png`, `logo-icon-white-256.png` |
| Favicon applied to both frontend + backend layouts | ✅ Done | White-center version on both |

### ✅ PHASE 2 — Auth, Roles & Users — COMPLETE

| Item | Status | Notes |
|---|---|---|
| Breeze auth pages (login, forgot-password, reset-password) | ✅ Done | CRM-themed, dark/light safe |
| Spatie permission middleware registered | ✅ Done | `bootstrap/app.php` |
| `AppServiceProvider` Gate::before for super-admin | ✅ Done | |
| `RolesAndPermissionsSeeder` | ✅ Done | All roles + permission strings seeded for ALL future modules |
| `SuperAdminSeeder` | ✅ Done | Super-admin user created |
| Profile page (`/profile`) | ✅ Done | CRM-themed, name/email + password change |
| `UserController` + Users CRUD | ✅ Done | Create/edit/delete with role assignment; super-admin hidden & protected |
| `UsersTable` Livewire component | ✅ Done | Search, role filter, pagination, live polling |
| `RoleController` + Role permission matrix UI | ✅ Done | Group-level toggle, per-permission checkboxes, permission cache cleared on update |
| Route-level `->middleware('can:xxx')` | ✅ Done | All user + role routes permission-gated |
| Security validations | ✅ Done | `not_in:super-admin` on role assignment; `not_in:super-admin,admin` on role creation; super-admin undeletable |
| Theme-aware color rule | ✅ Done | CSS vars enforced everywhere; `--crm-input-border` added; rule documented in Section 43-D |

### ✅ PHASE 8 — Public Website — COMPLETE (UI Polish Ongoing)

| Item | Status | Notes |
|---|---|---|
| Frontend layout (nav + footer + WhatsApp bubble) | ✅ Done | |
| Home page — hero, services, portfolio, testimonials, CTA | ✅ Done | |
| About page | ✅ Done | |
| Services page | ✅ Done | |
| Portfolio page | ✅ Done | |
| Contact page + ContactSubmitController + ContactInquiry model | ✅ Done | |
| FAQs page | ✅ Done | |
| Free Audit tool (PSI API) | ✅ Done | SeoAuditService |
| Free Consultation page | ✅ Done | |
| Privacy Policy + Refund Policy pages | ✅ Done | |
| Blog placeholder | ✅ Done | Until Phase 7B |
| SCSS frontend partials | ✅ Done | |

### ✅ PHASE 3 — Dashboard + CRM Core Modules — COMPLETE

| Module | Route | Status |
|---|---|---|
| Dashboard | `admin/dashboard` | ✅ Done — live stats, project due widget, renewal alerts, quick actions |
| Projects | `admin/projects` | ✅ Done — CRUD, Livewire table, show page with tabs (overview/docs/notes), project code auto-gen |
| Budget | `admin/budget` | ✅ Done — expenses + income tabs, P&L summary strip, monthly filter, type filter |
| Investments | `admin/investments` | ✅ Done — CRUD, Livewire table, show page with inline expense management |
| Hosting Clients | `admin/hosting` | ✅ Done — CRUD, renewal status badges, days-until-renewal computed, renewal alerts on dashboard |

### 🔲 BACKEND CRM MODULES — PHASE 4+ PENDING

| Module | Route | Status |
|---|---|---|
| API Keys Vault | `admin/api-keys` | 🔲 Placeholder |
| Credentials Vault | `admin/credentials` | 🔲 Placeholder |
| Personal Notes | `admin/notes` | 🔲 Placeholder |
| Contact Messages | `admin/contacts` | 🔲 Placeholder |
| Proposals | `admin/proposals` | 🔲 Placeholder |
| Portfolio (CRM) | `admin/portfolio` | 🔲 Placeholder |
| Blog (CRM) | `admin/blog` | 🔲 Placeholder |
| Activity Logs | `admin/activity` | 🔲 Placeholder |

### 📋 WHAT TO BUILD NEXT (In Order)

1. **Phase 4** — API Keys Vault + Credentials Vault + Personal Notes + Activity Logs
2. **Phase 5** — Contact Messages (backend) + Settings (SMTP + Email templates)
3. **Phase 6** — Proposals builder (PDF export)
4. **Phase 5** — Contact Messages (backend) + Settings (SMTP + Email templates)
5. **Phase 6** — Proposals builder (PDF export)
6. **Phase 7A** — SEO Dashboard
7. **Phase 7B** — Blog CMS + Portfolio CMS (make frontend dynamic)
8. **Phase 9+** — Products, Leads, Invoices (Phase 2)

---

## 1. PROJECT VISION & OBJECTIVES

### What We Are Building
A **single Laravel monolith** for Redis Solution Pvt. Ltd. with three distinct layers:
- **Public-facing website** (Laravel Blade SSR + Next.js-level animations) — stunning, conversion-focused, world-class IT company presence. Blade renders fully-formed HTML → perfect SEO from day one.
- **Private CRM backend panel** (Laravel Blade + Livewire + Alpine.js) — comprehensive internal tool with Blade components & partials replacing all spreadsheet workflows
- **Admin content management** — fully dynamic website (blog, pages, portfolio, FAQs all managed from CRM)

### Why Laravel (Not Node.js + React)
| Concern | Laravel Answer |
|---|---|
| Frontend in Blade? | ✅ Blade components, partials, layouts — Laravel's native template engine |
| Roles & Permissions | ✅ Spatie Laravel Permission — industry gold standard |
| Auth | ✅ Laravel Auth + Sanctum — battle-tested, zero config |
| SEO (server-rendered HTML) | ✅ Blade is SSR by default — Google crawls full HTML |
| Blog/CMS | ✅ Eloquent models, Blade views — built for this |
| One codebase | ✅ Public website + CRM + API all in one Laravel app |
| Hosting | ✅ PHP shared hosting possible, or VPS — very common in PK market |

### Core Problems Being Solved
| Current Pain | CRM Solution |
|---|---|
| Excel spreadsheet for finances | Real-time budget module with P&L dashboard |
| Manual project tracking | Full project lifecycle management with documents & messages |
| API keys in plain text files | Encrypted, categorized vault |
| No credential management | AES-256 encrypted credentials store |
| Hosting renewals forgotten | Hosting client tracker with renewal alerts |
| No crypto portfolio view | Live crypto investment tracker |
| No audit trail | Categorized activity log system |
| No SEO management | Integrated SEO state manager for all managed sites |

### Design Philosophy
- **CRM Panel**: Clean, data-dense, professional dark/light theme. Zero unnecessary animations. Fast.
- **Public Website**: NOT a copy of the current Redis Solution website. A completely original, world-beating design. Reference level: Cuberto, Fantasy Interactive, Locomotive, Resn. A Pakistani IT company client should land on this website, see the work, and immediately feel: *"These people are on another level."* Every pixel intentional. Animations purposeful, not decorative. Visually must outrank every IT company in Pakistan, South Asia, and compete with global agency standards.

---

## 2. TECH STACK — FULL JUSTIFICATION

> ⚠️ ACTUAL INSTALLED VERSIONS (verified from composer.json + package.json):
> - Laravel: **13.7** (not 11 — plan previously had wrong version)
> - PHP: **8.5** (system has 8.5.3 installed — not 8.3)
> - Tailwind CSS: **4.0** (not 3 — breaking changes, no tailwind.config.js needed)
> - Vite: **8.0**

### Core Framework — Laravel 13
```
Framework:       Laravel 13 (PHP 8.5)
Template Engine: Blade (components, partials, layouts, slots)
Reactivity:      Livewire 3 — ALL list tables + forms + dashboard widgets + kanban + notification bell
JS Sprinkles:    Alpine.js 3 — sidebar, modals, dropdowns, dark mode toggle
Styling:         Tailwind CSS 4 + SCSS/SASS (via npm sass package, Vite handles it)
Build Tool:      Vite 8.0 (HMR for CSS/JS, processes SCSS natively)
```

### Frontend — Public Website (Blade SSR)
```
Rendered by:    Laravel Blade (server-side rendered HTML — perfect SEO)
Animations:     GSAP 3 + ScrollTrigger (hero, scroll effects, counters)
Interactions:   Alpine.js (mobile menu, tabs, accordions, FAQs)
                Custom vanilla JS (custom cursor, magnetic buttons, marquee)
3D Tilt:        VanillaTilt.js (portfolio cards)
Icons:          Font Awesome 6 Free
Forms:          Laravel built-in form handling + validation
SEO:            artesaos/seotools — meta tags, OG, Twitter cards, JSON-LD per page
Sitemap:        spatie/laravel-sitemap (auto-generated, cached)
Fonts:          Clash Display (local), Syne (Google Fonts), DM Sans (local)
Styling:        SCSS → compiled via Vite (public.scss entry point)
```

### Frontend — CRM Panel (Blade + Livewire + Alpine.js)
```
Templates:      Blade components (<x-sidebar>, <x-stat-card>, <x-breadcrumb>)
                Blade partials (@include for headers, footers, flash messages)
                Blade layouts (@extends, @section, @yield)

LIST TABLES:    Livewire 3 — all CRM listing pages
                - Real-time search as-you-type (wire:model.live)
                - Sort, filter, paginate — pure PHP, no JS config
                - Pure Tailwind styling — zero CSS conflicts
                - Delete/confirm via Alpine.js + SweetAlert2 (no jQuery needed)
                - One Livewire component per module table

FORMS/WIDGETS:  Livewire 3 also for:
                - Dashboard stat cards (auto-refresh every 60s)
                - Notification bell (polling, unread count badge)
                - Kanban board (project status drag-drop)
                - Settings forms (auto-save, no page reload)
                - Proposal builder (dynamic line items, live total calc)

UI State:       Alpine.js for:
                - Sidebar collapse/expand
                - Modal open/close (non-AJAX modals)
                - Dropdown menus, tab switching
                - Vault reveal button (30-second auto-hide timer)
                - Dark/light mode toggle

AJAX Modals:    common.js [data-act=ajax-modal] pattern
                - Click a button → fetch modal HTML from server → show Bootstrap modal
                - No extra package needed

AJAX Forms:     common.js [data-form=ajax-form] pattern
                - Submit form → Axios POST → toast success/error → DataTable reload

Charts:         ApexCharts (PHP data → JSON → JS chart)
Rich Text:      Quill.js 2 (blog posts, email templates, notes, case studies — no jQuery, no API key)
Date Picker:    Flatpickr (lightweight, no dependency)
Icons:          Heroicons (Blade component <x-heroicon-o-*>)
Drag & Drop:    SortableJS (Kanban cards)
Styling:        SCSS → compiled via Vite (app.scss entry point)
```

### JavaScript Dependencies (CRM-specific)
```
SweetAlert2      — Beautiful confirm/alert dialogs (window.swal)
Axios            — HTTP requests (window.axios — AJAX actions, vault reveal, etc.)
Alpine.js        — UI state (sidebar, modals, dropdowns, vault timer)
                   Also handles delete confirmations via SweetAlert2 + Axios
                   No jQuery needed — Alpine replaces all jQuery patterns
```

> ⚠️ NOTE: common.js currently uses jQuery + DataTables patterns.
> It will be refactored at the END of Phase 1 to use Alpine.js + Axios patterns
> aligned with Livewire tables and the actual DB schema.

### Backend — Laravel Application
```
Auth:           Laravel Auth (built-in) + Laravel Breeze (Blade stack starter)
                Session-based auth (cookies) — not JWT
Roles/Perms:    spatie/laravel-permission
Encryption:     Laravel's encrypt()/decrypt() (AES-256-CBC via APP_KEY)
                Vault: separate VAULT_KEY in .env via openssl_encrypt
ORM:            Eloquent
Database:       MySQL 8.0
Cache/Queue:    Redis via predis/predis
Mail:           Laravel Mail + Mailable + Queue
Storage:        Laravel Storage + spatie/laravel-media-library
SEO:            artesaos/seotools + spatie/laravel-sitemap
Activity Log:   spatie/laravel-activitylog
Excel Export:   maatwebsite/excel
Image:          intervention/image 3.x (GD driver, already used in helper.php)
Tables:         Livewire 3 components (search, sort, filter, paginate — pure PHP)
PDF:            barryvdh/laravel-dompdf (proposals)
reCAPTCHA:      anhskohbo/no-captcha
Validation:     Laravel Form Request classes
Security:       CSRF (built-in), Blade auto-escaping, Eloquent parameterized queries
```

### DevOps & Infrastructure
```
Version Control: Git + GitHub
Web Server:      Nginx + PHP-FPM
Process/Queue:   Supervisor + Laravel Queue Worker
SSL:             Let's Encrypt (Certbot)
Scheduler:       Laravel Scheduler (cron every minute)
Monitoring:      Laravel Telescope (dev) + Sentry (prod)
Cache:           Redis (sessions + cache + queues)
```

### Package Summary (composer.json — to install)
```json
"require": {
    "php": "^8.5",
    "laravel/framework": "^13.0",
    "laravel/breeze": "^2.0",
    "spatie/laravel-permission": "^6.0",
    "spatie/laravel-activitylog": "^4.0",
    "spatie/laravel-sitemap": "^7.0",
    "spatie/laravel-media-library": "^11.0",
    "artesaos/seotools": "^1.3",
    "livewire/livewire": "^3.0",
    "maatwebsite/excel": "^3.1",
    "intervention/image": "^3.0",
    "predis/predis": "^2.0",
    "barryvdh/laravel-dompdf": "^3.0",
    "anhskohbo/no-captcha": "^3.0"
}
```

### NPM Packages (package.json — to install)
```json
"devDependencies": {
    "@tailwindcss/vite": "^4.0.0",
    "tailwindcss": "^4.0.0",
    "sass": "^1.77.0",
    "laravel-vite-plugin": "^3.1",
    "vite": "^8.0.0",
    "concurrently": "^9.0.1"
},
"dependencies": {
    "alpinejs": "^3.14",
    "gsap": "^3.12",
    "vanilla-tilt": "^1.8",
    "flatpickr": "^4.6",
    "apexcharts": "^3.50",
    "sortablejs": "^1.15",
    "sweetalert2": "^11.0",
    "axios": "^1.7",
    "quill": "^2.0"
}

// REMOVED: jquery, datatables.net-bs5, datatables.net-buttons-bs5, select2
// Alpine.js replaces all jQuery-based UI patterns
// Livewire handles all table rendering — no DataTables JS needed
// select2 → replaced by Tailwind-styled Alpine.js dropdowns or tom-select if needed
```

---

## 3. SYSTEM ARCHITECTURE OVERVIEW

```
┌────────────────────────────────────────────────────────────────┐
│                    BROWSER (User)                              │
├──────────────────────────┬─────────────────────────────────────┤
│  Visitor (Public)        │  Admin / Staff (CRM)                │
│  redissolution.com       │  redissolution.com/admin            │
│  /blog, /services, etc.  │  /admin/projects, /admin/budget...  │
└──────────────┬───────────┴──────────────────┬──────────────────┘
               │         HTTPS                │
               ▼                              ▼
┌──────────────────────────────────────────────────────────────┐
│              NGINX (reverse proxy + SSL termination)          │
│                   redissolution.com:443                       │
└──────────────────────────┬───────────────────────────────────┘
                           │
                           ▼
┌──────────────────────────────────────────────────────────────┐
│              LARAVEL 11 APPLICATION (PHP-FPM)                 │
│                                                              │
│  ┌─────────────────────────────────────────────────────────┐ │
│  │  ROUTING LAYER (routes/web.php + routes/admin.php)      │ │
│  │  Public routes: GET / | /services | /blog | /contact... │ │
│  │  Admin routes:  GET,POST /admin/* (auth + role guards)  │ │
│  └─────────────────┬───────────────────────────────────────┘ │
│                    │                                          │
│  ┌─────────────────▼───────────────────────────────────────┐ │
│  │  MIDDLEWARE STACK                                        │ │
│  │  web | auth | role:admin | permission:manage-projects... │ │
│  │  (Spatie middleware registered here)                     │ │
│  └─────────────────┬───────────────────────────────────────┘ │
│                    │                                          │
│  ┌─────────────────▼───────────────────────────────────────┐ │
│  │  CONTROLLERS                                             │ │
│  │  App\Http\Controllers\Public\*  (public website)        │ │
│  │  App\Http\Controllers\Admin\*   (CRM panel)             │ │
│  └─────────────────┬───────────────────────────────────────┘ │
│                    │                                          │
│  ┌─────────────────▼───────────────────────────────────────┐ │
│  │  LIVEWIRE COMPONENTS (reactive CRM UI)                  │ │
│  │  App\Livewire\Projects\ProjectsTable                    │ │
│  │  App\Livewire\Budget\BudgetDashboard                    │ │
│  │  App\Livewire\Blog\PostEditor  ... etc                  │ │
│  └─────────────────┬───────────────────────────────────────┘ │
│                    │                                          │
│  ┌─────────────────▼───────────────────────────────────────┐ │
│  │  ELOQUENT ORM (Models + Relationships)                  │ │
│  │  All business logic, relationships, scopes              │ │
│  └─────────────────┬───────────────────────────────────────┘ │
│                    │                                          │
│  ┌─────────────────▼───────────────────────────────────────┐ │
│  │  BLADE VIEW LAYER                                       │ │
│  │  resources/views/frontend/* (website)                     │ │
│  │  resources/views/backend/*  (CRM panel)                   │ │
│  │  resources/views/components/* (shared components)       │ │
│  └─────────────────────────────────────────────────────────┘ │
└──────────────────────────┬───────────────────────────────────┘
                           │
          ┌────────────────┼─────────────────┐
          │                │                 │
          ▼                ▼                 ▼
┌─────────────────┐ ┌──────────────┐ ┌─────────────────┐
│   MySQL 8.0     │ │  Redis       │ │  Storage Disk   │
│  All app data   │ │  Sessions    │ │  /storage/app   │
│  Eloquent ORM   │ │  Cache       │ │  uploads, media │
└─────────────────┘ │  Queues      │ └─────────────────┘
                    └──────────────┘

LARAVEL SCHEDULER (cron every minute):
  → Renewal alert emails (hosting clients)
  → Sitemap refresh (daily)
  → SEO report generation (weekly)

LARAVEL QUEUES (Redis driver):
  → Contact form email dispatch
  → Image processing (resize/optimize on upload)
  → Activity log bulk inserts
```

### URL Structure
```
PUBLIC WEBSITE:
  redissolution.com/                    → Home
  redissolution.com/services            → Services
  redissolution.com/about               → About
  redissolution.com/portfolio           → Portfolio
  redissolution.com/contact             → Contact
  redissolution.com/faqs                → FAQs
  redissolution.com/blog                → Blog listing
  redissolution.com/blog/{slug}         → Blog post
  redissolution.com/products            → Products (Phase 2)
  redissolution.com/products/{slug}     → Product detail (Phase 2)
  redissolution.com/privacy-policy      → Privacy Policy
  redissolution.com/refund-policy       → Refund Policy

CRM PANEL:
  redissolution.com/admin               → Dashboard
  redissolution.com/admin/projects      → Projects
  redissolution.com/admin/blog          → Blog management
  redissolution.com/admin/seo           → SEO dashboard
  redissolution.com/admin/roles         → Roles & Permissions
  ... (all modules under /admin/*)
```

---

## 4. COLOR SYSTEM & BRAND IDENTITY

### ⚠️ CORRECTION NOTE (v2.0)
Previous version incorrectly used navy/cyan blues. The REAL Redis Solution brand is:
- **Black + Orange gradient**. The logo is confirmed: black text + golden-to-deep-orange gradient icon.
- Exact logo colors extracted from visual inspection of downloaded logo assets.
- Logo tagline: **"INNOVATE. CREATE. SUCCEED."**

### Brand Assets Downloaded (assets/brand/)
```
logo-main.png      — 1024×378px primary horizontal logo (black + orange gradient)
logo-white.png     — White version (for dark backgrounds)
logo-original.png  — Full resolution original
logo-square.svg    — SVG square icon version
logo-icon-256.png  — 256×256 icon only
favicon-32.png     — 32px favicon
favicon-192.png    — 192px favicon (PWA)
favicon-apple.png  — 180px Apple Touch Icon
```

### Actual Brand Colors (Verified from CSS + Logo)
```css
/* ── BRAND ORANGE — THE SIGNATURE COLOR ── */
--brand-orange-deep:    #FF6400;   /* Deep vivid orange — from Elementor --e-global-color-secondary */
--brand-orange-golden:  #FFB800;   /* Golden amber — logo gradient top */
--brand-orange-mid:     #FF8C00;   /* Mid orange — logo gradient center */

/* The logo gradient (icon + D in REDIS): */
--gradient-brand:       linear-gradient(180deg, #FFB800 0%, #FF8C00 50%, #FF6400 100%);

/* ── BLACK / NEAR-BLACK ── */
--brand-black:          #100F0D;   /* Logo text color — near-black with warmth */
--color-dark:           #0A0A0A;   /* True dark background for website */
--color-dark-2:         #111111;   /* Card background on dark */
--color-dark-3:         #1A1A1A;   /* Elevated surface */
--color-dark-4:         #222222;   /* Borders on dark */
--color-dark-5:         #2A2A2A;   /* Subtle dividers */

/* ── WEBSITE BG (Dark Theme — Premium Agency Aesthetic) ── */
--bg-primary:           #080808;   /* Near-black — dominant background */
--bg-secondary:         #0F0F0F;   /* Section alternates */
--bg-card:              #141414;   /* Cards */
--bg-elevated:          #1C1C1C;   /* Modals, dropdowns */

/* ── CRM PANEL (separate — can use light or dark) ── */
--crm-bg-light:         #F5F5F5;
--crm-bg-dark:          #0F0F0F;
--crm-sidebar:          #111111;   /* Dark sidebar always */
--crm-card-light:       #FFFFFF;
--crm-card-dark:        #181818;

/* ── ORANGE GLOW (Signature Effect) ── */
/* Used on hover states, hero elements, important CTAs */
--glow-orange:          0 0 40px rgba(255, 100, 0, 0.4);
--glow-orange-strong:   0 0 80px rgba(255, 100, 0, 0.6);
--glow-golden:          0 0 40px rgba(255, 184, 0, 0.3);

/* ── GLASSMORPHISM (On dark background) ── */
--glass-bg:             rgba(255, 255, 255, 0.04);
--glass-bg-orange:      rgba(255, 100, 0, 0.06);
--glass-border:         rgba(255, 255, 255, 0.08);
--glass-border-orange:  rgba(255, 140, 0, 0.25);
--glass-backdrop:       blur(20px) saturate(180%);

/* ── TEXT ── */
--text-primary:         #FFFFFF;
--text-secondary:       #A0A0A0;
--text-muted:           #606060;
--text-orange:          #FF8C00;

/* ── STATUS COLORS ── */
--color-success:        #22C55E;
--color-warning:        #FFB800;   /* Maps to brand golden */
--color-danger:         #EF4444;
--color-info:           #3B82F6;

/* ── KEY GRADIENTS ── */
--gradient-hero-bg:     radial-gradient(ellipse 80% 60% at 50% -10%, rgba(255,100,0,0.15) 0%, transparent 70%);
--gradient-orange-text: linear-gradient(135deg, #FFB800 0%, #FF6400 100%);
--gradient-cta-btn:     linear-gradient(135deg, #FF8C00 0%, #FF6400 100%);
--gradient-card-border: linear-gradient(135deg, #FF8C00, #FF6400, transparent);
```

---

### ⚡ REVOLUTIONARY DESIGN DIRECTION (Not a copy of current Redis site)

The current Redis Solution website is a standard WordPress/Elementor site. The NEW website must be on a completely different level — competing with Cuberto, Locomotive, Resn, Fantasy Interactive globally.

**Design Language: "Dark Fire Agency"**
- **Dominant black** (#080808) background — creates a premium, luxury tech feel
- **Orange as the ONLY accent** — every highlight, every CTA, every hover effect burns orange
- The contrast of pure black + vivid orange is: memorable, bold, energetic — exactly "INNOVATE. CREATE. SUCCEED."
- **Intentional white space** — dark space is used generously, not filled
- **Typography-first layout** — massive headlines, tight tracking, large type does the visual work
- **Micro-interactions everywhere** — cursors, magnetic buttons, hover reveals
- **Scroll storytelling** — the page reveals itself as a narrative while scrolling

**Websites at this level (reference standard):**
- https://cuberto.com (dark + accent, magnetic cursor, scroll effects)
- https://locomotive.ca (scroll-driven transitions)
- https://resn.co.nz (immersive, every section is a moment)
- https://linear.app (extreme clarity + motion)

**What makes this BEAT every Pakistani/South Asian IT company:**
1. Custom animated cursor (orange dot that morphs on hover)
2. Magnetic button effect (buttons pull toward cursor on hover)
3. Text scramble/glitch reveals for headings
4. GSAP-powered scroll-driven animations
5. Portfolio section with smooth horizontal scroll on desktop
6. 3D card tilt on hover (portfolio items)
7. Noise texture overlay (adds depth/film grain to the flat black)
8. Number counters with physics easing (not linear)
9. Split-word text animations (each word enters from different direction)
10. Mouse-following orange spotlight on dark hero

---

### Typography System
```css
/* PUBLIC WEBSITE */
--font-display: 'Clash Display', sans-serif;
/* — Ultra-modern variable font, high contrast thick/thin
     Clash Display: FREE from fontshare.com, design-world-standard
     Used for: Hero H1, section numbers, impact statements */

--font-heading: 'Syne', sans-serif;
/* — Geometric, confident, contemporary
     Used for: H2, H3, card titles */

--font-body:    'DM Sans', sans-serif;
/* — Redis Solution's actual brand font (they host it)
     Used for: Body copy, descriptions, UI labels */

/* CRM PANEL */
--font-ui:      'DM Sans', sans-serif;       /* Familiar to brand */
--font-mono:    'JetBrains Mono', monospace; /* API keys, credentials, code */

/* Scale */
--text-xs:    0.75rem;    /* 12px — labels, captions */
--text-sm:    0.875rem;   /* 14px — table data, metadata */
--text-base:  1rem;       /* 16px — body */
--text-lg:    1.125rem;   /* 18px — lead text */
--text-xl:    1.25rem;    /* 20px — subheadings */
--text-2xl:   1.5rem;     /* 24px — card titles */
--text-3xl:   1.875rem;   /* 30px — section subheads */
--text-4xl:   2.25rem;    /* 36px — section titles */
--text-5xl:   3rem;       /* 48px — large headings */
--text-6xl:   3.75rem;    /* 60px — page headings */
--text-7xl:   4.5rem;     /* 72px — hero headline desktop */
--text-8xl:   6rem;       /* 96px — super hero (mobile: drops to 4xl) */
--text-9xl:   8rem;       /* 128px — decorative large numbers */
```

---

## 5. DATABASE ARCHITECTURE — COMPLETE SCHEMA

### Entity Relationship Overview
```
users (+ spatie: roles, permissions, model_has_roles, model_has_permissions, role_has_permissions)
  │
  ├── projects ──── project_documents
  │       └──────── project_messages
  │
  ├── investments ── investment_expenses
  │
  ├── budget_expenses
  ├── budget_incomes
  │
  ├── hosting_clients
  ├── api_keys
  ├── credentials
  ├── demo_projects
  ├── crypto_investments
  ├── personal_notes
  │
  ├── blog_categories
  ├── blog_posts ──── blog_tags (pivot: blog_post_tag)
  │
  ├── products (Phase 2)
  ├── portfolio_items
  ├── testimonials
  ├── faqs
  ├── page_seo_meta
  │
  ├── website_seo_states
  └── activity_log (spatie/laravel-activitylog)
```

### Laravel Migration Files (database/migrations/)

```php
// ══════════════════════════════════════════════
// USERS TABLE (extends Laravel default)
// ══════════════════════════════════════════════
Schema::create('users', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('email')->unique();
    $table->string('password');
    $table->string('avatar')->nullable();
    $table->boolean('is_active')->default(true);
    $table->timestamp('last_login_at')->nullable();
    $table->rememberToken();
    $table->timestamps();
    // Roles via Spatie: model_has_roles pivot table (auto-created by Spatie)
});

// ══════════════════════════════════════════════
// SPATIE PERMISSION TABLES (auto via vendor:publish)
// ══════════════════════════════════════════════
// roles: id, name, guard_name, created_at, updated_at
// permissions: id, name, guard_name, created_at, updated_at
// model_has_roles: role_id, model_type, model_id
// model_has_permissions: permission_id, model_type, model_id
// role_has_permissions: permission_id, role_id

// ══════════════════════════════════════════════
// PROJECTS
// ══════════════════════════════════════════════
Schema::create('projects', function (Blueprint $table) {
    $table->id();
    $table->string('project_code')->unique(); // RS-2026-001
    $table->string('client_name');
    $table->string('title');
    $table->text('description')->nullable();
    $table->longText('requirements_note')->nullable();
    $table->decimal('cost', 12, 2)->nullable();
    $table->string('currency', 10)->default('PKR');
    $table->date('deadline')->nullable();
    $table->string('developer_name')->nullable();
    $table->enum('status', ['pending','in_progress','in_review','testing','completed','on_hold','cancelled'])->default('pending');
    $table->string('live_url')->nullable();
    $table->string('testing_domain')->nullable();
    $table->string('requirements_doc')->nullable(); // storage path
    $table->foreignId('created_by')->constrained('users');
    $table->timestamps();
    $table->softDeletes();
});

Schema::create('project_documents', function (Blueprint $table) {
    $table->id();
    $table->foreignId('project_id')->constrained()->cascadeOnDelete();
    $table->string('file_path');
    $table->string('file_name');
    $table->unsignedInteger('file_size'); // bytes
    $table->string('mime_type');
    $table->string('note')->nullable();
    $table->timestamps();
});

Schema::create('project_messages', function (Blueprint $table) {
    $table->id();
    $table->foreignId('project_id')->constrained()->cascadeOnDelete();
    $table->string('sender'); // 'us' or client name
    $table->longText('message');
    $table->json('attachments')->nullable();
    $table->timestamp('sent_at')->useCurrent();
    $table->timestamps();
});

// ══════════════════════════════════════════════
// INVESTMENTS
// ══════════════════════════════════════════════
Schema::create('investments', function (Blueprint $table) {
    $table->id();
    $table->string('person_name');
    $table->decimal('amount', 12, 2)->nullable();
    $table->string('currency', 10)->default('PKR');
    $table->text('idea_details');
    $table->date('start_date');
    $table->date('expected_end_date')->nullable();
    $table->enum('status', ['active','completed','paused','cancelled'])->default('active');
    $table->timestamps();
    $table->softDeletes();
});

Schema::create('investment_expenses', function (Blueprint $table) {
    $table->id();
    $table->foreignId('investment_id')->constrained()->cascadeOnDelete();
    $table->text('details');
    $table->decimal('amount', 12, 2);
    $table->string('spend_purpose');
    $table->date('date');
    $table->text('output')->nullable();
    $table->string('receipt_path')->nullable();
    $table->timestamps();
});

// ══════════════════════════════════════════════
// BUDGET
// ══════════════════════════════════════════════
Schema::create('budget_expenses', function (Blueprint $table) {
    $table->id();
    $table->string('reason');
    $table->enum('type', ['personal','project','assets','grocery','utilities','office','marketing','other']);
    $table->decimal('amount', 12, 2);
    $table->string('currency', 10)->default('PKR');
    $table->dateTime('date')->useCurrent();
    $table->string('note')->nullable();
    $table->string('receipt_path')->nullable();
    $table->timestamps();
    $table->softDeletes();
});

Schema::create('budget_incomes', function (Blueprint $table) {
    $table->id();
    $table->string('source');
    $table->decimal('amount', 12, 2);
    $table->string('currency', 10)->default('PKR');
    $table->dateTime('date')->useCurrent();
    $table->string('note')->nullable();
    $table->string('proof_path')->nullable();
    $table->timestamps();
    $table->softDeletes();
});

// ══════════════════════════════════════════════
// HOSTING CLIENTS
// ══════════════════════════════════════════════
Schema::create('hosting_clients', function (Blueprint $table) {
    $table->id();
    $table->string('client_name');
    $table->string('domain_name');
    $table->date('starting_date');
    $table->enum('renew_duration', ['monthly','quarterly','semi_annually','yearly','two_years']);
    $table->decimal('amount', 10, 2);
    $table->string('currency', 10)->default('PKR');
    $table->enum('server_usage', ['hosting_only','hosting_and_domain','domain_only','vps','dedicated']);
    $table->boolean('auto_renew')->default(false);
    $table->string('hosting_provider')->nullable();
    $table->string('server_ip')->nullable();
    $table->text('notes')->nullable();
    $table->boolean('is_active')->default(true);
    $table->timestamps();
    $table->softDeletes();
});

// ══════════════════════════════════════════════
// API KEYS VAULT
// ══════════════════════════════════════════════
Schema::create('api_keys', function (Blueprint $table) {
    $table->id();
    $table->string('provider_name');
    $table->string('key_label');
    $table->text('key_value');  // Laravel encrypt() — AES-256 via APP_KEY
    $table->enum('key_type', ['api_key','secret_key','access_token','refresh_token','webhook_secret','private_key','public_key','other']);
    $table->string('environment')->default('production');
    $table->date('expires_at')->nullable();
    $table->timestamp('last_used_at')->nullable();
    $table->text('notes')->nullable();
    $table->boolean('is_active')->default(true);
    $table->timestamps();
    $table->softDeletes();
});

// ══════════════════════════════════════════════
// CREDENTIALS VAULT
// ══════════════════════════════════════════════
Schema::create('credentials', function (Blueprint $table) {
    $table->id();
    $table->string('system_name');
    $table->string('url')->nullable();
    $table->string('username')->nullable();
    $table->string('email')->nullable();
    $table->text('password');    // Laravel encrypt()
    $table->string('ip_address')->nullable();
    $table->string('port')->nullable();
    $table->text('command')->nullable();
    $table->enum('owner_type', ['personal','client']);
    $table->string('owner_name')->nullable();
    $table->enum('cred_type', ['web_panel','ssh','ftp','sftp','database','email','social_media','payment_gateway','cloud_console','vpn','other']);
    $table->text('notes')->nullable();
    $table->boolean('is_active')->default(true);
    $table->timestamps();
    $table->softDeletes();
});

// ══════════════════════════════════════════════
// DEMO PROJECTS
// ══════════════════════════════════════════════
Schema::create('demo_projects', function (Blueprint $table) {
    $table->id();
    $table->string('client_name')->nullable();
    $table->string('site_name');
    $table->string('url');
    $table->text('description')->nullable();
    $table->string('tech_stack')->nullable(); // comma-separated
    $table->string('thumbnail_path')->nullable();
    $table->boolean('is_public')->default(true);
    $table->timestamps();
    $table->softDeletes();
});

// ══════════════════════════════════════════════
// CRYPTO INVESTMENTS
// ══════════════════════════════════════════════
Schema::create('crypto_investments', function (Blueprint $table) {
    $table->id();
    $table->date('date');
    $table->decimal('amount_invested', 16, 4);
    $table->string('currency', 10)->default('USD');
    $table->string('coin');
    $table->string('coin_symbol', 20);
    $table->decimal('quantity', 20, 8)->nullable();
    $table->string('wallet_address')->nullable();
    $table->string('wallet_label')->nullable();
    $table->string('exchange')->nullable();
    $table->string('tx_hash')->nullable();
    $table->text('notes')->nullable();
    $table->timestamps();
    $table->softDeletes();
});

// ══════════════════════════════════════════════
// PERSONAL NOTES
// ══════════════════════════════════════════════
Schema::create('personal_notes', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->cascadeOnDelete();
    $table->string('title')->nullable();
    $table->longText('content'); // HTML from Quill.js
    $table->boolean('is_pinned')->default(false);
    $table->string('color', 7)->nullable(); // hex
    $table->json('tags')->nullable();
    $table->timestamps();
    $table->softDeletes();
    $table->index('user_id'); // fast per-user queries
});

// ══════════════════════════════════════════════
// WEBSITE SEO STATES (for managed client sites)
// ══════════════════════════════════════════════
Schema::create('website_seo_states', function (Blueprint $table) {
    $table->id();
    $table->string('site_name');
    $table->string('site_url');
    $table->string('client_name')->nullable();
    $table->string('meta_title')->nullable();
    $table->text('meta_description')->nullable();
    $table->text('keywords')->nullable();
    $table->integer('google_ranking')->nullable();
    $table->boolean('google_indexed')->default(false);
    $table->date('last_audit_date')->nullable();
    $table->unsignedTinyInteger('pagespeed_score')->nullable();
    $table->unsignedTinyInteger('mobile_score')->nullable();
    $table->unsignedTinyInteger('seo_score')->nullable();
    $table->unsignedInteger('backlinks_count')->nullable();
    $table->unsignedInteger('domain_authority')->nullable();
    $table->string('sitemap_url')->nullable();
    $table->boolean('robots_txt_ok')->default(false);
    $table->boolean('ssl_active')->default(true);
    $table->timestamp('last_updated_content')->nullable();
    $table->text('notes')->nullable();
    $table->json('issues')->nullable();      // array of issue strings
    $table->json('improvements')->nullable(); // array of actions taken
    $table->timestamps();
});

// ══════════════════════════════════════════════
// PAGE SEO META (for own public website pages)
// ══════════════════════════════════════════════
Schema::create('page_seo_meta', function (Blueprint $table) {
    $table->id();
    $table->string('page_key')->unique(); // 'home','services','about','contact','blog','portfolio','products'
    $table->string('page_name');          // human readable
    $table->string('meta_title')->nullable();
    $table->text('meta_description')->nullable();
    $table->text('keywords')->nullable();
    $table->string('og_title')->nullable();
    $table->text('og_description')->nullable();
    $table->string('og_image')->nullable(); // path
    $table->string('canonical_url')->nullable();
    $table->json('schema_markup')->nullable(); // JSON-LD schema
    $table->boolean('no_index')->default(false);
    $table->timestamps();
});

// ══════════════════════════════════════════════
// BLOG SYSTEM
// ══════════════════════════════════════════════
Schema::create('blog_categories', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('slug')->unique();
    $table->text('description')->nullable();
    $table->string('meta_title')->nullable();
    $table->text('meta_description')->nullable();
    $table->timestamps();
});

Schema::create('blog_tags', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('slug')->unique();
    $table->timestamps();
});

Schema::create('blog_posts', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained();     // author
    $table->foreignId('category_id')->nullable()->constrained('blog_categories')->nullOnDelete();
    $table->string('title');
    $table->string('slug')->unique();
    $table->text('excerpt')->nullable();             // short summary
    $table->longText('content');                     // HTML (Quill.js)
    $table->string('featured_image')->nullable();    // storage path
    $table->string('featured_image_alt')->nullable();
    $table->enum('status', ['draft','published','scheduled'])->default('draft');
    $table->timestamp('published_at')->nullable();
    $table->timestamp('scheduled_at')->nullable();
    // SEO fields per post
    $table->string('meta_title')->nullable();
    $table->text('meta_description')->nullable();
    $table->string('og_image')->nullable();
    $table->string('canonical_url')->nullable();
    $table->boolean('no_index')->default(false);
    $table->json('schema_markup')->nullable();       // JSON-LD Article schema
    // Stats
    $table->unsignedInteger('views')->default(0);
    $table->timestamps();
    $table->softDeletes();

    $table->index('slug');
    $table->index('status');
    $table->index('published_at');
});

Schema::create('blog_post_tag', function (Blueprint $table) {
    $table->foreignId('blog_post_id')->constrained()->cascadeOnDelete();
    $table->foreignId('blog_tag_id')->constrained()->cascadeOnDelete();
    $table->primary(['blog_post_id', 'blog_tag_id']);
});

// ══════════════════════════════════════════════
// PORTFOLIO ITEMS (managed from CRM, shown on website)
// ══════════════════════════════════════════════
Schema::create('portfolio_items', function (Blueprint $table) {
    $table->id();
    $table->string('title');
    $table->string('slug')->unique();
    $table->string('client_name')->nullable();
    $table->text('description')->nullable();
    $table->longText('case_study')->nullable();      // full case study HTML
    $table->enum('category', ['web','mobile','crm','ai','ecommerce','other']);
    $table->string('thumbnail')->nullable();          // storage path
    $table->json('gallery')->nullable();              // array of image paths
    $table->string('live_url')->nullable();
    $table->json('tech_stack')->nullable();           // array of tech names
    $table->json('results')->nullable();              // ["250% more traffic", etc.]
    $table->boolean('is_featured')->default(false);
    $table->boolean('is_published')->default(true);
    $table->integer('sort_order')->default(0);
    $table->timestamps();
    $table->softDeletes();
});

// ══════════════════════════════════════════════
// TESTIMONIALS (managed from CRM, shown on website)
// ══════════════════════════════════════════════
Schema::create('testimonials', function (Blueprint $table) {
    $table->id();
    $table->string('client_name');
    $table->string('client_title')->nullable();      // "CEO, Agnatech"
    $table->string('company')->nullable();
    $table->string('avatar')->nullable();
    $table->text('quote');
    $table->unsignedTinyInteger('rating')->default(5); // 1-5
    $table->boolean('is_featured')->default(false);
    $table->boolean('is_published')->default(true);
    $table->integer('sort_order')->default(0);
    $table->timestamps();
});

// ══════════════════════════════════════════════
// FAQs (managed from CRM, shown on website)
// ══════════════════════════════════════════════
Schema::create('faqs', function (Blueprint $table) {
    $table->id();
    $table->string('question');
    $table->text('answer');
    $table->string('category')->nullable();  // 'general','technical','billing','support'
    $table->integer('sort_order')->default(0);
    $table->boolean('is_published')->default(true);
    $table->timestamps();
});

// ══════════════════════════════════════════════
// CONTACT MESSAGES (from public contact form)
// ══════════════════════════════════════════════
Schema::create('contact_messages', function (Blueprint $table) {
    $table->id();
    $table->string('full_name');
    $table->string('email');
    $table->string('phone')->nullable();
    $table->string('company')->nullable();
    $table->string('service_interest')->nullable();
    $table->string('budget_range')->nullable();
    $table->text('message');
    $table->enum('status', ['new','read','replied','archived'])->default('new');
    $table->text('admin_notes')->nullable();
    $table->timestamp('read_at')->nullable();
    $table->timestamps();
});

// ══════════════════════════════════════════════
// PRODUCTS (Phase 2 — Redis Solution own products)
// ══════════════════════════════════════════════
Schema::create('products', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('slug')->unique();
    $table->text('tagline')->nullable();              // short pitch
    $table->longText('description')->nullable();       // full HTML description
    $table->string('logo')->nullable();                // product logo/icon
    $table->json('screenshots')->nullable();           // array of image paths
    $table->string('product_url')->nullable();         // live URL or landing
    $table->string('demo_url')->nullable();
    $table->enum('type', ['saas','tool','template','script','mobile_app','other']);
    $table->json('features')->nullable();              // array of feature strings
    $table->json('tech_stack')->nullable();
    $table->decimal('price', 10, 2)->nullable();       // null = contact for price
    $table->string('pricing_label')->nullable();       // "Starting at PKR 50,000"
    $table->boolean('is_featured')->default(false);
    $table->boolean('is_published')->default(true);
    $table->integer('sort_order')->default(0);
    // SEO per product page
    $table->string('meta_title')->nullable();
    $table->text('meta_description')->nullable();
    $table->string('og_image')->nullable();
    $table->timestamps();
    $table->softDeletes();
});

// ══════════════════════════════════════════════
// ACTIVITY LOG (spatie/laravel-activitylog handles this)
// ══════════════════════════════════════════════
// Table: activity_log (auto-created by Spatie)
// Fields: log_name, description, subject_type, subject_id,
//         causer_type, causer_id, properties (JSON: old/new values),
//         created_at
// Usage: activity()->causedBy($user)->performedOn($model)->log('created')
//        Or model uses HasActivity trait for auto-logging
```

---

## 6. AUTHENTICATION & AUTHORIZATION

### Authentication — Laravel Breeze (Blade Stack) + Custom Styling

Laravel Breeze gives the scaffolding (login, register, password reset views + controllers). We fully restyle them to match the dark CRM theme. Session-based auth — no JWT needed for web app.

```
LOGIN FLOW:
  POST /admin/login
     ├── Laravel Auth::attempt(['email', 'password', 'is_active' => true])
     ├── Record last_login_at
     ├── Regenerate session ID (anti session-fixation)
     ├── Redirect to /admin/dashboard
     └── spatie/laravel-activitylog: logs 'logged in'

LOGOUT:
  POST /admin/logout
     ├── Auth::logout()
     ├── Session invalidate + regenerate token
     └── Redirect to /admin/login

PASSWORD RESET:
  Standard Laravel password reset via email (Mailable + signed URL)

REMEMBER ME:
  Laravel built-in remember_token cookie (90 days)
```

---

### Roles & Permissions — Spatie Laravel Permission

**This is the heart of the access control system.**

```php
// Spatie package creates these tables automatically:
// roles, permissions, model_has_roles, model_has_permissions, role_has_permissions

// User model uses the trait:
use HasRoles; // from Spatie

// Check permission in controller:
$user->can('manage-projects')
$user->hasRole('admin')
$user->hasPermissionTo('view-budget')

// Check in Blade view:
@can('manage-credentials') ... @endcan
@role('super-admin') ... @endrole

// Middleware in routes:
Route::middleware(['auth', 'role:admin|super-admin'])->group(...)
Route::middleware(['auth', 'permission:manage-blog'])->group(...)
```

### Default Roles & Permissions (Seeded)

**ROLE: super-admin** *(You — full access, bypass all permission checks)*
```
Laravel convention: give 'super-admin' role a gate that passes everything.
No need to assign individual permissions — they have everything.
```

**ROLE: admin** *(Full operational access, cannot manage roles/users)*
```
Permissions:
  projects.view, projects.create, projects.edit, projects.delete
  investments.view, investments.create, investments.edit, investments.delete
  budget.view, budget.create, budget.edit, budget.delete
  hosting.view, hosting.create, hosting.edit, hosting.delete
  vault.view-list           (can see list but NOT reveal values)
  vault.reveal              (decrypted view — usually admin only)
  demo-projects.view, demo-projects.create, demo-projects.edit, demo-projects.delete
  crypto.view, crypto.create, crypto.edit
  seo-states.view, seo-states.create, seo-states.edit
  logs.view-all
  blog.view, blog.create, blog.edit, blog.delete
  portfolio.manage, testimonials.manage, faqs.manage
  contact-messages.view, contact-messages.reply
  products.view, products.create, products.edit, products.delete
```

**ROLE: content-manager** *(Custom example — manages website content only)*
```
Permissions:
  blog.view, blog.create, blog.edit           (no delete)
  portfolio.manage
  testimonials.manage
  faqs.manage
  page-seo.manage
  contact-messages.view
  products.view, products.edit
```

**ROLE: developer** *(Custom example — projects only)*
```
Permissions:
  projects.view, projects.edit    (no delete, no create)
  demo-projects.view
  hosting.view
  logs.view-own
```

### Role Management UI (Admin Panel Module)

Admin (super-admin only) can:
- **Create new roles** with any name
- **Create new permissions** from a predefined list or custom
- **Assign permissions to roles** (checkbox matrix)
- **Assign roles to users**
- See which users have which roles

```
/admin/roles            — list all roles
/admin/roles/create     — create role + assign permissions
/admin/roles/{id}/edit  — edit role permissions
/admin/users            — list users
/admin/users/{id}/edit  — assign roles to user + activate/deactivate
```

### Permission Matrix (Example)

| Permission Key | Super Admin | Admin | Content Manager | Developer |
|---|---|---|---|---|
| projects.view | ✅ | ✅ | ❌ | ✅ |
| projects.create | ✅ | ✅ | ❌ | ❌ |
| projects.edit | ✅ | ✅ | ❌ | ✅ |
| projects.delete | ✅ | ✅ | ❌ | ❌ |
| budget.view | ✅ | ✅ | ❌ | ❌ |
| vault.reveal | ✅ | ✅ | ❌ | ❌ |
| blog.create | ✅ | ✅ | ✅ | ❌ |
| page-seo.manage | ✅ | ✅ | ✅ | ❌ |
| roles.manage | ✅ | ❌ | ❌ | ❌ |
| users.manage | ✅ | ❌ | ❌ | ❌ |
| logs.view-all | ✅ | ✅ | ❌ | ❌ |

### Blade Route Protection
```php
// routes/admin.php
Route::prefix('admin')->middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index']);

    // Projects — any authenticated user with permission
    Route::middleware('permission:projects.view')->group(function () {
        Route::get('/projects', [ProjectController::class, 'index']);
        Route::get('/projects/{project}', [ProjectController::class, 'show']);
    });
    Route::middleware('permission:projects.create')->post('/projects', ...);
    Route::middleware('permission:projects.edit')->put('/projects/{project}', ...);
    Route::middleware('permission:projects.delete')->delete('/projects/{project}', ...);

    // Roles & Users — super-admin only
    Route::middleware('role:super-admin')->group(function () {
        Route::resource('/roles', RoleController::class);
        Route::resource('/users', UserController::class);
    });

    // Blog — content-manager or higher
    Route::middleware('permission:blog.view')->group(function () {
        Route::resource('/blog', BlogPostController::class);
    });
});
```

### CRM Sidebar Menu Visibility (Blade)
```blade
{{-- Only show menu items the user has permission to see --}}
@can('projects.view')
    <x-nav-item route="admin.projects.index" icon="folder" label="Projects" />
@endcan

@can('budget.view')
    <x-nav-item route="admin.budget.index" icon="currency" label="Budget" />
@endcan

@role('super-admin')
    <x-nav-item route="admin.roles.index" icon="shield" label="Roles & Permissions" />
    <x-nav-item route="admin.users.index" icon="users" label="Users" />
@endrole
```

---

## 7. LARAVEL ROUTES & CONTROLLER ARCHITECTURE

### Routes Files
```
routes/
  web.php        → Public website routes (no auth)
  admin.php      → CRM panel routes (auth + role middleware)
  auth.php        → Laravel Breeze auth routes (login, logout, password reset)
```

### Public Website Routes (routes/web.php)
```php
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/services', [ServiceController::class, 'index'])->name('services');
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/portfolio', [PortfolioController::class, 'index'])->name('portfolio');
Route::get('/portfolio/{slug}', [PortfolioController::class, 'show'])->name('portfolio.show');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store')
     ->middleware('throttle:3,60');  // max 3 per hour per IP
Route::get('/faqs', [FaqController::class, 'index'])->name('faqs');
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');       // Phase 2
Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show'); // Phase 2
Route::get('/privacy-policy', [PageController::class, 'privacy'])->name('privacy');
Route::get('/refund-policy', [PageController::class, 'refund'])->name('refund');
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');
Route::get('/robots.txt', [SitemapController::class, 'robots'])->name('robots');
```

### Admin CRM Routes (routes/admin.php — registered with prefix /admin)
```php
Route::prefix('admin')->name('admin.')->middleware(['auth', 'verified'])->group(function () {

    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // PROJECTS
    Route::middleware('permission:projects.view')->group(function () {
        Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
        Route::get('/projects/{project}', [ProjectController::class, 'show'])->name('projects.show');
    });
    Route::middleware('permission:projects.create')->post('/projects', [ProjectController::class, 'store'])->name('projects.store');
    Route::middleware('permission:projects.edit')->group(function () {
        Route::get('/projects/{project}/edit', [ProjectController::class, 'edit'])->name('projects.edit');
        Route::put('/projects/{project}', [ProjectController::class, 'update'])->name('projects.update');
        Route::patch('/projects/{project}/status', [ProjectController::class, 'updateStatus'])->name('projects.status');
        Route::post('/projects/{project}/messages', [ProjectMessageController::class, 'store'])->name('projects.messages.store');
        Route::post('/projects/{project}/documents', [ProjectDocumentController::class, 'store'])->name('projects.documents.store');
        Route::delete('/projects/{project}/documents/{document}', [ProjectDocumentController::class, 'destroy'])->name('projects.documents.destroy');
    });
    Route::middleware('permission:projects.delete')->delete('/projects/{project}', [ProjectController::class, 'destroy'])->name('projects.destroy');

    // INVESTMENTS
    Route::middleware('permission:investments.view')->resource('/investments', InvestmentController::class);
    Route::middleware('permission:investments.view')->prefix('/investments/{investment}')->group(function () {
        Route::resource('/expenses', InvestmentExpenseController::class)->except(['index']);
    });

    // BUDGET
    Route::middleware('permission:budget.view')->prefix('/budget')->name('budget.')->group(function () {
        Route::get('/', [BudgetController::class, 'index'])->name('index');
        Route::resource('/expenses', BudgetExpenseController::class)->except(['show']);
        Route::resource('/incomes', BudgetIncomeController::class)->except(['show']);
        Route::get('/report/{year}/{month}', [BudgetController::class, 'monthlyReport'])->name('report');
        Route::get('/export', [BudgetController::class, 'export'])->name('export');
    });

    // HOSTING
    Route::middleware('permission:hosting.view')->resource('/hosting', HostingClientController::class);
    Route::get('/hosting/renewals-due', [HostingClientController::class, 'renewalsDue'])->name('hosting.renewals');

    // VAULT — API KEYS
    Route::middleware('permission:vault.view-list')->prefix('/api-keys')->name('api-keys.')->group(function () {
        Route::get('/', [ApiKeyController::class, 'index'])->name('index');
        Route::get('/create', [ApiKeyController::class, 'create'])->name('create');
        Route::post('/', [ApiKeyController::class, 'store'])->name('store');
        Route::get('/{apiKey}/edit', [ApiKeyController::class, 'edit'])->name('edit');
        Route::put('/{apiKey}', [ApiKeyController::class, 'update'])->name('update');
        Route::delete('/{apiKey}', [ApiKeyController::class, 'destroy'])->name('destroy');
    });
    Route::middleware('permission:vault.reveal')
         ->get('/api-keys/{apiKey}/reveal', [ApiKeyController::class, 'reveal'])
         ->name('api-keys.reveal');

    // VAULT — CREDENTIALS
    Route::middleware('permission:vault.view-list')->resource('/credentials', CredentialController::class);
    Route::middleware('permission:vault.reveal')
         ->get('/credentials/{credential}/reveal', [CredentialController::class, 'reveal'])
         ->name('credentials.reveal');

    // DEMO PROJECTS
    Route::resource('/demo-projects', DemoProjectController::class);

    // CRYPTO
    Route::resource('/crypto', CryptoController::class);
    Route::get('/crypto/portfolio-summary', [CryptoController::class, 'portfolioSummary'])->name('crypto.summary');

    // NOTES (strict: user sees only own notes — enforced in controller)
    Route::resource('/notes', NoteController::class);
    Route::patch('/notes/{note}/pin', [NoteController::class, 'togglePin'])->name('notes.pin');

    // BLOG
    Route::middleware('permission:blog.view')->group(function () {
        Route::resource('/blog/posts', BlogPostController::class);
        Route::resource('/blog/categories', BlogCategoryController::class);
        Route::resource('/blog/tags', BlogTagController::class);
    });

    // WEBSITE CONTENT
    Route::middleware('permission:portfolio.manage')->resource('/portfolio', AdminPortfolioController::class);
    Route::middleware('permission:testimonials.manage')->resource('/testimonials', TestimonialController::class);
    Route::middleware('permission:faqs.manage')->resource('/faqs', AdminFaqController::class);
    Route::get('/contact-messages', [ContactMessageController::class, 'index'])->name('contact.index');
    Route::patch('/contact-messages/{msg}/status', [ContactMessageController::class, 'updateStatus'])->name('contact.status');

    // PRODUCTS (Phase 2)
    Route::middleware('permission:products.view')->resource('/products', AdminProductController::class);

    // SEO
    Route::prefix('/seo')->name('seo.')->group(function () {
        Route::get('/dashboard', [SeoController::class, 'dashboard'])->name('dashboard');
        Route::get('/pages', [PageSeoController::class, 'index'])->name('pages.index');
        Route::put('/pages/{pageKey}', [PageSeoController::class, 'update'])->name('pages.update');
        Route::resource('/client-sites', WebsiteSeoStateController::class);
        Route::get('/sitemap-settings', [SitemapController::class, 'settings'])->name('sitemap');
        Route::post('/sitemap-regenerate', [SitemapController::class, 'regenerate'])->name('sitemap.regenerate');
        Route::get('/robots', [RobotsController::class, 'edit'])->name('robots');
        Route::put('/robots', [RobotsController::class, 'update'])->name('robots.update');
    });

    // LOGS
    Route::get('/logs', [ActivityLogController::class, 'index'])
         ->middleware('permission:logs.view-all')
         ->name('logs.index');
    Route::get('/logs/mine', [ActivityLogController::class, 'mine'])->name('logs.mine');

    // USERS & ROLES (super-admin only)
    Route::middleware('role:super-admin')->group(function () {
        Route::resource('/users', UserController::class);
        Route::resource('/roles', RoleController::class);
        Route::post('/roles/{role}/permissions', [RoleController::class, 'syncPermissions'])->name('roles.permissions');
        Route::post('/users/{user}/roles', [UserController::class, 'syncRoles'])->name('users.roles');
    });
});
```

### Controller Pattern (Standard)
```php
// All admin controllers follow this pattern:
class ProjectController extends Controller
{
    public function index(Request $request): View
    {
        // Livewire handles table — controller just loads the view
        return view('admin.projects.index');
    }

    public function store(StoreProjectRequest $request): RedirectResponse
    {
        $project = Project::create([...$request->validated(), 'created_by' => auth()->id()]);
        $project->update(['project_code' => 'RS-' . now()->year . '-' . str_pad($project->id, 3, '0', STR_PAD_LEFT)]);

        // Spatie auto-logs via model observer
        return redirect()->route('admin.projects.show', $project)
                         ->with('success', 'Project created successfully.');
    }
}
```

### Livewire Component for DataTables
```php
// App\Livewire\Projects\ProjectsTable
class ProjectsTable extends Component
{
    public string $search = '';
    public string $statusFilter = '';
    public string $sortBy = 'created_at';
    public string $sortDir = 'desc';
    public int $perPage = 20;

    public function render(): View
    {
        $projects = Project::query()
            ->when($this->search, fn($q) => $q->where('client_name', 'like', "%{$this->search}%")
                                               ->orWhere('title', 'like', "%{$this->search}%"))
            ->when($this->statusFilter, fn($q) => $q->where('status', $this->statusFilter))
            ->orderBy($this->sortBy, $this->sortDir)
            ->paginate($this->perPage);

        return view('livewire.projects.projects-table', compact('projects'));
    }
}
```

---

## 8. MODULE 01 — PROJECTS MANAGEMENT

### Overview
The core operational module. Tracks every client project from inception to delivery.

### Project Form Fields (Create/Edit)
| Field | Type | Required | Notes |
|---|---|---|---|
| Client Name | Text | ✅ | Autocomplete from previous clients |
| Project Title | Text | ✅ | Brief descriptive name |
| Description | Textarea | ❌ | Internal description |
| Requirements Note | Rich Text | ❌ | First requirements communication |
| Requirements Doc | File Upload | ❌ | PDF, DOC, DOCX, max 20MB |
| Cost | Number | ❌ | Decimal, with currency selector |
| Currency | Select | ✅ | PKR, USD, SAR, AED, GBP |
| Deadline | Date Picker | ❌ | Cannot be past date |
| Developer Name | Text/Select | ❌ | Team member or freelancer |
| Status | Select | ✅ | Default: PENDING |
| Live URL | URL | ❌ | Validated URL format |
| Testing Domain | URL | ❌ | Staging/dev URL |

### Project Status Flow (Kanban)
```
PENDING → IN_PROGRESS → IN_REVIEW → TESTING → COMPLETED
    └──────────────────────────────────────→ ON_HOLD
    └──────────────────────────────────────→ CANCELLED
```

### Project Detail Page Layout
```
┌──────────────────────────────────────────────────────────┐
│  [RS-2026-001] Project Name            Status Badge      │
│  Client: John Doe | Developer: Ali | Deadline: 30 May    │
│  Cost: PKR 150,000 | Live: example.com | Test: test.com  │
├──────────────────────────────────────────────────────────┤
│  TABS: [Overview] [Documents] [Messages] [Timeline]      │
├──────────────────────────────────────────────────────────┤
│  OVERVIEW TAB:                                           │
│  Description, Requirements Note                          │
│                                                          │
│  DOCUMENTS TAB:                                          │
│  Upload button + list of files with date, note, download │
│                                                          │
│  MESSAGES TAB:                                           │
│  Chat-style sequential message thread                    │
│  Sender: "US" (right, blue) | "CLIENT" (left, gray)     │
│  Each msg: sender, content, timestamp, attachments       │
│  Add message form at bottom                              │
│                                                          │
│  TIMELINE TAB:                                           │
│  Auto-generated from status changes & activity logs      │
└──────────────────────────────────────────────────────────┘
```

### Projects List Page Features
- **Kanban View**: Drag cards between status columns
- **Table View**: All projects in paginated table with sorting
- **Filters**: Status, Developer, Client, Date Range, Overdue toggle
- **Search**: Global search by client name, title, project code
- **Quick Actions**: Change status, copy URL, view detail
- **Stats Row**: Total projects | Active | Overdue | Completed this month
- **Export**: CSV download of filtered data

### Business Logic & Automations
- Auto-generate `projectCode` on creation: `RS-YYYY-NNN`
- If deadline has passed and status is not COMPLETED → mark as "Overdue" visually
- Dashboard widget shows projects due in next 7 days
- Sending a message auto-creates an activity log entry
- Uploading a document triggers log entry

---

## 9. MODULE 02 — INVESTMENTS

### Overview
Track external investors or personal investment ventures, with full expense/output tracking.

### Investment Form Fields
| Field | Type | Required | Notes |
|---|---|---|---|
| Person Name | Text | ✅ | Investor or partner name |
| Amount | Number | ❌ | Initial investment amount |
| Currency | Select | ✅ | PKR, USD, etc. |
| Idea Details | Rich Text | ✅ | Business idea / project description |
| Start Date | Date | ✅ | |
| Expected End Date | Date | ❌ | Target completion/return date |
| Status | Select | ✅ | ACTIVE, COMPLETED, PAUSED, CANCELLED |

### Investment Expense Form Fields
| Field | Type | Required | Notes |
|---|---|---|---|
| Details | Textarea | ✅ | What was spent on |
| Amount | Number | ✅ | |
| Spend Purpose | Text | ✅ | Category/label of expense |
| Date | Date | ✅ | When spent |
| Output | Textarea | ❌ | What was achieved/produced |
| Receipt | File | ❌ | Proof of payment |

### Investment Detail Page Layout
```
┌────────────────────────────────────────────────────────┐
│  Investment Name (Person Name + Idea Summary)          │
│  Total Invested: PKR 500,000 | Status: ACTIVE         │
│  Start: Jan 2026 | Expected End: Dec 2026              │
├────────────────────────────────────────────────────────┤
│  TABS: [Overview] [Expenses]                           │
├────────────────────────────────────────────────────────┤
│  EXPENSES TAB:                                         │
│  Summary: Total Spent / Remaining Budget               │
│  ┌─────────────────────────────────────────────────┐  │
│  │ Date | Purpose | Amount | Details | Output | 🗑  │  │
│  └─────────────────────────────────────────────────┘  │
│  [+ Add Expense] button                                │
└────────────────────────────────────────────────────────┘
```

### Calculations
- Total Invested (from investment record)
- Total Spent (sum of all expense amounts)
- Remaining (Total Invested - Total Spent)
- ROI status flag based on expected end date

---

## 10. MODULE 03 — BUDGET (EXPENSES & INCOME)

### Overview
Full financial accounting matching the Google Spreadsheet structure. This is the digital replacement of the Received, Personal Expense, and Project Payments sheets.

### Budget Expense Form Fields
| Field | Type | Required | Default | Notes |
|---|---|---|---|---|
| Reason | Text | ✅ | — | What money was spent on |
| Type | Select | ✅ | — | PERSONAL, PROJECT, ASSETS, GROCERY, UTILITIES, OFFICE, MARKETING, OTHER |
| Amount | Number | ✅ | — | Decimal, positive |
| Currency | Select | ✅ | PKR | |
| Date | DateTime | ✅ | Now | Editable |
| Note | Text | ❌ | — | Extra context |
| Receipt | File | ❌ | — | Image or PDF |

### Budget Income Form Fields
| Field | Type | Required | Default | Notes |
|---|---|---|---|---|
| Source | Text | ✅ | — | Client name, platform, transfer source |
| Amount | Number | ✅ | — | |
| Currency | Select | ✅ | PKR | |
| Date | DateTime | ✅ | Now | |
| Note | Text | ❌ | — | |
| Proof | File | ❌ | — | Bank screenshot, invoice |

### Budget Dashboard Widgets
```
┌─────────────┐ ┌─────────────┐ ┌─────────────┐ ┌─────────────┐
│ THIS MONTH  │ │ THIS MONTH  │ │ NET PROFIT  │ │  BALANCE    │
│   INCOME    │ │  EXPENSES   │ │   / LOSS    │ │  (Running)  │
│ PKR 450,000 │ │ PKR 320,000 │ │ PKR 130,000 │ │ PKR 65,000  │
│ ↑ +12% MOM │ │ ↓ -5% MOM  │ │  ✅ PROFIT  │ │ All time    │
└─────────────┘ └─────────────┘ └─────────────┘ └─────────────┘
```

### Budget Page Features
- **Two tabs**: Expenses | Income
- **Monthly filter**: Select month/year
- **Expense type breakdown**: Pie chart by type
- **Income vs Expense line chart**: 12-month trend
- **Table**: Sorted by date desc, with edit/delete inline
- **Monthly Report**: Summary card showing P&L for selected month
- **Running balance**: All-time total income - all-time total expense
- **Export**: Export filtered data as CSV

### Monthly Summary Calculation
```
Monthly Income = SUM(budget_incomes WHERE month = selected_month)
Monthly Expense = SUM(budget_expenses WHERE month = selected_month)
Net = Monthly Income - Monthly Expense
Running Balance = SUM(all_incomes) - SUM(all_expenses)
```

### Expense Types Color Coding
| Type | Color |
|---|---|
| PERSONAL | Purple |
| PROJECT | Blue |
| ASSETS | Orange |
| GROCERY | Green |
| UTILITIES | Yellow |
| OFFICE | Cyan |
| MARKETING | Pink |
| OTHER | Gray |

---

## 11. MODULE 04 — HOSTING CLIENTS

### Overview
Track all client hosting and domain management with renewal alerts.

### Hosting Client Form Fields
| Field | Type | Required | Notes |
|---|---|---|---|
| Client Name | Text | ✅ | |
| Domain Name | Text | ✅ | e.g., example.com |
| Starting Date | Date | ✅ | When hosting began |
| Renew Duration | Select | ✅ | MONTHLY, QUARTERLY, SEMI_ANNUALLY, YEARLY, TWO_YEARS |
| Amount | Number | ✅ | Renewal cost per cycle |
| Currency | Select | ✅ | Default PKR |
| Server Usage | Select | ✅ | HOSTING_ONLY, HOSTING_AND_DOMAIN, DOMAIN_ONLY, VPS, DEDICATED |
| Hosting Provider | Text | ❌ | Namecheap, GoDaddy, SiteGround, etc. |
| Server IP | Text | ❌ | IP address |
| Auto Renew | Toggle | ✅ | Default: false |
| Notes | Textarea | ❌ | |
| Is Active | Toggle | ✅ | Default: true |

### Computed Fields (Not Stored)
- **Next Renewal Date**: Start Date + (N × Renew Duration cycle)
- **Days Until Renewal**: Next Renewal Date - Today
- **Renewal Status**: 
  - 🟢 OK (>30 days)
  - 🟡 Due Soon (≤30 days)
  - 🔴 Overdue (<0 days)
  - ⚫ Inactive

### Hosting List Features
- **Renewal Alert Banner**: Sites renewing in next 7 days
- **Filter**: Active/Inactive, Server Usage type, Provider
- **Sort**: By renewal date (ascending — most urgent first)
- **Quick copy**: Copy domain, copy IP
- **Monthly Cost Summary**: Total monthly hosting cost across all clients

---

## 12. MODULE 05 — API KEYS VAULT

### Overview
Secure, encrypted storage for all API keys. Values are AES-256 encrypted in database. Decryption requires admin role and is logged.

### API Key Form Fields
| Field | Type | Required | Notes |
|---|---|---|---|
| Provider Name | Text | ✅ | OpenAI, Stripe, Twilio, AWS, etc. |
| Key Label | Text | ✅ | Friendly name — "OpenAI GPT-4 Prod" |
| Key Value | Password Input | ✅ | AES-256 encrypted on save |
| Key Type | Select | ✅ | API_KEY, SECRET_KEY, ACCESS_TOKEN, etc. |
| Environment | Select | ✅ | production, staging, development |
| Expires At | Date | ❌ | Optional expiry |
| Notes | Textarea | ❌ | |
| Is Active | Toggle | ✅ | |

### Security Behavior
- Key value is **never shown in list view** — always masked as `••••••••••••`
- **Reveal** button triggers:
  1. Admin role check
  2. Activity log: `REVEAL_API_KEY` with user, timestamp, IP
  3. Returns decrypted value — displayed for 30 seconds then auto-hides
- Copy-to-clipboard button next to revealed key
- **Filter by**: Provider, Type, Environment, Active/Expired

---

## 13. MODULE 06 — CREDENTIALS VAULT

### Overview
SSH, FTP, cPanel, database credentials for all managed systems. Password encrypted at rest.

### Credential Form Fields
| Field | Type | Required | Notes |
|---|---|---|---|
| System Name | Text | ✅ | "Client ABC cPanel", "Main DB Server" |
| URL | URL | ❌ | Admin URL or hostname |
| Username | Text | ❌ | Login username |
| Email | Email | ❌ | Login email |
| Password | Password | ✅ | AES-256 encrypted |
| IP Address | Text | ❌ | Server IP |
| Port | Text | ❌ | SSH/DB port |
| Command | Code Area | ❌ | SSH command, connection string |
| Owner Type | Radio | ✅ | PERSONAL, CLIENT |
| Owner Name | Text | ❌ | If client type, client name |
| Credential Type | Select | ✅ | WEB_PANEL, SSH, FTP, DATABASE, etc. |
| Notes | Textarea | ❌ | |

### Security Behavior (same as API Keys)
- Password masked everywhere
- Reveal = admin only + logged
- Auto-hide after 30 seconds
- Command field shows in monospace font with copy button

### List Features
- **Filter**: Type, Owner Type, Owner Name, Active
- **Search**: System name, URL, owner name
- **Quick copy**: Copy IP, copy port, copy command
- **Type icons**: SSH = terminal icon, DB = database icon, etc.

---

## 14. MODULE 07 — DEMO PROJECTS

### Overview
Showcase internal demo/prototype projects with preview images.

### Demo Project Form Fields
| Field | Type | Required | Notes |
|---|---|---|---|
| Site Name | Text | ✅ | |
| URL | URL | ✅ | Live demo URL |
| Client Name | Text | ❌ | If built for specific client |
| Description | Textarea | ❌ | |
| Tech Stack | Tag Input | ❌ | React, Laravel, MySQL, etc. |
| Thumbnail | Image Upload | ❌ | Screenshot or mockup |
| Is Public | Toggle | ✅ | If public — can show on frontend portfolio |

### List Features
- Grid view (cards with thumbnail preview)
- List view (table)
- Public toggle — syncs with frontend portfolio

---

## 15. MODULE 08 — CRYPTO INVESTMENT

### Overview
Digital asset portfolio tracker matching the spreadsheet's Crypto Investment tab.

### Crypto Form Fields
| Field | Type | Required | Notes |
|---|---|---|---|
| Date | Date | ✅ | Purchase date |
| Amount Invested | Number | ✅ | Amount in PKR or USD |
| Currency | Select | ✅ | PKR, USD, USDT |
| Coin | Text | ✅ | Bitcoin, Ethereum, Solana, etc. |
| Coin Symbol | Text | ✅ | BTC, ETH, SOL, USDT |
| Quantity | Number | ❌ | How many coins purchased |
| Wallet Label | Text | ❌ | Binance, MetaMask, Ledger, etc. |
| Wallet Address | Text | ❌ | Blockchain address |
| Exchange | Text | ❌ | Binance, OKX, Coinbase |
| TX Hash | Text | ❌ | Transaction ID |
| Notes | Text | ❌ | |

### Portfolio Summary Widget
```
┌─────────────────────────────────────────────────────┐
│  CRYPTO PORTFOLIO SUMMARY                           │
│  ─────────────────────────────────────────────────  │
│  Total Invested:  $2,450.00 USD                    │
│  ─────────────────────────────────────────────────  │
│  By Coin Breakdown:                                 │
│  BTC:  $1,200 | 2 entries                          │
│  ETH:   $800  | 3 entries                          │
│  SOL:   $450  | 1 entry                            │
│  ─────────────────────────────────────────────────  │
│  By Wallet:                                         │
│  Binance: $1,800 | MetaMask: $650                  │
└─────────────────────────────────────────────────────┘
```

---

## 16. MODULE 09 — USER PERSONAL NOTES

### Overview
Private, per-user note-taking. Each user can only see and manage their own notes.

### Note Form Fields
| Field | Type | Required | Notes |
|---|---|---|---|
| Title | Text | ❌ | Optional heading |
| Content | Rich Text (Tiptap) | ✅ | Bold, italic, lists, code blocks, links |
| Color | Color Picker | ❌ | Card background color |
| Tags | Tag Input | ❌ | For organization |
| Is Pinned | Toggle | ❌ | Pin to top of list |

### Notes Features
- **Grid layout**: Colorful sticky-note cards
- **Pin**: Pinned notes always show at top
- **Search**: Full text search within own notes
- **Filter**: By tag
- **Rich Editor**: Tiptap with full formatting toolbar
- **Auto-save**: Draft saved every 30 seconds while typing
- **Strict isolation**: Backend enforces `userId = req.user.id` on ALL note queries — no admin override

---

## 17. MODULE 10 — SEO MANAGEMENT (Comprehensive)

### Overview
Three-part SEO system:
1. **Own Website SEO** — manage meta tags, sitemap, robots.txt for every public page of redissolution.com
2. **SEO Dashboard** — health indicators, issues, traffic signals for OWN website
3. **Client Site SEO Tracker** — track managed client sites' SEO states

---

### Part A — Own Website Page SEO (page_seo_meta table)

**Every public page of Redis Solution website has SEO control from the CRM:**

```
/admin/seo/pages
```

| Page | Key | Editable Fields |
|---|---|---|
| Home | `home` | Meta Title, Meta Description, Keywords, OG Title, OG Desc, OG Image, Schema (Organization) |
| Services | `services` | Meta Title, Meta Description, Keywords, OG |
| About | `about` | Same + LocalBusiness schema |
| Portfolio | `portfolio` | Same |
| Contact | `contact` | Same + LocalBusiness schema |
| Blog | `blog` | Same |
| Products | `products` | Same |
| FAQs | `faqs` | Same + FAQPage JSON-LD schema |
| Privacy | `privacy-policy` | Meta Title, no-index option |
| Refund | `refund-policy` | Meta Title, no-index option |

**Blade meta injection (in layout):**
```blade
{{-- resources/views/layouts/frontend.blade.php --}}
@php $seo = PageSeoMeta::where('page_key', $pageKey ?? 'home')->first(); @endphp

{!! SEOTools::generate() !!}
{{-- artesaos/seotools dynamically fills from DB + page-specific overrides --}}
```

**Blog post SEO:** Every blog post has its own meta title, description, OG image, canonical URL, Article JSON-LD schema (managed per-post in the blog editor).

**Product page SEO:** Every product has its own SEO fields (Phase 2).

---

### Part B — SEO Dashboard (/admin/seo/dashboard)

**Purpose:** Real-time health status of redissolution.com — show what's working, what needs fixing, where traffic is going.

```
┌──────────────────────────────────────────────────────────────┐
│  SEO HEALTH OVERVIEW                      redissolution.com  │
├────────────────┬───────────────┬─────────────────────────────┤
│ Overall Score  │ Pages Missing │ Sitemap Status              │
│  [72/100]      │ Meta: 2 pages │ ✅ Generated (2026-05-11)   │
│  Amber         │ OG Image: 4   │ 23 URLs indexed             │
├────────────────┴───────────────┴─────────────────────────────┤
│  ISSUES PANEL — What needs attention:                        │
│  🔴 HIGH: 2 pages have no meta description                   │
│  🔴 HIGH: Contact page missing OG image                     │
│  🟡 MED:  Blog posts without featured image (4 posts)        │
│  🟡 MED:  No FAQ JSON-LD schema on /faqs page                │
│  🟢 OK:   SSL Active | Robots.txt OK | Sitemap reachable    │
├──────────────────────────────────────────────────────────────┤
│  PAGE-BY-PAGE STATUS TABLE                                   │
│  Page      | Title ✅ | Desc ✅ | OG ⚠️ | Schema ❌ | Fix  │
│  Home      |  ✅      |  ✅     |  ✅   |   ✅      |  —   │
│  Services  |  ✅      |  ✅     |  ❌   |   ❌      | Fix  │
│  About     |  ✅      |  ❌     |  ❌   |   ❌      | Fix  │
│  Contact   |  ✅      |  ✅     |  ❌   |   ✅      | Fix  │
│  Blog      |  ✅      |  ✅     |  ✅   |   ✅      |  —   │
├──────────────────────────────────────────────────────────────┤
│  BLOG SEO TABLE                                              │
│  Post Title          | Meta | OG Image | Indexed | Views    │
│  "Best PHP Framework"| ✅   |  ✅      |  Yes    | 234      │
│  "SEO in 2026"       | ❌   |  ❌      |  Yes    | 89       │
│  [Fix] button on issues                                      │
├──────────────────────────────────────────────────────────────┤
│  TECHNICAL SEO CHECKLIST                                     │
│  ✅ Sitemap.xml accessible     ✅ Robots.txt exists          │
│  ✅ SSL Certificate active     ✅ Canonical URLs set         │
│  ✅ 404 page exists            ⚠️  No Google Analytics ID set│
│  ⚠️  No Search Console verified ❌ No hreflang (if multilang)│
├──────────────────────────────────────────────────────────────┤
│  GOOGLE ANALYTICS INTEGRATION                                │
│  Measurement ID: G-XXXXXXXX (set in CRM Settings)           │
│  Data shown (via GA4 Reporting API, if connected):           │
│  Sessions (30d) | Users (30d) | Bounce Rate | Top Pages     │
│  [Connect Google Analytics] button if not connected         │
├──────────────────────────────────────────────────────────────┤
│  QUICK ACTIONS                                               │
│  [Regenerate Sitemap] [Edit Robots.txt] [Edit Page SEO]     │
└──────────────────────────────────────────────────────────────┘
```

### Issues Detection Logic (Automated Checks)
These run on page load of the SEO dashboard (or via scheduled command):

```php
// App\Services\SeoAuditService::runOwnSiteAudit()
$issues = [];

// Check each page in page_seo_meta
foreach (PageSeoMeta::all() as $page) {
    if (empty($page->meta_title))       $issues[] = ['level'=>'high', 'page'=>$page->page_name, 'issue'=>'Missing meta title'];
    if (empty($page->meta_description)) $issues[] = ['level'=>'high', 'page'=>$page->page_name, 'issue'=>'Missing meta description'];
    if (empty($page->og_image))         $issues[] = ['level'=>'medium', 'page'=>$page->page_name, 'issue'=>'Missing OG image'];
    if (empty($page->schema_markup))    $issues[] = ['level'=>'low', 'page'=>$page->page_name, 'issue'=>'No schema markup'];
}

// Check blog posts
$postsNoMeta = BlogPost::published()->whereNull('meta_description')->count();
if ($postsNoMeta > 0) $issues[] = ['level'=>'high', 'issue'=>"{$postsNoMeta} blog posts missing meta description"];

// Check sitemap
$sitemapOk = Http::get(config('app.url') . '/sitemap.xml')->successful();
if (!$sitemapOk) $issues[] = ['level'=>'critical', 'issue'=>'Sitemap.xml not accessible'];

return $issues; // displayed on dashboard sorted by level
```

### Sitemap Management (/admin/seo/sitemap-settings)
```
Auto-generated by spatie/laravel-sitemap via scheduled command (daily)
Includes:
  / | /services | /about | /portfolio | /contact | /faqs | /blog
  /blog/{slug} for all published posts (with lastmod = updated_at)
  /products | /products/{slug} for all published products (Phase 2)
  /portfolio/{slug} for all published portfolio items

Excluded:
  /admin/* | /privacy-policy | /refund-policy (no-index pages)

Admin can:
  - See current sitemap URL list
  - Manually trigger regeneration
  - Set custom priority per page (0.1 – 1.0)
  - Set change frequency (daily, weekly, monthly)
```

### Robots.txt Management (/admin/seo/robots)
```
Editable textarea in CRM showing current robots.txt content
Live preview mode
Save → writes to public/robots.txt via Storage::disk('public')

Default content managed:
  User-agent: *
  Disallow: /admin/
  Disallow: /admin/*
  Allow: /
  Sitemap: https://redissolution.com/sitemap.xml
```

---

### Part C — Client Site SEO Tracker (/admin/seo/client-sites)
*(Same as original Module 10 — track managed client sites)*

Form Fields: Site Name, Site URL, Client Name, Meta Title, Meta Description, Keywords, Google Ranking, Google Indexed, Last Audit Date, PageSpeed Score, Mobile Score, SEO Score, Backlinks Count, Domain Authority, Sitemap URL, Robots.txt OK, SSL Active, Issues (JSON list), Improvements (JSON list), Notes

**SEO Score Display:** Circular gauge (0-100) with color coding
- 0-49: Red | 50-74: Amber | 75-89: Yellow-green | 90-100: Green

---

## 18. MODULE 11 — BLOGGING SYSTEM

### Overview
Full blog management from CRM. Blog posts appear on public website at `/blog` and `/blog/{slug}`. Built for SEO — every post has complete control over meta, OG, schema, canonical URL.

### Blog Post Form Fields
| Field | Type | Required | Notes |
|---|---|---|---|
| Title | Text | ✅ | Auto-generates slug |
| Slug | Text | ✅ | Editable, URL-safe, unique |
| Category | Select | ❌ | From blog_categories |
| Tags | Multi-select/tag input | ❌ | From blog_tags, create on fly |
| Excerpt | Textarea | ❌ | Short summary (shown in blog listing) |
| Content | Quill.js Rich Editor | ✅ | Full HTML — headings, images, code, tables |
| Featured Image | File Upload | ❌ | Optimized via intervention/image |
| Featured Image Alt | Text | ❌ | For accessibility + SEO |
| Status | Select | ✅ | draft, published, scheduled |
| Published At | DateTime | ❌ | Required if status = scheduled |
| --- SEO TAB --- | | | |
| Meta Title | Text | ❌ | Max 60 chars — counter shown |
| Meta Description | Textarea | ❌ | Max 160 chars — counter shown |
| OG Image | Image Upload | ❌ | Social share image |
| Canonical URL | URL | ❌ | Default = post URL |
| No-Index | Toggle | ❌ | Exclude from Google |
| Schema Type | Select | ❌ | Article, HowTo, FAQ, BlogPosting |

### Blog Post Slug Auto-Generation
```php
// BlogPost model observer
public function creating(BlogPost $post): void {
    $post->slug = Str::slug($post->title);
    // if duplicate: append -2, -3, etc.
}
```

### Blog Listing Page (CRM)
```
/admin/blog/posts
  - Table: Title | Category | Status | Published At | Views | Actions
  - Filter: Status, Category, Date range
  - Bulk actions: Publish, Draft, Delete
  - [+ New Post] button
  
/admin/blog/categories — CRUD for categories (name, slug, description, meta)
/admin/blog/tags       — CRUD for tags (name, slug)
```

### Public Blog Pages (Blade views)

**Blog Listing (`/blog`):**
```blade
{{-- resources/views/frontend/blog/index.blade.php --}}
Grid of blog cards (3 col desktop, 1 mobile):
  Each card:
    - Featured image (object-cover, 16:9, lazy load)
    - Category badge (orange pill)
    - Title (Syne, 22px)
    - Excerpt (2 lines, ellipsis)
    - Author + Date + Read time estimate
    - "Read More →" link

Sidebar or filter tabs: All | Category filters
Pagination: Laravel paginate(12)
```

**Blog Post (`/blog/{slug}`):**
```blade
{{-- resources/views/frontend/blog/show.blade.php --}}
Layout:
  Article header:
    - Category breadcrumb
    - Title (Clash Display, 52px, dark bg white text OR light bg dark text)
    - Author | Date | Est. read time | View count
    - Featured image (full width, rounded-lg)
  
  Article body (prose styles):
    - Quill.js output rendered safely with {!! $post->content !!}
    - Typography: DM Sans, 18px, line-height 1.7
    - Headings in Syne
    - Code blocks styled (dark bg, orange syntax)
    - Images: next-gen, lazy loaded
  
  Article footer:
    - Tags (orange pills)
    - Share buttons: Copy link, WhatsApp, LinkedIn, Twitter
    - Related posts (3 from same category)
  
  Structured data:
    - Article JSON-LD schema injected in <head>
    - Open Graph tags from post's og_image + og fields
    - Twitter Card meta tags
    - Canonical URL

SEO: View count increments on each page load (+1 to blog_posts.views)
     Does NOT count admin views (checked via auth()->check())
```

### SEO Impact of Blog
- Each blog post = a new indexed URL with unique meta
- Category pages = `/blog/category/{slug}` (also indexed, with category meta)
- Internal linking: Related posts section builds site structure
- Sitemap auto-includes all published posts
- Blog drives organic traffic → contact → project inquiries

---

## 18B. MODULE 12 — WEBSITE CONTENT MANAGEMENT

### Overview
All dynamic content on the public website is managed from the CRM. No need to edit code to update portfolio, testimonials, or FAQs.

### Portfolio Management (/admin/portfolio)
| Field | Type | Notes |
|---|---|---|
| Title | Text | Project name |
| Slug | Text | Auto-generated |
| Client Name | Text | Optional |
| Category | Select | web, mobile, crm, ai, ecommerce, other |
| Description | Textarea | Short (shown in grid) |
| Case Study | Rich Text | Full detail (shown on `/portfolio/{slug}`) |
| Thumbnail | Image | Main grid image |
| Gallery | Multi-image | Images for lightbox |
| Live URL | URL | Optional |
| Tech Stack | Tag input | Array |
| Results | Tag input | ["250% traffic growth", etc.] |
| Is Featured | Toggle | Shows first on grid |
| Is Published | Toggle | Hides from public |
| Sort Order | Number | Manual ordering |

### Testimonials Management (/admin/testimonials)
| Field | Type | Notes |
|---|---|---|
| Client Name | Text | |
| Client Title | Text | "CEO, Agnatech" |
| Company | Text | |
| Avatar | Image | |
| Quote | Textarea | |
| Rating | Select (1-5) | |
| Is Featured | Toggle | Used in homepage testimonial section |
| Is Published | Toggle | |
| Sort Order | Number | |

### FAQs Management (/admin/faqs)
| Field | Type | Notes |
|---|---|---|
| Question | Text | |
| Answer | Rich Text | |
| Category | Select | general, technical, billing, support |
| Sort Order | Number | Manual ordering |
| Is Published | Toggle | |

### Contact Messages (/admin/contact-messages)
- Incoming messages from website contact form
- Status: new, read, replied, archived
- Admin notes field
- Read at timestamp auto-set
- Email notification on new message (queued Mailable)
- Filter by status

---

## 18C. MODULE 13 — PRODUCTS (Phase 2)

### Overview
Redis Solution's own products listed on public website at `/products`. Each product has its own detail page. Think: SaaS tools, scripts, templates, mobile apps built in-house.

### Product Form Fields
| Field | Type | Required | Notes |
|---|---|---|---|
| Product Name | Text | ✅ | |
| Slug | Text | ✅ | Auto-generated |
| Tagline | Text | ❌ | One-liner pitch |
| Type | Select | ✅ | saas, tool, template, script, mobile_app, other |
| Description | Rich Text | ❌ | Full HTML description |
| Logo | Image | ❌ | Product icon/logo |
| Screenshots | Multi-image | ❌ | Gallery for product page |
| Product URL | URL | ❌ | Live product link |
| Demo URL | URL | ❌ | Demo/trial link |
| Features | Tag input | ❌ | Array of feature highlights |
| Tech Stack | Tag input | ❌ | Technologies used |
| Price | Number | ❌ | null = "Contact for pricing" |
| Pricing Label | Text | ❌ | "Starting at PKR 50,000" |
| Is Featured | Toggle | ❌ | Shown prominently |
| Is Published | Toggle | ✅ | |
| Sort Order | Number | ❌ | |
| Meta Title | Text | ❌ | SEO |
| Meta Description | Textarea | ❌ | SEO |
| OG Image | Image | ❌ | Social share |

### Public Products Page (`/products`)
```blade
{{-- Grid of product cards --}}
Each card:
  - Product logo/icon (square, 80px)
  - Product name (Syne, 22px)
  - Tagline (DM Sans, muted)
  - Type badge (orange pill)
  - [View Product →] button

Filter: By type (All | SaaS | Tools | Templates | Mobile Apps)
Sort: Featured first

Click → goes to /products/{slug}
```

### Product Detail Page (`/products/{slug}`)
```blade
Header: Logo + Name + Tagline + Type badge + [Visit Product] [Request Demo] buttons
Screenshots: Image gallery with lightbox
Features: Grid of feature cards (icon + text)
Tech stack: Pills
Pricing: Price or "Contact for pricing" CTA
Description: Full rich text
Related products (same type, bottom)

SEO: Product schema (SoftwareApplication JSON-LD), unique meta per product
```

---

## 18D. MODULE 14 — ACTIVITY LOGS

### Overview
Every state-changing action in the CRM is recorded automatically via **spatie/laravel-activitylog**. Not manually entered by users. Models use the `LogsActivity` trait — Spatie auto-captures old/new values on create/update/delete.

### What Gets Logged
| Action | When |
|---|---|
| LOGIN / LOGOUT | On auth events |
| CREATE_PROJECT | On project save |
| UPDATE_PROJECT | On any project field change |
| STATUS_CHANGE | Project status transitions |
| DELETE_PROJECT | On deletion |
| UPLOAD_DOCUMENT | File uploaded to project |
| ADD_MESSAGE | Message added to project |
| REVEAL_API_KEY | Admin decrypts API key |
| REVEAL_CREDENTIAL | Admin decrypts credential |
| CREATE_* / UPDATE_* / DELETE_* | All modules |

### Log Entry Data Captured
- User who performed action
- Exact action performed
- Module (categorized)
- Entity ID and human-readable title
- Old value (JSON, before state)
- New value (JSON, after state)
- IP Address
- User Agent (browser)
- Timestamp

### Logs Page Features
- **Filter**: Module, User, Action Type, Date Range
- **Search**: Entity title
- **Pagination**: 50 per page
- **Expandable rows**: Show old/new value diff
- **Export**: CSV of filtered logs (admin only)
- **Retention**: All logs kept indefinitely (or configurable)

---

## 19. CRM DASHBOARD — DESIGN & DATA

### Dashboard Layout
```
┌────────────────────────────────────────────────────────────────┐
│  Good morning, [Name] 👋  |  Sun, 11 May 2026                 │
├────────────────────────────────────────────────────────────────┤
│  STATS CARDS ROW (4 cards)                                     │
│  ┌──────────┐ ┌──────────┐ ┌──────────┐ ┌──────────┐         │
│  │ Projects │ │ This Mo. │ │ This Mo. │ │ Balance  │         │
│  │ Active   │ │ Income   │ │ Expense  │ │ Running  │         │
│  │   12     │ │ 450K PKR │ │ 320K PKR │ │  65K PKR │         │
│  └──────────┘ └──────────┘ └──────────┘ └──────────┘         │
├────────────────────────────────────────────────────────────────┤
│  ROW 2                                                         │
│  ┌───────────────────────────────┐ ┌────────────────────────┐ │
│  │  Income vs Expense (6 months) │ │  Projects by Status    │ │
│  │  Line Chart (Recharts)        │ │  Donut Chart           │ │
│  └───────────────────────────────┘ └────────────────────────┘ │
├────────────────────────────────────────────────────────────────┤
│  ROW 3                                                         │
│  ┌───────────────────────────────┐ ┌────────────────────────┐ │
│  │  Projects Due This Week       │ │  Hosting Renewals Due  │ │
│  │  List with status & deadline  │ │  (Next 30 days)        │ │
│  └───────────────────────────────┘ └────────────────────────┘ │
├────────────────────────────────────────────────────────────────┤
│  ROW 4                                                         │
│  ┌───────────────────────────────┐ ┌────────────────────────┐ │
│  │  Recent Activity Log          │ │  Quick Actions         │ │
│  │  Last 10 entries              │ │  + New Project         │ │
│  │                               │ │  + Add Income          │ │
│  │                               │ │  + Add Expense         │ │
│  └───────────────────────────────┘ └────────────────────────┘ │
└────────────────────────────────────────────────────────────────┘
```

### CRM Navigation (Sidebar — Updated with All Modules)
```
[Redis Solution Logo — white version]
─────────────────────────────────────
📊 Dashboard
─────────────────────────────────────
WORK
  📁 Projects
  💼 Investments
─────────────────────────────────────
FINANCE
  💰 Budget
     ├── Expenses
     └── Income
  ₿  Crypto
─────────────────────────────────────
CLIENTS
  🌐 Hosting Clients
  🎭 Demo Projects
─────────────────────────────────────
VAULT  ⚠️ (admin only)
  🔑 API Keys
  🔒 Credentials
─────────────────────────────────────
WEBSITE  (content-manager+)
  📰 Blog
     ├── Posts
     ├── Categories
     └── Tags
  🖼  Portfolio
  ⭐ Testimonials
  ❓ FAQs
  💬 Contact Messages  [badge: unread count]
  📦 Products  (Phase 2)
─────────────────────────────────────
SEO
  📈 SEO Dashboard         ← health overview + issues
  🗺  Page SEO              ← meta per page
  🌍 Client Sites SEO      ← external client sites
  🗂  Sitemap               ← view/regenerate
  🤖 Robots.txt            ← edit directly
─────────────────────────────────────
TOOLS
  📝 My Notes              ← private per user
  📋 Activity Logs
─────────────────────────────────────
ADMIN  🔐 (super-admin only)
  👥 Users
  🛡  Roles & Permissions
  ⚙️ Settings
─────────────────────────────────────
[User Avatar] [Name] [Role badge]
[Logout]

Sidebar behavior:
  - 260px expanded | 72px collapsed (icon-only)
  - Collapse toggle button at bottom of sidebar
  - Active item: 3px left orange border + orange text
  - Section headers: 10px, uppercase, tracked, muted — NOT clickable
  - Submenu items (Blog, Budget): indent 16px, smaller text
  - Permission-aware: items hidden if user lacks permission (@can in Blade)
  - Contact Messages badge: Livewire real-time count of 'new' messages
```

### CRM Header Bar
```
Left: Breadcrumb (Home > Projects > RS-2026-001)
Center: Global search (Livewire — searches across projects, clients, credentials)
Right: 
  🔔 Notifications bell (unread count badge)
  🌙 Dark/Light mode toggle (Alpine.js + localStorage)
  [User Avatar] dropdown → Profile | Change Password | Logout
```

---

## 20. FRONTEND PUBLIC WEBSITE — ALL PAGES

### Global Website Rules — "Dark Fire Agency" Design
- **Background**: Deep black (#080808) — the entire site lives on black
- **Accent**: Orange ONLY — every interactive element, every highlight
- **Not a blue website** — zero blues used on public site
- All pages share: Custom animated cursor + Navbar + Footer
- Smooth page transitions (Framer Motion `AnimatePresence` with black wipe)
- **Custom cursor**: Small orange dot (12px) that scales to 80px circle on hover over links/buttons — `mix-blend-mode: difference`
- Scroll progress bar at top (orange)
- Lazy loading for all images (next/image)
- Mobile-first responsive (320px → 1920px+)
- **Noise texture**: Subtle SVG grain overlay at 3% opacity on hero — adds film grain depth
- All text content authentic from Redis Solution website
- **No generic stock photos** — use abstract 3D renders or geometric illustrations in orange/black

### Global Cursor Component
```tsx
// components/shared/CustomCursor.tsx
// Small 12px orange dot follows mouse at native speed
// On hover [data-cursor="large"]: expands to 80px, border only
// On hover [data-cursor="text"]: expands, shows "VIEW" or "DRAG"
// mix-blend-mode: difference on light sections
```

---

### PAGE 1: HOME (`/`)

#### Section 1 — HERO (World-Class Standard)
```
Full viewport height — 100vh
Background: Pure black (#080808)
            + Radial orange glow: rgba(255,100,0,0.12) centered at top-center, 
              fades to black by 60% height (creates "burning from top" effect)
            + SVG noise texture overlay at 3% opacity (depth/grain)
            + NO particles — negative space IS the design

Layout: Centered, full-width — NOT split layout (too common, too 2019)

TOP STRIP (small, uppercase, letter-spacing wide):
  "REDIS SOLUTION — INNOVATE. CREATE. SUCCEED."
  Animated: each word fades in with 0.1s stagger

MAIN HEADLINE (Clash Display, 96–128px, white, tight letter-spacing):
  Line 1: "We Build"
  Line 2: "Digital"  ← this word in orange gradient (--gradient-orange-text)
  Line 3: "Excellence."

  Animation: GSAP SplitText — each character drops in from top with spring easing
  Timing: 0.05s stagger per character, starts 0.3s after page load

SUBHEADING (DM Sans, 18px, #A0A0A0, max-width 520px, centered):
  "From Rawalpindi to the world — we craft digital products that
   make businesses unforgettable."
  Animation: Fade in, translateY(20px→0), delay 0.8s

CTAs (appear at 1.0s):
  Primary: [Start a Project →]
    Background: linear-gradient(135deg, #FF8C00, #FF6400)
    Text: white, bold
    Hover: scale(1.04) + box-shadow: --glow-orange-strong
    MAGNETIC EFFECT: button pulls toward cursor within 80px radius
    
  Secondary: [See Our Work ↓]  
    Background: transparent
    Border: 1px solid rgba(255,255,255,0.15)
    Text: white
    Hover: border-color: #FF6400, text: #FF8C00

SCROLL INDICATOR (bottom center):
  Thin vertical line (2px, 60px tall) in white at 30% opacity
  Slowly extends down then fades — CSS animation, infinite
  Below: "SCROLL" in 10px uppercase, tracked wide, muted white

BELOW HERO (appears as user scrolls past 80vh):
  Marquee strip (full width, black bg, orange text):
  "WEBSITE DEVELOPMENT · MOBILE APPS · DIGITAL MARKETING · 
   SOFTWARE DEVELOPMENT · ERP & CMS · AI APPLICATIONS · "
  (repeating, scrolling right to left, 40s loop)
```

#### Section 2 — STATS (Premium Treatment)
```
Background: #0F0F0F (slightly lighter than hero for section separation)
Full-width, large numbers, minimal labels

Layout: 4 stats, each separated by a thin vertical orange line (1px)

Each stat:
  NUMBER: Clash Display, 80px, white — animated count-up with GSAP
          Physics easing: fast start, slow approach to final number (like a ball landing)
          Orange gradient on the number itself
  SUFFIX: (+, %, K) same size, orange
  LABEL:  DM Sans, 14px, #606060, uppercase, tracked wide
  
Stats:
  [100+]         [4+]           [50+]          [100%]
  CLIENTS SERVED  YEARS IN MARKET  TECHNOLOGIES   SATISFACTION

Between sections: thin horizontal orange line, 1px, full width, opacity 0.2
```

#### Section 3 — SERVICES (Accordion/List Style — NOT generic cards)
```
This section breaks convention. Instead of 6 identical cards in a grid,
use a LARGE LIST format (like Locomotive.ca, or Linear's feature list):

Left column (40%):
  Section number: "02" (Clash Display, 120px, #1C1C1C — large, decorative)
  Label: "WHAT WE DO" (10px, orange, tracked)
  Heading (Syne, 48px, white):
    "Services that
     drive results."
  Body (DM Sans, 16px, muted):
    "We combine technology with strategy to build
     products that outlast trends."

Right column (60%):
  6 service items in an ACCORDION list:
  Each item:
    - Number: "01", "02" etc. (14px, orange, monospace)
    - Service name (Syne, 28px, white)
    - Thin horizontal line below
    - On hover: line turns orange, service name slides left 8px, 
      a 2-line description fades in below (smooth height animation)
    - Arrow → appears on right in orange

  Services (same 6, all icons are orange, NOT multicolor):
  01  Website Development
  02  Mobile App Development
  03  Digital Marketing
  04  Software Development
  05  ERP & CMS Development
  06  AI-Based Applications

Right side shows a floating preview card when hovering each service:
  - #1C1C1C card with orange border glow
  - Shows a relevant screenshot or abstract illustration
  - Appears with scale(0.9)→scale(1) + fade animation
```

#### Section 4 — WHY US (Bento Grid Layout)
```
Background: #0A0A0A
Section label: "WHY REDIS SOLUTION" (orange, small, tracked)
Heading (Syne, 52px): "Built different." (white, left-aligned)

Instead of bullet points — use a BENTO GRID of asymmetric cards:
All cards: #141414 bg, 1px border rgba(255,255,255,0.07)
Hover: border glows orange (transition 0.3s)

┌─────────────────────┬────────────┬──────────────────┐
│  100+ Projects      │ NDA First  │  4+ Years        │
│  Delivered (large   │ We sign    │  In Market       │
│  card, tall)        │ before     │  (medium)        │
│                     │ discussing │                  │
│  Orange counter     │ your idea  │                  │
│  animation          │            │                  │
├─────────────────────┴────────────┤ 24/7 Support     │
│  100% Code Ownership             │  Post-launch     │
│  The code is yours from day one  │  maintenance     │
│  (wide card)                     │  included        │
├───────────────┬──────────────────┴──────────────────┤
│ Agile Process │  50+ Technologies Mastered           │
│ Real-time     │  [logos of tech: React, Node,       │
│ updates       │   Laravel, Flutter, AWS, OpenAI...] │
└───────────────┴─────────────────────────────────────┘

Each card entrance: slides in from bottom, staggered by 0.08s (Framer Motion)
```

#### Section 5 — PORTFOLIO (Horizontal Scroll — Market Differentiator)
```
This section uses HORIZONTAL SCROLL on desktop triggered by vertical scroll.
(GSAP ScrollTrigger with pin + horizontal scrub)
On mobile: standard vertical scroll grid.

Section Header (above the horizontal scroll zone):
  "03" (decorative number, large, muted)
  "Selected Work" (Syne, 52px, white)
  "Work that speaks." (DM Sans, muted)

Horizontal scroll container (pinned while user scrolls down):
  5–6 portfolio cards in a row, each 480px wide, full viewport height
  
  Each card (data-cursor="large" with "VIEW" text in cursor):
    Background: #141414
    Top: project category tag in orange (e.g., "WEB DEVELOPMENT")
    Middle: Full-bleed project screenshot image (object-fit: cover)
    Bottom overlay (always visible):
      - Project name (Syne, 24px, white)
      - Client name (DM Sans, 14px, muted)
      - Tech tags (small pills, orange border)
    Hover: image scales to 1.05, overlay darkens, custom cursor shows "VIEW"
    3D tilt on mouse move: max 8deg rotation (VanillaTilt or CSS transform)

After horizontal section ends:
  [View All Work →] full-width CTA button
  Orange gradient background, black text, bold
  Hover: glows orange (--glow-orange-strong)
```

#### Section 6 — TESTIMONIAL + CLIENT LOGOS
```
Background: #0F0F0F

Testimonial (full width, centered, large):
  Giant quotation mark: " (Clash Display, 200px, orange, opacity 0.15)
  overlaid by:
  Quote (Syne, 36px, white, max-width 800px, italic):
    "Redis Solution has been a game-changer for our business.
     Their professionalism and expertise delivered beyond expectations."
  
  Client row below quote:
    [Avatar photo, 48px circular] | [Name bold] [Title, muted] | [5 stars in orange]
    Mark Jensen, CEO — Agnatech

  Fade-in from bottom when scrolled into view

CLIENT LOGO MARQUEE:
  Below testimonial — infinite scrolling marquee (both directions for rhythm):
  Row 1 → (left): client/partner logos, white at 40% opacity, hover: 100% opacity
  Row 2 ← (right): same logos, slightly different speed
  
  Label above: "TRUSTED BY" (10px, orange, tracked)
```

#### Section 7 — INDUSTRIES (Rotating Globe / Tag Cloud)
```
Background: #080808
Label: "INDUSTRIES WE SERVE" (orange, small)
Heading: "No matter your domain." (Syne, 48px, white)

Layout: Large tag cloud / pill grid — pills in different sizes,
NOT in a boring equal grid:

Each pill: #1C1C1C bg, rounded-full, DM Sans 14px
Hover: bg becomes orange gradient, text turns black (inverted) — smooth 0.2s
Pills animate in with stagger from center outward

Industries (10 pills, varying font sizes for visual rhythm):
Healthcare (lg) | E-commerce (xl) | Education (md) | Real Estate (lg)
Finance (md) | Logistics (sm) | Oil & Gas (md) | Shipping (sm)
Point of Sale (lg) | Technology (md)
```

#### Section 8 — PROCESS (Scroll-Driven Numbered Steps)
```
Background: alternates to #0F0F0F for contrast
Label: "HOW IT WORKS" (orange, small, tracked)
Heading: "Simple. Transparent. Effective." (Syne, 48px, white)

4 steps, stacked vertically, each revealed on scroll:
(GSAP ScrollTrigger — each step animates in as it enters viewport)

Each step:
  Left: Large step number (Clash Display, 120px, #1C1C1C) — decorative
  Right: Content
    Step title (Syne, 28px, white)
    Description (DM Sans, 16px, #A0A0A0, 2–3 lines)
    Orange thin line animates drawing in from left (SVG path animation)

Steps:
  01  Discovery & Consultation
      "We start by listening. Your vision, your goals, your challenges.
       We ask the right questions so we build the right solution."

  02  Strategy & Planning
      "Architecture, wireframes, tech stack, timelines.
       No surprises — everything documented and approved by you."

  03  Design & Development
      "Agile sprints, real-time updates. You see progress weekly,
       not just at the end. Feedback drives every iteration."

  04  Launch & Growth
      "Go live with confidence. We stay with you post-launch —
       24/7 support, monitoring, and continuous improvement."

Connecting vertical orange line draws down as user scrolls through steps.
```

#### Section 9 — FINAL CTA (Full-Viewport, Immersive)
```
Full viewport height section (100vh) — makes a STATEMENT
Background: Pure black with large orange radial glow (200% intensity vs hero)
            Orange glow here is MUCH stronger — this is the climax of the page

Center-aligned content:
  Small label: "READY WHEN YOU ARE" (orange, tracked)
  
  Huge headline (Clash Display, 96px on desktop, white):
    "Let's build
     something
     great."
  (The word "great" has orange gradient)
  
  Subtext (DM Sans, 18px, muted):
    "From concept to launch — we're your technology partner."

  Two CTAs stacked on mobile, side by side on desktop:
    [Start a Project →]    — orange gradient button, magnetic, large (56px tall)
    [+92 349 3614440]      — phone link, ghost button with phone icon
  
  Below CTAs: Trust line
    "Free consultation · No commitment · NDA signed before we discuss"
    (12px, #606060, with orange dots between)

FOOTER follows immediately below this section (dark, minimal)
```

---

### PAGE 2: SERVICES (`/services` or `/technology-solutions-...`)

#### Layout
```
HERO: Page title + breadcrumb + abstract tech background
      "Our Services — Crafting Digital Excellence"

Each service gets a full detailed section:

┌─────────────────────────────────────────────────────┐
│  [Left: Large Animated Icon/Illustration]            │
│  [Right: Service Name + Description + Features List] │
└─────────────────────────────────────────────────────┘
(Alternating left-right for each service)

Services covered:
1. Website Development
   - Custom websites, e-commerce, landing pages
   - Stack: React, Next.js, Laravel, WordPress
   - Features: Responsive, SEO-ready, fast performance

2. Mobile App Development
   - iOS, Android, Cross-platform
   - Stack: React Native, Flutter
   - Features: Native performance, offline support

3. Digital Marketing
   - Social media ads, email marketing, content creation
   - Features: Data-driven, KPI-focused, ROI tracking

4. Software Development
   - Custom SaaS, CRM, ERP, APIs
   - Stack: Node.js, Laravel, Python
   - Features: Scalable, secure, maintainable

5. ERP & CMS Development
   - Business process automation
   - Stack: Laravel, WordPress, Custom
   - Features: Multi-module, role-based, reportable

6. AI-Based Applications
   - Chatbots, ML models, automation
   - Stack: Python, OpenAI, LangChain
   - Features: Intelligent, learning, contextual

Technology Stack visual:
  Animated icon grid of all technologies (scroll reveal)
  
CTA: "Not sure what you need? Let's talk." [Get Free Consultation]
```

---

### PAGE 3: ABOUT (`/about` or `/it-companies-islamabad/`)

```
HERO: "About Redis Solution"
      "Your Digital Transformation Partner Since 2020"

Section 1: Our Story
  Split layout — team photo (or office photo) | our story text
  "Founded with a vision to bridge the gap between businesses and technology..."

Section 2: Mission & Vision
  Two cards side by side:
  [Mission Card]: "Provide exceptional digital solutions..."
  [Vision Card]: "Be a global leader in transformative technology..."

Section 3: Core Values
  4-column icon grid:
  Innovation | Client-First | Quality | 24/7 Support

Section 4: Why We're Different
  Stats + achievement highlights
  4 years | 100+ clients | 50+ technologies | 6 core services

Section 5: Team (if photos available)
  Grid of team member cards

Section 6: Location Map embed or visual
  Office: ABC Plaza, 4th Road, Rawalpindi, Pakistan
```

---

### PAGE 4: PORTFOLIO (`/portfolio` or `/top-10-it-companies-...`)

```
HERO: "Our Work Speaks For Itself"
      "Explore projects that drove real business results"

Filter Bar: [All] [Websites] [Mobile Apps] [CRM/ERP] [AI]

Masonry/Grid of all portfolio items:
  - Thumbnail image
  - Category badge
  - Project name
  - Tech stack tags
  - Hover: overlay with "View Case Study" or "Visit Live"

Light box modal on click:
  - Full images/screenshots
  - Project description
  - Challenge + Solution + Result
  - Tech stack used
  - Live URL button (if available)

Stats Banner at bottom:
  "9 Websites | 12 Mobile Apps | 10 Enterprise Systems | 5 AI Projects"
```

---

### PAGE 5: CONTACT (`/contact` or `/best-software-houses...`)

```
HERO: "Let's Build Something Great Together"
      "Reach out — we respond within 24 hours"

Split layout:

LEFT (40%): Contact Info Cards
  📍 Office: ABC Plaza, 4th Road, Commercial Market Rd, Rawalpindi
  📞 Phone: +92 349 3614440
  📧 Email: info@redissolution.com
  💬 WhatsApp: [Quick Chat button]
  
  Social links: LinkedIn | Facebook | Twitter/X

  Working Hours:
  Mon–Fri: 9:00 AM – 6:00 PM (PKT)
  Sat: 10:00 AM – 2:00 PM

RIGHT (60%): Contact Form
  Fields:
  - Full Name *
  - Email Address *
  - Phone Number
  - Company Name
  - Service Interested In (select) *
  - Project Budget (select: <50K, 50K-200K, 200K+, Discuss)
  - Project Details * (textarea, min 50 chars)
  - [Send Message →] button with loading state

  On submit:
  - POST /api/public/contact (Nodemailer → info@redissolution.com)
  - Success message with animation
  - Rate limited (max 3 per IP per hour)

Below form: Quick response badges
  "⚡ Average response: 2 hours"
  "🔒 Your info is confidential"
  "✅ Free consultation included"
```

---

### PAGE 6: FAQs (`/faqs/`)

```
HERO: "Frequently Asked Questions"
      "Everything you need to know about working with us"

Search bar at top: "Search your question..."

Accordion-style FAQ list (animated open/close):
All 13+ FAQs from the website, categorized:

GENERAL:
  1. What services does Redis Solution offer?
  2. Which industries do you serve?
  3. Do you offer free consultations?

TECHNICAL:
  4. What technologies do you use?
  5. Can I see your case studies or portfolio?

PROJECT PROCESS:
  6. How does your development process work?
  7. How do you handle change requests?
  8. How do you estimate project timelines?
  9. What do you need from clients to start?

LEGAL & SECURITY:
  10. Do you sign NDAs?
  11. Who owns the source code?
  12. How do you protect client data?

BILLING:
  13. What payment models do you offer?
  14. Do you offer pilot/PoC projects?

SUPPORT:
  15. What post-launch support do you provide?
  16. How can we communicate during the project?

Still have questions? CTA: "Ask Us Directly" → contact form
```

---

### PAGE 7: PRIVACY POLICY (`/privacy-policy/`)
```
Clean readable layout, legal content
Sections: Data Collection | Usage | Protection | Rights | Contact
Last updated date shown prominently
```

---

### PAGE 8: REFUND POLICY (`/refund-policy/`)
```
Clean readable layout
Sections: Eligibility | Timeframe | Process | Non-refundable items | Contact
```

---

## 21. UI/UX DESIGN SYSTEM — CRM PANEL

### CRM Color Scheme (Consistent with brand)
```
Sidebar bg:          #111111  (dark always, no light mode for sidebar)
Main bg (dark):      #0F0F0F
Main bg (light):     #F5F5F5
Card (dark):         #1A1A1A
Card (light):        #FFFFFF
Border (dark):       rgba(255,255,255,0.08)
Border (light):      rgba(0,0,0,0.08)
Primary accent:      #FF6400  (orange — consistent brand)
Hover accent:        #FF8C00
Text primary dark:   #FFFFFF
Text primary light:  #111111
Text muted dark:     #808080
Text muted light:    #606060
Sidebar links:       #A0A0A0 default | #FFFFFF on hover | orange dot for active
Active nav item:     left 3px solid #FF6400 + bg: rgba(255,100,0,0.08)
```

### Layout
- **Sidebar**: 260px fixed left, collapsible to 72px (icon-only mode)
- **Main content**: Right of sidebar, full height, scrollable
- **Header bar**: 64px, sticky top — breadcrumb + search + notifications + user avatar
- **Page container**: max-width 1400px, px-6 py-8

### Blade Component Library (resources/views/components/)

All CRM UI is built with reusable Blade components + Livewire + Alpine.js.

**Layout Components:**
```blade
<x-admin-layout>          — full CRM layout (sidebar + header + content slot)
<x-page-header>           — page title + breadcrumb + action button slot
<x-card>                  — standard content card (border, rounded, shadow)
<x-stat-card>             — dashboard stat widget (number + label + trend)
```

**Form Components:**
```blade
<x-input>                 — text input with label + error message slot
<x-select>                — select dropdown with label
<x-textarea>              — textarea with label + char counter option
<x-toggle>                — Alpine.js powered toggle switch
<x-file-upload>           — Livewire file upload with progress
<x-date-picker>           — Flatpickr integration
<x-rich-editor>           — Quill.js integration
<x-tag-input>             — comma-separated tag input (Alpine.js)
```

**Data Components:**
```blade
<x-data-table>            — wrapper for Livewire table component
<x-badge status="pending"> — status pill (color auto from status string)
<x-empty-state>           — empty list placeholder with icon + message
<x-pagination>            — styled Laravel pagination links
```

**Interactive Components:**
```blade
<x-modal id="confirm-delete">      — Alpine.js modal (open/close via $dispatch)
<x-confirm-dialog>                 — delete confirmation with item name
<x-reveal-field>                   — masked value + reveal button (vault)
<x-toast>                          — Alpine.js toast notification
<x-dropdown>                       — accessible dropdown menu
```

**Example: Stat Card**
```blade
{{-- resources/views/components/stat-card.blade.php --}}
<div class="stat-card bg-card border border-border rounded-xl p-6">
    <div class="stat-icon text-orange-500 mb-3">{{ $icon }}</div>
    <div class="stat-value text-3xl font-bold text-white">{{ $value }}</div>
    <div class="stat-label text-sm text-muted mt-1">{{ $label }}</div>
    @isset($trend)
    <div class="stat-trend text-xs mt-2 {{ $trend > 0 ? 'text-green-400' : 'text-red-400' }}">
        {{ $trend > 0 ? '↑' : '↓' }} {{ abs($trend) }}% vs last month
    </div>
    @endisset
</div>
```

**Example: Reveal Field (Vault)**
```blade
{{-- resources/views/components/reveal-field.blade.php --}}
<div x-data="{ revealed: false, value: '', timer: null }"
     class="flex items-center gap-2">
    <code class="font-mono text-sm text-muted">
        <span x-show="!revealed">••••••••••••••••</span>
        <span x-show="revealed" x-text="value"></span>
    </code>
    <button @click="
        if(!revealed) {
            fetch('{{ $revealRoute }}', {method:'POST', headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}'}})
              .then(r=>r.json()).then(d=>{ value=d.value; revealed=true; timer=setTimeout(()=>revealed=false, 30000); })
        } else { revealed=false; clearTimeout(timer); }
    " class="btn-icon text-orange-500 hover:text-orange-400">
        <x-heroicon-o-eye class="w-4 h-4" />
    </button>
    <button x-show="revealed" @click="navigator.clipboard.writeText(value)"
            class="btn-icon text-muted hover:text-white">
        <x-heroicon-o-clipboard class="w-4 h-4" />
    </button>
    <span x-show="revealed" class="text-xs text-amber-400">
        Hides in <span x-text="'30s'"></span>
    </span>
</div>
```

### Tables (Livewire)
- Livewire `ProjectsTable` component handles: search, filters, sort, pagination
- Table headers: sortable (click → toggles asc/desc)
- Striped rows: alternating #141414 and #181818 (dark mode)
- Row hover: orange left border highlight
- Pagination: 20/50/100 per page (user selectable, stored in Livewire property)
- Bulk select: checkbox column + bulk action bar appears on selection

### Dark / Light Mode
- Toggle in header → Alpine.js + `document.documentElement.classList.toggle('dark')`
- Preference saved to `localStorage`
- Tailwind dark mode: `class` strategy (`darkMode: 'class'` in tailwind.config.js)
- On page load: read localStorage → apply class before render (no flash)
- Default: dark mode (matches brand — pure black sidebar always)

---

## 22. UI/UX DESIGN SYSTEM — PUBLIC WEBSITE

### Component Patterns

**Navigation (Navbar) — Dark Agency Style**
```
Always: transparent bg with backdrop-blur(8px) 
At top: logo + links visible against dark hero
On scroll >80px: thin 1px border-bottom rgba(255,255,255,0.08) appears
NEVER becomes white/light — the site is always dark

Left: Redis Solution logo (white version — logo-white.png)
      On dark bg, white logo is always legible
Center: nav links (DM Sans, 14px, #A0A0A0)
        Hover: text turns white, with orange underline (2px, scale from left)
        Active: white text + orange dot below link
Right: [Start a Project] button — small, orange outline on scroll
       Becomes orange-filled when scrolled past hero

Mobile: Full-screen overlay menu (black, 100vh × 100vw)
        Triggered by hamburger (2 lines → X morph animation)
        Links appear one by one (Clash Display, 48px, white) 
        with staggered slide-up animation
        Contact info at bottom
```

**Footer — Minimal and Intentional**
```
Background: #080808 (same as site)
Top border: 1px solid rgba(255,255,255,0.08)

Layout:
  Row 1: Logo (white) left | Email + Phone center | Social icons right
  Row 2: Nav links in one line (small, muted)
  Row 3: "© 2026 Redis Solution Pvt. Ltd. — All rights reserved." 
          | "Privacy Policy" | "Refund Policy"

Social icons: outlined circles, hover fills orange
Email: links with orange hover
Phone: tel: link

The footer is deliberately minimal — the page content is the showpiece, 
not the footer. Strip it down to pure information.
```

**Buttons — Orange System Only**
```
Primary: bg: linear-gradient(135deg,#FF8C00,#FF6400) | text: white | bold
         Hover: scale(1.03) + box-shadow: 0 0 60px rgba(255,100,0,0.5)
         Magnetic effect on desktop (pulls toward cursor)
         Border-radius: 6px (not round — we're bold, not bubbly)
         
Ghost: bg: transparent | border: 1px solid rgba(255,255,255,0.2) | text: white
       Hover: border-color: #FF6400 | text: #FF8C00 | bg: rgba(255,100,0,0.05)

Icon-only: Circle 44px | border: 1px solid rgba(255,255,255,0.15)
           Hover: border-color: #FF6400, bg: rgba(255,100,0,0.1)

Text link: text: #A0A0A0 | Hover: text: white | underline: orange
           + → arrow slides right 4px on hover

All: 0.2s cubic-bezier(0.4,0,0.2,1) transition | cursor: none (custom cursor)
ZERO blue buttons anywhere on the public website
```

**Service Cards (Accordion Style)**
```
List item container: border-bottom: 1px solid rgba(255,255,255,0.08)
Number: 14px, orange, monospace, JetBrains Mono
Title: 28px, Syne, white
Hover: title shifts right 8px | border-bottom turns orange
Preview pane: appears to the right (desktop) — dark card #1C1C1C with orange border-glow
```

**Bento Grid Cards**
```
bg: #141414
border: 1px solid rgba(255,255,255,0.06)
border-radius: 16px
padding: 32px
Hover: border-color: rgba(255,140,0,0.4) | box-shadow: 0 0 30px rgba(255,100,0,0.1)
transition: 0.3s ease all
All text: white primary | muted gray secondary | orange for numbers/highlights
```

**Portfolio Cards**
```
bg: #141414
overflow: hidden
border-radius: 12px
Image: 100% width, 260px height, object-fit: cover
       Hover: scale(1.05) 0.5s ease
Bottom content: always visible, dark gradient overlay behind text
Category tag: orange text, 11px, uppercase, tracked
Title: 22px, Syne, white
```

**Section Headers**
```
Small pill label above (e.g., "OUR SERVICES")
Large H2 headline
Subtext paragraph
Pattern: center-aligned for standalone sections, left-aligned for split layouts
```

**Service Cards**
```
White/glass background
Top: Icon in gradient rounded square
Middle: Title + description
Bottom: "Learn More →" link
Hover: translateY(-8px) + shadow intensifies + border glow
Transition: 0.3s cubic-bezier(0.4, 0, 0.2, 1)
```

**Portfolio Grid**
```
CSS Grid, auto-fill, min 300px, gap 24px
Image: object-cover, aspect-ratio 16/9, overflow hidden
Overlay: dark gradient, opacity-0 → opacity-100 on hover
Overlay content: title, tags, view button
Transition: 0.4s ease all
```

---

## 23. ANIMATION STRATEGY

### Public Website Animations — "Dark Fire Agency" Level

| Section | Animation | Library | Trigger | Notes |
|---|---|---|---|---|
| Custom cursor | Orange dot follows mouse, morphs on hover | Vanilla JS + CSS | Always | `mix-blend-mode: difference` on light elements |
| Page load | Black screen wipes away → hero reveals | GSAP timeline | On load | 600ms, smooth |
| Page transitions | Full black wipe covers → new page slides in | Framer Motion AnimatePresence | Route change | 400ms each direction |
| Hero headline | Per-character drop from top (SplitText) | GSAP SplitText + spring | On mount | 0.05s stagger |
| Hero orange glow | Slow pulse (scale 1.0 → 1.15 → 1.0) | CSS keyframes | Continuous | Radial gradient, 4s loop |
| Hero marquee | Continuous left scroll | CSS animation | Continuous | `animation: marquee 40s linear infinite` |
| Scroll progress bar | Width 0% → 100% | CSS / JS | On scroll | 2px, orange, fixed top |
| Stats counters | 0 → target with custom easing curve | GSAP + CustomEase | Viewport enter | "elastic" ease — not linear |
| Services accordion | Height 0 → auto + opacity | CSS + Framer Motion | Click/hover | 0.3s cubic-bezier |
| Services preview card | Scale 0.85 → 1 + fade | Framer Motion | Hover enter | 200ms |
| Bento grid cards | Slide up from 40px, stagger 0.08s | Framer Motion | Viewport enter | whileInView |
| Portfolio horizontal | Pinned panel, horizontal on vertical scroll | GSAP ScrollTrigger | Scroll | Pin section while scrolling |
| Portfolio card tilt | 3D perspective tilt (max 8deg) | VanillaTilt | Mouse move | Glare effect enabled |
| Testimonial | Fade + slide up | Framer Motion | Viewport enter | Simple, dignified |
| Logo marquee | Dual-row, opposite directions | CSS animation | Continuous | 25s and 30s loops |
| Industry pills | Stagger pop-in from center | Framer Motion | Viewport enter | 0.04s stagger |
| Process steps | Slide in + vertical line draws | GSAP ScrollTrigger | Scroll position | Line draws as step enters |
| Final CTA glow | Slow orange pulse — stronger than hero | CSS keyframes | Continuous | More intense than hero glow |
| Magnetic buttons | Pull toward cursor within 80px | Vanilla JS | Mouse move | Transform translate |
| Navbar links | Orange underline scales from left | CSS transform | Hover | 0.25s ease |
| Mobile menu | Full-screen expand + links stagger | Framer Motion | Click | Links: 0.06s stagger |
| Section numbers | Count up when entering viewport | GSAP | Viewport | Decorative, subtle |

### CRM Panel Animations (Minimal — data-focused)
| Element | Animation | Rule |
|---|---|---|
| Sidebar open/close | Width transition 0.2s | Fast, not distracting |
| Modal open | Scale 0.95→1 + fade 0.15s | Subtle |
| Table row appear | Fade in 0.1s | Lightweight |
| Toast notification | Slide in from top-right | react-hot-toast |
| Status badge change | Brief color pulse | CSS |
| Dashboard numbers | Count-up on load | One-time, satisfying |
| Loading skeleton | Shimmer animation | Avoids layout shift |
| Page route change | Fade 0.15s | Clean |

### Performance Rules
- All animations respect `prefers-reduced-motion`
- No animation > 500ms (except page-level transitions)
- `will-change: transform` only on actively animating elements
- Framer Motion lazy-loaded for CRM (not needed server-side)
- Three.js hero loaded asynchronously — page usable before it loads

---

## 24. SECURITY ARCHITECTURE

### Encryption for Vault Modules
```javascript
// AES-256-CBC implementation
const ENCRYPTION_KEY = process.env.ENCRYPTION_KEY; // 32-byte hex key from .env
const IV_LENGTH = 16;

function encrypt(text: string): string {
  const iv = crypto.randomBytes(IV_LENGTH);
  const cipher = crypto.createCipheriv('aes-256-cbc', Buffer.from(ENCRYPTION_KEY, 'hex'), iv);
  const encrypted = Buffer.concat([cipher.update(text), cipher.final()]);
  return iv.toString('hex') + ':' + encrypted.toString('hex');
}

function decrypt(text: string): string {
  const [ivHex, encryptedHex] = text.split(':');
  const iv = Buffer.from(ivHex, 'hex');
  const encrypted = Buffer.from(encryptedHex, 'hex');
  const decipher = crypto.createDecipheriv('aes-256-cbc', Buffer.from(ENCRYPTION_KEY, 'hex'), iv);
  return Buffer.concat([decipher.update(encrypted), decipher.final()]).toString();
}
```

### Security Checklist
- [ ] Helmet.js (HTTP headers: HSTS, CSP, X-Frame-Options, etc.)
- [ ] CORS: whitelist only known origins
- [ ] Rate limiting: 100 req/15min general, 5 req/15min login
- [ ] SQL injection: Prisma parameterized queries — safe by design
- [ ] XSS: Input sanitization on all text fields (DOMPurify server-side)
- [ ] JWT: Short access token (15min) + rotation on refresh
- [ ] Password hashing: bcrypt with rounds=12
- [ ] Sensitive fields: Never logged, never exposed in list endpoints
- [ ] File uploads: Validate MIME type + extension + virus scan (ClamAV optional)
- [ ] HTTPS: Enforced in production (HSTS header)
- [ ] Environment secrets: Never committed to git (.env.example only)
- [ ] DB: Separate read/write user permissions in production

---

## 25. FILE STORAGE & MEDIA MANAGEMENT

### Upload Configuration
```
/uploads
  /projects
    /:projectId
      /documents    → project docs (PDF, DOC, DOCX, XLS, ZIP)
      /messages     → message attachments (images, docs)
  /investments
    /:investmentId
      /receipts     → expense receipts
  /budget
    /receipts       → expense/income proofs
  /demo-projects
    /thumbnails     → preview images
  /users
    /avatars        → user profile photos
  /public
    /portfolio      → portfolio images (managed via CRM for website)
```

### Validation Rules
| Type | Max Size | Allowed Formats |
|---|---|---|
| Documents | 20 MB | PDF, DOC, DOCX, XLS, XLSX, ZIP, RAR |
| Images | 5 MB | JPG, PNG, WEBP, GIF |
| Receipts | 10 MB | JPG, PNG, PDF |
| Thumbnails | 5 MB | JPG, PNG, WEBP |

### Public Website Assets
- All public images → `next/image` with optimization
- Portfolio images → stored in `/uploads/public/portfolio/` served statically
- Logo + favicon → `/public/` (Next.js static)
- Font loading → `next/font` (no FOUT)

---

## 26. NOTIFICATION SYSTEM

### In-App Notifications (CRM)
Triggered automatically by system:
- Project deadline approaching (7 days warning)
- Hosting renewal due (30 days + 7 days warnings)
- API key expiring (if expiry date set, 30 days warning)
- New project message added (if not you)

Implementation:
- Notification model in DB with `isRead` flag
- Bell icon in header with unread count badge
- Dropdown showing last 20 notifications
- Mark all read button

### Email Notifications (via Nodemailer)
- Contact form submission → forwarded to info@redissolution.com
- Project deadline reminder (optional, configurable)
- Hosting renewal reminder (configurable)

---

## 27. FOLDER & FILE STRUCTURE (Laravel)

```
redis-solution/                        ← Laravel project root
│
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Frontend/               ← Public website controllers
│   │   │   │   ├── HomeController.php
│   │   │   │   ├── ServiceController.php
│   │   │   │   ├── AboutController.php
│   │   │   │   ├── PortfolioController.php
│   │   │   │   ├── BlogController.php
│   │   │   │   ├── ProductController.php
│   │   │   │   ├── ContactController.php
│   │   │   │   ├── FaqController.php
│   │   │   │   ├── PageController.php
│   │   │   │   └── SitemapController.php
│   │   │   └── Admin/                ← CRM admin controllers
│   │   │       ├── DashboardController.php
│   │   │       ├── ProjectController.php
│   │   │       ├── ProjectDocumentController.php
│   │   │       ├── ProjectMessageController.php
│   │   │       ├── InvestmentController.php
│   │   │       ├── InvestmentExpenseController.php
│   │   │       ├── BudgetController.php
│   │   │       ├── BudgetExpenseController.php
│   │   │       ├── BudgetIncomeController.php
│   │   │       ├── HostingClientController.php
│   │   │       ├── ApiKeyController.php
│   │   │       ├── CredentialController.php
│   │   │       ├── DemoProjectController.php
│   │   │       ├── CryptoController.php
│   │   │       ├── NoteController.php
│   │   │       ├── BlogPostController.php
│   │   │       ├── BlogCategoryController.php
│   │   │       ├── BlogTagController.php
│   │   │       ├── AdminPortfolioController.php
│   │   │       ├── TestimonialController.php
│   │   │       ├── AdminFaqController.php
│   │   │       ├── ContactMessageController.php
│   │   │       ├── AdminProductController.php
│   │   │       ├── SeoController.php
│   │   │       ├── PageSeoController.php
│   │   │       ├── WebsiteSeoStateController.php
│   │   │       ├── RobotsController.php
│   │   │       ├── ActivityLogController.php
│   │   │       ├── UserController.php
│   │   │       └── RoleController.php
│   │   ├── Requests/                 ← Form Request validators (one per form)
│   │   │   ├── StoreProjectRequest.php
│   │   │   ├── StoreBlogPostRequest.php
│   │   │   └── ...
│   │   └── Middleware/
│   │       └── RecordLastLogin.php
│   │
│   ├── Livewire/                     ← Livewire reactive components
│   │   ├── Projects/
│   │   │   ├── ProjectsTable.php     ← sortable/filterable project list
│   │   │   └── KanbanBoard.php       ← drag-drop kanban
│   │   ├── Budget/
│   │   │   ├── BudgetDashboard.php
│   │   │   ├── ExpensesTable.php
│   │   │   └── IncomesTable.php
│   │   ├── Blog/
│   │   │   ├── PostsTable.php
│   │   │   └── PostEditor.php
│   │   ├── Hosting/
│   │   │   └── HostingTable.php
│   │   ├── Vault/
│   │   │   ├── ApiKeysTable.php
│   │   │   └── CredentialsTable.php
│   │   ├── Seo/
│   │   │   └── SeoDashboard.php      ← real-time issues checker
│   │   ├── Dashboard/
│   │   │   └── DashboardWidgets.php  ← auto-refresh every 60s
│   │   └── Notifications/
│   │       └── NotificationBell.php  ← real-time unread count
│   │
│   ├── Models/
│   │   ├── User.php                  ← HasRoles (Spatie), HasFactory
│   │   ├── Project.php               ← LogsActivity, SoftDeletes
│   │   ├── ProjectDocument.php
│   │   ├── ProjectMessage.php
│   │   ├── Investment.php
│   │   ├── InvestmentExpense.php
│   │   ├── BudgetExpense.php
│   │   ├── BudgetIncome.php
│   │   ├── HostingClient.php
│   │   ├── ApiKey.php                ← encrypt/decrypt in getKeyValueAttribute
│   │   ├── Credential.php            ← encrypt/decrypt in getPasswordAttribute
│   │   ├── DemoProject.php
│   │   ├── CryptoInvestment.php
│   │   ├── PersonalNote.php
│   │   ├── BlogPost.php              ← LogsActivity, SoftDeletes
│   │   ├── BlogCategory.php
│   │   ├── BlogTag.php
│   │   ├── PortfolioItem.php
│   │   ├── Testimonial.php
│   │   ├── Faq.php
│   │   ├── ContactMessage.php
│   │   ├── Product.php
│   │   ├── PageSeoMeta.php
│   │   └── WebsiteSeoState.php
│   │
│   ├── Services/
│   │   ├── SeoAuditService.php       ← own-site SEO issue detection
│   │   ├── SitemapService.php        ← sitemap generation logic
│   │   └── RenewalAlertService.php   ← hosting renewal checks
│   │
│   ├── Mail/
│   │   ├── ContactFormMail.php       ← triggered by contact form
│   │   ├── RenewalReminderMail.php   ← hosting renewal alert
│   │   └── WelcomeUserMail.php
│   │
│   ├── Jobs/
│   │   ├── ProcessUploadedImage.php  ← resize + optimize (queued)
│   │   └── RefreshSitemap.php        ← queued sitemap refresh
│   │
│   └── Console/Commands/
│       ├── CheckRenewals.php         ← php artisan renewals:check (scheduled daily)
│       └── RegenerateSitemap.php     ← php artisan sitemap:generate
│
├── resources/
│   ├── views/
│   │   ├── layouts/
│   │   │   ├── public.blade.php      ← Public website layout (navbar + footer)
│   │   │   └── admin.blade.php       ← CRM layout (sidebar + header + content)
│   │   │
│   │   ├── components/               ← Blade components (x-component-name)
│   │   │   ├── public/
│   │   │   │   ├── navbar.blade.php
│   │   │   │   ├── footer.blade.php
│   │   │   │   └── custom-cursor.blade.php
│   │   │   └── admin/
│   │   │       ├── sidebar.blade.php
│   │   │       ├── header.blade.php
│   │   │       ├── stat-card.blade.php
│   │   │       ├── data-table.blade.php
│   │   │       ├── badge.blade.php
│   │   │       ├── modal.blade.php
│   │   │       ├── confirm-dialog.blade.php
│   │   │       ├── reveal-field.blade.php
│   │   │       ├── file-upload.blade.php
│   │   │       ├── input.blade.php
│   │   │       ├── select.blade.php
│   │   │       ├── textarea.blade.php
│   │   │       ├── toggle.blade.php
│   │   │       ├── tag-input.blade.php
│   │   │       ├── rich-editor.blade.php
│   │   │       └── page-header.blade.php
│   │   │
│   │   ├── frontend/                 ← Public website pages
│   │   │   ├── home/
│   │   │   │   ├── index.blade.php   ← homepage (all 9 sections)
│   │   │   │   └── partials/
│   │   │   │       ├── _hero.blade.php
│   │   │   │       ├── _stats.blade.php
│   │   │   │       ├── _services.blade.php
│   │   │   │       ├── _why-us.blade.php
│   │   │   │       ├── _portfolio.blade.php
│   │   │   │       ├── _testimonial.blade.php
│   │   │   │       ├── _industries.blade.php
│   │   │   │       ├── _process.blade.php
│   │   │   │       └── _cta.blade.php
│   │   │   ├── services/index.blade.php
│   │   │   ├── about/index.blade.php
│   │   │   ├── portfolio/
│   │   │   │   ├── index.blade.php
│   │   │   │   └── show.blade.php
│   │   │   ├── contact/index.blade.php
│   │   │   ├── faqs/index.blade.php
│   │   │   ├── blog/
│   │   │   │   ├── index.blade.php
│   │   │   │   └── show.blade.php
│   │   │   ├── products/             ← Phase 2
│   │   │   │   ├── index.blade.php
│   │   │   │   └── show.blade.php
│   │   │   ├── privacy-policy.blade.php
│   │   │   └── refund-policy.blade.php
│   │   │
│   │   ├── backend/                  ← CRM panel pages
│   │   │   ├── dashboard/index.blade.php
│   │   │   ├── auth/
│   │   │   │   ├── login.blade.php   ← dark-themed Breeze login
│   │   │   │   └── forgot-password.blade.php
│   │   │   ├── projects/
│   │   │   │   ├── index.blade.php   ← uses Livewire ProjectsTable
│   │   │   │   ├── show.blade.php    ← tabs: overview, docs, messages
│   │   │   │   ├── create.blade.php
│   │   │   │   └── edit.blade.php
│   │   │   ├── investments/ ...
│   │   │   ├── budget/ ...
│   │   │   ├── hosting/ ...
│   │   │   ├── api-keys/ ...
│   │   │   ├── credentials/ ...
│   │   │   ├── demo-projects/ ...
│   │   │   ├── crypto/ ...
│   │   │   ├── notes/ ...
│   │   │   ├── blog/
│   │   │   │   ├── posts/
│   │   │   │   │   ├── index.blade.php
│   │   │   │   │   ├── create.blade.php   ← Quill.js + SEO tab
│   │   │   │   │   └── edit.blade.php
│   │   │   │   ├── categories/ ...
│   │   │   │   └── tags/ ...
│   │   │   ├── portfolio/ ...
│   │   │   ├── testimonials/ ...
│   │   │   ├── faqs/ ...
│   │   │   ├── contact-messages/ ...
│   │   │   ├── products/ ...          ← Phase 2
│   │   │   ├── seo/
│   │   │   │   ├── dashboard.blade.php
│   │   │   │   ├── pages.blade.php    ← edit per-page meta
│   │   │   │   ├── client-sites/ ...
│   │   │   │   ├── sitemap.blade.php
│   │   │   │   └── robots.blade.php
│   │   │   ├── logs/index.blade.php
│   │   │   ├── users/ ...
│   │   │   └── roles/
│   │   │       ├── index.blade.php
│   │   │       ├── create.blade.php  ← role name + permission checkboxes
│   │   │       └── edit.blade.php
│   │   │
│   │   └── livewire/                 ← Livewire component views
│   │       ├── projects/
│   │       │   ├── projects-table.blade.php
│   │       │   └── kanban-board.blade.php
│   │       ├── budget/ ...
│   │       ├── seo/
│   │       │   └── seo-dashboard.blade.php
│   │       └── ...
│   │
│   ├── css/
│   │   ├── app.css                   ← Tailwind directives + custom CSS
│   │   ├── public.css                ← Public website animations CSS
│   │   └── admin.css                 ← CRM-specific styles
│   │
│   └── js/
│       ├── bootstrap.js              ← GLOBAL JS SERVICE (ALREADY EXISTS — do not rename)
│       │                               Exports: window.axios, window.swal, window.toast
│       │                               This is the app-wide alert/HTTP service bootstrap
│       ├── app.js                    ← CRM entry point: import bootstrap + Alpine (ALREADY EXISTS)
│       ├── public.js                 ← Public website entry: import bootstrap + GSAP + Alpine
│       ├── frontend/
│       │   ├── cursor.js             ← Custom cursor logic
│       │   ├── magnetic.js           ← Magnetic button effect
│       │   ├── animations.js         ← GSAP ScrollTrigger setup
│       │   └── marquee.js            ← Logo/text marquee
│       └── backend/
│           ├── charts.js             ← ApexCharts initialization
│           └── quill.js              ← Quill.js editor config + toolbar
│
├── routes/
│   ├── web.php                       ← Public website routes
│   ├── admin.php                     ← CRM admin routes (registered in RouteServiceProvider)
│   └── auth.php                      ← Breeze auth routes
│
├── database/
│   ├── migrations/                   ← All migration files
│   └── seeders/
│       ├── DatabaseSeeder.php
│       ├── RolesAndPermissionsSeeder.php  ← Creates default roles + permissions
│       ├── UserSeeder.php                 ← Creates super-admin user
│       ├── PageSeoMetaSeeder.php          ← Creates page_seo_meta rows
│       └── FaqSeeder.php                 ← Seeds initial FAQs
│
├── public/
│   ├── favicon.ico → (symlink or copy from assets/brand/)
│   ├── robots.txt  ← managed via admin, writable
│   └── build/      ← Vite compiled assets
│
├── storage/
│   └── app/
│       └── public/
│           ├── projects/             ← project documents
│           ├── blog/                 ← blog featured images
│           ├── portfolio/            ← portfolio thumbnails + gallery
│           ├── products/             ← product logos + screenshots
│           ├── avatars/              ← user avatars
│           └── general/             ← misc uploads
│
├── assets/brand/                     ← DOWNLOADED brand assets (not public)
│   ├── logo-main.png
│   ├── logo-white.png
│   └── ...
│
├── .env
├── .env.example
├── composer.json
├── package.json
├── vite.config.js
├── tailwind.config.js
└── artisan
```

---

## 28. DEVELOPMENT PHASES & TIMELINE (Laravel)

### Phase 1 — Laravel Foundation (Week 1-2)
- [ ] `composer create-project laravel/laravel redis-solution`
- [ ] Configure MySQL + `.env` + Redis connection
- [ ] `composer require laravel/breeze` → `php artisan breeze:install blade`
- [ ] Customize Breeze login page to dark CRM theme
- [ ] `composer require spatie/laravel-permission` → publish + migrate
- [ ] `composer require spatie/laravel-activitylog` → publish + configure
- [ ] `composer require artesaos/seotools spatie/laravel-sitemap`
- [ ] `composer require spatie/laravel-media-library intervention/image maatwebsite/excel`
- [ ] Create `routes/admin.php` + register in `RouteServiceProvider`
- [ ] Blade layout files: `layouts/frontend.blade.php` + `layouts/backend.blade.php`
- [ ] Admin sidebar + header Blade components
- [ ] Vite config: Tailwind + Alpine.js + GSAP + ApexCharts
- [ ] Run migrations for all custom tables
- [ ] `RolesAndPermissionsSeeder` — seed default roles + all permission strings
- [ ] `UserSeeder` — create super-admin user
- [ ] `PageSeoMetaSeeder` — seed all public pages with blank SEO rows

### Phase 2 — CRM Core Modules (Week 3-5)
- [ ] Dashboard controller + Livewire `DashboardWidgets` component
- [ ] Projects: controller, Livewire table, kanban board, detail page (tabs), documents upload, messages thread
- [ ] Investments: controller, Livewire table, expense sub-module
- [ ] Budget: controller, Livewire expense + income tables, ApexCharts monthly P&L, export (maatwebsite/excel)
- [ ] Hosting Clients: controller, Livewire table, renewal due alerts
- [ ] All Blade component library: `x-stat-card`, `x-badge`, `x-modal`, `x-data-table`, `x-page-header`

### Phase 3 — Vault, Tools & Remaining CRM (Week 6-7)
- [ ] API Keys: controller, Livewire table, reveal endpoint (permission-gated, logged by activitylog)
- [ ] Credentials: controller, Livewire table, reveal endpoint
- [ ] Demo Projects: controller, Livewire table, thumbnail upload
- [ ] Crypto Investment: controller, Livewire table, portfolio summary
- [ ] Personal Notes: controller, Livewire table, Quill.js editor, strict user_id isolation
- [ ] Activity Logs: Livewire filterable table, permission-gated

### Phase 4 — Roles, Users & SEO Dashboard (Week 8)
- [ ] Users management: CRUD, role assignment, activate/deactivate (super-admin only)
- [ ] Roles management: create role, permission checkbox matrix, assign to users
- [ ] Spatie `@can`/`@role` applied to ALL sidebar menu items and all routes
- [ ] SEO Dashboard: `SeoAuditService` issues detection, own-site page meta table, sitemap UI, robots.txt editor
- [ ] `PageSeoController` — edit per-page SEO from CRM
- [ ] Client Sites SEO: `WebsiteSeoStateController` CRUD

### Phase 5 — Blog + Website Content Management (Week 9-10)
- [ ] Blog system: `BlogPostController`, Livewire `PostsTable`, Quill.js editor, category + tag CRUD
- [ ] Blog post SEO tab (meta, OG, canonical, JSON-LD)
- [ ] Portfolio management: CRUD + image gallery upload
- [ ] Testimonials management: CRUD + avatar upload
- [ ] FAQs management: CRUD + sort order drag
- [ ] Contact Messages: inbox view + status management + email notification
- [ ] `ContactFormMail` Mailable + queued dispatch on form submission

### Phase 6 — Public Website (Week 11-13)
- [ ] Public layout with custom cursor (Blade partial + vanilla JS)
- [ ] Navbar (transparent→scroll behavior) + Footer
- [ ] Home page: all 9 sections as Blade partials (\_hero, \_stats, \_services, \_why-us, \_portfolio, \_testimonial, \_industries, \_process, \_cta)
- [ ] GSAP + ScrollTrigger animations for all sections
- [ ] Magnetic button JS + character split text hero animation
- [ ] Horizontal scroll portfolio section (GSAP ScrollTrigger pin)
- [ ] Services page (accordion hover + preview card)
- [ ] About page
- [ ] Portfolio page (grid + lightbox) + Portfolio detail (case study)
- [ ] Contact page (form → `ContactController@store` → queued mail)
- [ ] FAQs page (Alpine.js accordion, seeded from DB)
- [ ] Blog listing + blog post pages (SEO-complete, view counter)
- [ ] Privacy Policy + Refund Policy static pages
- [ ] `artesaos/seotools` wired to each page + per-page DB meta
- [ ] Sitemap auto-generation: `spatie/laravel-sitemap` + scheduled daily refresh
- [ ] Robots.txt served dynamically from `public/robots.txt`

### Phase 7 — Products (Phase 2) (Week 14)
- [ ] `Product` model + migration + seeder
- [ ] `Backend\ProductController` — CRUD with screenshot gallery upload
- [ ] Public `/products` listing page (Blade)
- [ ] Public `/products/{slug}` detail page with screenshots, features, CTA
- [ ] Products SEO per-product meta
- [ ] Sitemap updated to include product URLs

### Phase 8 — QA, Polish & Deployment (Week 15-16)
- [ ] Full responsive test (320px → 1920px), all browsers
- [ ] Lighthouse audit: Public website ≥90 Performance, 100 SEO score
- [ ] `php artisan telescope:install` (dev) + Sentry (prod) error monitoring
- [ ] Laravel Telescope for dev debugging
- [ ] Nginx config (single server, PHP-FPM)
- [ ] SSL: Let's Encrypt certbot
- [ ] Laravel Scheduler: add to server cron (`* * * * * cd /path && php artisan schedule:run`)
- [ ] Supervisor config for queue worker
- [ ] `.env.production` — APP_DEBUG=false, APP_ENV=production
- [ ] `php artisan optimize` + `php artisan view:cache` + `php artisan config:cache`
- [ ] GitHub Actions CI: run tests + deploy on push to main

---

## 29. ENVIRONMENT & DEPLOYMENT (Laravel)

### .env Configuration
```bash
APP_NAME="Redis Solution"
APP_ENV=production
APP_KEY=base64:<generated-by-artisan-key-generate>
APP_DEBUG=false
APP_URL=https://redissolution.com

LOG_CHANNEL=stack
LOG_LEVEL=error

# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=redis_solution
DB_USERNAME=redis_db_user
DB_PASSWORD=<strong-password>

# Redis (sessions + cache + queues)
REDIS_HOST=127.0.0.1
REDIS_PORT=6379
REDIS_PASSWORD=null

CACHE_DRIVER=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=redis

# Email (SMTP)
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=info@redissolution.com
MAIL_PASSWORD=<gmail-app-password>
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=info@redissolution.com
MAIL_FROM_NAME="Redis Solution"

# File Storage
FILESYSTEM_DISK=public

# Spatie Activity Log
ACTIVITY_LOGGER_ENABLED=true

# SEO Tools (artesaos/seotools)
# Configured in config/seotools.php

# Google Analytics (for SEO dashboard)
GOOGLE_ANALYTICS_ID=G-XXXXXXXX         # optional — shows in SEO dashboard
GOOGLE_SEARCH_CONSOLE_VERIFIED=true    # flag only

# Vault Encryption Key (separate from APP_KEY — for API keys + credentials)
VAULT_KEY=<64-char-hex — generated via: php artisan key:generate --show | base64>
```

### Nginx Configuration (Single Laravel App — All in One)
```nginx
server {
    listen 80;
    server_name redissolution.com www.redissolution.com;
    return 301 https://$host$request_uri;
}

server {
    listen 443 ssl http2;
    server_name redissolution.com www.redissolution.com;

    ssl_certificate     /etc/letsencrypt/live/redissolution.com/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/redissolution.com/privkey.pem;

    root /var/www/redis-solution/public;
    index index.php;

    # Security headers
    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";
    add_header X-XSS-Protection "1; mode=block";
    add_header Referrer-Policy "strict-origin-when-cross-origin";

    # Block direct access to /admin from certain countries (optional)
    # add_header Content-Security-Policy "...";

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.5-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }

    # Cache static assets
    location ~* \.(js|css|png|jpg|jpeg|gif|ico|svg|woff2)$ {
        expires 1y;
        add_header Cache-Control "public, immutable";
    }
}
```

### Supervisor Config (Queue Worker)
```ini
[program:redis-solution-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/redis-solution/artisan queue:work redis --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=www-data
numprocs=2
redirect_stderr=true
stdout_logfile=/var/log/redis-solution-worker.log
stopwaitsecs=3600
```

### Laravel Cron (Server crontab)
```
* * * * * cd /var/www/redis-solution && php artisan schedule:run >> /dev/null 2>&1
```

Laravel Scheduler handles:
- `daily` → `php artisan sitemap:generate`
- `daily` → `php artisan renewals:check` (hosting client alerts)
- `weekly` → SEO audit report generation

### Deployment Steps (Production)
```bash
git pull origin main
composer install --optimize-autoloader --no-dev
npm install && npm run build
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
php artisan storage:link
sudo supervisorctl restart redis-solution-worker:*
```

### Deployment Architecture
```
redissolution.com           → Laravel App (public/ folder)
redissolution.com/admin/*   → CRM Panel (same app, different routes)

Single VPS / shared hosting running:
  - PHP 8.5 + PHP-FPM
  - Nginx
  - MySQL 8.0
  - Redis 7
  - Supervisor (queue workers)
  - Let's Encrypt SSL

No separate servers needed. One Laravel app handles everything.
```

---

## APPENDIX: SPREADSHEET → CRM MODULE MAPPING

| Google Sheet Tab | CRM Module | Enhancement |
|---|---|---|
| Received | Budget → Income | Source categorization, proof uploads, search |
| Personal Expense | Budget → Expenses | Type categories, charts, monthly P&L |
| Investments | Investments | Full expense tracking, output logging |
| Crypto Investment | Crypto Investment | Portfolio summary, coin breakdown |
| Project Payments | Projects (cost field) | Full project context, documents, messages |
| Redis Solution | Dashboard + All modules | Real-time dashboard replaces manual tracking |
| Demo Projects | Demo Projects | URL, thumbnails, public/private toggle |
| Hosted Sites | Hosting Clients | Renewal alerts, cost tracking |
| API Keys | API Keys Vault | AES-256 encrypted, role-controlled reveal |

---

## APPENDIX: QUICK WINS — EXCEL PAIN POINTS SOLVED

| Pain Point | CRM Solution |
|---|---|
| Manual sum formulas | Auto-calculated totals everywhere |
| No drill-down on totals | Click any total to see individual entries |
| No audit trail who changed what | Full activity log on every change |
| Credentials in plain text files | AES-256 encrypted vault, reveal-on-demand |
| API keys scattered | Categorized encrypted vault with metadata |
| Hosting renewals forgotten | Automatic "due in X days" alerts |
| No search across data | Global search + module-level filters |
| No mobile access | Fully responsive CRM (tablet-friendly) |
| No role control | SUPER_ADMIN / ADMIN / STAFF roles |
| Project communication lost | Sequential message thread per project |

---

---

## 30. MODULE 15 — SETTINGS (System Configuration Center)

### Overview
A centralized settings panel under `/admin/settings` with multiple tabs. Everything configurable from the UI — no `.env` editing needed for operational settings. Stored in a `settings` key-value table in DB.

### Settings Storage Pattern
```php
// settings table: key (PK) | value (TEXT) | type | group
// Access anywhere in Laravel:
Setting::get('smtp_host')                    // get single value
Setting::get('smtp_password', 'default')     // with fallback
Setting::set('general_phone', '+92 349...')  // save value
Setting::getGroup('smtp')                    // all SMTP settings as array

// Global Blade helper (injected via AppServiceProvider → View::share):
// {{ setting('general_phone') }}
// {{ setting('general_email') }}
```

```php
Schema::create('settings', function (Blueprint $table) {
    $table->string('key')->primary();
    $table->text('value')->nullable();
    $table->string('type')->default('text'); // text, boolean, json, encrypted, image
    $table->string('group');                 // general, smtp, notification, seo, recaptcha
    $table->timestamps();
});
```

---

### TAB 1 — General Settings
**Route:** `/admin/settings/general`

| Setting Key | Label | Type | Notes |
|---|---|---|---|
| `general_company_name` | Company Name | Text | Shown in emails, footer |
| `general_tagline` | Tagline | Text | "INNOVATE. CREATE. SUCCEED." |
| `general_email` | Contact Email | Email | Public contact email |
| `general_phone` | Phone Number | Text | +92 349 3614440 |
| `general_whatsapp` | WhatsApp Number | Text | With country code |
| `general_address` | Office Address | Textarea | Full address |
| `general_google_maps_url` | Google Maps Link | URL | Embed link |
| `general_facebook` | Facebook URL | URL | |
| `general_twitter` | Twitter/X URL | URL | |
| `general_linkedin` | LinkedIn URL | URL | |
| `general_instagram` | Instagram URL | URL | |
| `general_youtube` | YouTube URL | URL | Optional |
| `general_ga_id` | Google Analytics ID | Text | G-XXXXXXXX |
| `general_copyright` | Copyright Text | Text | "© 2026 Redis Solution" |
| `general_meta_pixel` | Facebook Pixel ID | Text | Optional |

**How used:** All public Blade pages read these via `setting('general_phone')`. Change here → instantly reflected everywhere on the website.

---

### TAB 2 — SMTP Settings
**Route:** `/admin/settings/smtp`

| Setting Key | Label | Type | Notes |
|---|---|---|---|
| `smtp_driver` | Mail Driver | Select | smtp, sendmail, mailgun, log |
| `smtp_host` | SMTP Host | Text | smtp.gmail.com |
| `smtp_port` | SMTP Port | Number | 587 |
| `smtp_username` | SMTP Username | Text | |
| `smtp_password` | SMTP Password | Password | Stored encrypted |
| `smtp_encryption` | Encryption | Select | tls, ssl, none |
| `smtp_from_address` | From Email | Email | |
| `smtp_from_name` | From Name | Text | "Redis Solution" |

**Test Email Feature:**
```
[Send Test Email] button
→ Livewire method: sends a test mail to currently logged-in user's email
→ Shows success/fail toast immediately
→ Tests the entire SMTP config without leaving the page
```

**How it works:** On save, Laravel's `config()` is updated dynamically for the session:
```php
Config::set('mail.mailers.smtp.host', Setting::get('smtp_host'));
// ... etc. — so test email uses the NEW settings immediately
```

---

### TAB 3 — Email Templates
**Route:** `/admin/settings/email-templates`

A full email template management system. Every system email that Laravel sends can have its template customized from here — subject + HTML body with variable placeholders.

#### Email Template Table Schema
```php
Schema::create('email_templates', function (Blueprint $table) {
    $table->id();
    $table->string('name');               // "Contact Form Auto-Reply"
    $table->string('slug')->unique();     // 'contact-auto-reply' — used in code
    $table->string('subject');            // "We received your message, {client_name}!"
    $table->longText('body');             // Full HTML — editable in Quill.js
    $table->json('variables');            // [{key:'client_name',desc:'Sender name'}, ...]
    $table->boolean('is_system')->default(true); // system = can't delete, only edit
    $table->timestamps();
});
```

#### System Email Templates (Pre-seeded, Slug → Event)

| Slug | Name | Trigger | Available Variables |
|---|---|---|---|
| `contact-auto-reply` | Contact Form — Auto Reply to Sender | Contact form submitted | `{client_name}`, `{client_email}`, `{message}`, `{company_name}`, `{company_phone}` |
| `contact-admin-notify` | Contact Form — Admin Notification | Contact form submitted | `{client_name}`, `{client_email}`, `{client_phone}`, `{service_interest}`, `{budget}`, `{message}`, `{submitted_at}` |
| `contact-reply` | Contact Message — Manual Reply | Admin replies from CRM | `{client_name}`, `{original_message}`, `{reply_body}`, `{admin_name}`, `{company_name}` |
| `hosting-renewal-30d` | Hosting Renewal — 30 Days Warning | Scheduler daily check | `{client_name}`, `{domain}`, `{renewal_date}`, `{days_left}`, `{amount}`, `{company_email}` |
| `hosting-renewal-7d` | Hosting Renewal — 7 Days Warning | Same trigger | Same variables |
| `project-deadline-7d` | Project Deadline — 7 Days | Scheduler | `{project_title}`, `{client_name}`, `{deadline}`, `{developer_name}`, `{project_url}` |
| `welcome-user` | New User Welcome | User created by admin | `{user_name}`, `{user_email}`, `{temp_password}`, `{login_url}`, `{company_name}` |
| `password-reset` | Password Reset | Forgot password | `{user_name}`, `{reset_link}`, `{expires_in}` |
| `proposal-sent` | Proposal Sent to Client | Proposal emailed | `{client_name}`, `{proposal_number}`, `{project_title}`, `{valid_until}`, `{view_link}` |

#### Template Editor UI
```
Template List (left panel):
  List of all templates with slug + name
  Click → loads in editor (right panel)

Editor (right panel):
  Subject: [text input with variable chips clickable]
  Body: [Quill.js rich editor]
  
  Below editor:
  "Available Variables — click to insert:"
  [{client_name}] [{client_email}] [{message}] ... (orange pill chips)
  Clicking a chip inserts the variable at cursor position in Quill.js

  [Preview Email] — renders the template with dummy data in a modal
  [Reset to Default] — restores original seeded template
  [Save Template] — saves subject + body
```

#### How Templates Are Used in Code
```php
// In ContactController:
$template = EmailTemplate::where('slug', 'contact-auto-reply')->first();

Mail::send([], [], function ($message) use ($template, $contact) {
    $subject = str_replace(
        ['{client_name}', '{company_name}'],
        [$contact->full_name, setting('general_company_name')],
        $template->subject
    );
    $body = str_replace(
        ['{client_name}', '{message}', '{company_phone}'],
        [$contact->full_name, $contact->message, setting('general_phone')],
        $template->body
    );
    $message->to($contact->email)->subject($subject)->html($body);
});
```

---

### TAB 4 — Notification Settings
**Route:** `/admin/settings/notifications`

Control which system events trigger in-app notifications vs emails.

#### Notification Settings Schema
```php
Schema::create('notification_settings', function (Blueprint $table) {
    $table->string('event_key')->primary();  // 'new_contact_message'
    $table->string('label');                 // "New Contact Message"
    $table->string('description')->nullable();
    $table->boolean('in_app_enabled')->default(true);
    $table->boolean('email_enabled')->default(true);
    $table->timestamps();
});
```

#### Notification Events (Pre-seeded)

| Event Key | Label | In-App | Email |
|---|---|---|---|
| `new_contact_message` | New Contact Form Message | ✅ On | ✅ On |
| `hosting_renewal_30d` | Hosting Renewal — 30 Days | ✅ On | ✅ On |
| `hosting_renewal_7d` | Hosting Renewal — 7 Days | ✅ On | ✅ On |
| `project_deadline_7d` | Project Deadline — 7 Days | ✅ On | ❌ Off |
| `proposal_viewed` | Proposal Viewed by Client | ✅ On | ✅ On |
| `proposal_accepted` | Proposal Accepted | ✅ On | ✅ On |
| `new_user_created` | New User Added to System | ✅ On | ❌ Off |

#### Notification Settings UI
```
Table layout (one row per event):
Event            | Description            | In-App 🔔 | Email 📧
─────────────────────────────────────────────────────────────
New Contact Msg  | When contact form...   | [ON  ●]   | [ON  ●]
Hosting 30-Day   | 30 days before renewal | [ON  ●]   | [ON  ●]
Hosting 7-Day    | 7 days before renewal  | [ON  ●]   | [ON  ●]
Project Deadline | 7 days before deadline | [ON  ●]   | [OFF ○]
...

Each toggle: Alpine.js toggle + Livewire auto-save on change
```

#### In-App Notifications Table
```php
Schema::create('system_notifications', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // who sees it
    $table->string('event_key');
    $table->string('title');
    $table->text('body')->nullable();
    $table->string('action_url')->nullable(); // link to go to
    $table->string('icon')->nullable();       // icon name
    $table->boolean('is_read')->default(false);
    $table->timestamp('read_at')->nullable();
    $table->timestamps();
});
```

Notifications shown in the **header bell icon** (Livewire `NotificationBell` component) — polls every 30 seconds via Livewire polling, shows unread count badge, dropdown with last 15 notifications.

---

### TAB 5 — reCAPTCHA / Anti-Bot Settings
**Route:** Subsection of General or its own tab

| Setting Key | Label | Notes |
|---|---|---|
| `recaptcha_enabled` | Enable reCAPTCHA | Toggle — on/off for contact form |
| `recaptcha_site_key` | reCAPTCHA Site Key | From Google reCAPTCHA console |
| `recaptcha_secret_key` | reCAPTCHA Secret Key | Stored encrypted |
| `recaptcha_version` | Version | v2 (checkbox) or v3 (invisible) |
| `recaptcha_threshold` | v3 Score Threshold | 0.0–1.0, default 0.5 |
| `honeypot_enabled` | Enable Honeypot | Hidden field trap (always on recommended) |

---

## 31. ANTI-BOT PROTECTION (Contact Form)

### Multi-Layer Defense Strategy
Contact form has **3 layers of protection**:

**Layer 1 — Laravel Rate Limiting (Always Active)**
```php
// routes/web.php
Route::post('/contact', [ContactController::class, 'store'])
     ->middleware('throttle:3,60');  // max 3 submissions per IP per 60 minutes
```

**Layer 2 — Honeypot Field (Always Active)**
```html
<!-- Hidden in Blade form — bots fill this, humans don't see it -->
<input type="text" name="website" style="display:none;" tabindex="-1" autocomplete="off">
```
```php
// ContactController@store
if ($request->filled('website')) {
    // Bot detected — silently discard (don't tell the bot it failed)
    return back()->with('success', 'Message sent!'); // fake success
}
```

**Layer 3 — Google reCAPTCHA (Configurable from Settings)**
```php
// Package: anhskohbo/no-captcha OR manual API call
// Only active if recaptcha_enabled = true in settings

// v3 (Invisible — recommended, best UX):
// - No checkbox shown to user
// - Google scores the session 0.0–1.0
// - Score < threshold → blocked silently OR flagged for manual review

// v2 (Checkbox — fallback):
// - "I'm not a robot" checkbox
// - Use if v3 false positives are a problem

// In Blade:
@if(setting('recaptcha_enabled'))
    @if(setting('recaptcha_version') === 'v3')
        <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response">
        <script>
        grecaptcha.ready(function() {
            grecaptcha.execute('{{ setting("recaptcha_site_key") }}', {action:'contact'})
                .then(token => document.getElementById('g-recaptcha-response').value = token);
        });
        </script>
    @else
        {!! NoCaptcha::display() !!}
    @endif
@endif
```

**Additional:** Server-side email validation + basic content spam check (block if message contains too many URLs, or known spam patterns).

---

## 32. CONTACT MESSAGE REPLY SYSTEM (Enhanced)

### Overview
Admin can reply to any contact message directly from the CRM inbox. Reply is sent via email using a pre-saved template (from Email Templates). Reply is recorded in the database.

### Contact Replies Schema
```php
Schema::create('contact_replies', function (Blueprint $table) {
    $table->id();
    $table->foreignId('contact_message_id')->constrained()->cascadeOnDelete();
    $table->foreignId('sent_by')->constrained('users');
    $table->string('to_email');
    $table->string('to_name');
    $table->string('subject');
    $table->longText('body');        // HTML
    $table->string('template_slug')->nullable(); // which template was used as base
    $table->timestamp('sent_at')->useCurrent();
});
```

### Contact Message Detail Page (/admin/contact-messages/{id})
```
┌────────────────────────────────────────────────────────────┐
│  Contact Message — #42                     Status: [NEW ▼] │
├────────────────────────────────────────────────────────────┤
│  FROM: Mark Jensen <mark@agnatech.com>                     │
│  Date: 11 May 2026, 3:42 PM                               │
│  Service: Web Development | Budget: $5,000–$20,000        │
│  Company: Agnatech                                         │
├────────────────────────────────────────────────────────────┤
│  MESSAGE:                                                  │
│  "Hi, we're looking for a team to build our e-commerce    │
│   platform. We saw your portfolio and..."                  │
├────────────────────────────────────────────────────────────┤
│  ADMIN NOTES:                              [Save Notes]    │
│  [textarea — private internal note]                        │
├────────────────────────────────────────────────────────────┤
│  REPLY SECTION:                                            │
│  Template: [Select template ▼]  ← dropdown of email templates
│                ↓ loads template subject+body into fields   │
│  To: mark@agnatech.com (auto-filled)                      │
│  Subject: [editable text field]                            │
│  Body: [Quill.js editor — pre-filled from template]        │
│        All variables auto-replaced before loading          │
│  [Send Reply →]  [Preview]                                 │
│                                                            │
├────────────────────────────────────────────────────────────┤
│  REPLY HISTORY:                                            │
│  ┌─────────────────────────────────────────────────────┐  │
│  │ 11 May 2026 | Sent by: Admin | Subject: "Re: ..."  │  │
│  │ "Thank you for reaching out, Mark..."  [View]       │  │
│  └─────────────────────────────────────────────────────┘  │
└────────────────────────────────────────────────────────────┘
```

### Reply Send Flow
```php
// Admin clicks [Send Reply] → Livewire or form POST
// ContactReplyController@store:
1. Validate subject + body
2. Create ContactReply record in DB
3. Dispatch queued job: SendContactReplyMail::dispatch($reply)
4. Update contact_messages.status = 'replied'
5. Record in activity_log
6. Show success toast: "Reply sent to mark@agnatech.com"
```

---

## 33. PROPOSAL BUILDER

### Overview
Create professional project proposals from the CRM. Each proposal has a unique number, client details, line items (services/deliverables), total cost, timeline, terms, and validity date. Can be downloaded as a **polished PDF** or sent directly via email using the `proposal-sent` email template.

### Proposal Schema
```php
Schema::create('proposals', function (Blueprint $table) {
    $table->id();
    $table->string('proposal_number')->unique(); // RS-PROP-2026-001
    $table->string('client_name');
    $table->string('client_email')->nullable();
    $table->string('client_phone')->nullable();
    $table->string('client_company')->nullable();
    $table->string('platform')->nullable();       // Fiverr, Upwork, Direct Client, etc.
    $table->string('fiverr_username')->nullable(); // if platform = Fiverr
    $table->string('project_title');
    $table->text('project_description')->nullable();
    $table->decimal('subtotal', 12, 2)->default(0);
    $table->decimal('discount_amount', 12, 2)->default(0);
    $table->decimal('total_amount', 12, 2)->default(0);
    $table->string('currency', 10)->default('USD');
    $table->string('timeline')->nullable();         // "2–3 Weeks"
    $table->unsignedInteger('revision_rounds')->nullable();
    $table->date('valid_until')->nullable();
    $table->enum('status', ['draft','sent','viewed','accepted','rejected','expired'])->default('draft');
    $table->longText('terms_conditions')->nullable(); // pre-filled from default terms setting
    $table->longText('notes')->nullable();            // internal notes — NOT shown on PDF
    $table->string('rejection_reason')->nullable();
    $table->timestamp('sent_at')->nullable();
    $table->timestamp('viewed_at')->nullable();
    $table->foreignId('created_by')->constrained('users');
    $table->timestamps();
    $table->softDeletes();
});

Schema::create('proposal_items', function (Blueprint $table) {
    $table->id();
    $table->foreignId('proposal_id')->constrained()->cascadeOnDelete();
    $table->string('title');                 // "Homepage Design & Development"
    $table->text('description')->nullable(); // bullet points of what's included
    $table->decimal('unit_price', 10, 2)->nullable();
    $table->unsignedInteger('quantity')->default(1);
    $table->decimal('total', 10, 2)->nullable(); // unit_price × quantity
    $table->integer('sort_order')->default(0);
    $table->timestamps();
});
```

### Proposal Form Fields
| Field | Type | Required | Notes |
|---|---|---|---|
| Client Name | Text | ✅ | |
| Client Email | Email | ❌ | For sending proposal |
| Client Phone | Text | ❌ | |
| Client Company | Text | ❌ | |
| Platform | Select | ❌ | Direct Client, Fiverr, Upwork, Freelancer, LinkedIn, WhatsApp, Email, Other |
| Fiverr Username | Text | ❌ | Only shown if Platform = Fiverr |
| Project Title | Text | ✅ | |
| Project Description | Textarea | ❌ | Context/background |
| Currency | Select | ✅ | USD, PKR, SAR, AED, GBP, EUR |
| Timeline | Text | ❌ | "2–3 Weeks", "1 Month" |
| Revision Rounds | Number | ❌ | |
| Valid Until | Date | ❌ | Proposal expiry date |
| Terms & Conditions | Rich Text | ❌ | Pre-filled from default terms in settings |
| Notes (internal) | Textarea | ❌ | NOT on PDF |
| — LINE ITEMS — | | | |
| Item Title | Text | ✅ | One per deliverable |
| Item Description | Textarea | ❌ | What's included in this item |
| Unit Price | Number | ❌ | |
| Quantity | Number | ✅ | Default 1 |
| Total | Auto-calc | — | unit_price × quantity |
| [+ Add Item] | Button | — | Adds new row (Alpine.js dynamic) |
| [Remove] | Button | — | Per row |
| — TOTALS — | | | |
| Subtotal | Auto-calc | — | Sum of all item totals |
| Discount | Number | ❌ | Fixed amount or % |
| **Total** | Auto-calc | — | Subtotal – Discount |

### Proposal List Page (/admin/proposals)
```
Columns: # | Client | Platform | Project | Total | Status | Valid Until | Actions
Filter:  Status | Platform | Date range
Actions: View | Edit (draft only) | Download PDF | Send Email | Duplicate | Delete

Status badge colors:
  DRAFT     → gray
  SENT      → blue
  VIEWED    → purple (client opened the email)
  ACCEPTED  → green
  REJECTED  → red
  EXPIRED   → amber (past valid_until date)
```

### Proposal PDF Design (Professional Template)

Generated via **`barryvdh/laravel-dompdf`**. Renders a Blade view as PDF.

```
┌─────────────────────────────────────────────────────────────┐
│  [REDIS SOLUTION LOGO]              PROPOSAL                │
│  Redis Solution Pvt. Ltd.           #RS-PROP-2026-001       │
│  Rawalpindi, Pakistan               Date: 11 May 2026       │
│  info@redissolution.com             Valid Until: 25 May 2026│
│  +92 349 3614440                                            │
├─────────────────────────────────────────────────────────────┤
│  PREPARED FOR:                                              │
│  Mark Jensen                        Fiverr: @markjensen     │
│  Agnatech                                                   │
│  mark@agnatech.com                                          │
├─────────────────────────────────────────────────────────────┤
│  PROJECT: E-Commerce Platform Development                   │
│                                                             │
│  [Project Description paragraph]                            │
├─────────────────────────────────────────────────────────────┤
│  SCOPE OF WORK                                              │
│  ─────────────────────────────────────────────── ────────── │
│  #   Service / Deliverable          Qty    Price    Total   │
│  ─────────────────────────────────── ────── ─────── ─────── │
│  1   Homepage Design & Development   1    $800     $800    │
│      Responsive, animated, SEO-ready                        │
│                                                             │
│  2   Product Catalog Module          1    $600     $600    │
│      Filter, search, cart integration                       │
│                                                             │
│  3   Payment Gateway Integration     1    $400     $400    │
│      Stripe + PayPal                                        │
│                                                             │
│  4   Admin Dashboard                 1    $500     $500    │
│      Order management, inventory, reports                   │
│  ─────────────────────────────────── ────── ─────── ─────── │
│                              SUBTOTAL             $2,300   │
│                              DISCOUNT              -$300   │
│                         ┌──────────────────────────────┐   │
│                         │  TOTAL         USD $2,000    │   │
│                         └──────────────────────────────┘   │
├─────────────────────────────────────────────────────────────┤
│  PROJECT DETAILS                                            │
│  Timeline:     2–3 Weeks                                    │
│  Revisions:    3 Rounds                                     │
│  Tech Stack:   React.js, Laravel, MySQL, Stripe            │
├─────────────────────────────────────────────────────────────┤
│  TERMS & CONDITIONS                                         │
│  • 50% advance payment required to start the project       │
│  • Remaining 50% upon project completion                   │
│  • Source code transferred after full payment              │
│  • This proposal is valid until 25 May 2026               │
│  • Additional features will be quoted separately           │
├─────────────────────────────────────────────────────────────┤
│  WHY REDIS SOLUTION?                                        │
│  ✓ 100+ Projects Delivered    ✓ 4+ Years Experience        │
│  ✓ 24/7 Post-Launch Support   ✓ 100% Code Ownership        │
│  ✓ NDA Signed Before Discuss  ✓ Agile Development          │
├─────────────────────────────────────────────────────────────┤
│  ACCEPT THIS PROPOSAL:                                      │
│  Contact us: info@redissolution.com | +92 349 3614440      │
│  WhatsApp: [number]                                         │
│                                                             │
│  ─── REDIS SOLUTION — INNOVATE. CREATE. SUCCEED. ───       │
└─────────────────────────────────────────────────────────────┘
```

**PDF Design Specs:**
- Page: A4, portrait
- Header: Orange gradient top bar (5px) + Logo left + Proposal # right
- Footer: Orange bottom bar + "Confidential — Prepared exclusively for {client_name}"
- Colors: Black text, `#FF6400` orange accents (headings, table header, total box border)
- Total box: Orange border + bold + slightly larger font — eye-catching
- Font: DM Sans (embedded in DOMPDF)
- Section dividers: thin orange line

### Proposal Send Flow
```
[Send via Email] button:
  1. Modal: confirm email address (pre-filled from client_email)
  2. Attach PDF to email
  3. Use 'proposal-sent' email template
  4. Dispatch queued: SendProposalMail::dispatch($proposal)
  5. Update proposal.status = 'sent', proposal.sent_at = now()
  6. Activity log: "Proposal RS-PROP-2026-001 sent to mark@agnatech.com"
  7. In-app notification to all admins (if notification enabled)
```

### Default Terms in Settings
Add `proposal_default_terms` to settings table — rich text field in General Settings where admin writes standard T&C. Every new proposal pre-fills T&C from this setting.

### Proposal Duplication
[Duplicate] button → creates an identical new proposal with status=draft and new proposal number. Useful for sending similar quotes to multiple clients.

### Auto-Numbering
```php
// ProposalObserver@creating
$lastProposal = Proposal::withTrashed()->latest()->first();
$nextNum = $lastProposal ? (int) substr($lastProposal->proposal_number, -3) + 1 : 1;
$proposal->proposal_number = 'RS-PROP-' . now()->year . '-' . str_pad($nextNum, 3, '0', STR_PAD_LEFT);
```

---

## 34. UPDATED DATABASE ADDITIONS (v4.0)

New tables added to schema:
```php
settings            — key-value store for all system config
email_templates     — customizable HTML email templates per event
notification_settings — per-event in-app/email toggle
system_notifications — in-app notification records per user
contact_replies     — reply records for each contact message
proposals           — client proposals
proposal_items      — line items per proposal
```

New packages required:
```json
"barryvdh/laravel-dompdf": "^3.0",    // PDF generation for proposals
"anhskohbo/no-captcha": "^3.0"        // Google reCAPTCHA integration
```

---

## 35. UPDATED CRM NAVIGATION (v4.0)

```
[Redis Solution Logo]
─────────────────────────────────────
📊  Dashboard
─────────────────────────────────────
WORK
  📁  Projects
  💼  Investments
  📄  Proposals              ← NEW
─────────────────────────────────────
FINANCE
  💰  Budget
     ├── Expenses
     └── Income
  ₿   Crypto
─────────────────────────────────────
CLIENTS
  🌐  Hosting Clients
  🎭  Demo Projects
─────────────────────────────────────
VAULT  ⚠️ (admin only)
  🔑  API Keys
  🔒  Credentials
─────────────────────────────────────
WEBSITE  (content-manager+)
  📰  Blog
     ├── Posts
     ├── Categories
     └── Tags
  🖼   Portfolio
  ⭐  Testimonials
  ❓  FAQs
  💬  Contact Messages  [badge: unread]
  📦  Products  (Phase 2)
─────────────────────────────────────
SEO
  📈  SEO Dashboard
  🗺   Page SEO
  🌍  Client Sites SEO
  🗂   Sitemap
  🤖  Robots.txt
─────────────────────────────────────
TOOLS
  📝  My Notes
  📋  Activity Logs
─────────────────────────────────────
ADMIN  🔐 (super-admin only)
  👥  Users
  🛡   Roles & Permissions
  ─────────────────────────
  ⚙️   Settings              ← NEW
     ├── General
     ├── SMTP
     ├── Email Templates     ← NEW
     ├── Notifications       ← NEW
     └── reCAPTCHA / Anti-bot ← NEW
─────────────────────────────────────
[User Avatar] [Name] [Role]
[Logout]
```

---

## 36. UPDATED DEVELOPMENT PHASES (v4.0 Additions)

**Phase 4B — Settings, Notifications, Anti-Bot (added to Phase 4)**
- [ ] Settings controller + model (`Setting::get()` / `Setting::set()` helper)
- [ ] General Settings tab (all fields, save, reflected globally via `setting()` helper)
- [ ] SMTP Settings tab + test email (Livewire + Config::set())
- [ ] Email Templates: `email_templates` table + seeder (all 9 system templates with real HTML)
- [ ] Template editor page (Quill.js + variable chip insertion)
- [ ] Template preview modal (render with dummy data)
- [ ] Notification Settings tab (toggle matrix, Livewire auto-save)
- [ ] `system_notifications` table + `NotificationBell` Livewire component (polling 30s)
- [ ] reCAPTCHA settings tab (site key, secret key, version, threshold)
- [ ] Contact form: honeypot layer + throttle (always on) + reCAPTCHA (if enabled)
- [ ] Contact reply system: `contact_replies` table, reply form, template pre-load, send + log

**Phase 7B — Proposal Builder (added to Phase 7)**
- [ ] `proposals` + `proposal_items` migrations + model + seeder
- [ ] `barryvdh/laravel-dompdf` install + PDF Blade template design
- [ ] `Backend\ProductController` — uh wait, that's Phase 7; this is ProposalController
- [ ] Proposal list page (Livewire table, status badges, filter)
- [ ] Proposal create/edit page (dynamic line items with Alpine.js, auto-totals)
- [ ] Auto proposal numbering (Observer)
- [ ] PDF download endpoint + PDF Blade template (professional design)
- [ ] Send proposal via email (queued, using `proposal-sent` template)
- [ ] Proposal duplication feature
- [ ] Default terms setting in General Settings
- [ ] `anhskohbo/no-captcha` install + configure reCAPTCHA

---

---

## 37. WHATSAPP INTEGRATION

### Purpose
Pakistan mein 90% business WhatsApp pe hota hai. Website pe visitor directly WhatsApp contact kare + CRM mein sab conversations logged rahen.

### A — Website Widget (Frontend)

**Floating WhatsApp Button:**
- Bottom-right corner, always visible on all public pages
- Orange outer ring (brand color) + WhatsApp green icon
- Pulse animation to draw attention (CSS keyframe, subtle)
- On click: opens `https://wa.me/92XXXXXXXXXX?text=Hi%20Redis%20Solution%2C%20I%20need%20help%20with...` in new tab
- Pre-filled message text configurable from CRM Settings → General tab

**Implementation (Alpine.js + Blade):**
```blade
{{-- resources/views/components/whatsapp-bubble.blade.php --}}
<div x-data="{ show: false }" x-init="setTimeout(() => show = true, 2000)"
     x-show="show" x-transition:enter="transition ease-out duration-500"
     x-transition:enter-start="opacity-0 translate-y-4"
     x-transition:enter-end="opacity-100 translate-y-0"
     class="fixed bottom-6 right-6 z-50">
    <a href="https://wa.me/{{ setting('whatsapp_number') }}?text={{ urlencode(setting('whatsapp_default_message')) }}"
       target="_blank" rel="noopener"
       class="flex items-center gap-3 bg-[#25D366] text-white px-4 py-3 rounded-full shadow-2xl
              hover:bg-[#1ebe5d] transition-all group"
       aria-label="Chat on WhatsApp">
        <svg class="w-6 h-6 animate-pulse group-hover:animate-none" ...></svg>
        <span class="text-sm font-semibold hidden sm:inline">Chat with us</span>
    </a>
</div>
```

**Settings Fields (stored in `settings` table):**
| Key | Type | Default |
|---|---|---|
| `whatsapp_number` | string | 923001234567 |
| `whatsapp_default_message` | string | Hi Redis Solution, I need help with... |
| `whatsapp_widget_enabled` | boolean | true |
| `whatsapp_widget_delay_seconds` | integer | 2 |

### B — CRM WhatsApp Log (Manual)

**Table: `whatsapp_conversations`**
```sql
id                  bigint PK
contact_id          bigint FK (contacts/clients) nullable
project_id          bigint FK nullable
client_name         varchar(255)
whatsapp_number     varchar(20)
summary             text          -- brief summary of what was discussed
direction           enum('inbound', 'outbound')
logged_at           timestamp
logged_by           bigint FK (users)
has_attachment      boolean default false
attachment_path     varchar(500) nullable
created_at, updated_at timestamps
```

**CRM Page: `/admin/whatsapp-log`**
- List of all logged conversations (Livewire table)
- Quick-log button: fill name, number, summary, direction
- Filter by direction, date range, project
- "Open WhatsApp" button per row → opens direct wa.me link
- Linked to contact/project for context

**Permissions:** `whatsapp.view`, `whatsapp.create`

### C — CRM Navigation Addition
```
TOOLS
  📝  My Notes
  💬  WhatsApp Log       ← NEW
  📋  Activity Logs
```

---

## 38. EMAIL NEWSLETTER & MARKETING MODULE

### Purpose
Past clients + new subscribers ko engage rakho. Monthly newsletter, service announcements, re-engagement campaigns — seedha CRM se bhejna ho.

### A — Database Schema

**Table: `newsletter_subscribers`**
```sql
id                  bigint PK
email               varchar(255) UNIQUE
name                varchar(255) nullable
source              enum('website_form','manual','client_auto') default 'website_form'
-- 'client_auto' = auto-subscribed when project is created (opt-in)
status              enum('subscribed','unsubscribed','bounced') default 'subscribed'
subscribed_at       timestamp
unsubscribed_at     timestamp nullable
unsubscribe_token   varchar(64) UNIQUE -- for 1-click unsubscribe
tags                json nullable -- ['web-client', 'mobile', 'seo-interest']
created_at, updated_at timestamps
```

**Table: `newsletter_campaigns`**
```sql
id                  bigint PK
title               varchar(255)       -- internal name
subject             varchar(255)       -- email subject
body                longtext           -- HTML (Quill.js)
status              enum('draft','scheduled','sending','sent','failed')
send_to             enum('all','subscribed','tagged') default 'subscribed'
tags_filter         json nullable      -- send only to these tags
total_sent          integer default 0
total_opened        integer default 0  -- via 1px tracking pixel
scheduled_at        timestamp nullable
sent_at             timestamp nullable
created_by          bigint FK (users)
created_at, updated_at timestamps
```

**Table: `newsletter_sends`** (individual send log)
```sql
id                  bigint PK
campaign_id         bigint FK
subscriber_id       bigint FK
status              enum('queued','sent','failed','opened')
opened_at           timestamp nullable
opened_count        integer default 0
sent_at             timestamp nullable
```

### B — Website Subscribe Form

```blade
{{-- In footer + dedicated section on homepage --}}
<form wire:submit="subscribe" class="flex gap-3">
    <input type="email" wire:model="email" placeholder="Your email address"
           class="flex-1 px-4 py-3 bg-white/10 border border-white/20 rounded-lg text-white">
    {{-- honeypot --}}
    <input type="text" name="website_url" class="hidden" tabindex="-1">
    <button type="submit" class="btn-orange px-6 py-3">Subscribe</button>
</form>
```

After subscribe → queued email using `newsletter-welcome` email template.

One-click unsubscribe via `/newsletter/unsubscribe/{token}` route — GDPR compliant.

### C — CRM Newsletter Panel: `/admin/newsletter`

**Tabs:**
1. **Campaigns** — list of all campaigns, status badge, sent/opened stats
2. **Subscribers** — list, filter by status/tag, manual add, bulk import CSV, export
3. **New Campaign** — title, subject, Quill.js body editor, send-to selector, schedule or send now

**Campaign Create Flow:**
- Write subject + HTML body in Quill.js
- Preview modal (renders actual HTML)
- Send test to your own email
- Select audience (all / by tag)
- Schedule (future datetime) OR Send Now
- On send: dispatched to queue → `SendNewsletterJob` → batch emails via SMTP

**Open Tracking:**
```php
// In campaign email body, inject:
<img src="{{ route('newsletter.track-open', ['send_id' => $send->id]) }}"
     width="1" height="1" style="display:none;" alt="">
```

**Stats per campaign:** Sent: 142 | Opened: 67 (47.2%) | Failed: 3

### D — Permissions
`newsletter.view`, `newsletter.create`, `newsletter.send`, `newsletter.subscribers.manage`

### E — CRM Navigation Addition
```
MARKETING                              ← NEW group
  📧  Newsletter
     ├── Campaigns
     └── Subscribers
```

---

## 39. FREE AUDIT TOOL & LEAD MAGNET

### Purpose
Website pe visitor aata hai, kuch value milti hai, email/number deta hai — warm lead ban jata hai. Sabse powerful inbound strategy.

### A — Free Website SEO/Performance Audit Tool

**Public Page:** `/free-audit`

**User Flow:**
1. Visitor enters website URL + their name + email
2. Clicks "Run Free Audit"
3. System runs checks in background (queued job)
4. Results page loads with score + issues
5. Lead auto-captured in CRM (contact_messages or dedicated leads table)
6. Email sent to visitor: "Your audit report is ready" (with PDF summary)
7. Email to admin: "New audit lead — hamzaaslam016@gmail.com"

**What We Check (via PHP + Guzzle):**

```php
class WebsiteAuditService
{
    public function audit(string $url): array
    {
        $response = Http::timeout(15)->get($url);
        $html = $response->body();
        $dom = new DOMDocument();
        @$dom->loadHTML($html);

        return [
            'performance' => [
                'response_time_ms'  => $response->transferStats->getTransferTime() * 1000,
                'page_size_kb'      => strlen($html) / 1024,
                'has_gzip'          => $response->header('Content-Encoding') === 'gzip',
                'has_https'         => str_starts_with($url, 'https'),
            ],
            'seo' => [
                'has_title'         => (bool) $this->getMeta($dom, 'title'),
                'title_length'      => strlen($this->getMeta($dom, 'title')),
                'has_description'   => (bool) $this->getMeta($dom, 'description'),
                'desc_length'       => strlen($this->getMeta($dom, 'description')),
                'has_h1'            => $dom->getElementsByTagName('h1')->length > 0,
                'h1_count'          => $dom->getElementsByTagName('h1')->length,
                'has_og_title'      => (bool) $this->getOgMeta($dom, 'og:title'),
                'has_canonical'     => (bool) $this->getLink($dom, 'canonical'),
                'images_without_alt'=> $this->countImagesWithoutAlt($dom),
            ],
            'technical' => [
                'has_viewport_meta' => (bool) $this->getMeta($dom, 'viewport'),
                'has_robots_meta'   => (bool) $this->getMeta($dom, 'robots'),
                'broken_links'      => [],  // async, Phase 2
                'has_sitemap'       => $this->checkSitemap($url),
                'has_robots_txt'    => $this->checkRobotsTxt($url),
            ],
        ];
    }
}
```

**Score Calculation:**
- Each check = points (title: 10pts, description: 10pts, HTTPS: 15pts, H1: 8pts, OG: 5pts, etc.)
- Total out of 100
- Color-coded: 0-40 red, 41-70 orange, 71-100 green

**Results Page Design:**
```
┌─────────────────────────────────────────┐
│  YOUR WEBSITE AUDIT SCORE               │
│                                         │
│         ⬤ 67 / 100                     │
│         NEEDS IMPROVEMENT               │
│                                         │
│  🔴 Missing meta description            │
│  🔴 3 images without alt text          │
│  🟠 Title too short (28 chars)         │
│  🟠 No OG image found                  │
│  🟢 HTTPS enabled                      │
│  🟢 Mobile viewport set               │
│                                         │
│  ┌────────────────────────────────────┐ │
│  │  Want us to fix these for FREE?   │ │
│  │  Book a 30-min consultation call  │ │
│  │  [Book Now — It's Free]           │ │
│  └────────────────────────────────────┘ │
└─────────────────────────────────────────┘
```

### B — Database

**Table: `audit_requests`**
```sql
id                  bigint PK
name                varchar(255)
email               varchar(255)
phone               varchar(20) nullable
website_url         varchar(500)
status              enum('pending','processing','completed','failed') default 'pending'
score               tinyint unsigned nullable      -- 0-100
results_json        json nullable                  -- full audit data
pdf_path            varchar(500) nullable
ip_address          varchar(45)
contacted           boolean default false          -- admin marked as contacted
contacted_at        timestamp nullable
notes               text nullable                  -- admin notes on this lead
created_at, updated_at timestamps
```

### C — CRM Audit Leads Panel: `/admin/audit-leads`

- List of all audit requests
- Score badge (color-coded)
- Website URL, name, email, date
- "View Report" — shows full audit results
- "Mark Contacted" toggle
- Notes field per lead
- Export to CSV

**Lead Auto-Notification:**
- In-app notification to admin (bell)
- Email: "New SEO audit lead from example.com — Score: 67/100"

### D — Free Consultation Booking (Simple Version)

**Public Page:** `/free-consultation`

Simple form:
- Name, Email, Phone, Project Type (dropdown), Brief description, Preferred time (text)

No calendar library needed in Phase 1. Just saves to DB + sends notification to admin + confirmation email to visitor.

**Table:** Reuse `contact_messages` with `type = 'consultation'` column or add separate `consultation_requests` table.

### E — Settings (in General Settings tab)
```
Audit Tool Settings:
- Audit tool enabled (toggle)
- Max audits per IP per day (default: 3)
- Auto-send audit report email (toggle)
- Consultation form enabled (toggle)
```

---

## 40. PUBLIC CASE STUDIES & SOCIAL PROOF NUMBERS

### Purpose
"Show, don't tell" — visitors ko proof chahiye. Live counters + deep case studies = trust in seconds. Pakistani IT market mein yeh do cheezein immediately alag kar deti hain.

### A — Social Proof Live Counters (Homepage)

**Data Source:** Real data from CRM DB, cached every hour.

```php
// App\Http\Controllers\HomeController
public function index(): View
{
    $stats = Cache::remember('homepage_stats', 3600, function () {
        return [
            'projects_delivered'   => Project::where('status', 'completed')->count(),
            'clients_served'       => Project::distinct('client_name')->count('client_name'),
            'years_experience'     => now()->year - 2021,  // company founded 2021
            'satisfaction_percent' => 98,  // static, update manually via settings
            'hosted_sites'         => HostingClient::where('status', 'active')->count(),
        ];
    });
    return view('frontend.home', compact('stats'));
}
```

**Blade Counter Component (Alpine.js animated):**
```blade
{{-- resources/views/components/stat-counter.blade.php --}}
@props(['value', 'label', 'suffix' => '+', 'prefix' => ''])
<div class="text-center" x-data="{ count: 0, target: {{ $value }} }"
     x-intersect="
         let step = target / 60;
         let timer = setInterval(() => {
             count = Math.min(count + step, target);
             if (count >= target) clearInterval(timer);
         }, 16);
     ">
    <div class="text-5xl font-bold text-orange-500 font-display">
        {{ $prefix }}<span x-text="Math.floor(count)"></span>{{ $suffix }}
    </div>
    <div class="text-sm text-white/60 mt-2 font-medium uppercase tracking-widest">
        {{ $label }}
    </div>
</div>
```

**Homepage Stats Section:**
```blade
<section class="py-24 bg-[#0D0D0D] border-y border-white/5">
    <div class="container mx-auto grid grid-cols-2 md:grid-cols-5 gap-12">
        <x-stat-counter :value="$stats['projects_delivered']" label="Projects Delivered" />
        <x-stat-counter :value="$stats['clients_served']"    label="Clients Served" />
        <x-stat-counter :value="$stats['years_experience']"  label="Years Experience" suffix="+" />
        <x-stat-counter :value="$stats['satisfaction_percent']" label="Client Satisfaction" suffix="%" />
        <x-stat-counter :value="$stats['hosted_sites']"      label="Sites Managed" />
    </div>
</section>
```

### B — Case Studies System

**CRM Table: `case_studies`**
```sql
id                      bigint PK
title                   varchar(255)       -- "How we built XYZ for ABC client"
slug                    varchar(255) UNIQUE
client_name             varchar(255)       -- can be anonymized
industry                varchar(100)       -- "E-Commerce", "Real Estate", "Healthcare"
service_type            varchar(100)       -- "Web Development", "Mobile App"
cover_image             varchar(500)
gallery_images          json nullable      -- array of paths
challenge               text               -- Problem/challenge they faced
solution                longtext           -- What we built
results                 json               -- [{metric: "40% more revenue", icon: "chart"}]
technologies            json               -- ["Laravel", "React Native", "MySQL"]
project_url             varchar(500) nullable
testimonial_quote       text nullable
testimonial_author      varchar(255) nullable
testimonial_designation varchar(255) nullable
is_featured             boolean default false
is_published            boolean default false
sort_order              integer default 0
meta_title              varchar(255) nullable
meta_description        text nullable
published_at            timestamp nullable
created_by              bigint FK (users)
created_at, updated_at timestamps
```

**Results JSON Structure:**
```json
[
    {"metric": "40%", "label": "More Revenue", "icon": "trending-up"},
    {"metric": "2x",  "label": "Faster Load Time", "icon": "zap"},
    {"metric": "500+","label": "Monthly Users", "icon": "users"}
]
```

**Frontend Pages:**

`/case-studies` — Grid listing:
```
┌────────────────┐  ┌────────────────┐  ┌────────────────┐
│  [Cover Image] │  │  [Cover Image] │  │  [Cover Image] │
│                │  │                │  │                │
│ E-Commerce     │  │ Real Estate    │  │ Healthcare     │
│ Web + Mobile   │  │ Web App        │  │ Mobile App     │
│                │  │                │  │                │
│ Client: XXXX   │  │ Client: YYYY   │  │ Client: ZZZZ   │
│ 40% revenue ↑  │  │ 2x faster      │  │ 500+ users     │
│ [Read Story →] │  │ [Read Story →] │  │ [Read Story →] │
└────────────────┘  └────────────────┘  └────────────────┘
```

`/case-studies/{slug}` — Single case study page:
```
[HERO — Full width cover image with title overlay]

THE CHALLENGE
[challenge text]

OUR SOLUTION
[solution text with screenshots from gallery]

THE RESULTS
[  40%        2x Speed      500+ Users  ]
[ Revenue  ]  [   Load   ]  [  Monthly ]

TECHNOLOGIES USED
[Laravel] [React Native] [MySQL] [Redis]

"Amazing work, exceeded all expectations"
— Client Name, CEO at Company

[← Back to Case Studies]    [Start Your Project →]
```

### C — CRM Case Studies Panel: `/admin/case-studies`

- CRUD with Livewire
- Quill.js for Solution section (rich text + image upload)
- Results builder: add/remove metric rows (Alpine.js dynamic)
- Technologies: tag-style multi-input
- Gallery image upload (Spatie Media Library)
- Featured toggle (shows on homepage)
- Published/Draft toggle
- SEO fields (meta title, meta description)

**Permissions:** `case_studies.view`, `case_studies.create`, `case_studies.edit`, `case_studies.delete`

### D — Homepage Featured Case Studies

Show top 3 featured case studies below the stats section:

```blade
@foreach($featuredCaseStudies as $cs)
<div class="group relative overflow-hidden rounded-2xl border border-white/10
            hover:border-orange-500/50 transition-all duration-500">
    <img src="{{ $cs->cover_image }}" class="w-full h-64 object-cover
         group-hover:scale-105 transition-transform duration-700">
    <div class="p-6">
        <span class="text-xs text-orange-400 uppercase tracking-widest">{{ $cs->service_type }}</span>
        <h3 class="text-xl font-bold mt-2 text-white">{{ $cs->title }}</h3>
        <div class="flex gap-6 mt-4">
            @foreach(array_slice($cs->results, 0, 2) as $result)
            <div>
                <div class="text-2xl font-bold text-orange-500">{{ $result['metric'] }}</div>
                <div class="text-xs text-white/50">{{ $result['label'] }}</div>
            </div>
            @endforeach
        </div>
        <a href="/case-studies/{{ $cs->slug }}"
           class="inline-flex items-center gap-2 mt-4 text-orange-400 hover:text-orange-300 text-sm font-medium">
            Read Case Study <x-heroicon-o-arrow-right class="w-4 h-4" />
        </a>
    </div>
</div>
@endforeach
```

### E — CRM Navigation Addition
```
WEBSITE
  📰  Blog
  🖼   Portfolio
  ⭐  Testimonials
  📊  Case Studies       ← NEW
  ❓  FAQs
  💬  Contact Messages
  📦  Products (Phase 2)
```

### F — Development Phase (v5.0 additions)

**Phase 8B — Client Reach Modules**
- [ ] WhatsApp settings fields in General Settings tab
- [ ] WhatsApp floating bubble Blade component (all public pages)
- [ ] `whatsapp_conversations` table + migration
- [ ] WhatsApp Log CRM page (Livewire CRUD)
- [ ] `newsletter_subscribers` + `newsletter_campaigns` + `newsletter_sends` migrations
- [ ] Newsletter subscribe form (website footer + homepage section)
- [ ] Unsubscribe route + token system
- [ ] Newsletter CRM panel (campaigns list, subscriber list, campaign create)
- [ ] `SendNewsletterJob` queued batch mailer
- [ ] Open tracking pixel endpoint
- [ ] `audit_requests` table + migration
- [ ] `WebsiteAuditService` (HTTP + DOMDocument checks, score calc)
- [ ] `RunAuditJob` queued
- [ ] Free audit public page + results page
- [ ] Audit leads CRM panel
- [ ] Free consultation form (reuse contact_messages or new table)
- [ ] `case_studies` table + migration + model + factory
- [ ] Case Studies CRM CRUD (Livewire + Quill.js + Media Library)
- [ ] Case Studies public listing page + single page
- [ ] Homepage stats counter section (Cache + Alpine.js)
- [ ] Homepage featured case studies section (top 3 featured)
- [ ] Social proof counters wired to real CRM data

---

---

## 41. common.js & Helper.php ARCHITECTURE

Both files already exist in the project. This section documents every function, its usage pattern, and the final architecture decision.

---

### A — common.js (`public/assets/js/common.js`)

**What it is:** Global CRM JavaScript utility file. Loaded on every admin page. Handles all DataTables interactions, AJAX modals, AJAX form submissions, confirmation dialogs, and common UI patterns.

**Dependencies it expects globally:**
| Window variable | Package | How it's loaded |
|---|---|---|
| `window.swal` | SweetAlert2 | CDN or NPM via Vite |
| `window.axios` | Axios | NPM via Vite |
| `window.toast` | SweetAlert2 `.mixin()` | Defined in app.js before common.js |
| `$` / `jQuery` | jQuery | NPM via Vite |
| `$.fn.DataTable` | DataTables | NPM via Vite |
| `$.fn.select2` | Select2 | NPM via Vite |

**Setup in `resources/js/app.js`:**
```js
import jQuery from 'jquery';
window.$ = window.jQuery = jQuery;

import 'datatables.net-bs5';
import 'select2';

import Swal from 'sweetalert2';
window.swal = Swal;
window.toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3500,
    timerProgressBar: true,
});

import axios from 'axios';
window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
```

**Functions & DOM Patterns:**

| Function / Selector | What it does | Usage |
|---|---|---|
| `.delete[data-url][data-table]` | SweetAlert confirm → Axios DELETE → DataTable reload | `<button class="delete" data-url="/admin/x/1" data-table="#myTable">` |
| `deleteConfirmation(url, tableId, refresh, div_id)` | Core delete with confirm | Called by `.delete` handler |
| `toastMessage(message, status)` | Show SweetAlert2 toast | `toastMessage('Saved!', 'success')` |
| `[data-act=ajax-modal]` | Fetch HTML from server → Bootstrap modal | `<a data-act="ajax-modal" data-action-url="/admin/x/edit/1" data-title="Edit" data-method="GET">` |
| `[data-form=ajax-form]` | Axios form submit → toast → DataTable/redirect | `<form data-form="ajax-form" data-datatable="#myTable">` |
| `sendAjaxForm(form)` | Core AJAX form handler | Called by `[data-form=ajax-form]` |
| `.approve / .disapprove[data-url][data-table]` | Status change with optional reject reason | `<button class="approve" data-url="..." data-table="#t">` |
| `processRequest(url, tableId, formData)` | Core approve/disapprove flow | Called by `.approve/.disapprove` |
| `.request-confirmation[data-url][data-method][data-message]` | Generic confirm → any HTTP method | `<button class="request-confirmation" data-method="POST" data-url="..." data-message="Sure?">` |
| `addFileEventToLabel(file_id, label_id, preview_id)` | Custom file input with image preview | Call in page JS |
| `.file-upload` change | Profile pic preview | Standard usage |
| `.upload-button` click | Trigger hidden file input | |
| `#generate_password` click | Random 8-char password into `#password` + `#password_confirmation` | User create/edit forms |
| `#copy_password` click | Copy `#password` field value | |
| `.reset_filters` click | Reset all Select2 + date fields | Filter sections |

**Data attributes reference for `[data-form=ajax-form]`:**
```html
<form data-form="ajax-form"
      action="/admin/projects"
      method="POST"
      data-datatable="#projects-table"   <!-- reload this DataTable on success -->
      data-modal="#createModal"          <!-- hide this modal on success -->
      data-redirect="1"                  <!-- follow redirectUrl from response -->
      data-refresh="1"                   <!-- location.reload() on success -->
      data-form-reset="1"                <!-- reset form fields on success -->
      data-confirm="yes"                 <!-- show confirm dialog before submit -->
      data-html-div-id="#detail-area"    <!-- inject response.data.view here -->
      data-show-div="#nextSection"
      data-hide-div="#currentSection">
```

**Data attributes for `[data-act=ajax-modal]`:**
```html
<button data-act="ajax-modal"
        data-action-url="/admin/projects/1/edit"
        data-method="GET"
        data-title="Edit Project"
        data-modal-size="modal-xl"
        data-post-project_id="1">   <!-- any data-post-* becomes POST body -->
```

---

### B — Helper.php (`app/Helpers/Helper.php`)

**What it is:** Global PHP utility functions auto-loaded via Composer. Available everywhere in Laravel (controllers, Blade, Livewire, jobs).

**Autoload setup in `composer.json`:**
```json
"autoload": {
    "psr-4": { "App\\": "app/" },
    "files": [
        "app/Helpers/Helper.php"
    ]
}
```
Run `composer dump-autoload` after adding this.

**Function Reference:**

| Function | Purpose | Used In |
|---|---|---|
| `getFullName($user)` | `"John Doe"` from first+last name | Blade, controllers |
| `getImage($image, $isAvatar, $withBaseurl)` | Image URL with fallback (avatar or no_image.png) | Blade templates |
| `getFiles($file_name)` | Full URL for any stored file | Blade templates |
| `statusClasses($status)` | Returns Bootstrap class suffix: `'success'`, `'danger'`, `'warning'` | Blade: `badge-{{ statusClasses($row->status) }}` |
| `addEllipsis($text, $max)` | Truncate text with `...` | DataTables columns, cards |
| `isValue($value)` | Returns value or `'N/A'` if null/empty | Blade detail views |
| `formatString($key, $reverse)` | `snake_case → readable` or reverse | Display labels |
| `isActive($routes, $params)` | Returns `'active'` if current route matches | Sidebar Blade component |
| `getAssignedPermissionsCount($role, $group)` | Count permissions per group for a role | Roles & Permissions matrix |
| `setting($key, $default)` | Get value from `settings` table (statically cached) | Everywhere |

**⚠️ Functions to REMOVE (belong to previous project, not Redis CRM):**
- `getLocationLabel($locationKey, $stateKey)` — uses `config('states')` which doesn't exist here
- `getStateLabel($stateKey)` — same
- `getCategoryLabel($categoryKey)` — uses `config('categories')` which doesn't exist here

---

### C — FileService (`App\Services\FileService`)

**Decision:** Extract file-operation functions from helper.php into a dedicated service class.

**Why NOT a Trait:**
- Traits need `$this` — these functions are stateless utilities that take `$file` as parameter
- A static service class is cleaner, testable, and callable from anywhere

**Why NOT keep in helper.php:**
- File operations involve Intervention Image + Storage — better in a typed, injectable service class
- Easier to unit test `FileService::saveResizeImage()` vs a global function

**`App\Services\FileService` (move these from helper.php):**
```php
<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Format;
use Intervention\Image\ImageManager;

class FileService
{
    public static function saveResizeImage($file, string $directory, ?int $width = null, ?int $height = null, ?string $type = null): string
    {
        // (existing logic from helper.php)
    }

    public static function saveDocument($file, string $directory, ?string $fileName = null): string
    {
        // (existing logic from helper.php)
    }

    public static function saveAnyFile($file, string $directory, string $fileName): string
    {
        $fileType = $file->getMimeType();
        return str_starts_with($fileType, 'image/')
            ? self::saveResizeImage($file, $directory)
            : self::saveDocument($file, $directory, $fileName);
    }

    public static function deleteFile(string $path): void
    {
        // (existing logic from helper.php)
    }
}
```

**Usage in controllers:**
```php
use App\Services\FileService;

$path = FileService::saveResizeImage($request->file('cover'), 'projects/covers', 1200);
FileService::deleteFile($project->cover_image);
```

---

### D — SCSS Structure

**Why SCSS over plain CSS:**
- Variables for brand colors (define once, use everywhere)
- Nesting (cleaner than flat CSS)
- Mixins (reusable patterns: flex-center, truncate, etc.)
- Partials (organize into files, compile to one output)
- Vite handles it natively with `npm install sass`

**Folder structure:**
```
resources/
├── scss/
│   ├── app.scss               ← CRM entry (imported by resources/js/app.js or directly)
│   ├── public.scss            ← Public website entry
│   ├── _variables.scss        ← Brand colors, fonts, breakpoints
│   ├── _mixins.scss           ← Reusable SCSS mixins
│   ├── _reset.scss            ← Base resets / normalizations
│   ├── backend/
│   │   ├── _layout.scss       ← Sidebar, topbar, main content layout
│   │   ├── _sidebar.scss      ← Sidebar specific styles
│   │   ├── _tables.scss       ← DataTables custom styling (orange theme)
│   │   ├── _cards.scss        ← Stat cards, info cards
│   │   ├── _forms.scss        ← Input, select, textarea overrides
│   │   ├── _badges.scss       ← Status badge colors
│   │   ├── _modals.scss       ← Bootstrap modal customization
│   │   └── _buttons.scss      ← Primary/secondary/icon buttons
│   └── frontend/
│       ├── _hero.scss         ← Homepage hero section
│       ├── _nav.scss          ← Public navbar
│       ├── _portfolio.scss    ← Portfolio grid + VanillaTilt
│       ├── _services.scss     ← Services section
│       ├── _blog.scss         ← Blog listing + post page
│       ├── _footer.scss       ← Footer
│       └── _cursor.scss       ← Custom cursor styles
```

**`_variables.scss`:**
```scss
// Brand Colors
$orange-deep:    #FF6400;
$orange-golden:  #FFB800;
$orange-mid:     #FF8C00;
$black-bg:       #080808;
$black-logo:     #100F0D;
$dark-purple:    #3D3568;
$near-black:     #141025;
$section-dark:   #28214C;
$section-light:  #F4F4F4;
$white:          #FFFFFF;

// CRM Panel
$crm-bg:         #0F0F0F;
$crm-sidebar:    #111111;
$crm-card:       #1A1A1A;
$crm-border:     rgba(255,255,255,0.08);
$crm-text:       #E5E5E5;
$crm-muted:      #888888;

// Status Colors
$success:        #22c55e;
$warning:        #f59e0b;
$danger:         #ef4444;
$info:           #3b82f6;

// Fonts
$font-display:   'Clash Display', sans-serif;
$font-heading:   'Syne', sans-serif;
$font-body:      'DM Sans', sans-serif;
$font-mono:      'JetBrains Mono', monospace;

// Breakpoints
$mobile:  576px;
$tablet:  768px;
$laptop:  1024px;
$desktop: 1280px;
```

**`vite.config.js` (no changes needed — Vite auto-processes `.scss`):**
```js
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/scss/app.scss',      // CRM styles
                'resources/scss/public.scss',   // Public website styles
                'resources/js/app.js',
                'resources/js/public.js',
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
```

---

### E — Livewire Table Pattern (Full Example)

**Livewire Component (`app/Livewire/Admin/Projects/ProjectsTable.php`):**
```php
<?php

namespace App\Livewire\Admin\Projects;

use App\Models\Project;
use Livewire\Component;
use Livewire\WithPagination;

class ProjectsTable extends Component
{
    use WithPagination;

    public string $search = '';
    public string $statusFilter = '';
    public string $sortBy = 'created_at';
    public string $sortDir = 'desc';
    public int $perPage = 20;

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function sort(string $column): void
    {
        $this->sortDir = ($this->sortBy === $column && $this->sortDir === 'asc') ? 'desc' : 'asc';
        $this->sortBy = $column;
    }

    public function delete(int $id): void
    {
        $project = Project::findOrFail($id);
        $project->delete();
        $this->dispatch('toast', message: 'Project deleted.', type: 'success');
    }

    public function render()
    {
        $projects = Project::query()
            ->when($this->search, fn($q) =>
                $q->where('title', 'like', "%{$this->search}%")
                  ->orWhere('client_name', 'like', "%{$this->search}%")
            )
            ->when($this->statusFilter, fn($q) => $q->where('status', $this->statusFilter))
            ->orderBy($this->sortBy, $this->sortDir)
            ->paginate($this->perPage);

        return view('livewire.admin.projects.projects-table', compact('projects'));
    }
}
```

**Livewire Blade View (`resources/views/livewire/admin/projects/projects-table.blade.php`):**
```blade
<div>
    {{-- Search + Filters --}}
    <div class="flex items-center gap-3 mb-4">
        <input wire:model.live.debounce.300ms="search"
               type="text" placeholder="Search projects..."
               class="input-field flex-1">

        <select wire:model.live="statusFilter" class="input-field w-48">
            <option value="">All Statuses</option>
            <option value="planning">Planning</option>
            <option value="in_progress">In Progress</option>
            <option value="completed">Completed</option>
        </select>

        <select wire:model.live="perPage" class="input-field w-24">
            <option value="20">20</option>
            <option value="50">50</option>
            <option value="100">100</option>
        </select>
    </div>

    {{-- Table --}}
    <div class="crm-card overflow-hidden">
        <table class="crm-table w-full">
            <thead>
                <tr>
                    <th wire:click="sort('title')" class="sortable">
                        Title @if($sortBy === 'title') {{ $sortDir === 'asc' ? '↑' : '↓' }} @endif
                    </th>
                    <th wire:click="sort('client_name')" class="sortable">Client</th>
                    <th wire:click="sort('status')" class="sortable">Status</th>
                    <th wire:click="sort('budget')" class="sortable">Budget</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($projects as $project)
                <tr>
                    <td>{{ $project->title }}</td>
                    <td>{{ $project->client_name }}</td>
                    <td><x-admin.badge :status="$project->status" /></td>
                    <td>PKR {{ number_format($project->budget) }}</td>
                    <td>
                        <div class="flex items-center gap-2">
                            <a href="{{ route('admin.projects.show', $project) }}" class="btn-icon">
                                <x-heroicon-o-eye class="w-4 h-4" />
                            </a>
                            <a href="{{ route('admin.projects.edit', $project) }}" class="btn-icon">
                                <x-heroicon-o-pencil class="w-4 h-4" />
                            </a>
                            <button
                                x-data
                                @click="
                                    window.swal.fire({
                                        title: 'Delete project?',
                                        text: 'This cannot be undone.',
                                        icon: 'warning',
                                        showCancelButton: true,
                                        confirmButtonText: 'Yes, delete',
                                    }).then(r => r.isConfirmed && $wire.delete({{ $project->id }}))
                                "
                                class="btn-icon text-red-400 hover:text-red-300">
                                <x-heroicon-o-trash class="w-4 h-4" />
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted py-12">No projects found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-4">
        {{ $projects->links() }}
    </div>
</div>
```

**Controller (just loads the page):**
```php
class ProjectController extends Controller
{
    public function index(): View
    {
        return view('admin.projects.index');
    }
}
```

**Page Blade (`resources/views/backend/projects/index.blade.php`):**
```blade
@extends('layouts.backend')
@section('content')
    <x-admin.page-header title="Projects" :actions="[['label' => 'New Project', 'href' => route('admin.projects.create')]]" />
    <livewire:admin.projects.projects-table />
@endsection
```

**Route:**
```php
Route::get('projects', [ProjectController::class, 'index'])->name('admin.projects.index');
```

---

---

## 42. MASTER IMPLEMENTATION ROADMAP

> **This section supersedes Sections 28, 36, and the Phase additions in Section 40.**
> Fully consolidated, updated for Laravel 13 + Livewire Tables + SCSS stack.
> Project is already created — skip `composer create-project`.

---

### PHASE 1 — Foundation & Asset Pipeline ✅ COMPLETE
**Goal:** Laravel fully configured, SCSS compiling, JS globals ready, layouts working, DB migrated, seeders run.

**1.1 — Install Composer Packages** ✅
```bash
composer require laravel/breeze
composer require spatie/laravel-permission
composer require spatie/laravel-activitylog
composer require spatie/laravel-sitemap
composer require spatie/laravel-media-library
composer require artesaos/seotools
composer require livewire/livewire
composer require maatwebsite/excel
composer require intervention/image
composer require predis/predis
composer require barryvdh/laravel-dompdf
composer require anhskohbo/no-captcha
```

**1.2 — Install NPM Packages**
```bash
npm install sass
npm install alpinejs gsap vanilla-tilt flatpickr apexcharts sortablejs
npm install sweetalert2 axios
npm install quill
```

**1.3 — Laravel Breeze (Blade stack)**
```bash
php artisan breeze:install blade --no-interaction
```

**1.4 — Publish & Configure Packages**
```bash
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
php artisan vendor:publish --provider="Spatie\Activitylog\ActivitylogServiceProvider" --tag="activitylog-migrations"
php artisan vendor:publish --provider="Spatie\MediaLibrary\MediaLibraryServiceProvider" --tag="medialibrary-migrations"
php artisan livewire:publish --config
```

**1.5 — .env Setup**
```bash
# Update .env:
DB_CONNECTION=mysql
DB_DATABASE=redis_crm
DB_USERNAME=root
DB_PASSWORD=

REDIS_HOST=127.0.0.1
REDIS_PORT=6379

CACHE_DRIVER=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=redis

MAIL_MAILER=smtp
MAIL_FROM_ADDRESS=info@redissolution.com
MAIL_FROM_NAME="Redis Solution"

VAULT_KEY=  # generate: openssl rand -base64 32
```

**1.6 — SCSS Structure**
```bash
mkdir -p resources/scss/backend resources/scss/frontend
touch resources/scss/app.scss
touch resources/scss/public.scss
touch resources/scss/_variables.scss
touch resources/scss/_mixins.scss
touch resources/scss/_reset.scss
# backend partials:
touch resources/scss/backend/_layout.scss
touch resources/scss/backend/_sidebar.scss
touch resources/scss/backend/_tables.scss
touch resources/scss/backend/_cards.scss
touch resources/scss/backend/_forms.scss
touch resources/scss/backend/_badges.scss
touch resources/scss/backend/_modals.scss
touch resources/scss/backend/_buttons.scss
# frontend partials:
touch resources/scss/frontend/_hero.scss
touch resources/scss/frontend/_nav.scss
touch resources/scss/frontend/_footer.scss
touch resources/scss/frontend/_portfolio.scss
touch resources/scss/frontend/_blog.scss
touch resources/scss/frontend/_cursor.scss
```

**1.7 — Vite Config (`vite.config.js`)**
```js
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/scss/app.scss',
                'resources/scss/public.scss',
                'resources/js/app.js',
                'resources/js/public.js',
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
```

**1.8 — `resources/js/bootstrap.js` (ALREADY EXISTS — verify only)**
File already has: `window.axios`, `window.swal`, `window.toast` — do NOT duplicate in app.js.
Only verify toast position is `bottom-end` and timer is `3000`. Add toast event listener:
```js
// Add at bottom of bootstrap.js:
window.addEventListener('toast', e => {
    window.toast.fire({ icon: e.detail.type ?? 'success', title: e.detail.message });
});
```

**`resources/js/app.js` (ALREADY EXISTS — verify only)**
Must import bootstrap.js + Alpine. Should already be:
```js
import './bootstrap';
import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();
```

**1.9 — composer.json autoload (Helper.php)**
Add to `composer.json` → `autoload` → `files` array:
```json
"files": ["app/Helpers/Helper.php"]
```
Then: `composer dump-autoload`

**1.11 — Blade Layouts**
- `resources/views/layouts/backend.blade.php` — CRM shell (sidebar + topbar + content slot)
- `resources/views/layouts/frontend.blade.php` — Website shell (navbar + content + footer)
- `resources/views/components/backend/sidebar.blade.php`
- `resources/views/components/backend/topbar.blade.php`
- `resources/views/components/backend/breadcrumb.blade.php`
- `resources/views/components/backend/stat-card.blade.php`
- `resources/views/components/backend/badge.blade.php`
- `resources/views/components/backend/page-header.blade.php`
- `resources/views/components/whatsapp-bubble.blade.php`

**1.12 — Routes**
- Create `routes/admin.php`
- Register in `bootstrap/app.php` with `web` + `auth` + `verified` middleware group

**1.13 — Phase 1 Migrations only (core foundation)**
Create and run only what Phase 1 needs. Remaining tables are created in their respective phases.
```bash
php artisan make:migration create_settings_table --no-interaction
php artisan make:migration create_system_notifications_table --no-interaction
# Spatie migrations already published in step 1.4
php artisan migrate
```

**Migration schedule (create each in the phase you build it):**
| Phase | Migrations to create |
|---|---|
| 1 (Foundation) | `settings`, `system_notifications` |
| 2 (Auth) | spatie already done — no new ones |
| 3 (Core CRM) | `projects`, `project_documents`, `project_messages`, `investments`, `investment_expenses`, `budget_entries`, `hosting_clients` |
| 4 (Vault/CRM) | `api_keys`, `credentials`, `demo_projects`, `crypto_investments`, `personal_notes`, `whatsapp_conversations` |
| 5 (Settings/Comms) | `email_templates`, `contact_messages`, `contact_replies`, `newsletter_subscribers`, `newsletter_campaigns`, `newsletter_sends` |
| 6 (Proposals) | `proposals`, `proposal_items` |
| 7A (SEO) | `page_seo_metas`, `website_seo_states` |
| 7B (Blog/Content) | `blog_categories`, `blog_tags`, `blog_posts`, `blog_post_tag`, `portfolios`, `testimonials`, `faqs`, `case_studies`, `audit_requests` |
| 9 (Products) | `products` |

**1.14 — Seeders**
```bash
php artisan make:seeder RolesAndPermissionsSeeder   # all roles + permission strings
php artisan make:seeder SuperAdminSeeder             # super-admin user
php artisan make:seeder SettingsSeeder               # default settings rows
php artisan make:seeder EmailTemplatesSeeder         # 9 system email templates
php artisan make:seeder PageSeoMetaSeeder            # blank SEO row per public page
php artisan db:seed
```

**1.15 — Helper.php Cleanup + FileService**
- Remove `getLocationLabel()`, `getStateLabel()`, `getCategoryLabel()` — not needed for this project
- Create `app/Services/FileService.php` — move: `saveResizeImage`, `saveDocument`, `saveAnyFile`, `deleteFile` from helper.php
- Remaining helpers stay as global functions: `setting()`, `isActive()`, `statusClasses()`, `getFullName()`, `getImage()`, `addEllipsis()`, `isValue()`, `formatString()`, `getAssignedPermissionsCount()`

**1.16 — common.js Refactor (end of Phase 1)**
Once layouts and Livewire pattern are confirmed working:
- Remove jQuery-based patterns (DataTables reload, Select2 init)
- Rewrite delete confirmation → Alpine.js + `window.swal` + `$wire.delete()`
- Rewrite AJAX modal → Alpine.js + `window.axios` (fetch HTML, inject into Alpine component)
- Keep: vault reveal timer (Alpine), password generate/copy buttons
- Keep file path as `public/assets/js/common.js` — included in backend layout

**1.17 — Verify**
- `npm run dev` — SCSS compiles, no errors
- Login page loads at `/login`
- Redirect to `/admin/dashboard` after login
- Sidebar renders with correct navigation
- SweetAlert2 toast fires on test click
- Livewire test component renders (`php artisan make:livewire TestComponent`)

---

### PHASE 2 — Auth, Roles & Users 🔲 PARTIALLY COMPLETE
**Goal:** Login system themed, roles/permissions fully working, user management done.

- [x] Customize Breeze login/register/password pages to dark CRM theme (orange accents)
- [x] `bootstrap/app.php` → `withMiddleware()` — register `role` and `permission` middleware aliases (Laravel 13 way — no Kernel.php)
  ```php
  ->withMiddleware(function (Middleware $middleware) {
      $middleware->alias([
          'role'       => \Spatie\Permission\Middleware\RoleMiddleware::class,
          'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
          'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
      ]);
  })
  ```
- [x] `AppServiceProvider::boot()` — super-admin `Gate::before()` (Laravel 13 — no separate AuthServiceProvider)
  ```php
  Gate::before(fn(User $user, string $ability) => $user->hasRole('super-admin') ? true : null);
  ```
- [x] `RolesAndPermissionsSeeder` — seed all roles + every permission string from the permission matrix
- [x] `SuperAdminSeeder` — create super-admin user, assign super-admin role
- [ ] `Backend\UserController` — index, create, store, edit, update, destroy, toggle-status
- [ ] `UsersTable` Livewire component — search by name/email, filter by role/status, sort, paginate
- [ ] `Backend\RoleController` — index, create, store, edit, update, destroy
- [ ] Roles list page — all roles with permission count per group
- [ ] Role permission matrix UI — checkbox grid (permission groups × permissions), Alpine.js "select all group" toggle
- [ ] Assign role to user (dropdown on user edit form)
- [ ] `@can` / `@role` on ALL sidebar menu items
- [ ] Route middleware `->middleware('permission:xxx')` on all admin routes
- [ ] Test: create role "content-manager", assign blog permissions only, login as that user, verify access restricted

---

### PHASE 3 — Dashboard + Projects + Budget 🔲 NEXT UP
**Goal:** Main revenue modules working. These are used daily.

**Dashboard:**
- [ ] `DashboardController@index` — pass stats to view
- [ ] Stats: total projects, active projects, total income this month, pending invoices, hosting renewals due in 30 days
- [ ] Livewire `DashboardStats` component (auto-refresh 60s)
- [ ] ApexCharts: monthly income/expense bar chart (last 6 months)
- [ ] Recent activity feed (spatie activitylog last 10 items)

**Projects:**
- [ ] `Project` model + relationships (documents, messages, client)
- [ ] `Backend\ProjectController` — create, store, show, edit, update, destroy
- [ ] `ProjectsTable` Livewire component — search, status filter, sort by title/budget/deadline, paginate
- [ ] Project create/edit form — all fields, platform tags, Flatpickr dates
- [ ] Project detail page — 4 tabs: Overview / Documents / Messages / Activity
- [ ] Documents tab — upload files (FileService::saveAnyFile), list, download, delete
- [ ] Messages tab — threaded conversation per project (simple, not real-time)
- [ ] Kanban view — status columns: Planning → In Progress → Review → Completed
- [ ] SortableJS for drag-drop status change → Axios PATCH

**Investments:**
- [ ] `Investment` model + `InvestmentExpense` model
- [ ] `Backend\InvestmentController` — CRUD; `InvestmentsTable` Livewire component
- [ ] Investment expenses sub-table (AJAX modal create)
- [ ] Summary card: total invested, total recovered, ROI %

**Budget:**
- [ ] `BudgetEntry` model (type: income/expense, category, amount, date, notes)
- [ ] `Backend\BudgetController` — CRUD; `BudgetTable` Livewire component (income tab + expense tab)
- [ ] Income table + Expense table (separate tabs, same page)
- [ ] P&L summary card (income - expense = profit/loss)
- [ ] ApexCharts monthly chart
- [ ] Export to XLSX (`maatwebsite/excel`)

**Hosting Clients:**
- [ ] `HostingClient` model
- [ ] `Backend\HostingClientController` — CRUD; `HostingClientsTable` Livewire component
- [ ] Renewal alert: highlight rows where `renewal_date` ≤ 30 days away (red badge)
- [ ] Laravel Scheduler: daily email to admin if renewals due within 7 days

---

### PHASE 4 — Vault & Remaining CRM Modules
**Goal:** All CRM modules complete.

**API Keys Vault:**
- [ ] `ApiKey` model — `key_value` stored via `encrypt()` (AES-256)
- [ ] `Backend\ApiKeyController` — CRUD + reveal endpoint; `ApiKeysTable` Livewire component
- [ ] Reveal endpoint: `POST /admin/api-keys/{id}/reveal` — permission: `vault.reveal`, logged by activitylog
- [ ] Blade reveal component (Alpine.js 30s auto-hide timer)

**Credentials Vault:**
- [ ] `Credential` model — password via `encrypt()`
- [ ] Same pattern as API Keys — CRUD + reveal + permission-gated

**Demo Projects:**
- [ ] `DemoProject` model
- [ ] `Backend\DemoProjectController` — CRUD; `DemoProjectsTable` Livewire component
- [ ] Thumbnail upload (FileService::saveResizeImage, 800px wide)

**Crypto Investment:**
- [ ] `CryptoInvestment` model
- [ ] `Backend\CryptoController` — CRUD; `CryptoTable` Livewire component
- [ ] Portfolio summary: total PKR invested, coins breakdown

**Personal Notes:**
- [ ] `PersonalNote` model — `user_id` strictly isolated
- [ ] `Backend\NoteController` — CRUD scoped to `Auth::id()`
- [ ] Quill.js editor for note body
- [ ] NO cross-user access — `->where('user_id', auth()->id())`

**Activity Logs:**
- [ ] `AdminActivityLogController@index` — read-only
- [ ] `ActivityLogsTable` Livewire component — subject, event, causer, description, date; filter by event/user/date
- [ ] Filters: event type, date range, user

**WhatsApp Log:**
- [ ] `WhatsappConversation` model
- [ ] `Backend\WhatsappController` — CRUD; `WhatsappLogTable` Livewire component
- [ ] "Open WhatsApp" button → `wa.me/{number}` link

---

### PHASE 5 — Settings, Notifications & Communications
**Goal:** All admin-configurable settings, email system, notification bell, contact reply.

**Settings Module (5 Tabs):**
- [ ] `Setting` model + `setting()` helper wired to DB
- [ ] `Backend\SettingController` — show + update (grouped by tab)
- [ ] General tab — company name, phone, email, address, WhatsApp number, default message, socials
- [ ] SMTP tab — host, port, username, password, encryption, from-name + "Send Test Email" button
- [ ] Email Templates tab — list all 9 system templates, Quill.js editor, variable chip buttons, preview modal
- [ ] Notification Settings tab — per-event toggle matrix (in-app on/off, email on/off per event)
- [ ] reCAPTCHA tab — site key, secret key, version (v2/v3), threshold, enable/disable
- [ ] `EmailTemplatesSeeder` — seed all 9 templates with real HTML content

**Notification System:**
- [ ] `SystemNotification` model
- [ ] `NotificationBell` Livewire component — `wire:poll.30s`, unread count badge, dropdown list
- [ ] Include bell in admin topbar
- [ ] `NotificationService::send($userId, $type, $title, $message, $url)` — create DB row
- [ ] Mark as read (single + mark all read)

**Anti-Bot (Contact Form):**
- [ ] Layer 1: `throttle:3,60` middleware on contact POST route
- [ ] Layer 2: honeypot field `website` — silent fake success if filled
- [ ] Layer 3: reCAPTCHA v2/v3 (if enabled in settings) via `anhskohbo/no-captcha`

**Contact Message Reply:**
- [ ] `ContactMessagesTable` Livewire component — status badges (new/read/replied), filter by status
- [ ] Detail view — full message + reply section
- [ ] Reply form — load template dropdown (from email_templates), Quill.js pre-filled, send + log to `contact_replies`

**Newsletter Module:**
- [ ] `NewsletterSubscriber`, `NewsletterCampaign`, `NewsletterSend` models
- [ ] Website subscribe form Blade component (honeypot included)
- [ ] Unsubscribe route `/newsletter/unsubscribe/{token}`
- [ ] CRM panel: Campaigns tab (list, create, send test, schedule) + Subscribers tab
- [ ] `SendNewsletterJob` — queued batch sender
- [ ] Open tracking pixel endpoint

---

### PHASE 6 — Proposals
**Goal:** Professional proposal generation, PDF, email, status tracking.

- [ ] `Proposal` + `ProposalItem` models
- [ ] `ProposalObserver` — auto-number `RS-PROP-{YEAR}-{NNN}` on creating
- [ ] Register observer in `AppServiceProvider`
- [ ] `Backend\ProposalController` — create, store, show, edit, update, destroy, duplicate, send, download-pdf
- [ ] `ProposalsTable` Livewire component — proposal#, client, platform, total, status badge, filter by status
- [ ] Create/edit form — client info section, Fiverr/Upwork fields, dynamic line items (Alpine.js), auto-totals, tax %
- [ ] PDF Blade template (`resources/views/proposals/pdf.blade.php`) — A4, orange branded header, logo, line items table, total box, terms
- [ ] `barryvdh/laravel-dompdf` — download PDF endpoint + inline preview
- [ ] Send via email — `ProposalSentMail` Mailable using `proposal-sent` email template
- [ ] Status flow: draft → sent → viewed → accepted / rejected / expired
- [ ] "Viewed" webhook: pixel in email or link-click tracking
- [ ] Default terms from `setting('proposal_default_terms')`
- [ ] Duplicate proposal action (copy with new number, reset to draft)

---

### PHASE 7A — SEO Dashboard
**Goal:** Full SEO control panel for own site + client sites.

- [ ] Migrations: `page_seo_metas`, `website_seo_states`
- [ ] `PageSeoMeta` + `WebsiteSeoState` models
- [ ] `PageSeoMetaSeeder` — seed blank SEO row per public page
- [ ] `SeoAuditService::runOwnSiteAudit()` — detects missing meta, OG, descriptions
- [ ] `Backend\SeoController` — dashboard, page-seo CRUD, client-sites CRUD, sitemap, robots
- [ ] SEO Dashboard page — issues list (high/medium/low), score badge
- [ ] Page SEO Management — table of all pages, edit meta title/desc/OG image per page
- [ ] `artesaos/seotools` wired in all Frontend controllers (reads `page_seo_metas` table)
- [ ] Client Sites SEO — `WebsiteSeoState` CRUD; `ClientSitesTable` Livewire component
- [ ] Sitemap UI — show generated URLs, "Regenerate Now" → `php artisan sitemap:generate`
- [ ] Robots.txt editor — save to `public/robots.txt`

---

### PHASE 7B — Blog, Portfolio & Website Content
**Goal:** All CRM-managed content ready before public website is built in Phase 8.

- [ ] Migrations: `blog_categories`, `blog_tags`, `blog_posts`, `blog_post_tag`, `portfolios`, `testimonials`, `faqs`, `case_studies`, `audit_requests`
- [ ] `BlogCategory`, `BlogTag`, `BlogPost` models + relationships (ManyToMany tags)
- [ ] `Backend\BlogController` — CRUD; `BlogPostsTable` Livewire component
- [ ] Blog post create/edit — Quill.js body, SEO tab, featured image (FileService), categories/tags multi-select, schedule publish
- [ ] Blog categories + tags CRUD (simple list pages)
- [ ] View counter — session-based dedup (incremented from Frontend controller, not Livewire)
- [ ] `PortfolioItem` model; Portfolio CRUD — cover + gallery (Spatie Media Library), featured toggle
- [ ] `Testimonial` model; Testimonials CRUD — avatar (FileService), rating, featured toggle
- [ ] `Faq` model; FAQs CRUD — sort order drag-drop (SortableJS → PATCH endpoint)
- [ ] `CaseStudy` model; Case Studies CRUD — Quill.js, results builder (Alpine.js add/remove rows), gallery, technologies tags

---

### PHASE 8 — Public Website
**Goal:** Stunning "Dark Fire Agency" public website — all pages live with animations.

**Layout & Global:**
- [ ] Public Blade layout — includes: custom cursor, WhatsApp bubble, navbar, footer
- [ ] `resources/js/public.js` — GSAP init, ScrollTrigger register, cursor, magnetic buttons
- [ ] Custom cursor (orange dot, CSS morph on hover links/buttons)
- [ ] Navbar — transparent on top → dark on scroll (Alpine.js + IntersectionObserver)
- [ ] Footer — social links, newsletter subscribe form, quick links, address
- [ ] WhatsApp floating bubble (2s delay, from `setting('whatsapp_number')`)

**Home Page (`/`):**
- [ ] Hero — full-screen, Clash Display headline, GSAP character-split animation, CTA buttons, background noise texture
- [ ] Stats section — animated counters (Alpine.js x-intersect) from real CRM DB
- [ ] Services — bento grid layout, hover reveal descriptions
- [ ] Why Us — bento grid, icon cards
- [ ] Portfolio — horizontal scroll (GSAP ScrollTrigger pin), VanillaTilt cards
- [ ] Testimonials — marquee/slider, star ratings
- [ ] Featured Case Studies — top 3 featured, metric highlights
- [ ] Industries served — icon grid
- [ ] Process — numbered steps (GSAP stagger reveal)
- [ ] CTA section — magnetic button, orange gradient bar

**Other Pages:**
- [ ] `/services` — service cards with accordion details + preview card on hover
- [ ] `/about` — team section, story, values, brand timeline
- [ ] `/portfolio` — masonry grid + filter by category (Alpine.js) + lightbox
- [ ] `/case-studies` — grid listing + `/case-studies/{slug}` deep-dive page
- [ ] `/contact` — form (3-layer anti-bot), Google Maps embed, WhatsApp + phone CTAs
- [ ] `/faqs` — Alpine.js accordion (data from DB)
- [ ] `/blog` — listing + `/blog/{slug}` post (view counter, related posts)
- [ ] `/free-audit` — URL input form → `RunAuditJob` → results page → lead captured
- [ ] `/free-consultation` — simple form → notification to admin + confirmation email
- [ ] `/privacy-policy` — static Blade page
- [ ] `/refund-policy` — static Blade page
- [ ] `artesaos/seotools` — wired to all pages (reads `page_seo_metas` table)
- [ ] `spatie/laravel-sitemap` — scheduled daily, includes blog posts + case studies + portfolio

---

### PHASE 9 — Products (Phase 2)
**Goal:** Redis Solution's own products showcased publicly.

- [ ] `Product` model + migration (title, slug, tagline, description, cover, screenshots JSON, features JSON, price, demo URL, status)
- [ ] `Backend\ProductController` — CRUD; `ProductsTable` Livewire component
- [ ] Screenshot gallery upload (FileService + Spatie Media Library)
- [ ] Public `/products` — grid listing (published only)
- [ ] Public `/products/{slug}` — detail page (screenshots, features, pricing, CTA)
- [ ] Products SEO — per-product meta title/description/OG
- [ ] Sitemap updated to include product URLs

---

### PHASE 10 — Lead Management (Future / Phase 2+)
**Goal:** Turn CRM from reactive to proactive. Track every potential client.

- [ ] `Lead` model — name, email, phone, source (Fiverr/Upwork/website/referral/walk-in), budget, service interest, status (new → contacted → proposal → won/lost), lost reason, notes
- [ ] `Backend\LeadController` — CRUD; `LeadsTable` Livewire component + kanban pipeline view
- [ ] Follow-up reminder — Laravel Scheduler checks leads with `follow_up_at` due today → in-app notification + email
- [ ] Lead source analytics — pie chart: where do most leads come from?
- [ ] Convert lead → project (1-click: pre-fill project create form from lead data)
- [ ] Audit leads → Lead pipeline (auto-convert audit requests to leads)

---

### PHASE 11 — Invoice Module (Future / Phase 2+)
**Goal:** Replace manual invoice tracking with professional system.

- [ ] `Invoice` model — invoice_number (RS-INV-YYYY-NNN), project_id, client_name, line_items JSON, subtotal, tax, total, status (draft/sent/partial/paid/overdue), due_date, paid_at, notes
- [ ] `Backend\InvoiceController` — CRUD; `InvoicesTable` Livewire component
- [ ] 1-click create invoice from proposal (copy line items, client info)
- [ ] PDF invoice (same branded template as proposal but invoice layout)
- [ ] Send via email (queued)
- [ ] Payment record — partial payments tracking
- [ ] Overdue alerts — Scheduler daily check → notification to admin
- [ ] P&L Dashboard updated — include invoice paid amounts

---

### PHASE 12 — QA, Performance & Deployment
**Goal:** Production-ready, fast, secure.

**Testing:**
- [ ] Full responsive test: 320px → 1920px on Chrome, Firefox, Safari, Edge
- [ ] Lighthouse audit: Public website ≥90 Performance, 100 SEO, 100 Accessibility
- [ ] All CRUD operations tested (create, edit, delete, permission gates)
- [ ] Vault reveal test (permission denied for non-vault users)
- [ ] Email delivery test (all 9 templates)
- [ ] Livewire table search/sort/paginate test on large datasets (seed 500+ rows)
- [ ] Anti-bot test (honeypot, reCAPTCHA, rate limit)
- [ ] Queue worker test (emails, audit jobs, newsletter batch)

**Performance:**
- [ ] `php artisan optimize` + `php artisan config:cache` + `php artisan route:cache` + `php artisan view:cache`
- [ ] Images: all uploads go through FileService resize (max 1200px, 95% quality)
- [ ] Redis caching for: `homepage_stats` (1hr), `settings` (static cache in helper), sitemap
- [ ] Vite build: `npm run build` — minified CSS/JS

**Security:**
- [ ] `APP_DEBUG=false` in production `.env`
- [ ] All vault routes behind `permission:vault.view` + `permission:vault.reveal`
- [ ] VAULT_KEY separate from APP_KEY in `.env`
- [ ] Activity log on all sensitive models (`LogsActivity` on Eloquent models)
- [ ] Rate limiting on contact form, audit form, newsletter subscribe

**Deployment:**
```bash
# Server: Ubuntu 22.04 + Nginx + PHP 8.5 FPM + MySQL 8 + Redis
# Clone repo, install deps, configure .env

composer install --no-dev --optimize-autoloader
npm run build
php artisan migrate --force
php artisan db:seed --class=ProductionSeeder
php artisan optimize
```

**Nginx config** — single Laravel app at `redissolution.com`
**Supervisor** — `php artisan queue:work --sleep=3 --tries=3`
**Cron** — `* * * * * cd /var/www/redis-solution && php artisan schedule:run`
**SSL** — `certbot --nginx -d redissolution.com -d www.redissolution.com`

---

### Phase Summary Table

| Phase | What | Migrations | Status |
|---|---|---|---|
| 1 | Foundation — packages, SCSS, Vite, bootstrap.js, layouts, seeders | `settings`, `system_notifications` | ✅ COMPLETE |
| 2 | Auth, Roles, Permissions, Users management | Spatie (already published) | 🔶 PARTIAL (auth done, users/roles UI pending) |
| 3 | Dashboard, Projects, Budget, Investments, Hosting | `projects`, `investments`, `budget_entries`, `hosting_clients` + sub-tables | 🔲 NEXT UP |
| 4 | Vault, Demo Projects, Crypto, Notes, Logs, WhatsApp | `api_keys`, `credentials`, `demo_projects`, `crypto_investments`, `personal_notes`, `whatsapp_conversations` | 🔲 Pending |
| 5 | Settings, Email Templates, Notifications, Anti-Bot, Newsletter | `email_templates`, `contact_messages`, `contact_replies`, newsletter tables | 🔲 Pending |
| 6 | Proposal Builder — PDF, email, status tracking | `proposals`, `proposal_items` | 🔲 Pending |
| 7A | SEO Dashboard — own site + client sites | `page_seo_metas`, `website_seo_states` | 🔲 Pending |
| 7B | Blog, Portfolio, Testimonials, FAQs, Case Studies | `blog_*`, `portfolios`, `testimonials`, `faqs`, `case_studies`, `audit_requests` | 🔲 Pending |
| 8 | Public Website — all pages, GSAP, animations, audit tool | none | ✅ COMPLETE (UI polish ongoing) |
| 9 | Products (Phase 2) | `products` | 🟢 Later |
| 10 | Lead Management (Phase 2+) | `leads` | 🟢 Later |
| 11 | Invoice Module (Phase 2+) | `invoices` | 🟢 Later |
| 12 | QA, Performance, Deployment | none | 🔲 Before launch |

---

---

## 43. CODING STANDARDS, PSR & LARAVEL BEST PRACTICES

---

### A — bootstrap.js Alert Service (Global JS Pattern)

`resources/js/bootstrap.js` already exists and sets up the app-wide JS globals. Every Blade layout includes compiled `app.js` which imports it. Use these globals everywhere — never import swal/axios again locally.

**How to use `window.toast` (success/error feedback):**
```js
// Success
window.toast.fire({ icon: 'success', title: 'Project saved.' });

// Error
window.toast.fire({ icon: 'error', title: 'Something went wrong.' });

// Warning
window.toast.fire({ icon: 'warning', title: 'Please fill all required fields.' });
```

**How to use `window.swal` (confirmation dialogs):**
```js
// Delete confirmation
window.swal.fire({
    title: 'Delete this record?',
    text: 'This action cannot be undone.',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Yes, delete',
    confirmButtonColor: '#FF6400',  // brand orange
    cancelButtonColor: '#374151',
}).then(result => {
    if (result.isConfirmed) {
        // proceed with delete
        $wire.delete(id);   // Livewire call
        // OR
        window.axios.delete(url).then(...);
    }
});
```

**Alpine.js delete button pattern (Livewire):**
```blade
<button
    x-data
    @click="window.swal.fire({
        title: 'Delete?', icon: 'warning',
        showCancelButton: true, confirmButtonText: 'Yes, delete',
        confirmButtonColor: '#FF6400',
    }).then(r => r.isConfirmed && $wire.delete({{ $record->id }}))"
    class="btn-icon text-red-400 hover:text-red-300">
    <x-heroicon-o-trash class="w-4 h-4" />
</button>
```

**Livewire dispatch toast from PHP:**
```php
// In Livewire component after action:
$this->dispatch('toast', message: 'Record deleted.', type: 'success');
```
```js
// In app.js listen for it:
window.addEventListener('toast', e => {
    window.toast.fire({ icon: e.detail.type, title: e.detail.message });
});
```

---

### B — Folder Structure Convention

| Type | Namespace / Path |
|---|---|
| CRM controllers | `App\Http\Controllers\Backend\` → `app/Http/Controllers/Backend/` |
| Website controllers | `App\Http\Controllers\Frontend\` → `app/Http/Controllers/Frontend/` |
| CRM Livewire components | `App\Livewire\Backend\` → `app/Livewire/Backend/` |
| Public Livewire components | `App\Livewire\Frontend\` → `app/Livewire/Frontend/` |
| CRM views | `resources/views/backend/` |
| Website views | `resources/views/frontend/` |
| CRM Blade components | `resources/views/components/backend/` → `<x-backend.sidebar>` |
| Website Blade components | `resources/views/components/frontend/` → `<x-frontend.navbar>` |
| CRM layout | `resources/views/layouts/backend.blade.php` |
| Website layout | `resources/views/layouts/frontend.blade.php` |
| SCSS CRM | `resources/scss/backend/_*.scss` |
| SCSS Website | `resources/scss/frontend/_*.scss` |
| JS CRM | `resources/js/backend/charts.js`, `quill.js` |
| JS Website | `resources/js/frontend/cursor.js`, `animations.js` |

**Artisan `make:` commands with correct namespacing:**
```bash
# Backend controller
php artisan make:controller Backend/ProjectController --resource --no-interaction

# Frontend controller
php artisan make:controller Frontend/HomeController --no-interaction

# Backend Livewire component
php artisan make:livewire Backend/Projects/ProjectsTable --no-interaction

# Frontend Livewire component (newsletter form, audit tool)
php artisan make:livewire Frontend/NewsletterSubscribe --no-interaction
```

---

### C — PSR Standards (PHP)

This project follows **PSR-1**, **PSR-4**, and **PSR-12**. Laravel Pint enforces these automatically — always run `vendor/bin/pint --dirty` after editing PHP files.

**PSR-1 — Basic Coding Standard:**
```php
// ✅ Class names: PascalCase
class ProjectController extends Controller {}
class FileService {}

// ✅ Method names: camelCase
public function storeProject(): RedirectResponse {}
public function getFullName(): string {}

// ✅ Constants: UPPER_SNAKE_CASE
const MAX_FILE_SIZE = 10240;

// ✅ Properties: camelCase
private string $clientName;
public bool $isPublished = false;
```

**PSR-4 — Autoloading:**
```php
// Namespace MUST match directory path exactly
namespace App\Http\Controllers\Backend;   // → app/Http/Controllers/Backend/
namespace App\Livewire\Backend\Projects;  // → app/Livewire/Backend/Projects/
namespace App\Services;                   // → app/Services/
```

**PSR-12 — Extended Coding Style:**
```php
// ✅ Type hints on every method parameter and return type
public function store(StoreProjectRequest $request): RedirectResponse
{
    // ...
}

// ✅ Constructor property promotion (PHP 8.0+)
public function __construct(
    private readonly FileService $fileService,
    private readonly SeoAuditService $seoService,
) {}

// ✅ Named arguments for clarity on complex calls
FileService::saveResizeImage(
    file: $request->file('cover'),
    directory: 'projects/covers',
    width: 1200,
);

// ✅ Match expression over switch
$badgeClass = match($status) {
    'active', 'completed', 'accepted' => 'success',
    'pending'                          => 'warning',
    'rejected', 'expired'              => 'danger',
    default                            => 'secondary',
};

// ✅ Enums for fixed status values (PHP 8.1+)
enum ProjectStatus: string {
    case Planning   = 'planning';
    case InProgress = 'in_progress';
    case Review     = 'review';
    case Completed  = 'completed';
    case Cancelled  = 'cancelled';
}
```

---

### D — Laravel Best Practices

**1. Form Requests — validate in request class, not controller:**
```php
// ✅ Correct
class StoreProjectRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title'       => ['required', 'string', 'max:255'],
            'client_name' => ['required', 'string', 'max:255'],
            'budget'      => ['required', 'numeric', 'min:0'],
            'status'      => ['required', Rule::enum(ProjectStatus::class)],
            'cover'       => ['nullable', 'image', 'max:5120'],
        ];
    }
}

// Controller stays thin:
public function store(StoreProjectRequest $request): RedirectResponse
{
    $project = Project::create($request->validated());
    // ...
}
```

**2. Service Classes — business logic lives here, not in controllers:**
```php
// ✅ App\Services\FileService — file operations
// ✅ App\Services\SeoAuditService — SEO issue detection
// ✅ App\Services\ProposalService — PDF generation + email dispatch
// ✅ App\Services\NotificationService — create system notifications
// ✅ App\Services\WebsiteAuditService — public page auditing

// Controller only orchestrates:
public function store(StoreProposalRequest $request): RedirectResponse
{
    $proposal = $this->proposalService->create($request->validated());
    return redirect()->route('admin.proposals.show', $proposal);
}
```

**3. Observers — model lifecycle events:**
```php
// ✅ ProposalObserver — auto-numbering on creating
// ✅ BlogPostObserver — generate slug on creating
// ✅ UserObserver — send welcome email on created
// Register in AppServiceProvider:
public function boot(): void
{
    Proposal::observe(ProposalObserver::class);
    BlogPost::observe(BlogPostObserver::class);
}
```

**4. Eloquent — use relationships, not manual JOINs:**
```php
// ✅ Correct — eager load to avoid N+1
$projects = Project::with(['documents', 'messages.user'])
    ->withCount('messages')
    ->latest()
    ->paginate(20);

// ❌ Wrong — N+1 query problem
foreach ($projects as $project) {
    echo $project->documents->count(); // query per loop
}
```

**5. Accessors & Mutators (Laravel 9+ syntax):**
```php
// In ApiKey model — auto encrypt/decrypt
protected function keyValue(): Attribute
{
    return Attribute::make(
        get: fn(string $value) => decrypt($value),
        set: fn(string $value) => encrypt($value),
    );
}

// In User model — full name accessor
protected function fullName(): Attribute
{
    return Attribute::make(
        get: fn() => trim("{$this->first_name} {$this->last_name}"),
    );
}
```

**6. Scopes — reusable query constraints:**
```php
// In BlogPost model
public function scopePublished(Builder $query): void
{
    $query->where('is_published', true)
          ->where('published_at', '<=', now());
}

public function scopeFeatured(Builder $query): void
{
    $query->where('is_featured', true);
}

// Usage:
BlogPost::published()->featured()->latest()->take(3)->get();
```

**7. Policies — authorization logic per model:**
```php
// Use Spatie permissions, but for fine-grained model-level checks use Policies
// php artisan make:policy ProjectPolicy --model=Project --no-interaction
```

**8. Config over hardcoded values:**
```php
// ❌ Wrong
$maxSize = 5120;

// ✅ Correct
$maxSize = config('app.max_upload_size', 5120);
// OR use setting() helper:
$companyName = setting('general_company_name', 'Redis Solution');
```

---

### E — Code Comment Guidelines

**The golden rule: comment WHY, never WHAT.**

```php
// ❌ Wrong — describes WHAT (obvious from code)
// Loop through projects
foreach ($projects as $project) { ... }

// ❌ Wrong — restates the method name
// Get all published posts
public function getPublished(): Collection { ... }

// ✅ Correct — explains WHY (non-obvious decision)
// Static cache prevents N+1 queries when setting() is called
// multiple times per request from Blade templates.
static $settings = null;

// ✅ Correct — explains a security constraint
// Reveal endpoint is rate-limited to 10/minute per user.
// Do NOT remove — vault keys must not be bulk-exported.
Route::post('vault/reveal/{id}', ...)->middleware('throttle:10,1');

// ✅ Correct — explains a workaround
// DOMPDF requires inline styles; Tailwind classes are not processed in PDF context.
// All proposal PDF styles must use inline CSS only.
```

**PHPDoc blocks — only on non-obvious methods:**
```php
/**
 * @param array{metric: string, label: string, icon: string} $results
 */
public function setResults(array $results): void
{
    $this->results = $results;
}
```

**Blade comments — use for section markers only:**
```blade
{{-- Hero Section --}}
@include('frontend.home.partials._hero')

{{-- No PHP comments in Blade; they render to HTML comments --}}
{{-- Use {{-- --}} always, never <!-- --> for logic comments --}}
```

---

### F — Naming Conventions Quick Reference

| Item | Convention | Example |
|---|---|---|
| Controller | PascalCase + `Controller` | `ProjectController` |
| Livewire Component | PascalCase | `ProjectsTable` |
| Model | Singular PascalCase | `Project`, `BlogPost` |
| Migration | snake_case, descriptive | `create_projects_table` |
| Route name | dot.notation, descriptive | `admin.projects.index` |
| Blade view | snake_case or kebab-case | `index.blade.php`, `_hero.blade.php` |
| SCSS partial | `_kebab-case.scss` | `_sidebar.scss` |
| JS file | camelCase or kebab | `charts.js`, `quill.js` |
| Enum | PascalCase keys | `ProjectStatus::InProgress` |
| Request class | `Store/Update` + Model + `Request` | `StoreProjectRequest` |
| Service class | Descriptive + `Service` | `FileService`, `SeoAuditService` |
| Observer | Model + `Observer` | `ProposalObserver` |
| Job | Verb phrase | `SendNewsletterJob`, `RunAuditJob` |
| Mail | Descriptive + `Mail` | `ProposalSentMail` |
| Event | Past tense noun phrase | `ProposalViewed`, `UserRegistered` |
| Policy | Model + `Policy` | `ProjectPolicy` |

---

### G — Pint (Auto-formatter) — Run Always

```bash
# Run after editing any PHP file:
vendor/bin/pint --dirty

# Check only (CI):
vendor/bin/pint --test

# Format specific file:
vendor/bin/pint app/Http/Controllers/Backend/ProjectController.php
```

Pint is configured via `pint.json` (or defaults to Laravel preset). It enforces PSR-12 + Laravel conventions automatically — no manual formatting needed.

---

---

### D — Theme-Aware Color Rule (MANDATORY — Every Phase)

**NEVER hardcode background, text, or border colors for UI elements that appear in both dark and light themes.**

Every CRM UI element (buttons, cards, inputs, dropdowns, badges, topbar elements) must use CSS custom properties defined in `_variables.scss`. Both dark and light values are declared there.

**Available CRM CSS variables:**
```css
/* Backgrounds */
--crm-bg          /* Page background */
--crm-card        /* Card / panel background */
--crm-topbar      /* Top navigation bar background */
--crm-input       /* Input field background */
--crm-hover       /* Hover overlay (very subtle) */
--crm-thead       /* Table header background */

/* Text */
--crm-text        /* Primary text (high contrast) */
--crm-text-sub    /* Secondary text (medium contrast) */
--crm-text-muted  /* Muted text (low contrast) */

/* Borders & Shadows */
--crm-border      /* Border color */
--crm-shadow      /* Box shadow */
```

**What IS allowed as hardcoded:**
- Brand orange: `#FF6400` — same in both themes (intentional brand color)
- Semantic status colors: `#34D399` (success), `#FBBF24` (warning), `#F87171` (error), `#60A5FA` (info) — these are global semantic UI colors, not theme-dependent

**What is FORBIDDEN:**
```css
/* BAD — hardcoded colors that break in light theme */
color: #fff;
background: rgba(255,255,255,0.05);
border: 1px solid rgba(255,255,255,0.08);
color: rgba(255,255,255,0.55);

/* GOOD — theme-aware */
color: var(--crm-text);
background: var(--crm-input);
border: 1px solid var(--crm-border);
color: var(--crm-text-sub);
```

**Visibility checklist before shipping any UI component:**
1. Switch theme to **dark** — check all text, icons, borders are clearly visible
2. Switch theme to **light** — check same elements don't disappear or clash
3. If using `var(--crm-hover)` as background — it is intentionally very subtle (5% opacity). Use `var(--crm-input)` for elements that need to be visually distinct (buttons, badges, icon wrappers)

---

*Document Version: 8.0.0 | Updated: 2026-05-13 | Redis Solution Pvt. Ltd. CRM*
*This document covers every module, every field, every flow, every technical decision.*
*Use as the single source of truth for development.*
