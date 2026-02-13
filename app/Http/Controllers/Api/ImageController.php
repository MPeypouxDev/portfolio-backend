<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UploadImageRequest;

class ImageController extends Controller
{
    /**
     * Liste toutes les images
     */
    public function index()
    {
        $images = Image::with('project')->get();
        return response()->json($images);
    }

    /**
     * Upload une nouvelle image (admin)
     */
    public function store(UploadImageRequest $request)
    {
        $validated = $request->validated();

        $image = Image::create($validated);

        return response()->json($image->load('project'), 201);
    }

    /**
     * Afficher une image
     */
    public function show($id)
    {
        $image = Image::with('project')->findOrFail($id);
        return response()->json($image);
    }

    /**
     * Modifier une image (admin)
     */
    public function update(UploadImageRequest $request, $id)
    {
        $image = Image::findOrFail($id);

        $validated = $request->validated();

        $image->update($validated);

        return response()->json($image->load('project'));
    }

    /**
     * Supprimer une image (admin)
     */
    public function destroy($id)
    {
        $image = Image::findOrFail($id);
        $image->delete();

        return response()->json(['message' => 'Image deleted successfully']);
    }
}