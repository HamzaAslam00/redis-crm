# Redis Solution CRM — Master Architecture & Planning Document
### Prepared by: Software Architect Review | Date: 2026-05-11
### Version: 1.0.0 — Complete Blueprint

---

## TABLE OF CONTENTS

1. [Project Vision & Objectives](#1-project-vision--objectives)
2. [Tech Stack — Full Justification](#2-tech-stack--full-justification)
3. [System Architecture Overview](#3-system-architecture-overview)
4. [Color System & Brand Identity](#4-color-system--brand-identity)
5. [Database Architecture — Complete Schema](#5-database-architecture--complete-schema)
6. [Authentication & Authorization](#6-authentication--authorization)
7. [Backend API Architecture](#7-backend-api-architecture)
8. [Module 01 — Projects Management](#8-module-01--projects-management)
9. [Module 02 — Investments](#9-module-02--investments)
10. [Module 03 — Budget (Expenses & Income)](#10-module-03--budget-expenses--income)
11. [Module 04 — Hosting Clients](#11-module-04--hosting-clients)
12. [Module 05 — API Keys Vault](#12-module-05--api-keys-vault)
13. [Module 06 — Credentials Vault](#13-module-06--credentials-vault)
14. [Module 07 — Demo Projects](#14-module-07--demo-projects)
15. [Module 08 — Crypto Investment](#15-module-08--crypto-investment)
16. [Module 09 — User Personal Notes](#16-module-09--user-personal-notes)
17. [Module 10 — Website States (SEO Manager)](#17-module-10--website-states-seo-manager)
18. [Module 11 — Activity Logs](#18-module-11--activity-logs)
19. [CRM Dashboard — Design & Data](#19-crm-dashboard--design--data)
20. [Frontend Public Website — All Pages](#20-frontend-public-website--all-pages)
21. [UI/UX Design System — CRM Panel](#21-uiux-design-system--crm-panel)
22. [UI/UX Design System — Public Website](#22-uiux-design-system--public-website)
23. [Animation Strategy](#23-animation-strategy)
24. [Security Architecture](#24-security-architecture)
25. [File Storage & Media Management](#25-file-storage--media-management)
26. [Notification System](#26-notification-system)
27. [Folder & File Structure](#27-folder--file-structure)
28. [Development Phases & Timeline](#28-development-phases--timeline)
29. [Environment & Deployment](#29-environment--deployment)

---

## 1. PROJECT VISION & OBJECTIVES

### What We Are Building
A **dual-system platform** for Redis Solution Pvt. Ltd. consisting of:
- **Public-facing website** (Next.js SSR) — stunning, conversion-focused, reflects world-class IT company
- **Private CRM backend panel** (React SPA) — comprehensive internal tool replacing all spreadsheet workflows

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
- **Public Website**: World-class aesthetic. Every scroll reveals a story. Clients must feel they've found their partner on first visit. Animations purposeful, not decorative.

---

## 2. TECH STACK — FULL JUSTIFICATION

### Frontend — Public Website
```
Framework:     Next.js 14 (App Router, SSR/SSG for SEO)
Language:      TypeScript
Styling:       Tailwind CSS + Custom CSS Variables
Animation:     Framer Motion (scroll reveals, page transitions)
              GSAP (complex timeline animations, counters, hero)
3D/Visual:    Three.js (optional hero background particle system)
Icons:         Lucide React + React Icons
Forms:         React Hook Form + Zod validation
Email:         EmailJS or Nodemailer (contact form)
SEO:           next/head, next-seo, sitemap.xml auto-generation
Fonts:         Inter (body) + Space Grotesk (headings)
```

### Frontend — CRM Panel
```
Framework:     React 18 + Vite (fast HMR)
Language:      TypeScript
Styling:       Tailwind CSS + shadcn/ui component library
State:         Zustand (global state) + React Query (server state/cache)
Forms:         React Hook Form + Zod
Charts:        Recharts (budget graphs, project stats)
Tables:        TanStack Table v8 (sortable, filterable, paginated)
Date:          date-fns + React Day Picker
Rich Text:     Tiptap (for notes module)
Drag & Drop:   @dnd-kit (kanban board for projects)
Icons:         Lucide React
Notifications: react-hot-toast
File Upload:   React Dropzone
```

### Backend — API Server
```
Runtime:       Node.js 20 LTS
Framework:     Express.js + TypeScript
ORM:           Prisma (type-safe, migration management)
Database:      MySQL 8.0
Cache/Session: Redis (namesake — fits the brand perfectly)
Auth:          JWT (access token 15min) + Refresh Token (7 days, httpOnly cookie)
Encryption:    AES-256-CBC (credentials & API keys at rest)
File Storage:  Multer + local disk (or AWS S3 for production)
Validation:    Zod (shared types between frontend & backend)
Logging:       Winston (application logs) + custom DB audit logs
Rate Limiting: express-rate-limit
Security:      helmet, cors, express-mongo-sanitize (SQL injection safe via Prisma)
Email:         Nodemailer
API Docs:      Swagger/OpenAPI 3.0
```

### DevOps & Infrastructure
```
Version Control: Git + GitHub
CI/CD:          GitHub Actions
Web Server:     Nginx (reverse proxy)
Process Mgr:    PM2
SSL:            Let's Encrypt (Certbot)
Containerize:   Docker + Docker Compose (optional production)
Monitoring:     PM2 monitoring + optional Sentry for error tracking
```

---

## 3. SYSTEM ARCHITECTURE OVERVIEW

```
┌─────────────────────────────────────────────────────────────┐
│                    CLIENT LAYER                              │
├──────────────────────┬──────────────────────────────────────┤
│  Public Website      │  CRM Admin Panel                     │
│  Next.js (Port 3000) │  React + Vite (Port 5173)            │
│  SSR / SSG / ISR     │  SPA — Protected Routes              │
└──────────┬───────────┴──────────────┬───────────────────────┘
           │                          │
           │     HTTPS / REST API     │
           ▼                          ▼
┌─────────────────────────────────────────────────────────────┐
│                   API SERVER LAYER                           │
│             Node.js + Express (Port 4000)                    │
│  ┌─────────┐ ┌──────────┐ ┌──────────┐ ┌────────────────┐  │
│  │  Auth   │ │ Projects │ │  Budget  │ │  All Modules   │  │
│  │Middleware│ │  Router  │ │  Router  │ │   Routers      │  │
│  └─────────┘ └──────────┘ └──────────┘ └────────────────┘  │
│                   Prisma ORM Layer                           │
└──────────────────────────┬──────────────────────────────────┘
                           │
           ┌───────────────┴────────────────┐
           │                                │
           ▼                                ▼
┌─────────────────────┐          ┌──────────────────────┐
│     MySQL 8.0       │          │   Redis Cache         │
│  Primary Database   │          │  Sessions, Rate Limit │
│  All CRM Data       │          │  Temp Data, OTP       │
└─────────────────────┘          └──────────────────────┘
           │
           ▼
┌─────────────────────┐
│   File Storage      │
│   /uploads (local)  │
│   or AWS S3         │
└─────────────────────┘
```

---

## 4. COLOR SYSTEM & BRAND IDENTITY

### Derived from Redis Solution Website + Professional IT Company Standards

```css
/* ── PRIMARY PALETTE ── */
--color-primary:        #1B2B8C;   /* Deep Navy Blue — trust, authority */
--color-primary-light:  #2D45C8;   /* Medium Blue — buttons, links */
--color-primary-vivid:  #4A6CF7;   /* Vivid Blue — CTA, highlights */

/* ── ACCENT ── */
--color-accent:         #06B6D4;   /* Cyan/Teal — energy, innovation */
--color-accent-light:   #67E8F9;   /* Light Cyan — hover states */

/* ── GRADIENT (Hero & Key Sections) ── */
--gradient-hero:        linear-gradient(135deg, #0F172A 0%, #1B2B8C 50%, #06B6D4 100%);
--gradient-card:        linear-gradient(135deg, #1B2B8C 0%, #4A6CF7 100%);
--gradient-cta:         linear-gradient(90deg, #4A6CF7 0%, #06B6D4 100%);

/* ── NEUTRALS ── */
--color-dark:           #0F172A;   /* Almost black — dark backgrounds */
--color-dark-2:         #1E293B;   /* Card dark backgrounds */
--color-dark-3:         #334155;   /* Borders in dark mode */
--color-body:           #475569;   /* Body text */
--color-muted:          #94A3B8;   /* Placeholder, labels */
--color-border:         #E2E8F0;   /* Light borders */
--color-surface:        #F8FAFC;   /* Light background */
--color-white:          #FFFFFF;

/* ── STATUS COLORS ── */
--color-success:        #10B981;   /* Green — completed, active */
--color-warning:        #F59E0B;   /* Amber — pending, renewals due */
--color-danger:         #EF4444;   /* Red — overdue, deleted, failed */
--color-info:           #3B82F6;   /* Blue — informational */

/* ── GLASSMORPHISM (Public Website Hero Elements) ── */
--glass-bg:             rgba(255,255,255,0.05);
--glass-border:         rgba(255,255,255,0.12);
--glass-backdrop:       blur(16px);
```

### Typography System
```css
/* Public Website */
--font-heading: 'Space Grotesk', sans-serif;  /* Bold, modern, tech feel */
--font-body:    'Inter', sans-serif;           /* Clean, readable */

/* CRM Panel */
--font-ui:      'Inter', sans-serif;           /* Consistent, professional */
--font-mono:    'JetBrains Mono', monospace;   /* API keys, credentials, code */

/* Scale */
--text-xs:   0.75rem;   /* 12px */
--text-sm:   0.875rem;  /* 14px */
--text-base: 1rem;      /* 16px */
--text-lg:   1.125rem;  /* 18px */
--text-xl:   1.25rem;   /* 20px */
--text-2xl:  1.5rem;    /* 24px */
--text-3xl:  1.875rem;  /* 30px */
--text-4xl:  2.25rem;   /* 36px */
--text-5xl:  3rem;      /* 48px */
--text-6xl:  3.75rem;   /* 60px */
--text-7xl:  4.5rem;    /* 72px — hero headline */
```

---

## 5. DATABASE ARCHITECTURE — COMPLETE SCHEMA

### Entity Relationship Overview
```
users ──────────────────────────────────────────────────────┐
  │                                                          │
  ├── projects ──── project_documents                        │
  │       └──────── project_messages                         │
  │                                                          │
  ├── investments ── investment_expenses                      │
  │                                                          │
  ├── budget_expenses                                        │
  ├── budget_incomes                                         │
  │                                                          │
  ├── hosting_clients                                        │
  ├── api_keys                                               │
  ├── credentials                                            │
  ├── demo_projects                                          │
  ├── crypto_investments                                     │
  ├── personal_notes                                         │
  ├── website_seo_states                                     │
  └── activity_logs                                          │
```

### Complete Prisma Schema

```prisma
// ══════════════════════════════════════════════
// USERS & AUTH
// ══════════════════════════════════════════════

model User {
  id               Int       @id @default(autoincrement())
  name             String
  email            String    @unique
  password         String    // bcrypt hashed
  role             Role      @default(STAFF)
  avatar           String?
  isActive         Boolean   @default(true)
  lastLoginAt      DateTime?
  createdAt        DateTime  @default(now())
  updatedAt        DateTime  @updatedAt

  // Relations
  projects         Project[]
  personalNotes    PersonalNote[]
  activityLogs     ActivityLog[]
  refreshTokens    RefreshToken[]
}

enum Role {
  SUPER_ADMIN
  ADMIN
  STAFF
}

model RefreshToken {
  id        Int      @id @default(autoincrement())
  token     String   @unique
  userId    Int
  user      User     @relation(fields: [userId], references: [id])
  expiresAt DateTime
  createdAt DateTime @default(now())
}

// ══════════════════════════════════════════════
// PROJECTS MODULE
// ══════════════════════════════════════════════

model Project {
  id                 Int             @id @default(autoincrement())
  projectCode        String          @unique  // e.g., "RS-2026-001"
  clientName         String
  title              String
  description        String?         @db.Text
  requirementsNote   String?         @db.Text  // 1st requirements message text
  cost               Decimal?        @db.Decimal(12,2)
  currency           String          @default("PKR")
  deadline           DateTime?
  developerName      String?
  status             ProjectStatus   @default(PENDING)
  liveUrl            String?
  testingDomain      String?
  requirementsDocUrl String?         // path to uploaded file
  createdById        Int
  createdBy          User            @relation(fields: [createdById], references: [id])
  createdAt          DateTime        @default(now())
  updatedAt          DateTime        @updatedAt

  // Relations
  documents          ProjectDocument[]
  messages           ProjectMessage[]
}

enum ProjectStatus {
  PENDING
  IN_PROGRESS
  IN_REVIEW
  TESTING
  COMPLETED
  ON_HOLD
  CANCELLED
}

model ProjectDocument {
  id          Int      @id @default(autoincrement())
  projectId   Int
  project     Project  @relation(fields: [projectId], references: [id], onDelete: Cascade)
  fileUrl     String
  fileName    String
  fileSize    Int      // bytes
  fileType    String   // mime type
  note        String?
  uploadedAt  DateTime @default(now())
}

model ProjectMessage {
  id          Int      @id @default(autoincrement())
  projectId   Int
  project     Project  @relation(fields: [projectId], references: [id], onDelete: Cascade)
  sender      String   // "us" | "client" | client_name
  message     String   @db.Text
  attachments String?  // JSON array of file paths
  sentAt      DateTime @default(now())
}

// ══════════════════════════════════════════════
// INVESTMENTS MODULE
// ══════════════════════════════════════════════

model Investment {
  id              Int                 @id @default(autoincrement())
  personName      String
  amount          Decimal?            @db.Decimal(12,2)
  currency        String              @default("PKR")
  ideaDetails     String              @db.Text
  startDate       DateTime
  expectedEndDate DateTime?
  status          InvestmentStatus    @default(ACTIVE)
  createdAt       DateTime            @default(now())
  updatedAt       DateTime            @updatedAt

  // Relations
  expenses        InvestmentExpense[]
}

enum InvestmentStatus {
  ACTIVE
  COMPLETED
  PAUSED
  CANCELLED
}

model InvestmentExpense {
  id            Int         @id @default(autoincrement())
  investmentId  Int
  investment    Investment  @relation(fields: [investmentId], references: [id], onDelete: Cascade)
  details       String      @db.Text
  amount        Decimal     @db.Decimal(12,2)
  spendPurpose  String
  date          DateTime
  output        String?     @db.Text  // what was achieved/produced
  receiptUrl    String?
  createdAt     DateTime    @default(now())
}

// ══════════════════════════════════════════════
// BUDGET MODULE
// ══════════════════════════════════════════════

model BudgetExpense {
  id               Int             @id @default(autoincrement())
  reason           String
  type             ExpenseType
  amount           Decimal         @db.Decimal(12,2)
  currency         String          @default("PKR")
  date             DateTime        @default(now())
  note             String?
  receiptUrl       String?
  createdAt        DateTime        @default(now())
}

enum ExpenseType {
  PERSONAL
  PROJECT
  ASSETS
  GROCERY
  UTILITIES
  OFFICE
  MARKETING
  OTHER
}

model BudgetIncome {
  id          Int       @id @default(autoincrement())
  source      String
  amount      Decimal   @db.Decimal(12,2)
  currency    String    @default("PKR")
  date        DateTime  @default(now())
  note        String?
  proofUrl    String?
  createdAt   DateTime  @default(now())
}

// ══════════════════════════════════════════════
// HOSTING CLIENTS MODULE
// ══════════════════════════════════════════════

model HostingClient {
  id              Int             @id @default(autoincrement())
  clientName      String
  domainName      String
  startingDate    DateTime
  renewDuration   RenewDuration
  amount          Decimal         @db.Decimal(10,2)
  currency        String          @default("PKR")
  serverUsage     ServerUsage
  autoRenew       Boolean         @default(false)
  hostingProvider String?
  serverIP        String?
  notes           String?         @db.Text
  isActive        Boolean         @default(true)
  createdAt       DateTime        @default(now())
  updatedAt       DateTime        @updatedAt
}

enum RenewDuration {
  MONTHLY
  QUARTERLY
  SEMI_ANNUALLY
  YEARLY
  TWO_YEARS
}

enum ServerUsage {
  HOSTING_ONLY
  HOSTING_AND_DOMAIN
  DOMAIN_ONLY
  VPS
  DEDICATED
}

// ══════════════════════════════════════════════
// API KEYS MODULE
// ══════════════════════════════════════════════

model ApiKey {
  id            Int       @id @default(autoincrement())
  providerName  String
  keyLabel      String    // friendly name e.g., "OpenAI Production"
  keyValue      String    // AES-256 encrypted at rest
  keyType       ApiKeyType
  environment   String    @default("production")  // production | staging | dev
  expiresAt     DateTime?
  lastUsedAt    DateTime?
  notes         String?
  isActive      Boolean   @default(true)
  createdAt     DateTime  @default(now())
  updatedAt     DateTime  @updatedAt
}

enum ApiKeyType {
  API_KEY
  SECRET_KEY
  ACCESS_TOKEN
  REFRESH_TOKEN
  WEBHOOK_SECRET
  PRIVATE_KEY
  PUBLIC_KEY
  OTHER
}

// ══════════════════════════════════════════════
// CREDENTIALS MODULE
// ══════════════════════════════════════════════

model Credential {
  id          Int             @id @default(autoincrement())
  systemName  String
  url         String?
  username    String?
  email       String?
  password    String          // AES-256 encrypted
  ipAddress   String?
  port        String?
  command     String?         @db.Text  // SSH commands, etc.
  ownerType   CredentialOwner // personal | client
  ownerName   String?         // client name if client type
  credType    CredentialType
  notes       String?         @db.Text
  isActive    Boolean         @default(true)
  createdAt   DateTime        @default(now())
  updatedAt   DateTime        @updatedAt
}

enum CredentialOwner {
  PERSONAL
  CLIENT
}

enum CredentialType {
  WEB_PANEL
  SSH
  FTP
  SFTP
  DATABASE
  EMAIL
  SOCIAL_MEDIA
  PAYMENT_GATEWAY
  CLOUD_CONSOLE
  VPN
  OTHER
}

// ══════════════════════════════════════════════
// DEMO PROJECTS MODULE
// ══════════════════════════════════════════════

model DemoProject {
  id           Int      @id @default(autoincrement())
  clientName   String?  // optional — may be a general demo
  siteName     String
  url          String
  description  String?  @db.Text
  techStack    String?  // comma-separated or JSON
  thumbnail    String?  // screenshot/preview image path
  isPublic     Boolean  @default(true)
  createdAt    DateTime @default(now())
  updatedAt    DateTime @updatedAt
}

// ══════════════════════════════════════════════
// CRYPTO INVESTMENT MODULE
// ══════════════════════════════════════════════

model CryptoInvestment {
  id              Int      @id @default(autoincrement())
  date            DateTime
  amountInvested  Decimal  @db.Decimal(16,4)  // in PKR or USD
  currency        String   @default("USD")
  coin            String   // BTC, ETH, SOL, etc.
  coinSymbol      String
  quantity        Decimal? @db.Decimal(20,8)  // how many coins
  walletAddress   String?
  walletLabel     String?  // e.g., "Binance", "MetaMask", "Hardware"
  exchange        String?  // Binance, Coinbase, etc.
  txHash          String?  // transaction hash
  notes           String?
  createdAt       DateTime @default(now())
}

// ══════════════════════════════════════════════
// PERSONAL NOTES MODULE
// ══════════════════════════════════════════════

model PersonalNote {
  id          Int      @id @default(autoincrement())
  userId      Int      // STRICT: only owner can see/edit
  user        User     @relation(fields: [userId], references: [id])
  title       String?
  content     String   @db.LongText  // rich text (TipTap HTML)
  isPinned    Boolean  @default(false)
  color       String?  // hex color for note card color-coding
  tags        String?  // JSON array of tags
  createdAt   DateTime @default(now())
  updatedAt   DateTime @updatedAt
}

// ══════════════════════════════════════════════
// WEBSITE SEO STATES MODULE
// ══════════════════════════════════════════════

model WebsiteSeoState {
  id                  Int       @id @default(autoincrement())
  siteName            String
  siteUrl             String
  clientName          String?
  metaTitle           String?
  metaDescription     String?   @db.Text
  keywords            String?   @db.Text
  googleRanking       Int?      // approximate position
  googleIndexed       Boolean   @default(false)
  lastAuditDate       DateTime?
  pageSpeedScore      Int?      // 0-100
  mobileScore         Int?      // 0-100
  seoScore            Int?      // 0-100
  backlinksCount      Int?
  domain Authority    Int?
  sitemapUrl          String?
  robotsTxtOk         Boolean   @default(false)
  sslActive           Boolean   @default(true)
  lastUpdatedContent  DateTime?
  notes               String?   @db.Text
  issues              String?   @db.LongText  // JSON array of issues
  improvements        String?   @db.LongText  // JSON array of actions taken
  createdAt           DateTime  @default(now())
  updatedAt           DateTime  @updatedAt
}

// ══════════════════════════════════════════════
// ACTIVITY LOGS MODULE
// ══════════════════════════════════════════════

model ActivityLog {
  id          Int          @id @default(autoincrement())
  userId      Int
  user        User         @relation(fields: [userId], references: [id])
  action      String       // e.g., "CREATE_PROJECT", "UPDATE_STATUS", "DELETE_CREDENTIAL"
  module      LogModule
  entityId    Int?         // ID of the affected entity
  entityTitle String?      // human-readable name of entity
  oldValue    String?      @db.LongText  // JSON — state before
  newValue    String?      @db.LongText  // JSON — state after
  ipAddress   String?
  userAgent   String?
  createdAt   DateTime     @default(now())
}

enum LogModule {
  AUTH
  PROJECTS
  INVESTMENTS
  BUDGET
  HOSTING
  API_KEYS
  CREDENTIALS
  DEMO_PROJECTS
  CRYPTO
  NOTES
  SEO
  USERS
  SYSTEM
}
```

---

## 6. AUTHENTICATION & AUTHORIZATION

### Auth Flow
```
LOGIN REQUEST
     │
     ▼
[POST /api/auth/login]
     │
     ├── Validate email + password (bcrypt.compare)
     ├── Check isActive flag
     ├── Record lastLoginAt
     ├── Generate: accessToken (JWT, 15min, in response body)
     │            refreshToken (JWT, 7 days, httpOnly cookie)
     ├── Store refreshToken hash in DB (RefreshToken table)
     └── Log: ActivityLog { module: AUTH, action: LOGIN }

ACCESS TOKEN REFRESH
     │
[POST /api/auth/refresh]
     │
     ├── Read refreshToken from httpOnly cookie
     ├── Validate token + check against DB
     ├── Issue new accessToken
     └── Rotate refreshToken (old deleted, new issued)

LOGOUT
     │
[POST /api/auth/logout]
     │
     ├── Delete refreshToken from DB
     ├── Clear httpOnly cookie
     └── Log: ActivityLog { action: LOGOUT }
```

### Role Permissions Matrix
| Feature | SUPER_ADMIN | ADMIN | STAFF |
|---|---|---|---|
| View all modules | ✅ | ✅ | ✅ |
| Create any record | ✅ | ✅ | ✅ |
| Edit any record | ✅ | ✅ | Own records |
| Delete records | ✅ | ✅ | ❌ |
| View credentials (decrypted) | ✅ | ✅ | ❌ |
| View API keys (decrypted) | ✅ | ✅ | ❌ |
| View budget totals | ✅ | ✅ | ❌ |
| Manage users | ✅ | ❌ | ❌ |
| View activity logs | ✅ | ✅ | Own only |
| Export data | ✅ | ✅ | ❌ |

### Middleware Chain
```
Request → rateLimiter → authenticateJWT → checkRole → validateBody → controller
```

---

## 7. BACKEND API ARCHITECTURE

### Base URL Structure
```
Production:  https://api.redissolution.com/api/v1
Development: http://localhost:4000/api/v1
```

### Complete Routes Map

```
AUTH
  POST   /auth/login
  POST   /auth/logout
  POST   /auth/refresh
  GET    /auth/me

PROJECTS
  GET    /projects              (list, filter by status/developer/date)
  POST   /projects              (create)
  GET    /projects/:id          (single with documents & messages)
  PUT    /projects/:id          (update)
  DELETE /projects/:id          (soft delete)
  PATCH  /projects/:id/status   (quick status update)
  POST   /projects/:id/documents
  DELETE /projects/:id/documents/:docId
  GET    /projects/:id/messages
  POST   /projects/:id/messages
  DELETE /projects/:id/messages/:msgId

INVESTMENTS
  GET    /investments
  POST   /investments
  GET    /investments/:id
  PUT    /investments/:id
  DELETE /investments/:id
  GET    /investments/:id/expenses
  POST   /investments/:id/expenses
  PUT    /investments/:id/expenses/:expId
  DELETE /investments/:id/expenses/:expId

BUDGET
  GET    /budget/summary         (monthly/yearly P&L)
  GET    /budget/expenses        (list, filter by type/date/month)
  POST   /budget/expenses
  PUT    /budget/expenses/:id
  DELETE /budget/expenses/:id
  GET    /budget/incomes         (list, filter by source/date/month)
  POST   /budget/incomes
  PUT    /budget/incomes/:id
  DELETE /budget/incomes/:id
  GET    /budget/monthly-report/:year/:month

HOSTING
  GET    /hosting
  POST   /hosting
  GET    /hosting/:id
  PUT    /hosting/:id
  DELETE /hosting/:id
  GET    /hosting/renewals-due   (next 30 days)

API-KEYS
  GET    /api-keys
  POST   /api-keys
  GET    /api-keys/:id           (returns encrypted placeholder)
  GET    /api-keys/:id/reveal    (decrypted — admin only, logged)
  PUT    /api-keys/:id
  DELETE /api-keys/:id

CREDENTIALS
  GET    /credentials
  POST   /credentials
  GET    /credentials/:id        (returns masked password)
  GET    /credentials/:id/reveal (decrypted — admin only, logged)
  PUT    /credentials/:id
  DELETE /credentials/:id

DEMO-PROJECTS
  GET    /demo-projects
  POST   /demo-projects
  GET    /demo-projects/:id
  PUT    /demo-projects/:id
  DELETE /demo-projects/:id

CRYPTO
  GET    /crypto
  POST   /crypto
  GET    /crypto/:id
  PUT    /crypto/:id
  DELETE /crypto/:id
  GET    /crypto/portfolio-summary

NOTES
  GET    /notes                  (own user's notes only)
  POST   /notes
  GET    /notes/:id
  PUT    /notes/:id
  DELETE /notes/:id
  PATCH  /notes/:id/pin

SEO
  GET    /seo
  POST   /seo
  GET    /seo/:id
  PUT    /seo/:id
  DELETE /seo/:id

LOGS
  GET    /logs                   (admin+ only, filter by module/user/date)
  GET    /logs/my                (own actions)

USERS
  GET    /users                  (super admin only)
  POST   /users
  GET    /users/:id
  PUT    /users/:id
  DELETE /users/:id

DASHBOARD
  GET    /dashboard/stats        (project counts, budget summary, renewals due, etc.)

PUBLIC (no auth required)
  POST   /public/contact         (contact form submission)
```

### Standard API Response Format
```json
// Success
{
  "success": true,
  "data": { ... },
  "message": "Project created successfully",
  "meta": { "page": 1, "limit": 20, "total": 145 }
}

// Error
{
  "success": false,
  "error": {
    "code": "VALIDATION_ERROR",
    "message": "Deadline must be a future date",
    "details": [...]
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

## 17. MODULE 10 — WEBSITE STATES (SEO MANAGER)

### Overview
Track SEO performance and manage SEO updates for client or internal websites.

### SEO State Form Fields
| Field | Type | Required | Notes |
|---|---|---|---|
| Site Name | Text | ✅ | |
| Site URL | URL | ✅ | |
| Client Name | Text | ❌ | |
| Meta Title | Text | ❌ | Max 60 chars, counter shown |
| Meta Description | Textarea | ❌ | Max 160 chars, counter shown |
| Keywords | Textarea | ❌ | Comma separated |
| Google Ranking | Number | ❌ | Current approximate SERP position |
| Google Indexed | Toggle | ❌ | Is site indexed? |
| Last Audit Date | Date | ❌ | |
| PageSpeed Score | Number (0-100) | ❌ | |
| Mobile Score | Number (0-100) | ❌ | |
| SEO Score | Number (0-100) | ❌ | |
| Backlinks Count | Number | ❌ | |
| Sitemap URL | URL | ❌ | |
| Robots.txt OK | Toggle | ❌ | |
| SSL Active | Toggle | ❌ | Default true |
| Issues | Tag/List Input | ❌ | Known SEO issues |
| Improvements | Tag/List Input | ❌ | Actions taken |
| Notes | Textarea | ❌ | General notes |

### SEO Scores Display
- Circular progress gauges (0-100) with color:
  - 0-49: Red
  - 50-74: Amber
  - 75-89: Yellow-green
  - 90-100: Green

---

## 18. MODULE 11 — ACTIVITY LOGS

### Overview
Every state-changing action in the CRM is recorded automatically. Not manually entered by users.

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

### CRM Navigation (Sidebar)
```
[Logo — Redis Solution]
─────────────────────
📊 Dashboard
─────────────────────
WORK
📁 Projects
💼 Investments
─────────────────────
FINANCE
💰 Budget
   ├── Expenses
   └── Income
₿  Crypto
─────────────────────
CLIENTS
🌐 Hosting Clients
🎭 Demo Projects
─────────────────────
VAULT
🔑 API Keys
🔒 Credentials
─────────────────────
TOOLS
📝 My Notes
🔍 SEO Manager
📋 Activity Logs
─────────────────────
ADMIN (admin+ only)
👥 Users
⚙️ Settings
─────────────────────
[User Avatar & Name]
[Logout button]
```

---

## 20. FRONTEND PUBLIC WEBSITE — ALL PAGES

### Global Website Rules
- All pages share: Navbar (sticky, transparent→solid on scroll) + Footer
- Smooth page transitions (Framer Motion `AnimatePresence`)
- Scroll progress bar at top
- Lazy loading for all images (next/image)
- Mobile-first responsive (320px → 1920px+)
- All text from Redis Solution website used as authentic content
- Color scheme: Navy → Vivid Blue → Cyan gradient system

---

### PAGE 1: HOME (`/`)

#### Section 1 — HERO
```
Full viewport height
Background: Animated gradient mesh (navy → deep blue → cyan accents)
           Subtle particle system (Three.js or tsparticles)

Left side (60%):
  - Small pill badge: "🚀 Trusted by 100+ Clients Worldwide"
  - H1 (72px, Space Grotesk bold):
    "We Make Your
     Business Digital"
  - Subheading (20px):
    "Redis Solution delivers cutting-edge web, mobile, and AI solutions
     that transform your vision into powerful digital reality."
  - Two CTAs:
    [Get Free Consultation →]  (filled, gradient button)
    [See Our Work]             (ghost button)
  - Trust badges: ⭐⭐⭐⭐⭐ | 100+ Happy Clients | 4+ Years Experience

Right side (40%):
  - 3D/animated floating mockup cards showing:
    - Dashboard screenshot (floating, slight rotation)
    - Mobile app screenshot
    - Glassmorphism stat cards overlapping
  - Floating elements animate up/down (CSS keyframes)

Scroll indicator: animated bouncing chevron at bottom
```

#### Section 2 — STATS COUNTER
```
Background: Dark navy (#0F172A)
4 columns, each animates count up when scrolled into view:

[100+]        [4+]          [50+]         [99%]
Happy Clients  Years Exp.   Technologies  Client Satisfaction
```

#### Section 3 — SERVICES OVERVIEW
```
Header: "What We Build For You"
Subheader: "End-to-end digital solutions for modern businesses"

6 service cards in 3×2 grid (staggered entrance animation):

Each card:
  - Gradient icon background (unique color per service)
  - Service name (bold)
  - 2-line description
  - "Learn More →" link
  - Hover: card lifts, border glows, icon rotates slightly

Services:
1. Website Development    - Blue gradient icon
2. Mobile App Development - Purple gradient icon
3. Digital Marketing      - Pink gradient icon
4. Software Development   - Orange gradient icon
5. ERP & CMS              - Teal gradient icon
6. AI Applications        - Indigo gradient icon
```

#### Section 4 — WHY CHOOSE US
```
Split layout (50/50):
Left: Layered browser/device mockup (animated)
Right:
  Heading: "Why Businesses Trust Redis Solution"
  5 feature rows (each with icon + text, stagger-in animation):
  ✅ Expert Team — 50+ technologies mastered
  ✅ Client-First Approach — Tailored to your needs
  ✅ Agile Development — Real-time progress transparency
  ✅ 24/7 Support — Post-launch maintenance included
  ✅ 100% Code Ownership — Yours from day one
```

#### Section 5 — PORTFOLIO PREVIEW
```
Heading: "Our Recent Work"
Subheading: "See the digital experiences we've crafted"

Filter tabs: [All] [Web] [Mobile] [CRM] [AI]

Grid of 6 portfolio items (3×2 desktop, 1 column mobile):
Each item:
  - Full image with overlay on hover
  - Hover reveals: project name + tech tags + "View Project" button
  - Smooth scale + overlay animation on hover

[View Full Portfolio →] button centered below
```

#### Section 6 — TESTIMONIAL
```
Background: Subtle gradient
Single featured testimonial (large):
  - Large quotation mark graphic
  - Quote text (24px, italic)
  - Client photo (circular)
  - Client name + title + company
  
"Redis Solution has been a game-changer for our business.
 Their professionalism and expertise delivered beyond our expectations."
 — Mark Jensen, CEO, Agnatech

Below: Logo strip "Trusted by companies like:" (scrolling marquee)
```

#### Section 7 — INDUSTRIES WE SERVE
```
Horizontal scrolling pills or icon grid:
Healthcare | E-commerce | Education | Real Estate | Finance
Logistics | Oil & Gas | Shipping | Point of Sale | Technology
```

#### Section 8 — PROCESS / HOW WE WORK
```
4-step horizontal timeline (animated connector line between steps):

1. 💬 Consultation   → 2. 📋 Planning   → 3. ⚙️ Development   → 4. 🚀 Launch
"Tell us your vision"   "We plan it all"   "We build with care"   "Go live & grow"
```

#### Section 9 — CTA BANNER
```
Full-width section, gradient background (navy to cyan)
Heading: "Ready to Transform Your Business?"
Subheading: "Let's build something extraordinary together."
Two buttons: [Start Your Project] [Schedule a Call]
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

### Layout
- **Sidebar**: 260px fixed left, collapsible to 72px (icon-only mode)
- **Main content**: Right of sidebar, full height, scrollable
- **Header bar**: 64px, sticky top — breadcrumb + search + notifications + user avatar
- **Page container**: max-width 1400px, px-6 py-8

### Component Standards (shadcn/ui based)

**Cards**
- Rounded-xl (12px radius)
- Border: 1px solid border color
- Shadow: subtle box shadow
- Hover on interactive cards: slight lift

**Tables (TanStack)**
- Striped rows (subtle)
- Sticky header on scroll
- Column sorting indicators
- Row hover highlight
- Pagination: 20/50/100 per page options

**Forms**
- Label above input
- Error message below in red
- All required fields marked with `*`
- Validation on blur + on submit
- Submit button shows loading spinner

**Status Badges**
- Pill shape, colored background + text
- PENDING: amber | IN_PROGRESS: blue | COMPLETED: green | ON_HOLD: gray | CANCELLED: red

**Modals**
- Centered overlay with backdrop blur
- Smooth scale-in animation
- Close on Escape key + backdrop click

### Dark / Light Mode
- Toggle in header
- Preference saved to localStorage
- CSS variables switch seamlessly (no flash on load)

---

## 22. UI/UX DESIGN SYSTEM — PUBLIC WEBSITE

### Component Patterns

**Navigation (Navbar)**
```
Transparent at top → white/dark with shadow on scroll
Logo (left) | Nav links (center) | [Get Started] CTA button (right)
Mobile: hamburger → fullscreen slide-in menu with link animations
Links: Home | Services | Portfolio | About | Contact
Active link: gradient underline
```

**Buttons**
```
Primary: Gradient bg (blue→cyan) + white text + hover scale 1.02
Ghost: Border + text, hover: filled
Text link: Color + underline on hover + arrow →
All: 0.2s ease transition, cursor-pointer
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

### Public Website Animations

| Section | Animation | Library | Trigger |
|---|---|---|---|
| Hero headline | Text reveal (word by word) | Framer Motion | On mount |
| Hero mockups | Float up + down (infinite) | CSS keyframes | Immediate |
| Hero background | Gradient mesh shift | CSS keyframes | Continuous |
| Stats counters | Count 0 → N | GSAP CountTo | On viewport enter |
| Service cards | Stagger slide-up + fade-in | Framer Motion | On viewport enter |
| Section headers | Slide up + fade | Framer Motion | On viewport enter |
| Portfolio items | Scale in, stagger | Framer Motion | On filter/mount |
| Timeline steps | Draw line + pop nodes | GSAP / CSS | On scroll |
| Testimonial | Fade slide in | Framer Motion | On viewport enter |
| CTA banner | Gradient animate | CSS keyframes | Continuous |
| Page transition | Cross-fade + slide | Framer Motion AnimatePresence | On route change |
| Scroll progress bar | Width grows | CSS / JS | On scroll |
| Navbar | Blur + shadow appear | CSS transition | On scroll |

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

## 27. FOLDER & FILE STRUCTURE

```
redis-crm/
├── apps/
│   ├── web/                          ← Next.js public website
│   │   ├── app/
│   │   │   ├── (pages)/
│   │   │   │   ├── page.tsx          ← Home
│   │   │   │   ├── services/page.tsx
│   │   │   │   ├── about/page.tsx
│   │   │   │   ├── portfolio/page.tsx
│   │   │   │   ├── contact/page.tsx
│   │   │   │   ├── faqs/page.tsx
│   │   │   │   ├── privacy-policy/page.tsx
│   │   │   │   └── refund-policy/page.tsx
│   │   │   ├── layout.tsx
│   │   │   └── globals.css
│   │   ├── components/
│   │   │   ├── layout/
│   │   │   │   ├── Navbar.tsx
│   │   │   │   └── Footer.tsx
│   │   │   ├── home/
│   │   │   │   ├── HeroSection.tsx
│   │   │   │   ├── StatsSection.tsx
│   │   │   │   ├── ServicesSection.tsx
│   │   │   │   ├── PortfolioPreview.tsx
│   │   │   │   ├── TestimonialSection.tsx
│   │   │   │   ├── WhyUsSection.tsx
│   │   │   │   ├── ProcessSection.tsx
│   │   │   │   └── CTASection.tsx
│   │   │   ├── services/
│   │   │   ├── portfolio/
│   │   │   ├── contact/
│   │   │   └── shared/
│   │   │       ├── AnimatedSection.tsx  ← scroll reveal wrapper
│   │   │       ├── CounterCard.tsx
│   │   │       └── GradientText.tsx
│   │   ├── lib/
│   │   │   ├── animations.ts            ← Framer Motion variants
│   │   │   └── api.ts                   ← Contact form API calls
│   │   └── public/
│   │       ├── images/
│   │       └── favicon.ico
│   │
│   └── crm/                          ← React CRM Panel
│       ├── src/
│       │   ├── pages/
│       │   │   ├── Dashboard.tsx
│       │   │   ├── auth/
│       │   │   │   └── Login.tsx
│       │   │   ├── projects/
│       │   │   │   ├── ProjectsList.tsx
│       │   │   │   ├── ProjectDetail.tsx
│       │   │   │   └── ProjectForm.tsx
│       │   │   ├── investments/
│       │   │   ├── budget/
│       │   │   ├── hosting/
│       │   │   ├── api-keys/
│       │   │   ├── credentials/
│       │   │   ├── demo-projects/
│       │   │   ├── crypto/
│       │   │   ├── notes/
│       │   │   ├── seo/
│       │   │   ├── logs/
│       │   │   └── users/
│       │   ├── components/
│       │   │   ├── layout/
│       │   │   │   ├── Sidebar.tsx
│       │   │   │   ├── Header.tsx
│       │   │   │   └── AppLayout.tsx
│       │   │   ├── ui/                  ← shadcn/ui components
│       │   │   ├── shared/
│       │   │   │   ├── DataTable.tsx
│       │   │   │   ├── PageHeader.tsx
│       │   │   │   ├── StatusBadge.tsx
│       │   │   │   ├── RevealField.tsx  ← for API keys & credentials
│       │   │   │   ├── FileUploader.tsx
│       │   │   │   └── ConfirmDialog.tsx
│       │   │   └── charts/
│       │   │       ├── BudgetChart.tsx
│       │   │       └── ProjectStatusChart.tsx
│       │   ├── store/                   ← Zustand stores
│       │   │   ├── authStore.ts
│       │   │   └── uiStore.ts
│       │   ├── hooks/
│       │   │   ├── useProjects.ts       ← React Query hooks
│       │   │   ├── useBudget.ts
│       │   │   └── ...
│       │   ├── lib/
│       │   │   ├── api.ts               ← Axios instance + interceptors
│       │   │   ├── utils.ts
│       │   │   └── formatters.ts
│       │   └── types/
│       │       └── index.ts             ← Shared TypeScript types
│       └── index.html
│
├── server/                           ← Node.js Express API
│   ├── src/
│   │   ├── routes/
│   │   │   ├── auth.routes.ts
│   │   │   ├── projects.routes.ts
│   │   │   ├── investments.routes.ts
│   │   │   ├── budget.routes.ts
│   │   │   ├── hosting.routes.ts
│   │   │   ├── apiKeys.routes.ts
│   │   │   ├── credentials.routes.ts
│   │   │   ├── demoProjects.routes.ts
│   │   │   ├── crypto.routes.ts
│   │   │   ├── notes.routes.ts
│   │   │   ├── seo.routes.ts
│   │   │   ├── logs.routes.ts
│   │   │   ├── users.routes.ts
│   │   │   ├── dashboard.routes.ts
│   │   │   └── public.routes.ts
│   │   ├── controllers/              ← one per module
│   │   ├── middleware/
│   │   │   ├── authenticate.ts
│   │   │   ├── authorize.ts          ← role check
│   │   │   ├── validate.ts           ← Zod validation
│   │   │   ├── rateLimiter.ts
│   │   │   └── logger.ts             ← auto activity logging
│   │   ├── services/
│   │   │   ├── encryption.service.ts
│   │   │   ├── email.service.ts
│   │   │   └── upload.service.ts
│   │   ├── lib/
│   │   │   ├── prisma.ts             ← Prisma client singleton
│   │   │   └── redis.ts              ← Redis client
│   │   ├── schemas/                  ← Zod validation schemas
│   │   └── app.ts                    ← Express app setup
│   ├── prisma/
│   │   ├── schema.prisma
│   │   └── migrations/
│   ├── uploads/                      ← file storage
│   └── .env
│
├── package.json                      ← monorepo root
├── docker-compose.yml
└── README.md
```

---

## 28. DEVELOPMENT PHASES & TIMELINE

### Phase 1 — Foundation (Week 1-2)
- [ ] Initialize monorepo (turborepo or nx)
- [ ] Setup MySQL + Prisma schema + migrations
- [ ] Setup Redis client
- [ ] Express server setup: middleware, error handling, CORS
- [ ] Auth module: login, JWT, refresh, logout
- [ ] User management API
- [ ] Activity log middleware (global auto-logging)

### Phase 2 — Core Backend APIs (Week 3-4)
- [ ] Projects module (full CRUD + documents + messages)
- [ ] Budget module (expenses + income + summary)
- [ ] Investments module
- [ ] Hosting Clients module
- [ ] Dashboard stats endpoint

### Phase 3 — Vault & Remaining Backend (Week 5)
- [ ] API Keys module (with encryption)
- [ ] Credentials module (with encryption)
- [ ] Demo Projects module
- [ ] Crypto Investment module
- [ ] Personal Notes module (strict user isolation)
- [ ] SEO Manager module
- [ ] Logs endpoint (filtered)

### Phase 4 — CRM Frontend (Week 6-9)
- [ ] Project setup: Vite + React + TypeScript + Tailwind + shadcn/ui
- [ ] Login page
- [ ] Layout: Sidebar + Header + routing
- [ ] Dashboard page (all widgets)
- [ ] Projects: list (kanban + table) + detail (tabs) + form
- [ ] Budget: expenses + income + charts
- [ ] Investments: list + detail + expenses
- [ ] Hosting Clients: list + form + renewal alerts
- [ ] API Keys vault: list + reveal
- [ ] Credentials vault: list + reveal
- [ ] Demo Projects
- [ ] Crypto Investment
- [ ] Personal Notes (rich editor)
- [ ] SEO Manager
- [ ] Activity Logs
- [ ] User Management (admin)
- [ ] Dark/Light mode toggle
- [ ] Notifications

### Phase 5 — Public Website (Week 10-12)
- [ ] Next.js setup with Tailwind + Framer Motion + GSAP
- [ ] Global: Navbar + Footer + page transitions
- [ ] Home page: all 9 sections + all animations
- [ ] Services page
- [ ] Portfolio page + lightbox
- [ ] About page
- [ ] Contact page + form submission
- [ ] FAQs page (accordion)
- [ ] Privacy Policy + Refund Policy
- [ ] SEO: meta tags, sitemap.xml, robots.txt, Open Graph
- [ ] Performance: image optimization, lazy loading, code splitting

### Phase 6 — QA, Polish & Deployment (Week 13-14)
- [ ] Full responsive testing (320px → 1920px)
- [ ] Cross-browser testing (Chrome, Firefox, Safari, Edge)
- [ ] Security audit (OWASP checklist)
- [ ] Performance audit (Lighthouse ≥90 score)
- [ ] Load testing (Artillery or k6)
- [ ] Nginx config + SSL
- [ ] PM2 process management
- [ ] Docker Compose setup
- [ ] CI/CD pipeline (GitHub Actions)
- [ ] Documentation

---

## 29. ENVIRONMENT & DEPLOYMENT

### Environment Variables (server/.env)
```bash
# App
NODE_ENV=production
PORT=4000
API_BASE_URL=https://api.redissolution.com

# Database
DATABASE_URL="mysql://user:password@localhost:3306/redis_crm"

# Redis
REDIS_URL=redis://localhost:6379

# JWT
JWT_ACCESS_SECRET=<64-char-random-string>
JWT_REFRESH_SECRET=<64-char-random-string>
JWT_ACCESS_EXPIRY=15m
JWT_REFRESH_EXPIRY=7d

# Encryption (API Keys & Credentials)
ENCRYPTION_KEY=<64-char-hex-string>   # 32 bytes = 64 hex chars

# Email
SMTP_HOST=smtp.gmail.com
SMTP_PORT=587
SMTP_USER=info@redissolution.com
SMTP_PASS=<app-password>
MAIL_FROM="Redis Solution <info@redissolution.com>"

# File Upload
UPLOAD_DIR=./uploads
MAX_FILE_SIZE=20971520   # 20MB in bytes

# CORS
ALLOWED_ORIGINS=https://redissolution.com,https://crm.redissolution.com
```

### Nginx Configuration
```nginx
# Public Website
server {
    listen 443 ssl;
    server_name redissolution.com www.redissolution.com;
    location / {
        proxy_pass http://localhost:3000;
        proxy_set_header Host $host;
    }
}

# CRM Panel
server {
    listen 443 ssl;
    server_name crm.redissolution.com;
    root /var/www/crm/dist;
    try_files $uri /index.html;   # SPA fallback
}

# API
server {
    listen 443 ssl;
    server_name api.redissolution.com;
    location / {
        proxy_pass http://localhost:4000;
        proxy_set_header Host $host;
        proxy_set_header X-Real-IP $remote_addr;
    }
}
```

### Deployment Architecture
```
Domain:   redissolution.com        → Public Website (Next.js)
Domain:   crm.redissolution.com    → CRM Panel (React SPA)
Domain:   api.redissolution.com    → Express API Server

All behind Nginx with SSL (Let's Encrypt)
PM2 manages: Next.js process + Express process
MySQL: Local on same server or managed RDS
Redis: Local or managed Redis Cloud
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

*Document Version: 1.0.0 | Prepared: 2026-05-11 | Redis Solution Pvt. Ltd. CRM*
*This document covers every module, every field, every flow, every technical decision.*
*Use as the single source of truth for development.*
