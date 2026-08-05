<?php

namespace App\Support;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

/**
 * Uploaded photos and videos are written straight into `public/uploads/…` and
 * stored as public-relative paths ("uploads/2026/08/abc.jpg"), exactly like the
 * hand-placed files in `public/images`. No storage:link symlink is involved,
 * which matters because the site runs on shared hosting without SSH.
 */
class MediaStorage
{
    /** Everything this class writes lives under this folder — nothing else is ever deleted. */
    public const ROOT = 'uploads';

    /**
     * Move an upload into public/uploads and return its public-relative path.
     */
    public static function store(UploadedFile $file): string
    {
        $folder = self::ROOT.'/'.date('Y/m');
        $directory = public_path($folder);

        if (! is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        $name = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) ?: 'file';
        $name = Str::limit($name, 60, '').'-'.Str::lower(Str::random(8)).'.'.Str::lower($file->getClientOriginalExtension());

        $file->move($directory, $name);

        return $folder.'/'.$name;
    }

    /**
     * Delete a previously uploaded file. Paths outside `uploads/` (the seeded
     * photos that ship with the repo) are deliberately left alone.
     */
    public static function delete(?string $path): void
    {
        if (! $path || ! Str::startsWith($path, self::ROOT.'/') || Str::contains($path, '..')) {
            return;
        }

        $full = public_path($path);

        if (is_file($full)) {
            @unlink($full);
        }
    }

    /**
     * Replace `$current` with a newly uploaded file, cleaning up the old one.
     */
    public static function replace(?UploadedFile $file, ?string $current): ?string
    {
        if (! $file) {
            return $current;
        }

        self::delete($current);

        return self::store($file);
    }

    /**
     * The effective upload ceiling in megabytes, so forms can tell the truth
     * about what this server will actually accept.
     */
    public static function serverLimitMb(): int
    {
        $toMb = static function (string $value): int {
            $value = trim($value);
            $unit = Str::lower(substr($value, -1));
            $number = (int) $value;

            return match ($unit) {
                'g' => $number * 1024,
                'm' => $number,
                'k' => (int) ceil($number / 1024),
                default => (int) ceil($number / 1048576),
            };
        };

        $limits = array_filter([
            $toMb((string) ini_get('upload_max_filesize')),
            $toMb((string) ini_get('post_max_size')),
        ]);

        return $limits ? (int) min($limits) : 2;
    }
}
