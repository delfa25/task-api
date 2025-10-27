# Démonstration Task API

## 1. Démarrer le serveur
```bash
php artisan serve
```

## 2. Tester l'API avec curl

### Inscription
```bash
curl -X POST http://localhost:8000/api/register \
  -H "Content-Type: application/json" \
  -d '{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password123",
    "password_confirmation": "password123"
  }'
```

### Connexion
```bash
curl -X POST http://localhost:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "john@example.com",
    "password": "password123"
  }'
```

### Créer une tâche (remplacer TOKEN)
```bash
curl -X POST http://localhost:8000/api/tasks \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer TOKEN" \
  -d '{
    "title": "Ma première tâche",
    "description": "Description de la tâche",
    "status": "pending"
  }'
```

### Lister les tâches
```bash
curl -X GET http://localhost:8000/api/tasks \
  -H "Authorization: Bearer TOKEN"
```

## 3. Tests automatisés
```bash
php artisan test
```

## 4. GitHub Actions
- Push sur GitHub
- Les tests s'exécutent automatiquement
- Badge de statut dans le README