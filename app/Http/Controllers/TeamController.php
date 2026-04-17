<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    // afficher les équipes
    public function index()
    {
        $teams = Team::all();
        return view('teams.index', compact('teams'));
    }

    // ajouter équipe
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        Team::create([
            'name' => $request->name
        ]);

        return redirect()->back();
    }

    // supprimer équipe
    public function destroy(Team $team)
    {
        $team->delete();
        return redirect()->back();
    }
}