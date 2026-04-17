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
        Matche::create([
            'team1_id' => $request->team1_id,
            'team2_id' => $request->team2_id,
            'score_team1' => 0,
            'score_team2' => 0,
        ]);

        return redirect()->back();
    }

    public function updateScore(Request $request, Matche $matche)
    {
        $matche->update([
            'score_team1' => $request->score_team1,
            'score_team2' => $request->score_team2,
        ]);

        return redirect()->back();
    }

    // ✅ LA FONCTION IMPORTANTE
    public function ranking()
    {
        $teams = Team::all();
        $ranking = [];

        foreach ($teams as $team) {

            $matches = Matche::where('team1_id', $team->id)
                ->orWhere('team2_id', $team->id)
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