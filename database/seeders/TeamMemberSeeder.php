<?php

namespace Database\Seeders;

use App\Models\TeamMember;
use Illuminate\Database\Seeder;

class TeamMemberSeeder extends Seeder
{
    public function run(): void
    {
        // Photos are looked for in public/images/team (see the README there); a
        // member with no photo on disk falls back to their initials until an
        // admin uploads one from the panel. Bios are left for the team to write.
        $members = [
            [
                'name' => 'Coach Ebere Amariazu',
                'role' => 'Executive Director',
                'photo' => 'images/team/ebere-amariazu.jpg',
                'sort_order' => 1,
            ],
            [
                'name' => 'Kennedy Obinna Okoro',
                'role' => 'Project Implementation / Evaluation Manager',
                'photo' => 'images/team/kennedy-okoro.jpg',
                'sort_order' => 2,
            ],
            [
                'name' => 'Kennedy Onwunali',
                'role' => 'Media Officer',
                'photo' => 'images/team/kennedy-onwunali.jpg',
                'sort_order' => 3,
            ],
            [
                'name' => 'Esther Osayi',
                'role' => 'Field Officer / Community Mobilizer',
                'photo' => 'images/team/esther-osayi.jpg',
                'sort_order' => 4,
            ],
            [
                'name' => 'Amaka S Obi',
                'role' => 'Field Officer / Program',
                'photo' => 'images/team/amaka-obi.jpg',
                'sort_order' => 5,
            ],
        ];

        foreach ($members as $member) {
            TeamMember::updateOrCreate(
                ['name' => $member['name']],
                $member + ['is_active' => true]
            );
        }
    }
}
