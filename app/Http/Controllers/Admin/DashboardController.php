<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Team;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalTeams   = Team::count();
        $totalUsers   = User::where('role', 'user')->count();
        $usersInTeams = User::where('role', 'user')->whereNotNull('team_id')->count();
        $teams        = Team::withCount('members')->orderByDesc('score')->get();

        return view('admin.dashboard', compact('totalTeams', 'totalUsers', 'usersInTeams', 'teams'));
    }
}
