# Task API - Laravel JWT

![Tests](https://github.com/votre-username/task-api/workflows/Tests/badge.svg)

API REST pour la gestion de tâches avec authentification JWT.

## Fonctionnalités

- ✅ Authentification JWT (register, login, logout)
- ✅ CRUD complet pour les tâches
- ✅ Autorisation (utilisateurs ne peuvent voir que leurs tâches)
- ✅ Tests automatisés
- ✅ CI/CD avec GitHub Actions

## Installation

```bash
# Cloner le projet
git clone https://github.com/votre-username/task-api.git
cd task-api

# Installer les dépendances
composer install

# Copier le fichier d'environnement
cp .env.example .env

# Générer la clé d'application
php artisan key:generate

# Générer la clé JWT
php artisan jwt:secret

# Exécuter les migrations
php artisan migrate

# Lancer le serveur
php artisan serve
```

## API Endpoints

### Authentification
- `POST /api/register` - Inscription
- `POST /api/login` - Connexion
- `POST /api/logout` - Déconnexion
- `GET /api/me` - Profil utilisateur

### Tâches
- `GET /api/tasks` - Liste des tâches
- `POST /api/tasks` - Créer une tâche
- `GET /api/tasks/{id}` - Voir une tâche
- `PUT /api/tasks/{id}` - Modifier une tâche
- `DELETE /api/tasks/{id}` - Supprimer une tâche

## Tests

```bash
php artisan test
```

## Technologies

- Laravel 12
- JWT Auth
- PHPUnit
- GitHub Actions