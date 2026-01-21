<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Technology;

class TechnologySeeder extends Seeder
{
    public function run(): void
    {
        $technologies = [
            // Frontend
            ['name' => 'Vue.js', 'type' => 'frontend', 'color' => '#42b883'],
            ['name' => 'React', 'type' => 'frontend', 'color' => '#61dafb'],
            ['name' => 'TailwindCSS', 'type' => 'frontend', 'color' => '#06b6d4'],
            ['name' => 'JavaScript', 'type' => 'frontend', 'color' => '#f7df1e'],

            // Backend
            ['name' => 'Laravel', 'type' => 'backend', 'color' => '#ff2d20'],
            ['name' => 'PHP', 'type' => 'backend', 'color' => '#777bb4'],

            // Database
            ['name' => 'MySQL', 'type' => 'database', 'color' => '#4479a1'],
            ['name' => 'PostgreSQL', 'type' => 'database', 'color' => '#336791'],

            // Tools
            ['name' => 'Git', 'type' => 'tools', 'color' => '#f05032'],
            ['name' => 'Figma', 'type' => 'tools', 'color' => '#f24e1e'],
        ];

        foreach ($technologies as $tech) {
            Technology::create($tech);
        }
    }
}
