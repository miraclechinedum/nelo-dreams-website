<?php

namespace Database\Seeders;

use App\Models\ImpactStory;
use Illuminate\Database\Seeder;

class ImpactStorySeeder extends Seeder
{
    public function run(): void
    {
        $stories = [
            [
                'title' => 'School Awareness Campaign Reaches 12 Schools',
                'category' => 'School Campaign',
                'location' => 'Enugu, Nigeria',
                'period' => 'February 2025',
                'happened_on' => '2025-02-12',
                'summary' => 'Our flagship campaign brought mental health assemblies and SEL workshops to twelve schools in a single term, reaching thousands of pupils.',
                'body' => 'Across six weeks, our facilitators ran assemblies, classroom sessions, and teacher briefings — helping pupils build a shared language for their emotions and giving staff the tools to keep the conversation going.',
                'image' => 'images/impact/school-campaign.jpg',
                'sort_order' => 1,
            ],
            [
                'title' => 'Community Outreach in Three Neighbourhoods',
                'category' => 'Community Outreach',
                'location' => 'Nsukka, Nigeria',
                'period' => 'November 2024',
                'happened_on' => '2024-11-08',
                'summary' => 'We took mental health conversations into markets and town halls, meeting families where they already gather.',
                'body' => 'Working with local leaders, our teams hosted open-air sessions that normalised mental health, dispelled myths, and connected dozens of families to follow-up support.',
                'image' => 'images/impact/community-outreach.jpg',
                'sort_order' => 2,
            ],
            [
                'title' => 'Child Empowerment Initiative Graduates 200 Young Leaders',
                'category' => 'Empowerment',
                'location' => 'Enugu, Nigeria',
                'period' => 'July 2024',
                'happened_on' => '2024-07-20',
                'summary' => 'Two hundred children completed our peer-leadership track, learning to support classmates and speak up for their own wellbeing.',
                'body' => 'Through mentoring circles and confidence-building workshops, young people stepped into peer-support roles — becoming the first line of care and encouragement in their classrooms.',
                'image' => 'images/impact/empowerment.jpg',
                'sort_order' => 3,
            ],
            [
                'title' => 'Special Abilities Inclusion Program Launches',
                'category' => 'Inclusion',
                'location' => 'Awka, Nigeria',
                'period' => 'March 2024',
                'happened_on' => '2024-03-15',
                'summary' => 'A dedicated program created safe, adapted spaces for children with special abilities and trained their caregivers.',
                'body' => 'We co-designed inclusive activities with families and educators, ensuring children with special abilities are supported with dignity — and celebrated for everything they bring.',
                'image' => 'images/impact/inclusion.jpg',
                'sort_order' => 4,
            ],
        ];

        foreach ($stories as $story) {
            $story['slug'] = str($story['title'])->slug();
            ImpactStory::updateOrCreate(['slug' => $story['slug']], $story);
        }
    }
}
