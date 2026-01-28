<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        $projects = [
            [   'title' => 'E-commerce Platform',
                'slug' => 'ecommerce-platform',
                'description' => 'Plateforme e-commerce complète.',
                'github_url' => 'https://github.com/MPeypouxDev/ecommerce-platform',
                'demo_url' => 'https://demo-ecommerce.com',
                'is_featured' => true,
                'status' => 'published',
                'date_realisation' => '2025-01-15',
                'order' => 1,
                'author_id' => 1,
            ],
            [
                'title' => 'Task Management App',
                'slug' => 'task-management-app',
                'description' => 'Application de gestion de tâches collaborative.',
                'github_url' => 'https://github.com/MPeypouxDev/task-manager',
                'demo_url' => 'https://demo-tasks.com',
                'is_featured' => true,
                'status' => 'published',
                'date_realisation' => '2025-03-10',
                'order' => 2,
                'author_id' => 1,
            ],
            [
                'title' => 'Blog CMS',
                'slug' => 'blog-cms',
                'description' => 'Système de gestion de contenu pour blogs avec éditeur Markdown et SEO optimisé.',
                'github_url' => 'https://github.com/MPeypouxDev/blog-cms',
                'demo_url' => null,
                'is_featured' => false,
                'status' => 'published',
                'date_realisation' => '2024-09-01',
                'order' => 3,
                'author_id' => 1,
            ],
            [
                'title' => 'Weather Dashboard',
                'slug' => 'weather-dashboard',
                'description' => 'Dashboard météo interactif avec cartes et prévisions détaillées.',
                'github_url' => 'https://github.com/MPeypouxDev/weather-dashboard',
                'demo_url' => 'https://demo-weather.com',
                'is_featured' => true,
                'status' => 'published',
                'date_realisation' => '2025-07-15',
                'order' => 4,
                'author_id' => 1,
            ],
            [
                'title' => 'Social Network',
                'slug' => 'social-network',
                'description' => 'Réseau social minimaliste avec posts, likes, commentaires et messagerie.',
                'github_url' => 'https://github.com/MPeypouxDev/social-network',
                'demo_url' => null,
                'is_featured' => false,
                'status' => 'draft',
                'date_realisation' => '2025-10-01',
                'order' => 5,
                'author_id' => 1,
            ],
            [
                'title' => 'Portfolio Generator',
                'slug' => 'portfolio-generator',
                'description' => 'Générateur de portfolios personnalisables avec templates modernes.',
                'github_url' => 'https://github.com/MPeypouxDev/portfolio-generator',
                'demo_url' => 'https://demo-portfolio-gen.com',
                'is_featured' => false,
                'status' => 'published',
                'date_realisation' => '2024-05-20',
                'order' => 6,
                'author_id' => 1,
            ],
            [
                'title' => 'API Gateway',
                'slug' => 'api-gateway',
                'description' => 'Gateway API avec rate limiting, authentification et monitoring.',
                'github_url' => 'https://github.com/MPeypouxDev/api-gateway',
                'demo_url' => null,
                'is_featured' => true,
                'status' => 'published',
                'date_realisation' => '2025-02-01',
                'order' => 7,
                'author_id' => 1,
            ],
            [
                'title' => 'Quiz Platform',
                'slug' => 'quiz-platform',
                'description' => 'Plateforme de quiz interactifs avec classements et statistiques.',
                'github_url' => 'https://github.com/MPeypouxDev/quiz-platform',
                'demo_url' => 'https://demo-quiz.com',
                'is_featured' => false,
                'status' => 'published',
                'date_realisation' => '2024-11-01',
                'order' => 8,
                'author_id' => 1,
            ],
        ];

        foreach ($projects as $project) {
            Project::create($project);
        }
    }
}