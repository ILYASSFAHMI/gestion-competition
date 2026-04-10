<x-app-layout>
@section('title', 'Admin — Matchs')
<div class="page-container">
    <div class="page-header" style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:1rem;">
        <div>
            <h1 class="page-title">🗓️ Gestion des Matchs</h1>
        </div>
        <a href="{{ route('admin.matches.create') }}" class="btn btn-primary">+ Programmer un match</a>
    </div>

    <div class="card" style="padding:0;overflow:hidden;">
        @if($matches->isEmpty())
        <div style="padding:3rem;text-align:center;color:var(--muted);">
            <div style="font-size:2.5rem;margin-bottom:1rem;">⚽</div>
            Aucun match programmé.
        </div>
        @else
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Domaine</th>
                    <th>Équipes</th>
                    <th>Statut & Score</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($matches as $match)
                <tr>
                    <td>{{ $match->match_date->format('d/m/Y H:i') }}</td>
                    <td><span style="font-size:0.75rem;background:rgba(99,102,241,0.1);color:var(--primary);padding:0.2rem 0.5rem;border-radius:4px;text-transform:uppercase;">{{ $match->field }}</span></td>
                    <td style="font-weight:600;">{{ $match->team1->name }} <span style="color:var(--muted);font-weight:400;font-size:0.8rem;">vs</span> {{ $match->team2->name }}</td>
                    <td>
                        @if($match->status === 'upcoming')
                            <span style="color:var(--accent);">À venir</span>
                        @elseif($match->status === 'live')
                            <span style="color:#ef4444;font-weight:bold;">En cours (Jouable)</span>
                        @else
                            <span style="color:#10b981;font-weight:bold;">Terminé</span>
                        @endif
                    </td>
                    <td>
                        <div style="display:flex;gap:0.5rem;">
                            @if($match->status !== 'finished')
                            <a href="{{ route('admin.matches.edit', $match) }}" class="btn btn-secondary btn-sm">✏️ Éditer/Résoudre</a>
                            @endif
                            <form method="POST" action="{{ route('admin.matches.destroy', $match) }}">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Supprimer ce match ?')">🗑️</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div style="padding:1rem 1.5rem;">
            {{ $matches->links() }}
        </div>
        @endif
    </div>
</div>
</x-app-layout>
