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
                'path' => 'https://res.cloudinary.com/dzirsb9lc/image/upload/v1771339121/evenementiel-main_pekcle.png',
                'alt_text' => 'Page d\'accueil du site de l\'agence événementielle',
                'is_primary' => true,
                'order' => 0,
            ];
            $images[] = [
                'project_id' => $evenementiel->id,
                'name' => 'Services',
                'path' => 'https://res.cloudinary.com/dzirsb9lc/image/upload/v1771339121/evenementiel1_xhb87v.png',
                'alt_text' => 'Section services de l\'agence',
                'is_primary' => false,
                'order' => 1,
            ];
            $images[] = [
                'project_id' => $evenementiel->id,
                'name' => 'Portfolio',
                'path' => 'https://res.cloudinary.com/dzirsb9lc/image/upload/v1771339120/evenementiel2_qq6y80.png',
                'alt_text' => 'Galerie de réalisations',
                'is_primary' => false,
                'order' => 2,
            ];
        }

        if ($finance) {
            $images[] = [
                'project_id' => $finance->id,
                'name' => 'Dashboard',
                'path' => 'https://res.cloudinary.com/dzirsb9lc/image/upload/v1771338161/finance-main_ab2akt.png',
                'alt_text' => 'Dashboard principal du gestionnaire de finances',
                'is_primary' => true,
                'order' => 0,
            ];
            $images[] = [
                'project_id' => $finance->id,
                'name' => 'Statistiques',
                'path' => 'https://res.cloudinary.com/dzirsb9lc/image/upload/v1771338161/finance1_azdkla.png',
                'alt_text' => 'Graphiques et statistiques financières',
                'is_primary' => false,
                'order' => 1,
            ];
            $images[] = [
                'project_id' => $finance->id,
                'name' => 'Budgets',
                'path' => 'https://res.cloudinary.com/dzirsb9lc/image/upload/v1771338162/finance2_a6wmtm.png',
                'alt_text' => 'Gestion des budgets',
                'is_primary' => false,
                'order' => 2,
            ];
        }

        if ($combat) {
            $images[] = [
                'project_id' => $combat->id,
                'name' => 'Menu principal',
                'path' => 'https://res.cloudinary.com/dzirsb9lc/image/upload/v1771338179/combat-main_dcpwql.png',
                'alt_text' => 'Écran d\'accueil du jeu Combat Arena',
                'is_primary' => true,
                'order' => 0,
            ];
            $images[] = [
                'project_id' => $combat->id,
                'name' => 'Combat',
                'path' => 'https://res.cloudinary.com/dzirsb9lc/image/upload/v1771338178/combat1_qbgvvw.png',
                'alt_text' => 'Combat en cours entre deux personnages',
                'is_primary' => false,
                'order' => 1,
            ];
        }

        foreach ($images as $imageData) {
            Image::updateOrCreate(
                [
                    'project_id' => $imageData['project_id'],
                    'path' => $imageData['path']
                ],
                $imageData
            );
        }
    }
}