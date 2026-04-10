<x-app-layout>
@section('title', 'Admin — Équipes')
<div class="page-container">

    <div class="page-header" style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:1rem;">
        <div>
            <h1 class="page-title">🏫 Gestion des Équipes</h1>
            <p class="page-subtitle">{{ $teams->total() }} équipe(s) au total</p>
        </div>
        <a href="{{ route('admin.teams.create') }}" class="btn btn-primary">+ Nouvelle équipe</a>
    </div>

    <div class="card" style="padding:0;overflow:hidden;">
        @if($teams->isEmpty())
        <div style="padding:3rem;text-align:center;color:var(--muted);">
            <div style="font-size:2.5rem;margin-bottom:1rem;">🏫</div>
            Aucune équipe pour l'instant.
            <div style="margin-top:1rem;">
                <a href="{{ route('admin.teams.create') }}" class="btn btn-primary">Créer la première équipe</a>
            </div>
        </div>
        @else
        <table>
            <thead>
                <tr>
                    <th>École / Équipe</th>
                    <th>Code d'accès</th>
                    <th>Membres</th>
                    <th>Score</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($teams as $team)
                <tr>
                    <td>
                        <div style="font-weight:600;display:flex;align-items:center;gap:0.5rem;">
                            {{ $team->name }}
                            <span style="font-size:0.65rem;background:rgba(99,102,241,0.1);color:var(--primary);padding:0.15rem 0.4rem;border-radius:4px;text-transform:uppercase;letter-spacing:0.5px;">{{ $team->field }}</span>
                        </div>
                        @if($team->description)
                        <div style="font-size:0.75rem;color:var(--muted);margin-top:0.2rem;">{{ Str::limit($team->description, 50) }}</div>
                        @endif
                    </td>
                    <td>
                        <code style="background:rgba(99,102,241,0.1);color:var(--primary);padding:0.3rem 0.75rem;border-radius:6px;font-size:0.9rem;font-weight:700;letter-spacing:2px;">
                            {{ $team->join_code }}
                        </code>
                    </td>
                    <td>
                        @php $full = $team->members_count >= $team->max_members; @endphp
                        <span style="{{ $full ? 'color:#f87171;font-weight:600;' : 'color:var(--muted);' }}">
                            {{ $team->members_count }}/{{ $team->max_members }}
                            {{ $full ? '🔴 Complet' : '' }}
                        </span>
                    </td>
                    <td style="font-weight:700;font-family:'Space Grotesk',sans-serif;font-size:1rem;">
                        {{ number_format($team->score) }}
                    </td>
                    <td>
                        <div style="display:flex;gap:0.5rem;flex-wrap:wrap;">
                            <a href="{{ route('admin.teams.edit', $team) }}" class="btn btn-secondary btn-sm">✏️ Modifier</a>
                            <form method="POST" action="{{ route('admin.teams.regenerate', $team) }}" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-warning btn-sm" onclick="return confirm('Régénérer le code ?')">🔄 Nouveau code</button>
                            </form>
                            <form method="POST" action="{{ route('admin.teams.destroy', $team) }}" style="display:inline;">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Supprimer \"{{ $team->name }}\" ? Les membres seront retirés.')">🗑️</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div style="padding:1rem 1.5rem;">
            {{ $teams->links() }}
        </div>
        @endif
    </div>

</div>
</x-app-layout>
