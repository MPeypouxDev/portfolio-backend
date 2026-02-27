# Portfolio Backend

![Laravel](https://img.shields.io/badge/Laravel-12-FF2D20?logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?logo=php&logoColor=white)
![JWT](https://img.shields.io/badge/JWT-Auth-000000?logo=jsonwebtokens&logoColor=white)
![PHPUnit](https://img.shields.io/badge/PHPUnit-11.5-366488?logo=php&logoColor=white)

API REST construite avec Laravel 12 pour alimenter un portfolio développeur. Elle expose des endpoints publics pour la consultation du portfolio et des endpoints protégés par JWT pour l'administration du contenu.

## Stack technique

| Catégorie | Technologie |
|-----------|------------|
| Framework | Laravel 12 |
| Langage | PHP 8.2+ |
| Authentification | JWT (tymon/jwt-auth v2.2) |
| Base de données | SQLite (dev) / MySQL (prod) |
| Tests | PHPUnit 11.5 |
| Formatage | Laravel Pint |

## Prérequis

- PHP 8.2+
- Composer 2+
- SQLite (dev) ou MySQL (prod)

## Installation

```bash
# Installer les dépendances PHP
composer install

# Copier le fichier d'environnement
cp .env.example .env

# Générer les clés de l'application et JWT
php artisan key:generate
php artisan jwt:secret

# Créer la base de données SQLite et lancer les migrations
touch database/database.sqlite
php artisan migrate --seed

# Créer le lien symbolique pour le stockage des images
php artisan storage:link

# Lancer le serveur de développement
php artisan serve
```

## Configuration `.env`

```env
APP_URL=http://localhost:8000
FRONTEND_URL=http://localhost:5173

DB_CONNECTION=sqlite
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=portfolio
# DB_USERNAME=root
# DB_PASSWORD=

JWT_SECRET=your_secret_here
JWT_TTL=60
JWT_REFRESH_TTL=20160

FILESYSTEM_DISK=public
```

## Architecture

```
app/
├── Http/
│   ├── Controllers/Api/    # Orchestration des requêtes HTTP (6 contrôleurs)
│   ├── Requests/           # Validation des entrées (6 classes FormRequest)
│   ├── Resources/          # Transformation des réponses JSON (4 classes)
│   └── Middleware/         # ForceJsonResponse — force Content-Type: application/json
├── Models/                 # Eloquent : User, Project, Technology, Image, Contact
├── Observers/              # ProjectObserver — suppression en cascade des fichiers image
└── Policies/               # ProjectPolicy — autorisation par ownership
```

## Base de données

### Schéma des tables

**users**
| Colonne | Type | Description |
|---------|------|-------------|
| id | bigint | Clé primaire |
| name | string | Nom affiché |
| email | string unique | Identifiant de connexion |
| password | string | Hash bcrypt |
| timestamps, soft deletes | | |

**projects**
| Colonne | Type | Description |
|---------|------|-------------|
| id | bigint | Clé primaire |
| title | string unique | Titre du projet |
| slug | string unique | URL-friendly |
| description | text | Description longue |
| status | enum | `draft` / `published` / `archived` |
| type | enum | `frontend` / `fullstack` / `backend` |
| github_url | string nullable | Lien dépôt |
| demo_url | string nullable | Lien démo |
| date_realisation | date | Date de réalisation |
| author_id | FK → users | Propriétaire |
| is_featured | boolean | Mis en avant sur la home |
| order | integer | Ordre d'affichage |
| timestamps, soft deletes | | |

**technologies**
| Colonne | Type | Description |
|---------|------|-------------|
| id | bigint | Clé primaire |
| name | string unique | Nom de la technologie |
| type | enum | `backend` / `frontend` / `database` / `tools` |
| color | string | Couleur hexadécimale |
| icon | string nullable | Nom du fichier SVG |
| timestamps, soft deletes | | |

**project_technology** (pivot N:N)
| Colonne | Type |
|---------|------|
| project_id | FK → projects |
| technology_id | FK → technologies |

**images**
| Colonne | Type | Description |
|---------|------|-------------|
| id | bigint | Clé primaire |
| project_id | FK → projects | Projet associé |
| name | string | Nom descriptif |
| path | string | Chemin de stockage |
| alt_text | string | Texte alternatif (SEO / accessibilité) |
| is_primary | boolean | Image principale du projet |
| order | integer | Ordre d'affichage |
| timestamps, soft deletes | | |

**contacts**
| Colonne | Type | Description |
|---------|------|-------------|
| id | bigint | Clé primaire |
| first_name | string | Prénom |
| last_name | string | Nom |
| email | string | Email de l'expéditeur |
| phone | string nullable | Téléphone |
| messages | text | Contenu du message |
| read_at | timestamp nullable | Date de lecture |
| timestamps, soft deletes | | |

### Relations

```
users ──< projects          (1:N via author_id)
projects >──< technologies  (N:N via project_technology)
projects ──< images         (1:N)
contacts                    (indépendant)
```

### Contraintes sur les uploads d'images

- Formats acceptés : JPEG, PNG, WebP
- Taille max : 5 Mo
- Dimensions : 800×600 px minimum — 4000×4000 px maximum

## API Endpoints

### Format des réponses d'erreur

```json
{
  "status": "error",
  "message": "Description de l'erreur",
  "errors": {
    "field": ["Détail de validation"]
  }
}
```

| Code HTTP | Signification |
|-----------|--------------|
| 200 | Succès |
| 201 | Ressource créée |
| 204 | Suppression réussie (pas de contenu) |
| 401 | Non authentifié |
| 403 | Non autorisé (ownership) |
| 404 | Ressource introuvable |
| 422 | Erreur de validation |
| 429 | Trop de requêtes (rate limiting) |

### Endpoints publics

```
POST   /api/login                        Authentification
GET    /api/projects                     Liste des projets publiés (avec relations)
GET    /api/projects/featured            Projets mis en avant
GET    /api/projects/{id}               Détail d'un projet
GET    /api/technologies                 Liste des technologies
GET    /api/technologies/{id}           Détail d'une technologie
GET    /api/images                       Liste des images
GET    /api/images/{id}                 Détail d'une image
POST   /api/contact                      Soumettre un message de contact
```

### Endpoints protégés (JWT requis)

```
# Auth
POST   /api/logout                       Invalider le token
GET    /api/me                           Utilisateur connecté
POST   /api/refresh                      Renouveler le token JWT

# Projets
GET    /api/admin/projects               Projets de l'utilisateur (tous statuts)
POST   /api/projects                     Créer un projet
PUT    /api/projects/{id}               Modifier un projet
DELETE /api/projects/{id}               Supprimer un projet (soft delete)

# Technologies
POST   /api/technologies                 Créer une technologie
PUT    /api/technologies/{id}           Modifier une technologie
DELETE /api/technologies/{id}           Supprimer une technologie

# Images
POST   /api/images                       Créer un enregistrement image
PUT    /api/images/{id}                 Modifier un enregistrement image
DELETE /api/images/{id}                 Supprimer un enregistrement image

# Upload fichiers
POST   /api/upload                       Uploader un fichier image
DELETE /api/upload                       Supprimer un fichier image

# Contacts
GET    /api/contacts                     Liste des messages
GET    /api/contacts/{id}               Détail d'un message
DELETE /api/contacts/{id}               Supprimer un message
PUT    /api/admin/contacts/{id}/read    Marquer comme lu
```

## Sécurité

### Authentification JWT

1. L'utilisateur s'authentifie via `POST /api/login`
2. Un token JWT est retourné (TTL : 60 min, refresh : 14 jours)
3. Les routes protégées utilisent le middleware `auth:api`
4. Le token doit être transmis dans le header : `Authorization: Bearer <token>`
5. La blacklist est activée — les tokens invalidés via `/api/logout` ne sont plus acceptés

### Rate limiting

- 5 tentatives de connexion par minute sur `/api/login`
- Réponse HTTP 429 en cas de dépassement

### Autorisation par ownership

`ProjectPolicy` vérifie que l'utilisateur connecté est bien l'auteur (`author_id`) avant toute modification ou suppression d'un projet.

## Tests

```bash
# Lancer tous les tests
php artisan test

# Lancer une suite spécifique
php artisan test --testsuite=Feature
php artisan test --testsuite=Unit
```

Les tests utilisent une base SQLite dédiée (`portfolio_test`) configurée dans `phpunit.xml` et le trait `RefreshDatabase` pour isoler chaque test.

**Couverture actuelle :**
- Auth — login, logout, refresh, me
- Projets — CRUD, autorisation par ownership, soft delete, validation
- Technologies — CRUD
- Contacts — soumission, lecture admin, suppression
- Upload — validation format, taille, dimensions

## Commandes utiles

```bash
# Formater le code
./vendor/bin/pint

# Lister les routes API
php artisan route:list --path=api

# Vider tous les caches
php artisan optimize:clear

# Suivre les logs en temps réel
php artisan pail
```

## Déploiement

```bash
composer install --optimize-autoloader --no-dev
php artisan config:cache
php artisan route:cache
php artisan migrate --force
php artisan storage:link
```

Configurer `.env` pour la production :
- `APP_ENV=production`
- `APP_DEBUG=false`
- `DB_CONNECTION=mysql` avec les credentials de production
- `FRONTEND_URL` = URL du frontend déployé
