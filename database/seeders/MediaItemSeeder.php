<?php

namespace Database\Seeders;

use App\Models\MediaItem;
use Illuminate\Database\Seeder;

class MediaItemSeeder extends Seeder
{
    public function run(): void
    {
        // Reset only the photos that ship with the repo, so the curated list
        // below stays exact. Anything uploaded through the admin panel lives
        // under `uploads/` and is deliberately left untouched.
        MediaItem::where('path', 'like', 'images/gallery/%')->delete();

        $images = [
            ['title' => 'Classroom assembly', 'caption' => 'Pupils name their feelings during a Mind Matters assembly.', 'category' => 'Schools', 'span' => 'wide', 'path' => 'images/gallery/assembly.jpg', 'sort_order' => 1],
            ['title' => 'SEL club in session', 'caption' => 'A weekly social-emotional learning club.', 'category' => 'Schools', 'span' => 'normal', 'path' => 'images/gallery/sel-club.jpg', 'sort_order' => 2],
            ['title' => 'On the pitch', 'caption' => 'Football for Development with Rangers Foundation.', 'category' => 'Partnership', 'span' => 'tall', 'path' => 'images/gallery/football.jpg', 'sort_order' => 3],
            ['title' => 'Community gathering', 'caption' => 'An open-air outreach in the neighbourhood.', 'category' => 'Community', 'span' => 'normal', 'path' => 'images/gallery/community.jpg', 'sort_order' => 4],
            ['title' => 'Tranod International School', 'caption' => 'Teachers’ mental health day — Tranod International School, Efab City Estate, Lokogoma.', 'category' => 'Schools', 'span' => 'normal', 'path' => 'images/gallery/leaders.jpg', 'sort_order' => 5],
            ['title' => 'Inclusion in action', 'caption' => 'Adapted activities for children with special abilities.', 'category' => 'Inclusion', 'span' => 'wide', 'path' => 'images/gallery/inclusion.jpg', 'sort_order' => 6],

            // School visits added from the foundation’s 2025 outreach
            ['title' => 'Funvile International School', 'caption' => 'Funvile International School, Efab City Estate, Lokogoma, Abuja.', 'category' => 'Schools', 'span' => 'wide', 'path' => 'images/gallery/funvile-school.jpg', 'sort_order' => 7],
            ['title' => 'Damanza Govt School JSS', 'caption' => 'Mental health awareness at Damanza Government Junior Secondary School.', 'category' => 'Schools', 'span' => 'tall', 'path' => 'images/gallery/damanza-school.jpg', 'sort_order' => 8],
            ['title' => 'Bloomfield International School', 'caption' => 'Mental Health & Self-Awareness Program 2025 — Bloomfield International School, Efab City Estate, Lokogoma.', 'category' => 'Schools', 'span' => 'normal', 'path' => 'images/gallery/bloomfield-school.jpg', 'sort_order' => 9],
            ['title' => 'Federal Govt Boys College', 'caption' => 'Anti-bullying advocacy at Federal Govt Boys College — Junior.', 'category' => 'Schools', 'span' => 'wide', 'path' => 'images/gallery/federal-college.jpg', 'sort_order' => 10],
            ['title' => 'Senior students cohort', 'caption' => 'A senior cohort joins the mental-health awareness program.', 'category' => 'Schools', 'span' => 'normal', 'path' => 'images/gallery/senior-students.jpg', 'sort_order' => 11],
        ];

        foreach ($images as $image) {
            MediaItem::updateOrCreate(
                ['path' => $image['path']],
                $image + ['type' => 'image', 'in_gallery' => true, 'is_active' => true]
            );
        }
    }
}
