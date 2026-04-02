<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    /**
     * Show the join-team form for the authenticated user.
     */
    public function joinForm()
    {
        if (auth()->user()->hasTeam()) {
            return redirect()->route('home')->with('info', 'Vous faites déjà partie d\'une équipe.');
        }
        return view('teams.join');
    }

    /**
     * Process the join-team request.
     */
    public function join(Request $request)
    {
        $request->validate([
            'join_code' => 'required|string',
            'field' => 'required|string',
        ]);

        if (auth()->user()->hasTeam()) {
            return redirect()->route('home');
        }

        $team = Team::where('join_code', strtoupper(trim($request->join_code)))
                    ->where('field', $request->field)
                    ->first();

        if (!$team) {
            return back()->withErrors(['join_code' => 'Code invalide. Vérifiez le code de votre école.']);
        }

        if ($team->isFull()) {
            return back()->withErrors(['join_code' => "L'équipe \"{$team->name}\" est complète ({$team->max_members} membres max). Contactez l'administrateur."]);
        }

        auth()->user()->update(['team_id' => $team->id]);

        return redirect()->route('home')
                         ->with('success', "Vous avez rejoint l'équipe \"{$team->name}\" avec succès ! 🎉");
    }

    /**
     * Leave the current team.
     */
    public function leave(Request $request)
    {
        auth()->user()->update(['team_id' => null]);
        return redirect()->route('home')->with('success', 'Vous avez quitté votre équipe.');
    }
}