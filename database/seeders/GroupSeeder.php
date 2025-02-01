<?php

namespace Database\Seeders;

use App\Models\Group;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $groups = [

            [
                'grupo' => 'A',
            ],
            [
                'grupo' => 'B',
            ],
            [
                'grupo' => 'C',
            ],
            [
                'grupo' => 'D',
            ],
            [
                'grupo' => 'E',
            ],
            [
                'grupo' => 'F',
            ],
            [
                'grupo' => 'G',
            ],


        ];

foreach ($groups as $group) {
    Group::create($group);
}
    }
}
