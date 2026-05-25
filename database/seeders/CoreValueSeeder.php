<?php

namespace Database\Seeders;

use App\Models\CoreValue;
use Illuminate\Database\Seeder;

class CoreValueSeeder extends Seeder
{
    public function run(): void
    {
        $values = [
            ['letter' => 'A', 'title' => 'Accountability', 'description' => 'We own our programs, our outcomes, and our promises — to the children, families, and partners who trust us.', 'sort_order' => 1],
            ['letter' => 'I', 'title' => 'Integrity', 'description' => 'We protect dignity at every turn and never exploit vulnerability for attention, funding, or applause.', 'sort_order' => 2],
            ['letter' => 'D', 'title' => 'Diligence', 'description' => 'We do the work thoroughly — preparing, listening, and following through long after the cameras leave.', 'sort_order' => 3],
            ['letter' => 'D', 'title' => 'Discipline', 'description' => 'We stay consistent in purpose, showing up for the same communities season after season.', 'sort_order' => 4],
            ['letter' => 'T', 'title' => 'Teamwork', 'description' => 'We collaborate across schools, clubs, and communities to multiply impact far beyond what we could do alone.', 'sort_order' => 5],
        ];

        foreach ($values as $value) {
            CoreValue::updateOrCreate(
                ['title' => $value['title']],
                $value
            );
        }
    }
}
