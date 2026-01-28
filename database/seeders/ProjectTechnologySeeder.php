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
            'ecommerce-platform' => ['Laravel', 'Vue.js', 'MySQL', 'TailwindCSS', 'JavaScript'],
            'task-management-app' => ['React', 'Laravel', 'MySQL', 'TailwindCSS'],
            'blog-cms' => ['Laravel', 'PHP', 'MySQL', 'TailwindCSS'],
            'weather-dashboard' => ['Vue.js', 'JavaScript', 'TailwindCSS'],
            'social-network' => ['React', 'Laravel', 'MySQL', 'TailwindCSS'],
            'portfolio-generator' => ['Vue.js', 'Laravel', 'MySQL', 'TailwindCSS'],
            'api-gateway' => ['Laravel', 'PHP', 'MySQL'],
            'quiz-platform' => ['React', 'Laravel', 'MySQL', 'TailwindCSS', 'JavaScript'],
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