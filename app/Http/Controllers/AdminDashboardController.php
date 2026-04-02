<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\User;
use App\Models\Challenge;
use App\Models\Solve;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'teams'      => Team::count(),
            'users'      => User::where('role', 'user')->count(),
            'challenges' => Challenge::count(),
            'solves'     => Solve::count(),
        ];

        $topTeams = Team::withCount('users')
            ->with('solves')
            ->orderByDesc('score')
            ->take(5)
            ->get();

        $recentSolves = Solve::with(['team', 'challenge', 'user'])
            ->orderByDesc('created_at')
            ->take(10)
            ->get();

        return view('dashboard', compact('stats', 'topTeams', 'recentSolves'));
    }
}
