<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database with Nelo Dreams Foundation content.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@nelodreams.org'],
            ['name' => 'Nelo Dreams Admin', 'password' => bcrypt('password')]
        );

        $this->call([
            StatisticSeeder::class,
            ObjectiveSeeder::class,
            CoreValueSeeder::class,
            ProgramSeeder::class,
            ImpactStorySeeder::class,
            GalleryImageSeeder::class,
            PartnerSeeder::class,
            TestimonialSeeder::class,
        ]);
    }
}
