<?php 

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Technology;
use Illuminate\Http\Request;
use App\Http\Requests\StoreTechnologyRequest;
use App\Http\Requests\UpdateTechnologyRequest;

class TechnologyController extends Controller
{
    /**
     * Liste toutes les technologies
     */
    public function index()
    {
        $technologies = Technology::all();
        return response()->json($technologies);
    }

    /**
     * Créer une nouvelle technologie (admin)
     */
    public function store(StoreTechnologyRequest $request)
    {
        $validated = $request->validated();

        $technology = Technology::create($validated);

        return response()->json($technology, 201);
    }

    /**
     * Afficher une technologie
     */
    public function show($id)
    {
        $technology = Technology::findOrFail($id);
        return response()->json($technology);
    }

    /**
     * Modifier une technologie (admin)
     */
    public function update(UpdateTechnologyRequest $request, $id)
    {
        $technology = Technology::findOrFail($id);

        $validated = $request->validated();

        $technology->update($validated);

        return response()->json($technology);
    }

    /**
     * Supprimer une technologie (admin)
     */
    public function destroy($id)
    {
        $technology = Technology::findOrFail($id);
        $technology->delete();

        return response()->json(['message' => 'Technology deleted successfully']);
    }
}