<?php

namespace Database\Seeders;

use App\Models\Image;
use App\Models\Project;
use Illuminate\Database\Seeder;

class ImageSeeder extends Seeder
{
    public function run(): void
    {
        $evenementiel = Project::where('slug', 'agence-evenementielle')->first();
        $finance = Project::where('slug', 'gestionnaire-finance')->first();
        $combat = Project::where('slug', 'anime-fight')->first();

        $images = [];

        if ($evenementiel) {
            $images[] = [
                'project_id' => $evenementiel->id,
                'name' => 'Page d\'accueil',
                'path' => 'projects/agence-evenementielle/evenementiel-main.jpg',
                'alt_text' => 'Page d\'accueil du site de l\'agence événementielle',
                'is_primary' => true,
                'order' => 0,
            ];
            $images[] = [
                'project_id' => $evenementiel->id,
                'name' => 'Services',
                'path' => 'projects/agence-evenementielle/evenementiel1.jpg',
                'alt_text' => 'Section services de l\'agence',
                'is_primary' => false,
                'order' => 1,
            ];
            $images[] = [
                'project_id' => $evenementiel->id,
                'name' => 'Portfolio',
                'path' => 'projects/agence-evenementielle/evenementiel2.jpg',
                'alt_text' => 'Galerie de réalisations',
                'is_primary' => false,
                'order' => 2,
            ];
        }

        if ($finance) {
            $images[] = [
                'project_id' => $finance->id,
                'name' => 'Dashboard',
                'path' => 'projects/gestionnaire-finances/finance-main.jpg',
                'alt_text' => 'Dashboard principal du gestionnaire de finances',
                'is_primary' => true,
                'order' => 0,
            ];
            $images[] = [
                'project_id' => $finance->id,
                'name' => 'Statistiques',
                'path' => 'projects/gestionnaire-finances/finance1.jpg',
                'alt_text' => 'Graphiques et statistiques financières',
                'is_primary' => false,
                'order' => 1,
            ];
            $images[] = [
                'project_id' => $finance->id,
                'name' => 'Budgets',
                'path' => 'projects/gestionnaire-finances/finance2.jpg',
                'alt_text' => 'Gestion des budgets',
                'is_primary' => false,
                'order' => 2,
            ];
        }

        if ($combat) {
            $images[] = [
                'project_id' => $combat->id,
                'name' => 'Menu principal',
                'path' => 'projects/anime-fight/combat-main.jpg',
                'alt_text' => 'Écran d\'accueil du jeu Combat Arena',
                'is_primary' => true,
                'order' => 0,
            ];
            $images[] = [
                'project_id' => $combat->id,
                'name' => 'Combat',
                'path' => 'projects/anime-fight/combat1.jpg',
                'alt_text' => 'Combat en cours entre deux personnages',
                'is_primary' => false,
                'order' => 1,
            ];
        }

        foreach ($images as $imageData) {
            Image::updateOrCreate(
                [
                    'project_id' => $imageData['project_id'],
                    'path' => $imageData['path'],
                ],
                $imageData
            );
        }
    }
}
