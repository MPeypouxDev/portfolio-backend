# Portfolio Backend

Backend API REST développé avec Laravel pour alimenter mon portfolio personnel.
Ce projet expose une API sécurisée, structurée et documentée, reposant sur une base de données relationnelle et une authentification JWT.

## Stack technique
![Laravel](https://img.shields.io/badge/Laravel-FF2D20?logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-777BB4?logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-4479A1?logo=mysql&logoColor=white)

- Laravel 10+
- PHP 8.1+
- MySQL
- JWT Authentication
- API REST
- Migrations & Seeders
- PHPUnit (tests)

## Objectif du projet

- Exposer les données du projets
- Gérer les technologies associées (many-to-many)
- Gérer les images liées aux projets
- Enregistrer les messages envoyés via formulaire de contact
- Protéger les routes d'administration via authentification JWT
- Fournir une API propre et exploitable par un frontend React

## Architecture applicative

L'application suit le pattern MVC de Laravel.

### Structure principale

app/
 |-- Http/
 |   |-- Controllers/Api/
 |       |-- AuthController.php
 |       |-- ProjectController.php
 |       |-- TechnologyController.php
 |       |-- ImageController.php
 |       |-- UploadController.php
 |       |-- ContactController.php  
 |-- Models/
 |   |-- Project.php
 |   |-- Technology.php
 |   |-- Image.php
 |   |-- Contact.php
 |   |-- User.php
 |-- Observers/
 |   |-- ProjectObserver.php
 database/
 |-- migrations/
 |-- seeders/
 routes/
 |-- api.php

 ## Responsabilités

 - Controllers: gestion des requêtes HTTP et orchestration
 - Models: définition des relations et logique d'accès aux données
 - Observers: automatisation de traitements
 - Migrations: définition du schéma relationnel
 - Seeders: génération d'un jeu de données cohérent pour le développement
 - Configuration JWT: sécurisation des endpoints protégés

 ## Modélisation de la base de données

 ### Table principales

 projects
 - id
 - title
 - description
 - slug
 - type
 - date_realisation
 - timestamps

 technologies
 - id
 - name (unique)
 - icon
 - timestamps

 project_technology
 Table pivot many-to-many
- project_id
- technology_id

images
Relations 1-N avec projects
- id
- project_id
- path
- alt_text
- is_primary
- order
- timestamps

contacts
Messages envoyés via le formulaire de contact
- id
- name
- email
- message

users
Utilisateurs authentifiés pour l'administration

## Relations principales

- Un projet posséde plusieurs technologies (N-N via table pivot)
- Une technologie peut être associée à plusieurs projets
- Un projet possède plusieurs images (1-N)
- Les messages de contact sont indépendants des projets
- Les utilisateurs sont authentifiés vie JWT

## Sécurité

### Authentification JWT

L'authentification repose sur JWT (JSON Web Token) pour une authentification stateless et scalable.

#### Fonctionnement

1. Un utilisateur s'authentifie via `/api/login`
2. Un token JWT est généré avec un TTL configurable
3. Les routes protégées utilisent le middleware `auth:api`
4. Le token doit être fourni dans l'en-tête `Authorization: Bearer <token>`

#### Protection contre les attaques

**Rate Limiting :**
- Limitation à **5 tentatives de connexion par minute** sur `/api/login`
- Réponse HTTP 429 en cas de dépassement
- Prévention des attaques par force brute

**Logging des échecs :**
- Chaque tentative de connexion échouée est enregistrée
- Informations loggées : email, IP, user-agent, timestamp
- Fichiers de logs : `storage/logs/laravel.log`

### Routes protégées

Toutes les routes d'administration nécessitent un token JWT valide :
- Création / modification / suppression de projets
- Upload d'images
- Gestion des technologies
- Accès aux messages de contact

### Configuration

- `config/auth.php` : définition du guard API basé sur JWT
- `config/jwt.php` : configuration du TTL, algorithme de signature
- `config/cors.php` : autorisation du frontend via FRONTEND_URL

## API Endpoints

### Structure des réponses d'erreur

Toutes les erreurs API retournent une structure JSON standardisée :
```json
{
  "status": "error",
  "message": "Description de l'erreur",
  "errors": {
    "field": ["Détails de validation"]
  }
}
```

**Exemples d'erreurs :**

**Erreur de validation (422) :**
```json
{
  "status": "error",
  "message": "The email field must be a valid email address.",
  "errors": {
    "email": ["The email field must be a valid email address."]
  }
}
```

**Erreur d'authentification (401) :**
```json
{
  "status": "error",
  "message": "Identifiants incorrects",
  "errors": null
}
```

**Rate limit dépassé (429) :**
```json
{
  "status": "error",
  "message": "Too Many Attempts.",
  "errors": null
}
```

### Authentification

- POST /api/login
- POST /api/logout
- GET /api/me

### Projets

- GET /api/projects
- GET /api/prokects/{id}
- POST /api/projects/{id} (protégé)
- PUT /api/projects/{id} (protégé)
- DELETE /api/projects/{id} (protégé)

### Technologies

- GET /api/technologies
- POST /api/technologies (protégé)

### Images

- POST /api/upload (protégé)
- Gestion via ImageController (protégé)

### Contact 
- POST /api/contact

### Exemple de réponse JSON

GET /api/projects :

[
  {
    "id": 1,
    "title": "Agence Evénementielle",
    "slug": "agence-evenementielle",
    "type": "frontend",
    "description": "Site vitrine pour une agence événementielle. Interface élégante présentant les services et formulaire de contact.",
    "status": "published",
    "github_url": "https://github.com/MPeypouxDev/Events-Co",
    "demo_url": "https://events-and-co.netlify.app/",
    "date_realisation": "2025-06-15T00:00:00.000000Z",
    "author_id": 1,
    "is_featured": false,
    "order": 1,
    "created_at": "2026-02-09T13:50:57.000000Z",
    "updated_at": "2026-02-09T13:50:57.000000Z",
    "deleted_at": null,
    "author": {
      "id": 1,
      "name": "Mathys Peypoux",
      "email": "admin@portfolio.com",
      "email_verified_at": null,
      "created_at": "2026-02-09T13:50:57.000000Z",
      "updated_at": "2026-02-09T13:50:57.000000Z"
    },
    "technologies": [
      {
        "id": 4,
        "name": "JavaScript",
        "type": "frontend",
        "color": "#F7DF1E",
        "created_at": "2026-02-09T13:50:57.000000Z",
        "updated_at": "2026-02-09T13:50:57.000000Z",
        "deleted_at": null,
        "icon": "javascript.svg",
        "pivot": {
          "project_id": 1,
          "technology_id": 4
        }
      },
      {
        "id": 5,
        "name": "HTML5",
        "type": "frontend",
        "color": "#E34F26",
        "created_at": "2026-02-09T13:50:57.000000Z",
        "updated_at": "2026-02-09T13:50:57.000000Z",
        "deleted_at": null,
        "icon": "html5.svg",
        "pivot": {
          "project_id": 1,
          "technology_id": 5
        }
      },
      {
        "id": 6,
        "name": "CSS",
        "type": "frontend",
        "color": "#663399",
        "created_at": "2026-02-09T13:50:57.000000Z",
        "updated_at": "2026-02-09T13:50:57.000000Z",
        "deleted_at": null,
        "icon": "css.svg",
        "pivot": {
          "project_id": 1,
          "technology_id": 6
        }
      }
    ],
    "images": [
      {
        "id": 1,
        "name": "Page d'accueil",
        "path": "projects/agence-evenementielle/evenementiel-main.jpg",
        "alt_text": "Page d'accueil du site de l'agence événementielle",
        "is_primary": true,
        "order": 0,
        "project_id": 1,
        "created_at": "2026-02-09T13:50:57.000000Z",
        "updated_at": "2026-02-09T13:50:57.000000Z",
        "deleted_at": null
      },
      {
        "id": 2,
        "name": "Services",
        "path": "projects/agence-evenementielle/evenementiel1.jpg",
        "alt_text": "Section services de l'agence",
        "is_primary": false,
        "order": 1,
        "project_id": 1,
        "created_at": "2026-02-09T13:50:57.000000Z",
        "updated_at": "2026-02-09T13:50:57.000000Z",
        "deleted_at": null
      },
      {
        "id": 3,
        "name": "Portfolio",
        "path": "projects/agence-evenementielle/evenementiel2.jpg",
        "alt_text": "Galerie de réalisations",
        "is_primary": false,
        "order": 2,
        "project_id": 1,
        "created_at": "2026-02-09T13:50:57.000000Z",
        "updated_at": "2026-02-09T13:50:57.000000Z",
        "deleted_at": null
      }
    ]
  }
]

## Installation

### Prérequis

- PHP >= 8.1
- Composer >= 2.0
- MySQL >= 5.7

### Commandes d'installation

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan jwt:secret
php artisan migrate --seed
php artisan storage:link
php artisan serve
```

## Variables d'environnement

```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=portfolio
DB_USERNAME=root
DB_PASSWORD=

APP_URL=http://localhost:8000

FRONTEND_URL=http://localhost:5173
```

## Tests

L'application utilise PHPUnit

Lancer les tests :

```bash
php artisan test
```

Les tests couvrent:
- Endpoints API
- Authentification
- Création de ressources
- Validation des requêtes

## Choix techniques

### Laravel

Framework robuste permettant:
- Architecture claire MVC
- Gestion native des migrations
- Sécurité intégrée
- Ecosystème mature

### JWT

Choix effectué pour:
- Séparer authentification backend / frontend
- Faciliter l'intégration SPA
- Utiliser une authentification stateless

### MySQL

Base relationnelle adpatée à:
- Relations N-N
- Intégrité référentielle
- Structuration claire des données

## Améliorations futures

- Mise en place d'API Resources pour standardiser les réponses JSON
- Utilisation de FormRequest pour validation avancée
- Ajout de tests Feature supplémentaires
- Pagination des endpoints
- Mise en cache des requêtes fréquentes
- Dockerisation du projet
- Intégration CI/CD