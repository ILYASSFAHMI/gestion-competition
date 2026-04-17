<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Team;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('team')->get();
        $teams = Team::all();

        return view('users.index', compact('users', 'teams'));
    }

    public function updateTeam(Request $request, User $user)
    {
        $user->team_id = $request->team_id;
        $user->save();

        return redirect()->back();
    }
}