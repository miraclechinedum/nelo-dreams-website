<?php

namespace Database\Seeders;

use App\Models\Partner;
use Illuminate\Database\Seeder;

class PartnerSeeder extends Seeder
{
    public function run(): void
    {
        $partners = [
            [
                'name' => 'Rangers International FC Foundation',
                'tagline' => 'Building Champions on the Pitch and in the Mind',
                'description' => 'Our strategic partner combines elite football development with mental health education and social-emotional learning — proving that football builds far more than players.',
                'logo' => 'images/logo-rangers.svg',
                'website' => null,
                'is_strategic' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Diamond Tech Innovations',
                'tagline' => 'Technology & Digital Partner',
                'description' => 'DTI helps brands, startups, and enterprises scale through engineered digital experiences and data-driven growth — building integrated digital roadmaps across custom web & app development, system design & automation, and growth marketing.',
                'logo' => 'images/logo-dti.jpeg',
                'website' => 'https://dti.technology',
                'is_strategic' => false,
                'sort_order' => 2,
            ],
            [
                'name' => 'Partner Schools Network',
                'tagline' => 'Where the work begins',
                'description' => 'A growing network of schools that open their classrooms to mental health literacy and SEL.',
                'logo' => null,
                'website' => null,
                'is_strategic' => false,
                'sort_order' => 3,
            ],
            [
                'name' => 'Community Health Allies',
                'tagline' => 'Care beyond the classroom',
                'description' => 'Local health workers and counsellors who provide follow-up support for children and families.',
                'logo' => null,
                'website' => null,
                'is_strategic' => false,
                'sort_order' => 4,
            ],
        ];

        foreach ($partners as $partner) {
            Partner::updateOrCreate(['name' => $partner['name']], $partner);
        }
    }
}
