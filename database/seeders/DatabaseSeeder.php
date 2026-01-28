<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        /**
         * Seed the application's database
         */
        $this->call([
            UserSeeder::class,
            TechnologySeeder::class,
            ProjectSeeder::class,
            ProjectTechnologySeeder::class,
            ImageSeeder::class,
            ContactSeeder::class,
        ]);
    }
}
