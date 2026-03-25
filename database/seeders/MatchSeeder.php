<?php

namespace Database\Seeders;

use App\Models\Team;
use App\Models\Matche;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class MatchSeeder extends Seeder
{
    public function run(): void
    {
        // Create Teams if they don't exist
        $teams = [
            ['name' => 'Real Madrid'],
            ['name' => 'FC Barcelona'],
            ['name' => 'Manchester City'],
            ['name' => 'Liverpool'],
            ['name' => 'Bayern Munich'],
            ['name' => 'PSG'],
        ];

        foreach ($teams as $teamData) {
            Team::firstOrCreate($teamData);
        }

        $allTeams = Team::all();

        if ($allTeams->count() < 2) return;

        // LIVE Matches
        Matche::create([
            'team1_id' => $allTeams[0]->id,
            'team2_id' => $allTeams[1]->id,
            'match_date' => Carbon::now()->subMinutes(30),
            'status' => 'live',
            'score_team1' => 2,
            'score_team2' => 1,
        ]);

        // UPCOMING Matches
        Matche::create([
            'team1_id' => $allTeams[2]->id,
            'team2_id' => $allTeams[3]->id,
            'match_date' => Carbon::now()->addDays(1)->setTime(20, 0),
            'status' => 'upcoming',
            'score_team1' => 0,
            'score_team2' => 0,
        ]);

        Matche::create([
            'team1_id' => $allTeams[4]->id,
            'team2_id' => $allTeams[5]->id,
            'match_date' => Carbon::now()->addDays(2)->setTime(19, 45),
            'status' => 'upcoming',
            'score_team1' => 0,
            'score_team2' => 0,
        ]);

        // FINISHED Matches
        Matche::create([
            'team1_id' => $allTeams[1]->id,
            'team2_id' => $allTeams[4]->id,
            'match_date' => Carbon::now()->subDays(2),
            'status' => 'finished',
            'score_team1' => 3,
            'score_team2' => 0,
        ]);

        Matche::create([
            'team1_id' => $allTeams[3]->id,
            'team2_id' => $allTeams[0]->id,
            'match_date' => Carbon::now()->subDays(1),
            'status' => 'finished',
            'score_team1' => 1,
            'score_team2' => 1,
        ]);
    }
}
