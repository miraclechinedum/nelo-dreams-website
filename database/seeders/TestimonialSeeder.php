<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    public function run(): void
    {
        $testimonials = [
            [
                'name' => 'Mrs. Adaeze Okafor',
                'role' => 'Head Teacher',
                'organization' => 'Government Primary School, Enugu',
                'quote' => 'For the first time, our pupils have words for what they feel — and the confidence to use them. Nelo Dreams changed the emotional climate of our school.',
                'sort_order' => 1,
            ],
            [
                'name' => 'Chinedu E.',
                'role' => 'Parent & Volunteer',
                'organization' => 'Nsukka',
                'quote' => 'I used to dismiss my son’s worries. The parent training taught me to listen first. Our home feels different now — calmer, closer.',
                'sort_order' => 2,
            ],
            [
                'name' => 'Coach Ifeanyi',
                'role' => 'Youth Development Coach',
                'organization' => 'Rangers International FC Foundation',
                'quote' => 'We train the mind behind the behaviour. When a child learns to manage pressure on the pitch, they carry that strength into every part of life.',
                'sort_order' => 3,
            ],
        ];

        foreach ($testimonials as $testimonial) {
            Testimonial::updateOrCreate(
                ['name' => $testimonial['name']],
                $testimonial
            );
        }
    }
}
