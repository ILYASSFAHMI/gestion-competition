<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::with('team')
            ->when($request->search, fn($q) => $q->where('name', 'like', "%{$request->search}%")
                                                   ->orWhere('email', 'like', "%{$request->search}%"))
            ->when($request->team_id, fn($q) => $q->where('team_id', $request->team_id))
            ->when($request->role, fn($q) => $q->where('role', $request->role))
            ->orderBy('name')
            ->paginate(20);

        $teams = Team::orderBy('name')->get();

        return view('admin.users.index', compact('users', 'teams'));
    }

    public function create()
    {
        $teams = Team::orderBy('name')->get();
        return view('admin.users.create', compact('teams'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'role'     => 'required|in:admin,user',
            'team_id'  => 'nullable|exists:teams,id',
        ]);

        // Check team capacity
        if ($request->team_id) {
            $team = Team::find($request->team_id);
            if ($team->isFull()) {
                return back()->withErrors(['team_id' => "L'équipe \"{$team->name}\" est déjà complète ({$team->max_members} membres max)."])->withInput();
            }
        }

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => $request->password,
            'role'     => $request->role,
            'team_id'  => $request->team_id,
        ]);

        return redirect()->route('admin.users.index')
                         ->with('success', "L'utilisateur a été créé.");
    }

    public function edit(User $user)
    {
        $teams = Team::orderBy('name')->get();
        return view('admin.users.edit', compact('user', 'teams'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6|confirmed',
            'role'     => 'required|in:admin,user',
            'team_id'  => 'nullable|exists:teams,id',
        ]);

        // Check team capacity if changing team
        if ($request->team_id && $request->team_id != $user->team_id) {
            $team = Team::find($request->team_id);
            if ($team->isFull()) {
                return back()->withErrors(['team_id' => "L'équipe \"{$team->name}\" est déjà complète ({$team->max_members} membres max)."])->withInput();
            }
        }

        $data = [
            'name'    => $request->name,
            'email'   => $request->email,
            'role'    => $request->role,
            'team_id' => $request->team_id,
        ];

        if ($request->filled('password')) {
            $data['password'] = $request->password;
        }

        $user->update($data);

        return redirect()->route('admin.users.index')
                         ->with('success', "L'utilisateur a été mis à jour.");
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Vous ne pouvez pas supprimer votre propre compte.');
        }
        $name = $user->name;
        $user->delete();
        return redirect()->route('admin.users.index')
                         ->with('success', "L'utilisateur \"{$name}\" a été supprimé.");
    }
}
