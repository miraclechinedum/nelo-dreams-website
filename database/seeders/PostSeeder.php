<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;

/**
 * Write-ups supplied by the foundation. Keyed on the slug, so re-running the
 * seeder refreshes the wording without duplicating posts or touching the
 * photos and videos the team has attached to them in the admin panel.
 */
class PostSeeder extends Seeder
{
    public function run(): void
    {
        $posts = [
            [
                'title' => 'Mental Health Outreach for Commercial Drivers in Abuja',
                'slug' => 'mental-health-outreach-commercial-drivers-abuja',
                'category' => 'Community Outreach',
                'location' => 'Police Signpost, Lugbe, FCT Abuja',
                'period' => '12 June 2025',
                'happened_on' => '2025-06-12',
                'summary' => 'Nelo Dreams Foundation and the Rangers International Football Club Foundation delivered a mental health engagement for executives of the National Union of Road Transport Workers and commercial drivers in the Lugbe metropolis.',
                'body' => <<<'TEXT'
                    The Nelo Dreams Foundation, in partnership with the Rangers International Football Club Foundation, on 12/6/2025 conducted a mental health engagement for executives of the National Union of Road Transport Workers and commercial drivers operating within the Lugbe metropolis, near Police Signpost, Lugbe, FCT Abuja.

                    The session focused on the importance of prioritizing brain health and overall well-being for safer, more productive driving. Participants received a practical toolkit designed to help them "drive with their minds" through improved mental fitness and self-regulation.

                    Facilitators shared actionable strategies on brain health, including adequate sleep, balanced nutrition, regular physical activity, and proper hydration. The goal was to equip drivers with habits that directly improve focus, reduce fatigue, and boost productivity on the road.

                    Participants expressed appreciation to both foundations, stating that they gained new skills relevant to their daily work and committed to applying the lessons during their commercial driving activities.
                    TEXT,
                'hashtags' => '#MentalHealthAwareness #NeloDreamsFoundation #RangersFCFoundation',
                'sort_order' => 0,
                'is_active' => true,
            ],
            [
                'title' => 'Childhood Trauma Awareness at Nathaniel Gift School, Ogun State',
                'slug' => 'childhood-trauma-awareness-nathaniel-gift-school',
                'category' => 'School Campaign',
                'location' => 'Nathaniel Gift School, Ogun State',
                'period' => '5 June 2026',
                'happened_on' => '2026-06-05',
                'summary' => 'A mental health exercise for pupils in Primary 4–6, JSS 1–3 and SS 1–2, covering what childhood trauma is, how to recognise it, and how to prevent mental stress in children and adults.',
                'body' => <<<'TEXT'
                    On 5th June 2026, NELO DREAMS FOUNDATION and RANGERS INTERNATIONAL FC FOUNDATION partnered to conduct a mental health exercise at Nathaniel Gift School, Ogun State. The session targeted students in Primary 4–6, JSS 1–3, and SS 1–2.

                    Key Highlights:

                    - Childhood Trauma: Students were educated on what childhood trauma is and how it can affect a child's mental health and well-being.
                    - Signs & Effects: We also covered the symptoms and signs of childhood trauma, and its potential effects on development and behaviour.
                    - Prevention & Support: Finally, students learned how trauma can impact mental health and practical ways to prevent mental stress in both children and adults.
                    TEXT,
                'hashtags' => '#MentalHealthAwareness #NeloDreamsFoundation #RangersFCFoundation',
                'sort_order' => 0,
                'is_active' => true,
            ],
            [
                'title' => 'Mental Health Engagement at Nathaniel Gift International School',
                'slug' => 'mental-health-engagement-nathaniel-gift-international-school',
                'category' => 'School Campaign',
                'location' => 'Nathaniel Gift International School, Ogun State',
                'period' => '2 June 2026',
                'happened_on' => '2026-06-02',
                'summary' => 'A session for students in Primary 4–5, JSS 1 and SS 2 — held for crucial learning outcomes, with hands-on exercises on recognising and managing mental health challenges.',
                'body' => <<<'TEXT'
                    Mental Health Engagement at Nathaniel Gift International School, Ogun State. Held on 2nd June 2026 — for crucial learning outcomes.

                    Nelo Dreams Foundation, in partnership with Rangers International FC Foundation, delivered a mental health session for students in Primary 4–5, JSS 1 and SS 2.

                    Key Highlights:

                    - Mental Health Education: Clear definitions and understanding of the causes of mental health challenges.
                    - Awareness: Identification of signs and symptoms of mental health issues in children and young people.
                    - Empowerment: Practical, hands-on exercises and quotable insights on mental health shared with students.

                    We remain committed to promoting mental health awareness among students to improve academic productivity, general well-being, and support sustainable development.
                    TEXT,
                'hashtags' => '#MentalHealthAwareness #NeloDreamsFoundation #RangersFCFoundation',
                'sort_order' => 0,
                'is_active' => true,
            ],
            [
                'title' => 'Workplace Mental Health Awareness & Toolkit Session',
                'slug' => 'workplace-mental-health-awareness-toolkit-session',
                'category' => 'Event',
                'location' => 'Excellence International Christian Centre, Plot 1527, Cadastral Zone B11, Opposite Sun-City Estate, Kaura District, Lokogoma – Galadimawa, FCT, Abuja',
                'period' => 'Friday, 31 July 2026 · 10:00 AM',
                'happened_on' => '2026-07-31',
                'summary' => 'A free session for community members, professionals and organizational leaders on workplace mental health — its impact on productivity, and a practical toolkit for managing stress and burnout.',
                'body' => <<<'TEXT'
                    WORKPLACE MENTAL HEALTH AWARENESS & TOOLKIT SESSION
                    Hosted by: NELO DREAMS FOUNDATION INT'L
                    In partnership with: RANGERS INTERNATIONAL FOOTBALL CLUB FOUNDATION

                    Join us for another life-changing session focused on Workplace Mental Health.

                    This event brings community members, professionals, and organizational leaders together to:

                    - Learn more about workplace mental health and its impact on productivity and well-being.
                    - Receive a practical toolkit for effective management of stress, burnout, and overwhelming workplace challenges.
                    - Build skills in SEL + REBT to strengthen teams and leadership.

                    Date: Friday, 31st July 2026
                    Time: 10:00 AM prompt
                    Venue: Excellence International Christian Centre, Plot 1527, Cadastral Zone B11, Opposite Sun-City Estate, Kaura District, Lokogoma – Galadimawa, FCT, Abuja

                    Admission: FREE — seats are limited.
                    TEXT,
                'hashtags' => '#SELMatters #WorkplaceWellness #BeyondThePitch #RIFCFoundation #NeloDreamsFoundation',
                'sort_order' => 0,
                'is_active' => true,
            ],
        ];

        foreach ($posts as $post) {
            Post::updateOrCreate(['slug' => $post['slug']], $post);
        }
    }
}
