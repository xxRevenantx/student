<?php

namespace Database\Seeders;

use App\Models\Director;
use App\Models\Supervisor;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        Storage::deleteDirectory('imagenes');
        Storage::makeDirectory('imagenes');

        User::factory()->create([
            'name' => 'Carlos Nuñez',
            'email' => 'carlos@admin.com',
            'password' => bcrypt('12345678'),
        ]);

        Director::factory(5)->create();
        Supervisor::factory(5)->create();

        $this->call(LevelSeeder::class);


    }
}
