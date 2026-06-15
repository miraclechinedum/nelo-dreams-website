<?php
/**
 * One-time deployment helper for shared hosting (no SSH).
 *
 * Visit ONCE in the browser:
 *   https://YOUR_DOMAIN.com/setup.php?token=THE_VALUE_FROM_.env
 *
 * It runs `php artisan migrate --force --seed`, then writes a lock file so
 * it can't be re-run by accident. DELETE this file from public_html as soon
 * as it finishes successfully.
 */

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\Artisan;

$laravel = __DIR__.'/../nelodreams-app';

require $laravel.'/vendor/autoload.php';
$app = require_once $laravel.'/bootstrap/app.php';
$app->usePublicPath(__DIR__);
$app->make(Kernel::class)->bootstrap();

header('Content-Type: text/plain; charset=UTF-8');

$expected = env('DEPLOY_SECRET');
$got = $_GET['token'] ?? '';

if (! $expected || strlen($expected) < 12) {
    http_response_code(500);
    exit("DEPLOY_SECRET is not set in .env (or is too short). Add a long random value to .env and try again.\n");
}

if (! hash_equals($expected, (string) $got)) {
    http_response_code(403);
    exit("Forbidden — pass ?token=YOUR_DEPLOY_SECRET in the URL.\n");
}

$lock = __DIR__.'/.setup-done';
if (file_exists($lock)) {
    exit(
        "This setup has already been run on ".file_get_contents($lock).".\n".
        "If you really want to re-run it, delete both this file and {$lock}.\n"
    );
}

echo "Running: php artisan migrate --force --seed\n";
echo str_repeat('-', 60)."\n";

try {
    Artisan::call('migrate', ['--force' => true, '--seed' => true]);
    echo Artisan::output();

    Artisan::call('config:cache');
    Artisan::call('route:cache');
    Artisan::call('view:cache');
    echo "\nCached config, routes and views.\n";

    file_put_contents($lock, date('c'));
    echo "\n".str_repeat('=', 60)."\n";
    echo "SUCCESS. Now DELETE /public_html/setup.php from File Manager.\n";
} catch (\Throwable $e) {
    http_response_code(500);
    echo "FAILED: ".$e->getMessage()."\n";
    echo $e->getTraceAsString();
}
