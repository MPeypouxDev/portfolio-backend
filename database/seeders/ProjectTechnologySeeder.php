<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Technology;
use Illuminate\Database\Seeder;

class ProjectTechnologySeeder extends Seeder
{
    public function run(): void
    {
        $projects = Project::all();
        $technologies = Technology::all();

        $projectTechMapping = [
            'agence-evenementielle' => ['HTML5', 'CSS', 'JavaScript'],
            'gestionnaire-finance' => ['HTML5', 'CSS', 'JavaScript'],
            'anime-fight' => ['HTML5', 'CSS', 'JavaScript'],
        ];

        foreach ($projects as $project) {
            if (isset($projectTechMapping[$project->slug])) {
                $techNames = $projectTechMapping[$project->slug];

                foreach ($techNames as $techName) {
                    $technology = $technologies->firstWhere('name', $techName);

                    if ($technology) {
                        $project->technologies()->attach($technology->id);
                    }
                }
            }
        }
    }
}
