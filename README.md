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
├── Http/Controllers/      HomeController, ContactController
├── Http/Requests/         StoreContactRequest (validation + honeypot)
└── Models/                Statistic, Objective, CoreValue, Program,
                           ImpactStory, GalleryImage, Partner, Testimonial,
                           ContactMessage  (+ Concerns/Publishable trait)

database/
├── migrations/            One table per content type
└── seeders/               Sample NGO content for every section

resources/
├── css/app.css            Design system: brand palette, type, motion
├── js/app.js              Alpine + counter, reveal observer, sticky header
└── views/
    ├── layouts/app.blade.php
    ├── components/        button, card, program-card, objective-card,
    │                      value-card, testimonial, timeline-item, stat,
    │                      section-header, media, reveal, icon, logo/*
    ├── pages/home.blade.php
    └── partials/
        ├── header.blade.php, footer.blade.php
        └── home/          hero, about, objectives, programs, values, impact,
                           testimonials, partnership, approach, cta, contact
                           + infographics/
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
| `GalleryImage`   | `gallery_images`   | “From the field” gallery        |
| `Partner`        | `partners`         | Rangers partnership + partners  |
| `Testimonial`    | `testimonials`     | Community voices                |
| `ContactMessage` | `contact_messages` | Submitted contact enquiries     |

Re‑seed any time with `php artisan db:seed` (idempotent — uses `updateOrCreate`).

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
