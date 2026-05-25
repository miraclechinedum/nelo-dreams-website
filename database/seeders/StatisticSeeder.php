<?php

namespace Database\Seeders;

use App\Models\Statistic;
use Illuminate\Database\Seeder;

class StatisticSeeder extends Seeder
{
    public function run(): void
    {
        $stats = [
            ['label' => 'Children Reached', 'value' => 25000, 'suffix' => '+', 'icon' => 'users', 'sort_order' => 1],
            ['label' => 'Schools Engaged', 'value' => 64, 'suffix' => '', 'icon' => 'academic-cap', 'sort_order' => 2],
            ['label' => 'Communities Served', 'value' => 38, 'suffix' => '+', 'icon' => 'map-pin', 'sort_order' => 3],
            ['label' => 'Volunteers', 'value' => 310, 'suffix' => '+', 'icon' => 'heart', 'sort_order' => 4],
        ];

        foreach ($stats as $stat) {
            Statistic::updateOrCreate(['label' => $stat['label']], $stat);
        }
    }
}
