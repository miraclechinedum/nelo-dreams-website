# Nelo Dreams Foundation International — Website

A modern, world‑class website for **Nelo Dreams Foundation International**, a child
mental‑health awareness NGO, in strategic partnership with **Rangers International FC
Foundation**.

> _“Glad You Were Born.”_

Built with **Laravel 12 · Blade · Tailwind CSS v4 · Alpine.js**. Editorial layouts,
authentic storytelling, subtle scroll animations, animated counters, and a fully
CMS‑ready content architecture.

---

## Tech stack

| Layer        | Choice                                            |
| ------------ | ------------------------------------------------- |
| Framework    | Laravel 12 (PHP 8.2+)                             |
| Templating   | Blade components + anonymous components           |
| Styling      | Tailwind CSS v4 (CSS‑first `@theme` config)       |
| Interactivity| Alpine.js v3 (+ `intersect`, `collapse` plugins)  |
| Build        | Vite 7 (`@tailwindcss/vite`)                      |
| Database     | SQLite by default (any Laravel‑supported driver)  |

---

## Getting started

```bash
# 1. Install dependencies
composer install
npm install

# 2. Environment
cp .env.example .env        # already present after scaffold
php artisan key:generate

# 3. Database (SQLite is the default)
touch database/database.sqlite        # if it doesn't exist
php artisan migrate --seed

# 4a. Develop (hot reload)
npm run dev                 # in one terminal
php artisan serve           # in another  ->  http://127.0.0.1:8000

# 4b. …or build for production
npm run build
php artisan serve
```

> **Important:** serve through `php artisan serve` (or a real web server). A bare
> `php -S … public/index.php` will not serve the compiled `/build` assets.

---

## Adding the real brand assets

The site ships with elegant, brand‑coloured **placeholders** so it looks complete out of
the box. Drop the real files at these paths to replace them automatically — no code
changes required (each component checks `file_exists` and falls back to the placeholder):

| Asset                         | Path                                    |
| ----------------------------- | --------------------------------------- |
| Nelo Dreams logo (circular)   | `public/images/logo-nelo.jpeg`          |
| Rangers Foundation logo       | `public/images/logo-rangers.jpeg`       |
| Diamond Tech Innovations logo | `public/images/logo-dti.jpeg`           |
| Hero background photo         | `public/images/hero.jpg`                |
| About section photo           | `public/images/about.jpg`               |
| CTA background photo          | `public/images/cta.jpg`                 |
| Program photos                | `public/images/programs/*.jpg`          |
| Impact story photos           | `public/images/impact/*.jpg`            |
| Gallery photos                | `public/images/gallery/*.jpg`           |
| Featured impact video         | `public/videos/featured.mp4`            |

`.png`, `.jpg`, `.jpeg`, `.svg` and `.webp` are all accepted for the logos. Image paths
for programs / stories / gallery are defined in the seeders and stored in the database, so
you can also manage them from a future admin panel. Large source media kept locally for
reference can live under `public/images/_archive/` — that folder is gitignored.

---

## Project structure

```
app/
├── Console/Commands/      CreateAdminUser (php artisan admin:user)
├── Http/Controllers/      HomeController, UpdateController, ContactController
│                          Auth/LoginController, Admin/* (dashboard, posts,
│                          media, messages, account)
├── Http/Requests/         StoreContactRequest (validation + honeypot),
│                          Admin/PostRequest, Admin/MediaItemRequest
├── Support/               MediaStorage (uploads → public/uploads)
└── Models/                Statistic, Objective, CoreValue, Program,
                           ImpactStory, Post, MediaItem, Partner, Testimonial,
                           ContactMessage  (+ Concerns/Publishable trait)

database/
├── migrations/            One table per content type
└── seeders/               Sample NGO content for every section

resources/
├── css/app.css            Design system: brand palette, type, motion
├── js/app.js              Alpine + counter, reveal observer, sticky header
└── views/
    ├── layouts/           app.blade.php, admin.blade.php
    ├── components/        button, card, program-card, objective-card,
    │                      value-card, testimonial, timeline-item, stat,
    │                      section-header, media, reveal, icon, logo/*
    ├── pages/             home.blade.php, updates/{index,show}
    ├── admin/             dashboard, posts/*, media/*, messages, account
    ├── auth/login.blade.php
    └── partials/
        ├── header.blade.php, footer.blade.php
        └── home/          hero, about, objectives, programs, values, impact,
                           updates, testimonials, partnership, approach, cta,
                           contact + infographics/
```

---

## Content management (CMS‑ready)

Every section is driven by Eloquent models, so content can be edited in the database today
and wired to an admin UI later. Each content model uses the `Publishable` trait providing
`->active()` and `->ordered()` query scopes.

| Model            | Table              | Powers                          |
| ---------------- | ------------------ | ------------------------------- |
| `Statistic`      | `statistics`       | Hero impact counters            |
| `Objective`      | `objectives`       | The three objective cards       |
| `CoreValue`      | `core_values`      | AIDDT values                    |
| `Program`        | `programs`         | Programs grid                   |
| `ImpactStory`    | `impact_stories`   | Impact timeline                 |
| `Post`           | `posts`            | `/updates` — news & outreach reports |
| `MediaItem`      | `media_items`      | Photos/videos: “From the field” gallery + post attachments |
| `Partner`        | `partners`         | Rangers partnership + partners  |
| `Testimonial`    | `testimonials`     | Community voices                |
| `ContactMessage` | `contact_messages` | Submitted contact enquiries     |

Re‑seed any time with `php artisan db:seed` (idempotent — uses `updateOrCreate`;
it never touches anything uploaded through the admin panel).

---

## Admin panel

The foundation posts its own pictures, videos and write-ups at **`/admin`**
(sign in at `/admin/login`; there is also a *Staff sign-in* link in the footer).

| Section | What it does |
| ------- | ------------ |
| **Posts** | Headline, summary, full text, date, venue, hashtags — plus any number of attached photos and videos. Published posts appear at `/updates`, on the home page, and each gets its own page. |
| **Photos & videos** | Upload individual files, caption them, set their size in the bento grid, and choose whether each shows in the “From the field” gallery. |
| **Messages** | Contact-form enquiries. |
| **My account** | Change name, sign-in email and password. |

There is no public registration — accounts are created from the command line:

```bash
php artisan admin:user info@nelodreams.org --name="Nelo Dreams Admin"
# same command resets the password of an existing account
```

`DatabaseSeeder` also creates one, using `ADMIN_EMAIL` / `ADMIN_PASSWORD` from
`.env` (or a random password it prints once).

**How uploads are stored.** Files go straight into `public/uploads/YYYY/MM/`
and are saved as public-relative paths (`uploads/2026/08/photo-a1b2c3d4.jpg`),
exactly like the hand-placed files in `public/images`. No `storage:link` symlink
is involved — that matters because the site runs on shared hosting without SSH.
The folder's contents are git-ignored, and `deploy/build-bundle.sh` excludes it
so a re-deploy can never overwrite what is already live.

Photos are capped at 8MB and videos at 128MB in validation; the real ceiling is
whatever PHP allows (`upload_max_filesize` / `post_max_size`), which the admin
dashboard displays.

---

## Design system

Defined in `resources/css/app.css` via Tailwind v4 `@theme`:

- **Navy** `navy-50…950` (brand anchor `#021B4E` = `navy-900`)
- **Electric / sky** `electric-50…900` (accent `#0EA5E9` = `electric-500`)
- **Fonts** — Plus Jakarta Sans (display) · Inter (body)
- **Motion** — `.reveal` / `.img-reveal` scroll reveals, animated counters,
  CSS‑driven infographics. All gated behind `prefers-reduced-motion`.

---

## Accessibility & performance

- Semantic landmarks, skip‑to‑content link, ARIA labels on nav / icons / forms.
- Keyboard‑navigable menu (Escape closes), visible focus rings, WCAG‑aware contrast.
- `prefers-reduced-motion` disables all animation.
- Reveals use a single robust `IntersectionObserver` with a fail‑safe so content is
  **never** permanently hidden.
- Lazy‑loaded images and map iframe.

---

## Testing

```bash
php artisan test
```

Feature tests cover the homepage render, seeded content, and the contact form
(valid submission, validation errors, and honeypot spam protection).
