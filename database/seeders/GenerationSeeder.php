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
                'start_year' => 2020,
                'end_year' => 2026,
                'status' => 'active',
            ],
            [
                'start_year' => 2021,
                'end_year' => 2027,
                'status' => 'active',
            ],
            [
                'start_year' => 2022,
                'end_year' => 2028,
                'status' => 'active',
            ],
        ];

        foreach ($generations as $generation) {
            Generation::create($generation);
        }
    }
}
