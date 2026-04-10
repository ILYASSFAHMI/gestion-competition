<x-app-layout>
@section('title', 'Admin — Utilisateurs')
<div class="page-container">

    <div class="page-header" style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:1rem;">
        <div>
            <h1 class="page-title">👥 Gestion des Utilisateurs</h1>
            <p class="page-subtitle">{{ $users->total() }} utilisateur(s) au total</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">+ Nouvel utilisateur</a>
    </div>

    {{-- Filtres --}}
    <form method="GET" style="display:flex;gap:0.75rem;margin-bottom:1.5rem;flex-wrap:wrap;">
        <input name="search" type="text" value="{{ request('search') }}" placeholder="Rechercher..." style="width:220px;flex:none;">
        <select name="team_id" style="width:180px;flex:none;">
            <option value="">Toutes les équipes</option>
            @foreach($teams as $team)
            <option value="{{ $team->id }}" {{ request('team_id') == $team->id ? 'selected' : '' }}>{{ $team->name }}</option>
            @endforeach
            <option value="null" {{ request('team_id') === 'null' ? 'selected' : '' }}>Sans équipe</option>
        </select>
        <select name="role" style="width:140px;flex:none;">
            <option value="">Tous les rôles</option>
            <option value="user"  {{ request('role') === 'user'  ? 'selected' : '' }}>Participant</option>
            <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
        </select>
        <button type="submit" class="btn btn-secondary">🔍 Filtrer</button>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">✕ Reset</a>
    </form>

    <div class="card" style="padding:0;overflow:hidden;">
        @if($users->isEmpty())
        <div style="padding:3rem;text-align:center;color:var(--muted);">
            <div style="font-size:2rem;margin-bottom:1rem;">👤</div>
            Aucun utilisateur trouvé.
        </div>
        @else
        <table>
            <thead>
                <tr>
                    <th>Utilisateur</th>
                    <th>Équipe</th>
                    <th>Rôle</th>
                    <th>Inscription</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>
                        <div style="display:flex;align-items:center;gap:0.75rem;">
                            <div style="width:32px;height:32px;border-radius:8px;background:linear-gradient(135deg,var(--primary),#8b5cf6);display:flex;align-items:center;justify-content:center;font-weight:700;font-size:0.8rem;color:white;flex-shrink:0;">
                                {{ strtoupper(substr($user->name, 0, 2)) }}
                            </div>
                            <div>
                                <div style="font-weight:600;">{{ $user->name }}</div>
                                <div style="font-size:0.75rem;color:var(--muted);">{{ $user->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        @if($user->team)
                            <span style="font-size:0.8rem;background:rgba(99,102,241,0.1);color:var(--primary);padding:0.2rem 0.6rem;border-radius:6px;">{{ $user->team->name }}</span>
                        @else
                            <span style="color:var(--muted);font-size:0.8rem;">—</span>
                        @endif
                    </td>
                    <td>
                        @if($user->role === 'admin')
                            <span style="font-size:0.75rem;background:rgba(245,158,11,0.1);color:var(--accent);padding:0.2rem 0.6rem;border-radius:6px;font-weight:700;">Admin</span>
                        @else
                            <span style="font-size:0.75rem;color:var(--muted);">Participant</span>
                        @endif
                    </td>
                    <td style="font-size:0.8rem;color:var(--muted);">{{ $user->created_at->format('d/m/Y') }}</td>
                    <td>
                        <div style="display:flex;gap:0.5rem;">
                            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-secondary btn-sm">✏️</a>
                            @if($user->id !== auth()->id())
                            <form method="POST" action="{{ route('admin.users.destroy', $user) }}">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Supprimer {{ $user->name }} ?')">🗑️</button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div style="padding:1rem 1.5rem;">
            {{ $users->links() }}
        </div>
        @endif
    </div>

</div>
</x-app-layout>
