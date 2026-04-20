<x-app-layout>
<div class="page-container">

    <div style="display:flex;align-items:flex-start;justify-content:space-between;flex-wrap:wrap;gap:1rem;margin-bottom:2rem;">
        <div>
            <h1 class="page-title">👥 ÉQUIPES</h1>
            <p class="page-subtitle">{{ $teams->count() }} équipe(s) inscrites — max 4 membres par équipe</p>
        </div>
        <div style="display:flex;gap:0.75rem;flex-wrap:wrap;">
            @if(!auth()->user()->hasTeam())
            <a href="{{ route('teams.create') }}" class="btn btn-primary">➕ Créer mon équipe</a>
            <a href="{{ route('teams.join') }}" class="btn btn-secondary">🔑 Rejoindre une équipe</a>
            @else
            <a href="{{ route('teams.show', auth()->user()->team) }}" class="btn btn-secondary">🛡️ Mon équipe</a>
            @endif
        </div>
    </div>

    @if($teams->isEmpty())
    <div class="card" style="text-align:center;padding:4rem;color:#5a7a9a;">
        <div style="font-size:3rem;">👥</div>
        <p style="margin-top:1rem;">Aucune équipe créée. Soyez le premier !</p>
    </div>
    @else
    <div class="card" style="padding:0;overflow:hidden;">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Équipe</th>
                    <th>Leader</th>
                    <th>Membres</th>
                    <th>Challenges</th>
                    <th>Score</th>
                    @if(auth()->user()->isAdmin())<th>Actions</th>@endif
                </tr>
            </thead>
            <tbody>
                @foreach($teams as $i => $team)
                <tr>
                    <td class="mono" style="color:#5a7a9a;">{{ $i + 1 }}</td>
                    <td>
                        <a href="{{ route('teams.show', $team) }}"
                           style="color:#e2eaf5;text-decoration:none;font-weight:600;font-family:'Rajdhani',sans-serif;font-size:1rem;">
                            {{ $team->name }}
                        </a>
                        @if($userTeam && $userTeam->id === $team->id)
                        <span class="badge" style="color:var(--neon-green);border-color:var(--neon-green);background:rgba(0,255,136,0.08);margin-left:0.5rem;">MA TEAM</span>
                        @endif
                    </td>
                    <td style="color:#8ca0c0;">{{ $team->leader?->name ?? 'N/A' }}</td>
                    <td>
                        <div style="display:flex;align-items:center;gap:0.5rem;">
                            <div class="progress-bar" style="width:60px;">
                                <div class="progress-fill" style="width:{{ ($team->users_count / 4) * 100 }}%;"></div>
                            </div>
                            <span class="mono" style="font-size:0.8rem;color:#8ca0c0;">{{ $team->users_count }}/4</span>
                        </div>
                    </td>
                    <td class="mono" style="color:#8ca0c0;">{{ $team->solves->count() }}</td>
                    <td>
                        <span class="mono" style="color: var(--neon-green);font-weight:600;">
                            {{ number_format($team->score) }} pts
                        </span>
                    </td>
                    @if(auth()->user()->isAdmin())
                    <td>
                        <form method="POST" action="{{ route('teams.destroy', $team) }}"
                              onsubmit="return confirm('Supprimer cette équipe ?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                        </form>
                    </td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>
</x-app-layout>