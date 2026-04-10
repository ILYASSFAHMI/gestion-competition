<x-app-layout>
@section('title', 'Admin — Tableau de bord')
<div class="page-container">

    <div class="page-header" style="display:flex;align-items:center;justify-content:space-between;">
        <div>
            <h1 class="page-title">⚙️ Tableau de bord Admin</h1>
            <p class="page-subtitle">Gérez les équipes et les participants</p>
        </div>
    </div>

    {{-- Stats --}}
    <div class="stat-grid">
        <div class="stat-box" style="border-color:rgba(99,102,241,0.3);">
            <div class="stat-value" style="color:var(--primary);">{{ $totalTeams }}</div>
            <div class="stat-label">🏫 Équipes inscrites</div>
        </div>
        <div class="stat-box" style="border-color:rgba(52,211,153,0.3);">
            <div class="stat-value" style="color:#34d399;">{{ $totalUsers }}</div>
            <div class="stat-label">👥 Participants</div>
        </div>
        <div class="stat-box" style="border-color:rgba(245,158,11,0.3);">
            <div class="stat-value" style="color:var(--accent);">{{ $usersInTeams }}</div>
            <div class="stat-label">✅ Membres assignés</div>
        </div>
        <div class="stat-box" style="border-color:rgba(239,68,68,0.3);">
            <div class="stat-value" style="color:#f87171;">{{ $totalUsers - $usersInTeams }}</div>
            <div class="stat-label">⏳ Sans équipe</div>
        </div>
    </div>

    {{-- Quick actions --}}
    <div style="display:flex;gap:0.75rem;margin-bottom:2rem;flex-wrap:wrap;">
        <a href="{{ route('admin.teams.create') }}" class="btn btn-primary">🏫 Nouvelle équipe</a>
        <a href="{{ route('admin.users.create') }}" class="btn btn-secondary">👤 Nouvel utilisateur</a>
        <a href="{{ route('admin.matches.create') }}" class="btn btn-secondary">🗓️ Programmer un match</a>
        <a href="{{ route('admin.matches.index') }}" class="btn btn-secondary">Gérer les matchs</a>
        <a href="{{ route('admin.teams.index') }}" class="btn btn-secondary">Gérer les équipes</a>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Gérer les utilisateurs</a>
    </div>

    {{-- Classement --}}
    <div class="card" style="padding:0;overflow:hidden;">
        <div style="padding:1.25rem 1.5rem;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;">
            <span style="font-weight:700;">🏆 Classement des équipes</span>
            <a href="{{ route('admin.teams.index') }}" style="font-size:0.8rem;color:var(--primary);">Gérer →</a>
        </div>
        @if($teams->isEmpty())
        <div style="padding:2rem;text-align:center;color:var(--muted);">Aucune équipe créée.</div>
        @else
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>École</th>
                    <th>Membres</th>
                    <th>Score</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($teams as $i => $team)
                <tr>
                    <td style="font-weight:700;{{ $i<3?'color:'.(['#fbbf24','#94a3b8','#b45309'][$i]).';':'' }}">
                        {{ $i < 3 ? ['🥇','🥈','🥉'][$i] : ($i+1) }}
                    </td>
                    <td>
                        <div style="font-weight:600;">{{ $team->name }}</div>
                        <div style="font-size:0.75rem;color:var(--muted);">Code : <code style="background:rgba(99,102,241,0.1);padding:0.1rem 0.4rem;border-radius:4px;color:var(--primary);">{{ $team->join_code }}</code></div>
                    </td>
                    <td>
                        <span style="{{ $team->members_count >= $team->max_members ? 'color:#f87171;' : 'color:var(--muted);' }}">
                            {{ $team->members_count }}/{{ $team->max_members }}
                        </span>
                    </td>
                    <td style="font-weight:700;font-family:'Space Grotesk',sans-serif;">{{ number_format($team->score) }}</td>
                    <td>
                        <a href="{{ route('admin.teams.edit', $team) }}" class="btn btn-secondary btn-sm">✏️ Modifier</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>

</div>
</x-app-layout>
