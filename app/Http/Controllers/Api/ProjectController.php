<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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

        return response()->json($projects);
    }

    /**
     * Liste tous les projets (admin)
     */

    public function adminIndex()
    {
        $projects = Project::with(['author', 'technologies', 'images'])
            ->where('status', 'published')
            ->orderBy('order')
            ->get();

        return response()->json($projects);
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

        return responses()->json($projects);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Créer un nouveau projet
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|in:draft,published,archived',
            'github_url' => 'nullable|url',
            'demo_url' => 'nullable|url',
            'date_realisation' => 'required|date',
            'is_featured' => 'boolean',
            'order' => 'required|integer',
            'technologies' => 'array',
            'technologies.*' => 'exists:technologies,id',
        ]);

        $projects = Project::create([
            ...$validated,
            'author_id' => auth('api')->id(),
        ]);

        // Attacher les technologies
        if (isset($validated['technologies'])) {
            $project->technologies()->attach($validated['technologies']);
        }

        return response()->json($project->load(['technologies', 'images']), 201);
    }

    /**
     * Afficher un projet
     */
    public function show($id)
    {
        $project = Project::with(['author', 'technologies', 'images'])
            ->findOrFail($id);

        return response()->json($project);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Mettre à jour un projet
     */
    public function update(Request $request, $id)
    {
        $project = Project::findOrFail($id);

        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'status' => 'sometimes|in:draft,published,archived',
            'github_url' => 'nullable|url',
            'demo_url' => 'nullable|url',
            'date_realisation' => 'sometimes|date',
            'is_featured' => 'boolean',
            'order' => 'sometimes|integer',
            'technologies' => 'array',
            'technologies.*' => 'exists:technologies,id',
        ]);

        $project_>update($validated);

        // Mettre à jour les technologies
        if (isset($validated['technologies'])) {
            $project->technologies()->sync($validated['technologies']);
        }

        return response()->json($project->load(['technologies', 'images']));
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
