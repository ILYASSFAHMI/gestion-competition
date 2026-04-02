<?php

namespace App\Http\Controllers;

use App\Models\Challenge;
use App\Models\Solve;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChallengeController extends Controller
{
    /**
     * Display all challenges (for authenticated users).
     */
    public function index()
    {
        $categories = ['web', 'pwn', 'crypto', 'forensics', 'reverse', 'misc'];
        $challenges = Challenge::where('is_active', true)
            ->orderBy('category')
            ->orderBy('points')
            ->get();

        $userTeam = Auth::user()->team;
        $solvedIds = $userTeam
            ? $userTeam->solves()->pluck('challenge_id')->toArray()
            : [];

        return view('challenges.index', compact('challenges', 'categories', 'solvedIds', 'userTeam'));
    }

    /**
     * Submit a flag for a challenge.
     */
    public function submitFlag(Request $request, Challenge $challenge)
    {
        $user = Auth::user();

        if (!$user->hasTeam()) {
            return back()->with('error', 'Vous devez rejoindre une équipe pour soumettre des flags.');
        }

        $request->validate([
            'flag' => 'required|string',
        ]);

        $team = $user->team;

        // Already solved?
        if ($challenge->isSolvedByTeam($team->id)) {
            return back()->with('error', 'Votre équipe a déjà résolu ce challenge.');
        }

        // Check flag
        if (trim($request->flag) !== trim($challenge->flag)) {
            return back()->with('error', '❌ Flag incorrect. Essayez encore !');
        }

        // Record solve and add points to team
        Solve::create([
            'team_id'      => $team->id,
            'challenge_id' => $challenge->id,
            'user_id'      => $user->id,
        ]);

        $team->increment('score', $challenge->points);

        return back()->with('success', '🎉 Correct ! +' . $challenge->points . ' points pour ' . $team->name . ' !');
    }

    // ---- ADMIN METHODS ----

    /**
     * Admin: List all challenges.
     */
    public function adminIndex()
    {
        $challenges = Challenge::withCount('solves')->orderByDesc('created_at')->get();
        return view('challenges.admin', compact('challenges'));
    }

    /**
     * Admin: Show create challenge form.
     */
    public function create()
    {
        return view('challenges.create');
    }

    /**
     * Admin: Store new challenge.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:100',
            'description' => 'required|string',
            'category'    => 'required|in:web,pwn,crypto,forensics,reverse,misc',
            'points'      => 'required|integer|min:1',
            'flag'        => 'required|string',
            'file_url'    => 'nullable|url',
            'difficulty'  => 'required|in:easy,medium,hard,insane',
        ]);

        Challenge::create($request->all());

        return redirect()->route('challenges.admin')
            ->with('success', 'Challenge créé avec succès.');
    }

    /**
     * Admin: Show edit challenge form.
     */
    public function edit(Challenge $challenge)
    {
        return view('challenges.edit', compact('challenge'));
    }

    /**
     * Admin: Update challenge.
     */
    public function update(Request $request, Challenge $challenge)
    {
        $request->validate([
            'title'       => 'required|string|max:100',
            'description' => 'required|string',
            'category'    => 'required|in:web,pwn,crypto,forensics,reverse,misc',
            'points'      => 'required|integer|min:1',
            'flag'        => 'required|string',
            'file_url'    => 'nullable|url',
            'difficulty'  => 'required|in:easy,medium,hard,insane',
            'is_active'   => 'boolean',
        ]);

        $challenge->update($request->all());

        return redirect()->route('challenges.admin')
            ->with('success', 'Challenge mis à jour.');
    }

    /**
     * Admin: Delete challenge.
     */
    public function destroy(Challenge $challenge)
    {
        $challenge->delete();
        return redirect()->route('challenges.admin')
            ->with('success', 'Challenge supprimé.');
    }
}
