<x-app-layout>
@section('title', "Modifier l'équipe")
<div class="page-container" style="max-width:700px;">

    <div class="page-header">
        <a href="{{ route('admin.teams.index') }}" style="color:var(--muted);font-size:0.85rem;">← Retour aux équipes</a>
        <h1 class="page-title" style="margin-top:0.5rem;">✏️ Modifier : {{ $team->name }}</h1>
    </div>

    {{-- Stats rapides --}}
    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:1rem;margin-bottom:1.5rem;">
        <div class="stat-box">
            <div class="stat-value">{{ $team->members_count }}</div>
            <div class="stat-label">Membres actuels</div>
        </div>
        <div class="stat-box">
            <div class="stat-value">{{ $team->max_members }}</div>
            <div class="stat-label">Max membres</div>
        </div>
        <div class="stat-box">
            <div class="stat-value" style="color:var(--primary);">{{ $team->score }}</div>
            <div class="stat-label">Score actuel</div>
        </div>
    </div>

    <div class="card">
        <form method="POST" action="{{ route('admin.teams.update', $team) }}">
            @csrf @method('PUT')

            <div class="form-group">
                <label for="name">NOM DE L'ÉCOLE / ÉQUIPE *</label>
                <input id="name" name="name" type="text" value="{{ old('name', $team->name) }}" required>
                @error('name') <div class="form-error">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label for="field">DOMAINE / SPORT *</label>
                <select id="field" name="field" required>
                    @foreach(['foot', 'ctf', 'baskett', 'chess', 'volley ball', 'Esport'] as $f)
                    <option value="{{ $f }}" {{ old('field', $team->field) == $f ? 'selected' : '' }}>{{ ucfirst($f) }}</option>
                    @endforeach
                </select>
                @error('field') <div class="form-error">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label for="join_code">CODE D'ACCÈS *</label>
                <div style="display:flex;gap:0.75rem;align-items:center;">
                    <input id="join_code" name="join_code" type="text" value="{{ old('join_code', $team->join_code) }}"
                        style="letter-spacing:3px;font-weight:700;text-transform:uppercase;" required>
                    <div style="white-space:nowrap;font-size:0.8rem;color:var(--muted);">ou</div>
                    <form method="POST" action="{{ route('admin.teams.regenerate', $team) }}" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn btn-warning btn-sm" onclick="return confirm('Générer un nouveau code ? L\'ancien ne fonctionnera plus.')">🔄 Auto-générer</button>
                    </form>
                </div>
                @error('join_code') <div class="form-error">{{ $message }}</div> @enderror
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                <div class="form-group">
                    <label for="max_members">MAX MEMBRES *</label>
                    <input id="max_members" name="max_members" type="number" value="{{ old('max_members', $team->max_members) }}" min="{{ $team->members_count }}" max="20" required>
                    @error('max_members') <div class="form-error">{{ $message }}</div> @enderror
                </div>
                <div class="form-group">
                    <label for="score">SCORE *</label>
                    <input id="score" name="score" type="number" value="{{ old('score', $team->score) }}" min="0" required>
                    @error('score') <div class="form-error">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="description">DESCRIPTION</label>
                <textarea id="description" name="description">{{ old('description', $team->description) }}</textarea>
                @error('description') <div class="form-error">{{ $message }}</div> @enderror
            </div>

            <div style="display:flex;gap:0.75rem;margin-top:1.5rem;">
                <button type="submit" class="btn btn-primary" style="flex:1;padding:0.75rem;">💾 Enregistrer</button>
                <a href="{{ route('admin.teams.index') }}" class="btn btn-secondary">Annuler</a>
            </div>
        </form>
    </div>

    {{-- Membres de l'équipe --}}
    <div class="card" style="margin-top:1.5rem;padding:0;overflow:hidden;">
        <div style="padding:1.25rem 1.5rem;border-bottom:1px solid var(--border);font-weight:700;">
            👥 Membres actuels ({{ $team->members_count }}/{{ $team->max_members }})
        </div>
        @if($team->members->isEmpty())
        <div style="padding:1.5rem;text-align:center;color:var(--muted);font-size:0.875rem;">Aucun membre.</div>
        @else
        <table>
            <thead><tr><th>Nom</th><th>Email</th><th>Action</th></tr></thead>
            <tbody>
                @foreach($team->members as $member)
                <tr>
                    <td style="font-weight:600;">{{ $member->name }}</td>
                    <td style="color:var(--muted);">{{ $member->email }}</td>
                    <td>
                        <a href="{{ route('admin.users.edit', $member) }}" class="btn btn-secondary btn-sm">✏️ Modifier</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>

    {{-- Danger zone --}}
    <div class="card" style="margin-top:1.5rem;border-color:rgba(239,68,68,0.3);background:rgba(239,68,68,0.03);">
        <div style="font-weight:700;color:#f87171;margin-bottom:0.75rem;">⚠️ Zone dangereuse</div>
        <p style="color:var(--muted);font-size:0.875rem;margin:0 0 1rem;">
            Supprimer cette équipe retirera tous ses membres. Cette action est irréversible.
        </p>
        <form method="POST" action="{{ route('admin.teams.destroy', $team) }}">
            @csrf @method('DELETE')
            <button type="submit" class="btn btn-danger" onclick="return confirm('Supprimer définitivement \"{{ $team->name }}\" ?')">
                🗑️ Supprimer l'équipe
            </button>
        </form>
    </div>

</div>
</x-app-layout>
