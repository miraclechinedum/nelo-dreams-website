<?php
/**
 * Production index.php for Namecheap shared hosting.
 *
 * Replace /public_html/index.php with this file. It points Laravel's
 * autoload + bootstrap at the nelodreams-app/ folder sitting next to
 * the document root (i.e. in your home directory):
 *
 *   /home/USERNAME/
 *   ├── nelodreams-app/           <- Laravel framework (NOT web-accessible)
 *   └── DOCUMENT_ROOT/            <- this index.php + the contents of /public live here
 */

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Path to the Laravel framework relative to the document root.
$laravel = __DIR__.'/../nelodreams-app';

if (file_exists($maintenance = $laravel.'/storage/framework/maintenance.php')) {
    require $maintenance;
}

require $laravel.'/vendor/autoload.php';

/** @var Application $app */
$app = require_once $laravel.'/bootstrap/app.php';

// Laravel's public_path() default would point to nelodreams-app/public/,
// which doesn't exist in this split layout — the built Vite assets and
// images live in the document root (where this file is). Tell Laravel so
// that @vite(), asset() and friends resolve correctly.
$app->usePublicPath(__DIR__);

$app->handleRequest(Request::capture());
