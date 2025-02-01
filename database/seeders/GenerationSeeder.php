<?php

namespace Database\Seeders;

use App\Models\Generation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GenerationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $generations = [
            [
                'fecha_inicio' => 2017,
                'fecha_termino' => 2020,
                'status' => '1',
                'level_id' => 1,
                'order' => 1,
            ],
            [
                'fecha_inicio' => 2018,
                'fecha_termino' => 2021,
                'status' => '1',
                'level_id' => 1,
                'order' => 2,
            ],
            [
                'fecha_inicio' => 2019,
                'fecha_termino' => 2022,
                'status' => '1',
                'level_id' => 1,
                'order' => 3,
            ],
            [
                'fecha_inicio' => 2017,
                'fecha_termino' => 2023,
                'status' => '1',
                'level_id' => 2,
                'order' => 1,
            ],
            [
                'fecha_inicio' => 2018,
                'fecha_termino' => 2024,
                'status' => '1',
                'level_id' => 2,
                'order' => 2,
            ],
            [
                'fecha_inicio' => 2019,
                'fecha_termino' => 2025,
                'status' => '1',
                'level_id' => 2,
                'order' => 3,
            ],
            [
                'fecha_inicio' => 2020,
                'fecha_termino' => 2026,
                'status' => '1',
                'level_id' => 2,
                'order' => 4,
            ],
            [
                'fecha_inicio' => 2021,
                'fecha_termino' => 2027,
                'status' => '1',
                'level_id' => 2,
                'order' => 5,
            ],
            [
                'fecha_inicio' => 2022,
                'fecha_termino' => 2028,
                'status' => '1',
                'level_id' => 2,
                'order' => 6,
            ],
            [
                'fecha_inicio' => 2017,
                'fecha_termino' => 2020,
                'status' => '1',
                'level_id' => 3,
                'order' => 1,
            ],
            [
                'fecha_inicio' => 2018,
                'fecha_termino' => 2021,
                'status' => '1',
                'level_id' => 3,
                'order' => 2,
            ],
            [
                'fecha_inicio' => 2019,
                'fecha_termino' => 2022,
                'status' => '1',
                'level_id' => 3,
                'order' => 3,
            ]


        ];

        foreach ($generations as $generation) {
            Generation::create($generation);
        }
    }
}
