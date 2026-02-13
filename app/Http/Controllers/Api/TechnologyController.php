<?php 

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Technology;
use Illuminate\Http\Request;
use App\Http\Requests\StoreTechnologyRequest;
use App\Http\Requests\UpdateTechnologyRequest;
use App\Http\Resources\TechnologyResource;

class TechnologyController extends Controller
{
    /**
     * Liste toutes les technologies
     */
    public function index()
    {
        $technologies = Technology::all();

        return TechnologyResource::collection($technologies);
    }

    /**
     * Créer une nouvelle technologie (admin)
     */
    public function store(StoreTechnologyRequest $request)
    {
        $validated = $request->validated();

        $technology = Technology::create($validated);

        return (new TechnologyResource($technology))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Afficher une technologie
     */
    public function show($id)
    {
        $technology = Technology::findOrFail($id);
        
        return new TechnologyResource($technology);
    }

    /**
     * Modifier une technologie (admin)
     */
    public function update(UpdateTechnologyRequest $request, $id)
    {
        $technology = Technology::findOrFail($id);

        $validated = $request->validated();

        $technology->update($validated);

        return new TechnologyResource($technology);
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