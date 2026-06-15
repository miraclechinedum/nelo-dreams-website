#!/usr/bin/env bash
# Build a self-contained zip you can upload to Namecheap shared hosting.
#
# Output: ./nelo-dreams-deploy.zip
#
# The zip's top-level structure:
#   laravel-app/         -> belongs in /home/USERNAME/
#   _public_html/        -> move its CONTENTS into /home/USERNAME/public_html/
#
# This script:
#   1. rsyncs the project to a temp folder, excluding dev-only stuff
#   2. runs `composer install --no-dev --optimize-autoloader` in the temp folder
#   3. arranges the public_html half
#   4. zips it up

set -euo pipefail

PROJECT_ROOT="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
BUILD_ROOT="$(mktemp -d -t nelo-deploy-XXXXXX)"
OUT_ZIP="${PROJECT_ROOT}/nelo-dreams-deploy.zip"

LARAVEL_DIR="${BUILD_ROOT}/laravel-app"
PUB_DIR="${BUILD_ROOT}/_public_html"

trap 'rm -rf "${BUILD_ROOT}"' EXIT

echo "→ Staging project in ${BUILD_ROOT}"
mkdir -p "${LARAVEL_DIR}"

# --- 1. copy the framework (excluding things production doesn't need) --------
rsync -a \
  --exclude='.git/' \
  --exclude='.github/' \
  --exclude='.vscode/' \
  --exclude='node_modules/' \
  --exclude='tests/' \
  --exclude='phpunit.xml' \
  --exclude='vendor/' \
  --exclude='.env' \
  --exclude='database/database.sqlite' \
  --exclude='storage/logs/*.log' \
  --exclude='storage/framework/cache/data/*' \
  --exclude='storage/framework/sessions/*' \
  --exclude='storage/framework/views/*' \
  --exclude='storage/framework/testing/*' \
  --exclude='public/images/_archive/' \
  --exclude='public/' \
  --exclude='nelo-dreams-deploy.zip' \
  --exclude='*.mjs' \
  --exclude='deploy/build-bundle.sh' \
  "${PROJECT_ROOT}/" "${LARAVEL_DIR}/"

# --- 2. install production-only composer dependencies ------------------------
echo "→ composer install --no-dev --optimize-autoloader"
(
  cd "${LARAVEL_DIR}"
  composer install --no-dev --optimize-autoloader --no-interaction --no-progress 2>&1 | tail -5
)

# --- 3. provision .env from the template -------------------------------------
cp "${PROJECT_ROOT}/deploy/.env.production.example" "${LARAVEL_DIR}/.env"

# --- 4. arrange the public_html half -----------------------------------------
mkdir -p "${PUB_DIR}"
# everything from /public except the index.php (we use the deploy version)
rsync -a \
  --exclude='index.php' \
  --exclude='hot' \
  --exclude='images/_archive/' \
  "${PROJECT_ROOT}/public/" "${PUB_DIR}/"
# the production index.php that points autoload to ../laravel-app
cp "${PROJECT_ROOT}/deploy/index.php"  "${PUB_DIR}/index.php"
# the one-time setup helper (delete after use)
cp "${PROJECT_ROOT}/deploy/setup.php"  "${PUB_DIR}/setup.php"

# --- 5. zip ------------------------------------------------------------------
echo "→ Zipping to ${OUT_ZIP}"
rm -f "${OUT_ZIP}"
(
  cd "${BUILD_ROOT}"
  zip -r -q "${OUT_ZIP}" laravel-app _public_html
)

SIZE=$(du -h "${OUT_ZIP}" | cut -f1)
echo ""
echo "✓ Built ${OUT_ZIP} (${SIZE})"
echo "  Now upload it to /home/USERNAME/ in cPanel File Manager and follow DEPLOYMENT.md."
