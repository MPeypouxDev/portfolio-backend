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
            ['name' => 'Vue.js', 'icon' => 'vuedotjs.svg', 'type' => 'frontend', 'color' => '#4FC08D'],
            ['name' => 'React', 'icon' => 'react.svg', 'type' => 'frontend', 'color' => '#61DAFB'],
            ['name' => 'TailwindCSS', 'icon' => 'tailwindcss.svg', 'type' => 'frontend', 'color' => '#06B6D4'],
            ['name' => 'JavaScript', 'icon' => 'javascript.svg', 'type' => 'frontend', 'color' => '#F7DF1E'],
            ['name' => 'HTML5', 'icon' => 'html5.svg', 'type' => 'frontend', 'color' => '#E34F26'],
            ['name' => 'CSS', 'icon' => 'css.svg', 'type' => 'frontend', 'color' => '#663399'],

            // Backend
            ['name' => 'Laravel', 'icon' => 'laravel.svg', 'type' => 'backend', 'color' => '#FF2D20'],
            ['name' => 'PHP', 'icon' => 'php.svg', 'type' => 'backend', 'color' => '#777BB4'],

            // Database
            ['name' => 'MySQL', 'icon' => 'mysql.svg', 'type' => 'database', 'color' => '#4479A1'],
            ['name' => 'PostgreSQL', 'icon' => 'postgresql.svg', 'type' => 'database', 'color' => '#4169E1'],

            // Tools
            ['name' => 'Git', 'icon' => 'github.svg', 'type' => 'tools', 'color' => '#181717'],
            ['name' => 'Figma', 'icon' => 'figma.svg', 'type' => 'tools', 'color' => '#F24E1E'],
        ];

        foreach ($technologies as $tech) {
            Technology::updateOrCreate(
                ['name' => $tech['name']],
                $tech
            );
        }
    }
}
