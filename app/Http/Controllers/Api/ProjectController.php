<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Http\Resources\ProjectResource;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::with(['author', 'technologies', 'images'])
            ->where('status', 'published')
            ->orderBy('order')
            ->get();

        return ProjectResource::collection($projects);
    }

    /**
     * Liste tous les projets (admin)
     */

    public function adminIndex()
    {
        $projects = Project::with(['author', 'technologies', 'images'])
            ->orderBy('order')
            ->get();

        return ProjectResource::collection($projects);
    }

    /**
     * Projets en vedette
     */

    public function featured()
    {
        $projects = Project::with(['author', 'technologies', 'images'])
            ->where('status', 'published')
            ->where('is_featured', true)
            ->orderBy('order')
            ->get();

        return ProjectResource::collection($projects);
    }

    /**
     * Créer un nouveau projet
     */
    public function store(StoreProjectRequest $request)
    {
        $validated = $request->validated();

        $project = Project::create([
            ...$validated,
            'author_id' => auth('api')->id(),
        ]);

        // Attacher les technologies
        if (isset($validated['technologies'])) {
            $project->technologies()->attach($validated['technologies']);
        }

        return (new ProjectResource($project->load(['technologies', 'images'])))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Afficher un projet
     */
    public function show($id)
    {
        $project = Project::with(['author', 'technologies', 'images'])
            ->findOrFail($id);

        return new ProjectResource($project);
    }

    /**
     * Mettre à jour un projet
     */
    public function update(UpdateProjectRequest $request, $id)
    {
        $project = Project::findOrFail($id);

        $validated = $request->validated();

        $project->update($validated);

        // Mettre à jour les technologies
        if (isset($validated['technologies'])) {
            $project->technologies()->sync($validated['technologies']);
        }

        return new ProjectResource($project->load(['technologies', 'images']));
    }

    /**
     * Supprimer un projet (soft delete)
     */
    public function destroy($id)
    {
        $project = Project::findOrFail($id);
        $project->delete();

        return response()->json(['message' => 'Projet supprimé avec succès']);
    }
}
