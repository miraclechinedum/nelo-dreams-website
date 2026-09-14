# Deploying to Namecheap Shared Hosting (cPanel, no SSH)

This guide walks through deploying the site to a Namecheap shared‑hosting plan
using only the cPanel File Manager — no SSH, no command line. Total time:
about 20 minutes once the deploy bundle is built.

---

## What ends up where

Namecheap shared hosting gives you a Linux home directory that looks like this:

```
/home/USERNAME/
├── laravel-app/        <-- the Laravel framework (NOT web-accessible)
│   ├── app/  bootstrap/  config/  database/  resources/  routes/  storage/
│   ├── vendor/         (production-only dependencies)
│   ├── artisan
│   └── .env            <-- secrets live here
│
└── public_html/        <-- the document root your domain points to
    ├── index.php       (the production index.php from /deploy)
    ├── .htaccess       (Laravel's public/.htaccess)
    ├── favicon.svg
    ├── robots.txt
    ├── build/          (compiled Vite assets)
    ├── images/         (logos, hero, programs, impact, gallery)
    └── videos/         (featured.mp4)
```

The framework lives **outside** the public_html so visitors can't poke at your
`.env` or vendor files. Only the contents of the `public/` folder go in
`public_html`. This is the standard, secure Laravel layout for shared hosting.

---

## Pre-flight checklist

- [ ] You have a Namecheap **Stellar** (or higher) cPanel hosting plan.
- [ ] You have your **cPanel login** (Namecheap dashboard → *Hosting List* → *Manage* → *Go to cPanel*).
- [ ] Your domain is **pointed to the hosting** (Namecheap auto‑links domains bought on the same account; otherwise update the nameservers under *Domain List → Manage*).
- [ ] You've **built the deploy bundle** locally — see the next section.

---

## Building the deploy bundle (run once on your Mac)

From the project root:

```bash
bash deploy/build-bundle.sh
```

This produces `nelo-dreams-deploy.zip` in the project root containing:
- The whole Laravel app with **production-only** dependencies (`vendor/`)
- Compiled Vite assets in `public/build/`
- All real photos and the featured video
- The production `index.php` and `setup.php` helpers

The script does NOT touch your local `vendor/` (it builds in a temp folder).

---

## Step 1 — Pick PHP 8.2 or 8.3 in cPanel

The site needs **PHP 8.2+**. Most Namecheap accounts default to an older version.

In cPanel → search for **"MultiPHP Manager"** → tick your domain → set the
PHP version dropdown to **PHP 8.2** or **PHP 8.3** → *Apply*.

> If you don't see 8.2/8.3, open *Select PHP Version* and switch there instead.

---

## Step 2 — Create the MySQL database

In cPanel → **MySQL Databases** (not phpMyAdmin):

1. **Create a new database** — name it `nelo` (cPanel will prefix your username
   so the real name becomes `USERNAME_nelo`).
2. **Create a new MySQL user** — username `nelouser` (becomes `USERNAME_nelouser`),
   set a long random password and **save it somewhere safe**.
3. **Add the user to the database** with **ALL PRIVILEGES**.

You now have three values to remember:
- `DB_DATABASE` = `USERNAME_nelo`
- `DB_USERNAME` = `USERNAME_nelouser`
- `DB_PASSWORD` = the password you saved

---

## Step 3 — Upload and extract the bundle

In cPanel → **File Manager** → make sure *Show Hidden Files* is on
(*Settings* → tick *Show Hidden Files*).

1. Go to your **home directory** (`/home/USERNAME/`).
2. Click **Upload** and upload `nelo-dreams-deploy.zip`.
3. Right‑click the zip → **Extract** → extract to `/home/USERNAME/`.

After extraction you should see:

```
/home/USERNAME/
├── laravel-app/
└── (extra files we'll move next)
```

The zip is structured so `laravel-app/` lands in the right place automatically.
Anything that belongs in `public_html` is in a folder called `_public_html/` —
**move the *contents* of `_public_html/` into your existing `public_html/`**:

1. Open `_public_html/`, select all (Ctrl+A), click **Move**.
2. Set the destination to `/public_html` and confirm.
3. Delete the now‑empty `_public_html/` folder and the original `.zip`.

Verify the structure matches the diagram at the top of this guide.

---

## Step 4 — Configure `.env`

In File Manager, open `/home/USERNAME/laravel-app/`.

You'll see `.env.example` (already named `.env` by the build script — confirm).
Right‑click `.env` → **Edit** and fill in:

| Key             | Value                                                                  |
| --------------- | ---------------------------------------------------------------------- |
| `APP_URL`       | `https://YOUR_DOMAIN.com` (include `https://`)                         |
| `APP_KEY`       | Get this by running `php artisan key:generate --show` locally and pasting the `base64:…` value, OR ask in your terminal and I'll generate one |
| `DB_DATABASE`   | `USERNAME_nelo`                                                        |
| `DB_USERNAME`   | `USERNAME_nelouser`                                                    |
| `DB_PASSWORD`   | the password you saved in step 2                                       |
| `DEPLOY_SECRET` | a long random string — e.g. `openssl rand -hex 24` (32+ chars)         |
| `ADMIN_EMAIL`   | the address the foundation will sign in to the admin panel with        |
| `ADMIN_PASSWORD`| their password, at least 10 characters (leave blank and setup.php prints a random one) |
| `MAIL_*`        | optional — fill in if you'll use the contact form to send emails       |

Save the file.

---

## Step 5 — Run the one-time setup

In your browser visit:

```
https://YOUR_DOMAIN.com/setup.php?token=YOUR_DEPLOY_SECRET
```

(Replace `YOUR_DEPLOY_SECRET` with the value you put in `.env`.)

You should see plain‑text output ending with **`SUCCESS`** — it ran the
migrations, seeded the content, and cached the routes/views.

> **Now go back to File Manager and DELETE `/public_html/setup.php`**. Don't
> skip this step — it's a one‑time helper, not a permanent route.

---

## Step 6 — Test the site

Visit `https://YOUR_DOMAIN.com/` — you should see the hero with the real
mental‑health‑signs photo and the stats card. Click through:

- **About** — shows mission, vision, "Est. 2018"
- **Programs** — six cards with photos
- **Impact** — featured video + timeline + bento gallery (11 photos)
- **Partnership** — Rangers feature + DTI partner card
- **Contact** — form should send to `contact_messages` table (verify in phpMyAdmin)

If you see a generic 500 error, see *Troubleshooting* below.

---

## Step 7 — Hand over the admin panel

The foundation posts its own photos, videos and write-ups at:

```
https://YOUR_DOMAIN.com/admin/login
```

(There's also a discreet **Staff sign-in** link in the website footer.)

Sign in with the `ADMIN_EMAIL` / `ADMIN_PASSWORD` from step 4 and go to
**My account** to change the password. What they can do:

- **Posts** — write an update (headline, summary, full text, date, venue,
  hashtags) and attach as many photos and videos as they like. Published posts
  appear at `/updates` and in the *Latest Updates* section of the home page.
- **Photos & videos** — upload single files, caption them, and choose whether
  each one shows in the *From the field* gallery on the home page.
- **Messages** — read and reply to contact-form enquiries.

Uploads are written to `/public_html/uploads/` — **make sure that folder exists
and is writable (755)**. It is deliberately excluded from the deploy bundle so
re-deploying never overwrites what the foundation has already posted.

### If large videos fail to upload

Shared hosting usually caps uploads at 2MB. In cPanel → **Select PHP Version**
→ *Options*, raise:

| Setting               | Suggested |
| --------------------- | --------- |
| `upload_max_filesize` | `128M`    |
| `post_max_size`       | `128M`    |
| `max_execution_time`  | `300`     |
| `memory_limit`        | `256M`    |

The dashboard shows the limit the server is currently enforcing.

---

## Step 8 — Optional: Laravel scheduler (cron)

If you later add scheduled tasks (e.g. periodic emails), cPanel → **Cron Jobs**
→ add:

| Field   | Value                                                       |
| ------- | ----------------------------------------------------------- |
| Minute  | `*`                                                         |
| Hour    | `*`                                                         |
| Day     | `*`                                                         |
| Month   | `*`                                                         |
| Weekday | `*`                                                         |
| Command | `cd /home/USERNAME/laravel-app && php artisan schedule:run >> /dev/null 2>&1` |

Not needed for the current site.

---

## Updating the site later

> **Note on folder names.** The live server keeps the framework in
> `/home/USERNAME/nelodreams-app/` — that is the path `public_html/index.php`
> points at. Older parts of this guide say `laravel-app/`; wherever you see
> that, read `nelodreams-app/`.

For an ordinary change (new content, copy edits, a new section), build the two
**incremental** zips rather than the full bundle:

```bash
npm run build                  # compile CSS/JS
bash deploy/build-update.sh    # -> nelodreams-app-update.zip + docroot-update.zip
```

`build-update.sh` works out what changed from git, so the zips contain only the
changed files plus `public/build/`. It ships **no `vendor/`, no `.env` and no
database**, and it never touches `uploads/`, so nothing the foundation has
posted can be overwritten. Pass a git ref to build from a specific point:
`bash deploy/build-update.sh HEAD~1`.

Then, in cPanel File Manager:

1. Upload `nelodreams-app-update.zip` to `/home/USERNAME/nelodreams-app/` →
   right-click → **Extract** → confirm **Overwrite existing files**.
2. Upload `docroot-update.zip` to the document root (`public_html`) →
   **Extract** → overwrite.
3. Visit `https://YOUR_DOMAIN.com/update.php?token=YOUR_DEPLOY_SECRET`
   (the `DEPLOY_SECRET` already in `laravel .env`). It runs any new migrations,
   seeds only the seeders listed at the top of `deploy/update.php`, rebuilds the
   config/route/view caches, and prints a short verification report.
4. **Delete `update.php`** from the document root.
5. Hard-refresh the site (**Ctrl/⌘ + Shift + R**).

Step 3 is not optional when a release adds or changes a file in `config/`: the
server runs with a cached config, and until it is rebuilt the new settings read
as empty.

### Why not just re-run `setup.php`?

`setup.php` runs the **full** seeder. The content seeders use `updateOrCreate`,
so a blanket re-seed would silently revert any edit the foundation has made from
the admin panel to a seeded post, programme or photo. Use `update.php` instead;
it only runs the seeders you name.

If you do genuinely need to re-seed everything (e.g. restoring a wiped
database), restore `setup.php`, delete `/public_html/.setup-done`, visit the URL,
then delete `setup.php` again.

---

## Troubleshooting

**500 error / blank page** — open `/home/USERNAME/laravel-app/storage/logs/laravel.log` in File Manager. The error is at the bottom.

**"Class not found" / autoload errors** — vendor wasn't uploaded fully. Re‑upload `laravel-app/vendor/` from the bundle.

**"Database connection refused"** — double‑check `DB_HOST=127.0.0.1` (sometimes `localhost` doesn't work on cPanel). Verify the user is attached to the DB with ALL PRIVILEGES.

**"Permission denied" writing to storage** — in File Manager set permissions on `laravel-app/storage/` and `laravel-app/bootstrap/cache/` to **755** recursively.

**Images / CSS not loading (404)** — confirm `public_html/.htaccess` exists; if not, copy it from the bundle. Make sure `public_html/index.php` is the **deploy version** (the one that points to `../laravel-app`).

**`APP_KEY` missing** — locally run `php artisan key:generate --show`, copy the `base64:…` output into `.env` on the server, then visit `setup.php` again.

**Contact form 419 (Page Expired)** — make sure `APP_URL` is set, `https://` and matches the exact domain you're visiting (with or without `www`).
