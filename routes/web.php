<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\TeamController as AdminTeamController;
use App\Http\Controllers\Admin\UserController as AdminUserController;

/* ═══════════════════════════════════════════════════════
   PUBLIC — Page d'accueil / Leaderboard
═══════════════════════════════════════════════════════ */
Route::get('/', function () {
    $teamsByField = \App\Models\Team::withCount('members')
        ->orderByDesc('score')
        ->get()
        ->groupBy('field');
        
    $upcomingMatches = \App\Models\Matche::with(['team1', 'team2'])
        ->whereIn('status', ['upcoming', 'live'])
        ->orderBy('status', 'asc') // live en premier (l avant u)
        ->orderBy('match_date', 'asc')
        ->take(8)
        ->get();
        
    return view('welcome', compact('teamsByField', 'upcomingMatches'));
})->name('home');

/* ═══════════════════════════════════════════════════════
   AUTHENTICATED USERS
═══════════════════════════════════════════════════════ */
Route::middleware('auth')->group(function () {

    // Dashboard utilisateur
    Route::get('/dashboard', function () {
        $user = auth()->user()->load('team.members');
        return view('dashboard', compact('user'));
    })->name('dashboard');

    // Rejoindre / Quitter une équipe
    Route::get('/join',   [TeamController::class, 'joinForm'])->name('teams.join');
    Route::post('/join',  [TeamController::class, 'join'])->name('teams.join.post');
    Route::post('/leave', [TeamController::class, 'leave'])->name('teams.leave');

});

/* ═══════════════════════════════════════════════════════
   ADMIN PANEL
═══════════════════════════════════════════════════════ */
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard admin
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Gestion des équipes (écoles)
    Route::get('/teams',                          [AdminTeamController::class, 'index'])->name('teams.index');
    Route::get('/teams/create',                   [AdminTeamController::class, 'create'])->name('teams.create');
    Route::post('/teams',                         [AdminTeamController::class, 'store'])->name('teams.store');
    Route::get('/teams/{team}/edit',              [AdminTeamController::class, 'edit'])->name('teams.edit');
    Route::put('/teams/{team}',                   [AdminTeamController::class, 'update'])->name('teams.update');
    Route::delete('/teams/{team}',                [AdminTeamController::class, 'destroy'])->name('teams.destroy');
    Route::post('/teams/{team}/regenerate-code',  [AdminTeamController::class, 'regenerateCode'])->name('teams.regenerate');

    // Gestion des utilisateurs
    Route::get('/users',              [AdminUserController::class, 'index'])->name('users.index');
    Route::get('/users/create',       [AdminUserController::class, 'create'])->name('users.create');
    Route::post('/users',             [AdminUserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit',  [AdminUserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}',       [AdminUserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}',    [AdminUserController::class, 'destroy'])->name('users.destroy');

    // Gestion des matchs
    Route::get('/matches',                            [\App\Http\Controllers\Admin\MatchController::class, 'index'])->name('matches.index');
    Route::get('/matches/create',                     [\App\Http\Controllers\Admin\MatchController::class, 'create'])->name('matches.create');
    Route::post('/matches',                           [\App\Http\Controllers\Admin\MatchController::class, 'store'])->name('matches.store');
    Route::get('/matches/{match}/edit',               [\App\Http\Controllers\Admin\MatchController::class, 'edit'])->name('matches.edit');
    Route::put('/matches/{match}',                    [\App\Http\Controllers\Admin\MatchController::class, 'update'])->name('matches.update');
    Route::post('/matches/{match}/resolve',           [\App\Http\Controllers\Admin\MatchController::class, 'resolve'])->name('matches.resolve');
    Route::delete('/matches/{match}',                 [\App\Http\Controllers\Admin\MatchController::class, 'destroy'])->name('matches.destroy');

});

require __DIR__ . '/auth.php';