<?php

namespace Database\Seeders;

use App\Models\GalleryImage;
use Illuminate\Database\Seeder;

class GalleryImageSeeder extends Seeder
{
    public function run(): void
    {
        $images = [
            ['title' => 'Classroom assembly', 'caption' => 'Pupils name their feelings during a Mind Matters assembly.', 'category' => 'Schools', 'span' => 'wide', 'image' => 'images/gallery/assembly.jpg', 'sort_order' => 1],
            ['title' => 'SEL club in session', 'caption' => 'A weekly social-emotional learning club.', 'category' => 'Schools', 'span' => 'normal', 'image' => 'images/gallery/sel-club.jpg', 'sort_order' => 2],
            ['title' => 'On the pitch', 'caption' => 'Football for Development with Rangers Foundation.', 'category' => 'Partnership', 'span' => 'tall', 'image' => 'images/gallery/football.jpg', 'sort_order' => 3],
            ['title' => 'Community gathering', 'caption' => 'An open-air outreach in the neighbourhood.', 'category' => 'Community', 'span' => 'normal', 'image' => 'images/gallery/community.jpg', 'sort_order' => 4],
            ['title' => 'Young leaders', 'caption' => 'Peer-support graduates celebrate together.', 'category' => 'Empowerment', 'span' => 'normal', 'image' => 'images/gallery/leaders.jpg', 'sort_order' => 5],
            ['title' => 'Inclusion in action', 'caption' => 'Adapted activities for children with special abilities.', 'category' => 'Inclusion', 'span' => 'wide', 'image' => 'images/gallery/inclusion.jpg', 'sort_order' => 6],
        ];

        foreach ($images as $image) {
            GalleryImage::updateOrCreate(
                ['title' => $image['title']],
                $image
            );
        }
    }
}
