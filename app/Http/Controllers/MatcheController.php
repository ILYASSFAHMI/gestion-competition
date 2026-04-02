<?php

namespace App\Http\Controllers;

use App\Models\Matche;
use App\Models\Team;
use Illuminate\Http\Request;

class MatcheController extends Controller
{
    public function index()
    {
        $matches = Matche::with(['team1', 'team2'])->get();
        $teams = Team::all();

        return view('matches.index', compact('matches', 'teams'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'team1_id' => 'required|exists:teams,id',
            'team2_id' => 'required|exists:teams,id',
            'match_date' => 'nullable|date',
            'status' => 'required|string|in:upcoming,live,finished',
            'score_team1' => 'required|integer',
            'score_team2' => 'required|integer',
        ]);

        Matche::create([
            'team1_id' => $request->team1_id,
            'team2_id' => $request->team2_id,
            'match_date' => $request->match_date,
            'status' => $request->status,
            'score_team1' => $request->score_team1,
            'score_team2' => $request->score_team2,
        ]);

        return redirect()->back()->with('success', 'Match ajouté avec succès.');
    }

    public function updateScore(Request $request, $id)
    {
        $match = Matche::findOrFail($id);

        $request->validate([
            'score_team1' => 'required|integer',
            'score_team2' => 'required|integer',
            'status' => 'sometimes|string|in:upcoming,live,finished',
        ]);

        $data = [
            'score_team1' => $request->score_team1,
            'score_team2' => $request->score_team2,
        ];

        if ($request->has('status')) {
            $data['status'] = $request->status;
        }

        $match->update($data);

        return redirect()->back()->with('success', 'Match mis à jour.');
    }

    public function destroy($id)
    {
        $match = Matche::findOrFail($id);
        $match->delete();
        return redirect()->back()->with('success', 'Battle supprimée.');
    }

    // ✅ LA FONCTION IMPORTANTE
    public function ranking()
    {
        $teams = Team::all();
        $ranking = [];

        foreach ($teams as $team) {

            $matches = Matche::where(function($query) use ($team) {
                    $query->where('team1_id', $team->id)
                          ->orWhere('team2_id', $team->id);
                })
                ->whereIn('status', ['live', 'finished'])
                ->get();

            $points = 0;
            $goalsFor = 0;
            $goalsAgainst = 0;

            foreach ($matches as $match) {
                if ($match->team1_id == $team->id) {
                    $goalsFor += $match->score_team1;
                    $goalsAgainst += $match->score_team2;

                    if ($match->score_team1 > $match->score_team2) $points += 3;
                    elseif ($match->score_team1 == $match->score_team2) $points += 1;
                } else {
                    $goalsFor += $match->score_team2;
                    $goalsAgainst += $match->score_team1;

                    if ($match->score_team2 > $match->score_team1) $points += 3;
                    elseif ($match->score_team1 == $match->score_team2) $points += 1;
                }
            }

            $ranking[] = [
                'team' => $team->name,
                'points' => $points,
                'goalsFor' => $goalsFor,
                'goalsAgainst' => $goalsAgainst,
                'diff' => $goalsFor - $goalsAgainst
            ];
        }

        usort($ranking, function ($a, $b) {
            return $b['points'] <=> $a['points']
                ?: $b['diff'] <=> $a['diff'];
        });

        return view('ranking.index', compact('ranking'));
    }
}