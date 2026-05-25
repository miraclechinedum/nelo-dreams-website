<?php

namespace Database\Seeders;

use App\Models\Objective;
use Illuminate\Database\Seeder;

class ObjectiveSeeder extends Seeder
{
    public function run(): void
    {
        $objectives = [
            [
                'title' => 'Mental Health Literacy for Every Child',
                'description' => 'We deliver age-appropriate mental health and social-emotional learning (SEL) awareness programs in schools, communities, and online — so children can name their feelings, understand their minds, and ask for help without shame.',
                'icon' => 'sparkles',
                'sort_order' => 1,
            ],
            [
                'title' => 'Inclusion & Empowerment of Children with Special Abilities',
                'description' => 'We create safe spaces, training opportunities, and dignity-centered programs that ensure children with special abilities are seen, supported, and celebrated as full members of their communities.',
                'icon' => 'hand-raised',
                'sort_order' => 2,
            ],
            [
                'title' => 'Capacity Building for Youths, Parents and Educators',
                'description' => 'We train the adults around the child — teachers, parents, and youth leaders — to recognise mental health needs early and respond with skill, warmth, and consistency.',
                'icon' => 'users',
                'sort_order' => 3,
            ],
        ];

        foreach ($objectives as $objective) {
            Objective::updateOrCreate(['title' => $objective['title']], $objective);
        }
    }
}
