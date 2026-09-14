#!/usr/bin/env bash
# Build the two INCREMENTAL update zips for Namecheap shared hosting.
#
# Use this for an ordinary content/code change. Use deploy/build-bundle.sh
# instead only for a first-time install or when composer dependencies change —
# this script deliberately ships no vendor/ and no .env.
#
# Output (project root):
#   nelodreams-app-update.zip  -> extract into /home/USERNAME/nelodreams-app/
#   docroot-update.zip         -> extract into the document root (public_html)
#
# Which files go in is derived from git, so the zips contain exactly what
# changed — nothing stale, nothing forgotten:
#
#   bash deploy/build-update.sh            # everything not yet committed
#   bash deploy/build-update.sh HEAD~1     # everything since that commit
#
# public/build/ is always included: it is gitignored, but the compiled CSS/JS
# changes on every `npm run build` and the page references it by hashed name.

set -euo pipefail

PROJECT_ROOT="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
SINCE="${1:-}"
BUILD_ROOT="$(mktemp -d -t nelo-update-XXXXXX)"
APP_DIR="${BUILD_ROOT}/app-update"
PUB_DIR="${BUILD_ROOT}/docroot-update"

APP_ZIP="${PROJECT_ROOT}/nelodreams-app-update.zip"
PUB_ZIP="${PROJECT_ROOT}/docroot-update.zip"

trap 'rm -rf "${BUILD_ROOT}"' EXIT
cd "${PROJECT_ROOT}"

# --- 1. work out which files changed -----------------------------------------
if [[ -n "${SINCE}" ]]; then
  echo "→ Collecting files changed since ${SINCE}"
  CHANGED="$(git diff --name-only --diff-filter=ACMR "${SINCE}")"
else
  echo "→ Collecting uncommitted changes"
  # -uall so new directories are expanded into individual files
  CHANGED="$(git status --porcelain -uall | grep -v '^ *D' | cut -c4-)"
fi

mkdir -p "${APP_DIR}" "${PUB_DIR}"

app_count=0
pub_count=0

while IFS= read -r file; do
  [[ -z "${file}" || ! -f "${file}" ]] && continue
  case "${file}" in
    # Framework side — goes into nelodreams-app/
    app/*|config/*|routes/*|database/migrations/*|database/seeders/*|resources/views/*|bootstrap/app.php)
      mkdir -p "${APP_DIR}/$(dirname "${file}")"
      cp "${file}" "${APP_DIR}/${file}"
      app_count=$((app_count + 1))
      ;;
    # Document-root side — strip the leading public/
    public/*)
      rel="${file#public/}"
      case "${rel}" in
        uploads/*|images/_archive/*|hot|index.php) continue ;;  # never overwrite live uploads
        *README.md|*.md) continue ;;                            # developer notes stay out of the docroot
      esac
      mkdir -p "${PUB_DIR}/$(dirname "${rel}")"
      cp "${file}" "${PUB_DIR}/${rel}"
      pub_count=$((pub_count + 1))
      ;;
    # Everything else (tests, docs, package.json, deploy scripts) is not deployed.
  esac
done <<< "${CHANGED}"

# --- 2. always ship the compiled assets (gitignored, but always needed) -------
if [[ -d "${PROJECT_ROOT}/public/build" ]]; then
  echo "→ Including compiled assets from public/build"
  mkdir -p "${PUB_DIR}/build"
  rsync -a "${PROJECT_ROOT}/public/build/" "${PUB_DIR}/build/"
else
  echo "!! public/build is missing — run 'npm run build' first." >&2
  exit 1
fi

# --- 3. the update helper ------------------------------------------------------
cp "${PROJECT_ROOT}/deploy/update.php" "${PUB_DIR}/update.php"

# --- 4. zip --------------------------------------------------------------------
rm -f "${APP_ZIP}" "${PUB_ZIP}"
(cd "${APP_DIR}" && zip -r -q "${APP_ZIP}" .)
(cd "${PUB_DIR}" && zip -r -q "${PUB_ZIP}" .)

echo ""
echo "✓ ${APP_ZIP##*/}  ($(du -h "${APP_ZIP}" | cut -f1), ${app_count} changed files)"
echo "    extract into  /home/USERNAME/nelodreams-app/"
echo "✓ ${PUB_ZIP##*/}  ($(du -h "${PUB_ZIP}" | cut -f1), ${pub_count} changed files + build/ + update.php)"
echo "    extract into  the document root (public_html)"
echo ""
echo "Then visit  https://YOUR_DOMAIN.com/update.php?token=YOUR_DEPLOY_SECRET"
echo "and delete update.php afterwards."
