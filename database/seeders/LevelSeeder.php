<?php

namespace Database\Seeders;

use App\Models\Director;
use App\Models\Level;
use App\Models\Supervisor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class LevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
                $levels = [
                    [
                        'level' => 'Preescolar',
                        'slug' => Str::slug('Preescolar'),
                        'color' => '#a8f200',
                        'cct' => '21DPR0001E',
                        'director_id' => Director::all()->random()->id,
                        'supervisor_id' => Supervisor::all()->random()->id,

                    ],
                    [
                        'level' => 'Primaria',
                        'slug' => Str::slug('Primaria'),
                        'color' => '#007af2',
                        'cct' => '21DPR0001E',
                        'director_id' => Director::all()->random()->id,
                        'supervisor_id' => Supervisor::all()->random()->id,

                    ],
                    [
                        'level' => 'Secundaria',
                        'slug' => Str::slug('Secundaria'),
                        'color' => '#f200e5',
                        'cct' => '21DPR0001E',
                        'director_id' => Director::all()->random()->id,
                        'supervisor_id' => Supervisor::all()->random()->id,

                    ],

                ];

        foreach ($levels as $level) {
            Level::create($level);
        }

    }
}
