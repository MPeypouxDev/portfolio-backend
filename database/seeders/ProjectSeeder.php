<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        $projects = [
            ['title' => 'Agence Evénementielle',
                'slug' => 'agence-evenementielle',
                'description' => 'Site vitrine pour une agence événementielle. Interface élégante présentant les services et formulaire de contact.',
                'type' => 'frontend',
                'github_url' => 'https://github.com/MPeypouxDev/Events-Co',
                'demo_url' => 'https://events-and-co.netlify.app/',
                'is_featured' => false,
                'status' => 'published',
                'date_realisation' => '2025-06-15',
                'order' => 1,
                'author_id' => 1,
            ],
            [
                'title' => 'Gestionnaire de Finances',
                'slug' => 'gestionnaire-finance',
                'description' => 'Application web de gestion financière personnelle. Suivi des dépenses, budgets et statistiques détaillées.',
                'type' => 'frontend',
                'github_url' => 'https://github.com/MPeypouxDev/Gestion-Comptable',
                'demo_url' => 'https://gestioncomptable.netlify.app/',
                'is_featured' => false,
                'status' => 'published',
                'date_realisation' => '2025-07-08',
                'order' => 2,
                'author_id' => 1,
            ],
            [
                'title' => 'Anime Fight Mini Game',
                'slug' => 'anime-fight',
                'description' => 'Jeu de combat en ligne mettant en scène des personnages d\'animations populaires. Système de combat dynamique et matchmaking.',
                'type' => 'frontend',
                'github_url' => 'https://github.com/MPeypouxDev/Anime-Fight',
                'demo_url' => 'https://animefightgame.netlify.app/',
                'is_featured' => true,
                'status' => 'published',
                'date_realisation' => '2025-08-02',
                'order' => 3,
                'author_id' => 1,
            ],
        ];

        foreach ($projects as $project) {
            Project::create($project);
        }
    }
}
