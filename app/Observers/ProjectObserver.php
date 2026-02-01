<?php

namespace App\Observers;

use App\Models\Project;
use Illuminate\Support\Facades\Storage;

class ProjectObserver
{
    /**
     * Soft delete
     */
    public function deleted(Project $project)
    {
        $this->deleteProjectImages($project);
    }

    /**
     * Force delete
     */
    public function forceDeleted(Project $project)
    {
        $this->deleteProjectImages($project);
    }

    /**
     * Supprime toutes les images d'un projet
     */
    private function deleteProjectImages(Project $project)
    {
        // Path du dossier
        $projectFolder = "projects/{$project->slug}";

        if (Storage::disk('public')->exists($projectFolder)) {
            Storage::disk('public')->deleteDirectory($projectFolder);
        }

        // Log pour tracer les suppressions
        \Log::info("Images deleted for project: {$project->title} ({$project->slug})");
    }
}