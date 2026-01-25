<?php 

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Technology;
use Illuminate\Http\Request;

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
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:technologies',
            'icon' => 'nullable|string|max:255',
            'color' => 'required|string|max:7',
        ]);

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
    public function update(Request $request, $id)
    {
        $technology = Technology::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:technologies,name,' . $id,
            'icon' => 'nullable|string|max:255',
            'color' => 'required|string|max:7',
        ]);

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