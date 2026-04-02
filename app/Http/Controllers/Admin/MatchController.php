<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Matche;
use App\Models\Team;
use Illuminate\Http\Request;

class MatchController extends Controller
{
    public function index(Request $request)
    {
        $matches = Matche::with(['team1', 'team2'])
            ->orderBy('match_date', 'desc')
            ->paginate(15);
            
        return view('admin.matches.index', compact('matches'));
    }

    public function create()
    {
        $teams = Team::orderBy('name')->get();
        return view('admin.matches.create', compact('teams'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'team1_id'   => 'required|exists:teams,id',
            'team2_id'   => 'required|exists:teams,id|different:team1_id',
            'field'      => 'required|in:foot,ctf,baskett,chess,volley ball,Esport',
            'match_date' => 'required|date',
        ]);

        $team1 = Team::find($request->team1_id);
        $team2 = Team::find($request->team2_id);
        
        if ($team1->field !== $request->field || $team2->field !== $request->field) {
            return back()->withErrors(['field' => 'Les deux équipes doivent appartenir au domaine sélectionné.'])->withInput();
        }

        Matche::create([
            'team1_id' => $request->team1_id,
            'team2_id' => $request->team2_id,
            'field' => $request->field,
            'match_date' => $request->match_date,
            'status' => 'upcoming',
        ]);

        return redirect()->route('admin.matches.index')->with('success', 'Match programmé avec succès.');
    }

    public function edit(Matche $match)
    {
        $teams = Team::where('field', $match->field)->orderBy('name')->get();
        return view('admin.matches.edit', compact('match', 'teams'));
    }

    public function update(Request $request, Matche $match)
    {
        if ($match->status === 'finished') {
            return back()->with('error', 'Impossible de modifier un match déjà terminé.');
        }

        $request->validate([
            'match_date' => 'required|date',
            'status'     => 'required|in:upcoming,live,finished',
        ]);

        $match->update([
            'match_date' => $request->match_date,
            'status'     => $request->status,
        ]);

        return redirect()->route('admin.matches.index')->with('success', 'Match mis à jour.');
    }

    public function resolve(Request $request, Matche $match)
    {
        if ($match->status === 'finished') {
            return back()->with('error', 'Ce match est déjà terminé.');
        }

        $request->validate([
            'match_result' => 'required|in:team1_wins,draw,team2_wins',
        ]);

        $t1_score = 0;
        $t2_score = 0;

        $t1 = $match->team1;
        $t2 = $match->team2;

        if ($request->match_result === 'team1_wins') {
            $t1_score = 1;
            $t1->increment('score', 3);
        } elseif ($request->match_result === 'team2_wins') {
            $t2_score = 1;
            $t2->increment('score', 3);
        } else {
            $t1->increment('score', 1);
            $t2->increment('score', 1);
        }

        $match->update([
            'team1_score' => $t1_score,
            'team2_score' => $t2_score,
            'status'      => 'finished',
        ]);

        return redirect()->route('admin.matches.index')->with('success', 'Match terminé et scores des équipes mis à jour !');
    }
    
    public function destroy(Matche $match)
    {
        $match->delete();
        return redirect()->route('admin.matches.index')->with('success', 'Match supprimé.');
    }
}
