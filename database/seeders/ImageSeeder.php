<?php

namespace Database\Seeders;

use App\Models\Image;
use App\Models\Project;
use Illuminate\Database\Seeder;

class ImageSeeder extends Seeder
{
    public function run(): void
    {
        $projects = Project::all();

        foreach ($projects as $index => $project) {
            Image::create([
                'name' => $project->slug . '-main.jpg',
                'path' => '/images/projects/' . $project->slug . '/main.jpg',
                'alt_text' => 'Image principale de ' . $project->title,
                'is_primary' => true,
                'order' => 0,
                'project_id' => $project->id,
            ]);

            $secondaryImages = rand(2, 3);
            for ($i = 1; $i <= $secondaryImages; $i++) {
                Image::create([
                    'name' => $project->slug . '-' . $i . '.jpg',
                    'path' => '/images/projects/' . $project->slug . '/screenshot-' . $i . '.jpg',
                    'alt_text' => 'Capture d\'écran ' . $i . ' de ' . $project->title,
                    'is_primary' => false,
                    'order' => $i,
                    'project_id' => $project->id,
                ]);
            }
        }
    }
}