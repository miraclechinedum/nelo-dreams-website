<?php

namespace Database\Seeders;

use App\Models\Program;
use Illuminate\Database\Seeder;

class ProgramSeeder extends Seeder
{
    public function run(): void
    {
        $programs = [
            [
                'title' => 'Mind Matters School Program',
                'category' => 'Schools',
                'summary' => 'A structured, age-appropriate curriculum that teaches children to understand emotions, manage stress, and support their peers.',
                'description' => 'Mind Matters brings mental health literacy into the classroom through interactive lessons, storytelling, and guided practice. Children learn a vocabulary for their feelings and the confidence to use it.',
                'icon' => 'academic-cap',
                'image' => 'images/programs/mind-matters.jpg',
                'is_featured' => true,
                'sort_order' => 1,
            ],
            [
                'title' => 'Social-Emotional Learning Clubs',
                'category' => 'Schools',
                'summary' => 'Weekly peer clubs where children practise empathy, regulation, and resilience through play and reflection.',
                'description' => 'SEL Clubs turn the science of social-emotional learning into joyful weekly habits — building the everyday skills that help children thrive at school and at home.',
                'icon' => 'sparkles',
                'image' => 'images/programs/sel-clubs.jpg',
                'is_featured' => true,
                'sort_order' => 2,
            ],
            [
                'title' => 'Special Abilities Inclusion',
                'category' => 'Inclusion',
                'summary' => 'Dignity-centered spaces and training that ensure children with special abilities are supported and celebrated.',
                'description' => 'We partner with schools and families to build inclusive environments, adapt activities, and equip caregivers — so no child is left at the margins.',
                'icon' => 'hand-raised',
                'image' => 'images/programs/inclusion.jpg',
                'is_featured' => true,
                'sort_order' => 3,
            ],
            [
                'title' => 'Parent & Educator Training',
                'category' => 'Capacity Building',
                'summary' => 'Practical workshops that help adults recognise mental health needs early and respond with skill.',
                'description' => 'Through hands-on training, we equip the trusted adults in a child’s life to notice the signs, hold safe conversations, and know when and how to refer.',
                'icon' => 'users',
                'image' => 'images/programs/training.jpg',
                'is_featured' => true,
                'sort_order' => 4,
            ],
            [
                'title' => 'Football for Development',
                'category' => 'Partnership',
                'summary' => 'With Rangers International FC Foundation, we use football to build discipline, teamwork, and emotional strength.',
                'description' => 'Football for Development blends coaching with social-emotional learning, using the rhythm of the game to teach focus, resilience, and respect on and off the pitch.',
                'icon' => 'trophy',
                'image' => 'images/programs/football.jpg',
                'is_featured' => true,
                'sort_order' => 5,
            ],
            [
                'title' => 'Community Mental Health Outreach',
                'category' => 'Community',
                'summary' => 'Open-air awareness drives that bring mental health conversations directly into neighbourhoods.',
                'description' => 'Our outreach teams meet communities where they are — markets, town halls, and places of worship — to normalise mental health and connect families to support.',
                'icon' => 'megaphone',
                'image' => 'images/programs/outreach.jpg',
                'is_featured' => true,
                'sort_order' => 6,
            ],
        ];

        foreach ($programs as $program) {
            $program['slug'] = str($program['title'])->slug();
            Program::updateOrCreate(['slug' => $program['slug']], $program);
        }
    }
}
