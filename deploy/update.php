<?php
/**
 * Incremental update helper for shared hosting (no SSH).
 *
 * Unlike setup.php — which runs the FULL seeder and is meant to be used once,
 * on a brand-new install — this script is safe to run after every deploy:
 *
 *   1. runs any new migrations   (`migrate --force`, never `--fresh`)
 *   2. seeds ONLY the classes named in SEEDERS below
 *   3. rebuilds the config / route / view caches
 *
 * It deliberately does NOT call `db:seed` with no arguments. The content
 * seeders use updateOrCreate, so a blanket re-seed would silently revert any
 * edit the foundation has made to a seeded post, programme or photo from the
 * admin panel.
 *
 * Visit in the browser:
 *   https://YOUR_DOMAIN.com/update.php?token=THE_DEPLOY_SECRET_FROM_.env
 *
 * DELETE this file from the document root once it reports SUCCESS.
 */

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

/** Seeders to run on this deploy. Each must be idempotent (updateOrCreate). */
const SEEDERS = [
    \Database\Seeders\TeamMemberSeeder::class,
];

$laravel = __DIR__.'/../nelodreams-app';

require $laravel.'/vendor/autoload.php';
$app = require_once $laravel.'/bootstrap/app.php';
$app->usePublicPath(__DIR__);
$app->make(Kernel::class)->bootstrap();

header('Content-Type: text/plain; charset=UTF-8');

/**
 * Read a value straight out of the .env file.
 *
 * NOT env() — once `config:cache` has run (which this script does at the end of
 * every deploy) Laravel stops loading .env altogether on boot, so env() returns
 * null and the token check below would reject every request, including correct
 * ones. Parsing the file keeps the script re-runnable.
 */
$envValue = static function (string $key) use ($laravel): ?string {
    if (! is_readable($file = $laravel.'/.env')) {
        return null;
    }

    foreach (file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        $line = trim($line);

        if ($line === '' || str_starts_with($line, '#') || ! str_contains($line, '=')) {
            continue;
        }

        [$name, $value] = explode('=', $line, 2);

        if (trim($name) !== $key) {
            continue;
        }

        $value = trim($value);

        // strip an inline comment, then surrounding quotes
        if (! str_starts_with($value, '"') && ! str_starts_with($value, "'")) {
            $value = trim(explode('#', $value, 2)[0]);
        }

        return trim($value, "\"'");
    }

    return null;
};

$expected = $envValue('DEPLOY_SECRET') ?: env('DEPLOY_SECRET');
$got = $_GET['token'] ?? '';

if (! $expected || strlen($expected) < 12) {
    http_response_code(500);
    exit("DEPLOY_SECRET is not set in .env (or is too short).\n");
}

if (! hash_equals($expected, (string) $got)) {
    http_response_code(403);
    exit("Forbidden — pass ?token=YOUR_DEPLOY_SECRET in the URL.\n");
}

$line = str_repeat('-', 60);

try {
    echo "1. Migrating\n{$line}\n";
    Artisan::call('migrate', ['--force' => true]);
    echo Artisan::output();

    echo "\n2. Seeding\n{$line}\n";
    foreach (SEEDERS as $seeder) {
        Artisan::call('db:seed', ['--class' => $seeder, '--force' => true]);
        echo $seeder." ... done\n";
    }

    // Rebuilding the config cache is NOT optional on this deploy: config/site.php
    // is a new file, and a stale cached config would leave the contact email and
    // the Facebook link empty on every page.
    echo "\n3. Rebuilding caches\n{$line}\n";
    foreach (['config:cache', 'route:cache', 'view:clear', 'view:cache'] as $command) {
        Artisan::call($command);
        echo $command." ... done\n";
    }

    echo "\n4. Verifying\n{$line}\n";
    printf("%-22s %s\n", 'contact email', config('site.email') ?: '(EMPTY — config cache problem)');
    printf("%-22s %s\n", 'facebook link', config('site.socials.facebook') ?: '(none)');
    printf("%-22s %s\n", 'team_members table', Schema::hasTable('team_members') ? 'present' : 'MISSING');
    printf("%-22s %d\n", 'team members', Schema::hasTable('team_members') ? \App\Models\TeamMember::count() : 0);

    foreach (\App\Models\TeamMember::orderBy('sort_order')->get() as $member) {
        $file = __DIR__.'/'.ltrim((string) $member->photo, '/');
        printf("  %-24s %s\n", $member->name, is_file($file) ? 'photo ok' : 'PHOTO MISSING: '.$member->photo);
    }

    echo "\n".str_repeat('=', 60)."\n";
    echo "SUCCESS. Now DELETE update.php from the document root.\n";
} catch (\Throwable $e) {
    http_response_code(500);
    echo "FAILED: ".$e->getMessage()."\n\n".$e->getTraceAsString()."\n";
}
