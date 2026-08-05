<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database with Nelo Dreams Foundation content.
     */
    public function run(): void
    {
        // The admin account for the media panel. Set ADMIN_EMAIL / ADMIN_PASSWORD
        // in .env before seeding in production; otherwise a random password is
        // generated and printed once, here.
        $email = env('ADMIN_EMAIL', 'admin@nelodreams.org');
        $password = env('ADMIN_PASSWORD') ?: Str::password(16, symbols: false);

        $user = User::firstOrCreate(
            ['email' => $email],
            ['name' => env('ADMIN_NAME', 'Nelo Dreams Admin'), 'password' => bcrypt($password)]
        );

        if ($user->wasRecentlyCreated) {
            $this->command?->warn("Admin account created: {$email}");
            $this->command?->warn("Password: {$password}");
            $this->command?->warn('Sign in at /admin/login and change this password.');
        }

        $this->call([
            StatisticSeeder::class,
            ObjectiveSeeder::class,
            CoreValueSeeder::class,
            ProgramSeeder::class,
            ImpactStorySeeder::class,
            MediaItemSeeder::class,
            PostSeeder::class,
            PartnerSeeder::class,
            TestimonialSeeder::class,
        ]);
    }
}
