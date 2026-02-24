<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProjectRequest;
// use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Http\Requests\UpdateProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use Illuminate\Support\Str;

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
            ->where('author_id', auth('api')->id())
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

        $data = $request->validated();

        $slug = $data['slug'] ?? Str::slug($data['title']);

        if (Project::where('slug', $slug)->exists()) {
            $slug .= '-'.now()->format('His');
        }

        $data['slug'] = $slug;

        $data['author_id'] = auth('api')->id();

        $project = Project::create($data);

        if (isset($data['technologies'])) {
            $project->technologies()->attach($data['technologies']);
        }

        return (new ProjectResource($project->load(['author', 'technologies', 'images'])))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Afficher un projet
     */
    public function show($id)
    {
        $project = Project::with(['author', 'technologies', 'images'])
            ->where('status', 'published')
            ->findOrFail($id);

        return new ProjectResource($project);
    }

    /**
     * Mettre à jour un projet
     */
    public function update(UpdateProjectRequest $request, $id)
    {
        $project = Project::findOrFail($id);
        $this->authorize('update', $project);

        $validated = $request->validated();

        if (isset($validated['title']) && ! isset($validated['slug'])) {
            $slug = Str::slug($validated['title']);

            if (Project::where('slug', $slug)->where('id', '!=', $project->id)->exists()) {
                $slug .= '-'.now()->format('His');
            }

            $validated['slug'] = $slug;
        }

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
        $this->authorize('delete', $project);
        $project->delete();

        return response()->noContent();
    }
}
