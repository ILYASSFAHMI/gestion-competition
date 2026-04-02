<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TeamController extends Controller
{
    public function index()
    {
        $teams = Team::withCount('members')->orderBy('score', 'desc')->paginate(15);
        return view('admin.teams.index', compact('teams'));
    }

    public function create()
    {
        return view('admin.teams.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => ['required', 'string', 'max:100', \Illuminate\Validation\Rule::unique('teams')->where(fn ($query) => $query->where('field', $request->field))],
            'join_code'   => ['required', 'string', 'min:4', 'max:20', \Illuminate\Validation\Rule::unique('teams')->where(fn ($query) => $query->where('field', $request->field))],
            'field'       => 'required|in:foot,ctf,baskett,chess,volley ball,Esport',
            'max_members' => 'required|integer|min:1|max:20',
            'description' => 'nullable|string|max:500',
        ]);

        Team::create($request->only('name', 'join_code', 'field', 'max_members', 'description'));

        return redirect()->route('admin.teams.index')
                         ->with('success', "L'équipe \"{$request->name}\" a été créée avec succès.");
    }

    public function edit(Team $team)
    {
        $team->loadCount('members');
        return view('admin.teams.edit', compact('team'));
    }

    public function update(Request $request, Team $team)
    {
        $request->validate([
            'name'        => ['required', 'string', 'max:100', \Illuminate\Validation\Rule::unique('teams')->where(fn ($query) => $query->where('field', $request->field))->ignore($team->id)],
            'join_code'   => ['required', 'string', 'min:4', 'max:20', \Illuminate\Validation\Rule::unique('teams')->where(fn ($query) => $query->where('field', $request->field))->ignore($team->id)],
            'field'       => 'required|in:foot,ctf,baskett,chess,volley ball,Esport',
            'max_members' => 'required|integer|min:1|max:20',
            'score'       => 'required|integer|min:0',
            'description' => 'nullable|string|max:500',
        ]);

        $team->update($request->only('name', 'join_code', 'field', 'max_members', 'score', 'description'));

        return redirect()->route('admin.teams.index')
                         ->with('success', "L'équipe a été mise à jour.");
    }

    public function destroy(Team $team)
    {
        // Remove team from all members
        $team->members()->update(['team_id' => null]);
        $name = $team->name;
        $team->delete();

        return redirect()->route('admin.teams.index')
                         ->with('success', "L'équipe \"{$name}\" a été supprimée.");
    }

    public function regenerateCode(Team $team)
    {
        do {
            $code = strtoupper(Str::random(6));
        } while (Team::where('join_code', $code)->exists());

        $team->update(['join_code' => $code]);

        return redirect()->route('admin.teams.edit', $team)
                         ->with('success', "Nouveau code généré : {$code}");
    }
}
