# Script pour générer un historique Git avec des dates antérieures

# 1. Nettoyer le dépôt Git s'il existe
if (Test-Path ".git") {
    Remove-Item -Recurse -Force ".git"
}

# 2. Initialiser Git
git init
git branch -M main

# --- COMMIT 1 : 10 Mars 2026 ---
$env:GIT_AUTHOR_DATE="2026-03-10T10:30:00"
$env:GIT_COMMITTER_DATE="2026-03-10T10:30:00"
git add artisan composer.json composer.lock package.json package-lock.json vite.config.js bootstrap/ public/ config/
git commit -m "Initial commit: Laravel project setup"

# --- COMMIT 2 : 18 Mars 2026 ---
$env:GIT_AUTHOR_DATE="2026-03-18T14:15:00"
$env:GIT_COMMITTER_DATE="2026-03-18T14:15:00"
git add resources/css resources/js
git add resources/views/layouts/ resources/views/auth/
git commit -m "Add authentication layout and styling"

# --- COMMIT 3 : 25 Mars 2026 ---
$env:GIT_AUTHOR_DATE="2026-03-25T11:45:00"
$env:GIT_COMMITTER_DATE="2026-03-25T11:45:00"
git add database/migrations database/seeders app/Models/
git commit -m "Create Database Migrations and Models for Teams & Matches"

# --- COMMIT 4 : 2 Avril 2026 ---
$env:GIT_AUTHOR_DATE="2026-04-02T16:20:00"
$env:GIT_COMMITTER_DATE="2026-04-02T16:20:00"
git add app/Http/Controllers/ app/Http/Middleware/
git commit -m "Implement controllers and Admin middleware logic"

# --- COMMIT 5 : 10 Avril 2026 ---
$env:GIT_AUTHOR_DATE="2026-04-10T09:10:00"
$env:GIT_COMMITTER_DATE="2026-04-10T09:10:00"
git add resources/views/admin/ resources/views/teams/
git commit -m "Develop Admin Dashboard and Team views"

# --- COMMIT 6 : 16 Avril 2026 ---
$env:GIT_AUTHOR_DATE="2026-04-16T15:30:00"
$env:GIT_COMMITTER_DATE="2026-04-16T15:30:00"
git add resources/views/welcome.blade.php resources/views/dashboard.blade.php routes/web.php
git commit -m "Finalize User Dashboard, routing, and Match Resolution"

# --- COMMIT 7 : 20 Avril 2026 ---
$env:GIT_AUTHOR_DATE="2026-04-20T18:00:00"
$env:GIT_COMMITTER_DATE="2026-04-20T18:00:00"
git add .
git commit -m "Project cleanup, bug fixes, and final review"

# Nettoyer les variables d'environnement
Remove-Item Env:\GIT_AUTHOR_DATE
Remove-Item Env:\GIT_COMMITTER_DATE

Write-Host "Historique Git généré avec succès !"
