<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UploadController extends Controller
{
    /**
     * Upload une image (admin)
     */
    public function uploadImage(Request $request)
    {
        // Validation
        $request->validate([
            'image' => 'required|image|mimes:jpeg,jpg,png,webp|max:5120',
            'project_slug' => 'required|string|max:255',
            'type' => 'required|in:main, screenshot',
        ]);

        // Récupération du fichier
        $file = $request->file('image');
        $projectSlug = $request->input('project_slug');
        $type = $request->input('type');

        // Validation des dimensions
        $dimensions = getimagesize($file->getRealPath());
        $width = $dimensions[0];
        $height = $dimensions[1];

        if ($width < 800 || $height < 600 ) {
            return response()->json([
                'message' => 'Image too small. Minimum dimensions: 800x600px',
                'current_dimensions' => "{$width}x{$height}"
            ], 422);
        }

        if ($width > 4000 || $height > 4000) {
            return response()->json([
                'message' => 'Image too big. Maximal dimensions: 4000x4000px',
                'current_dimensions' => "{$width}x{$height}"
            ], 422);
        }

        // Génération d'un nom de fichier unique
        $extension = $file->getClientOriginalExtension();
        $filename = $type . '-' . Str::random(10) . '-' . time() . '-' . $extension;

        // Chemin de stockage
        $path = $file->storeAs(
            "projects/{$projectSlug}",
            $filename,
            'public'
        );

        // URL d'accès au fichier
        $url = Storage::url($path);

        return response()->json([
            'message' => 'Image uploaded successfully',
            'path' => $path,
            'url' => $url,
            'filename' => $filename,
            'size' => $file->getSize(),
            'dimensions' => [
                'width' => $width,
                'height' => $height,
            ],  
        ], 201);
    }

    /**
     * Supprimer une image (admin)
     */
    public function deleteImage(Request $request)
    {
        $request->validate([
            'path' => 'required|string',
        ]);

        $path = $request->input('path');

        if (!Storage::disk('public')->exists($path)) {
            return response()->json([
                'message' => 'File not found',
            ], 404);
        }

        // Supprimer le fichier
        Storage::disk('public')->delete($path);

        return response()->json([
            'message' => 'Image deleted successfully',
        ]);
    }
}