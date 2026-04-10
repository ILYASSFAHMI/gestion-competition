<x-app-layout>
@section('title', "Modifier l'utilisateur")
<div class="page-container" style="max-width:600px;">

    <div class="page-header">
        <a href="{{ route('admin.users.index') }}" style="color:var(--muted);font-size:0.85rem;">← Retour aux utilisateurs</a>
        <h1 class="page-title" style="margin-top:0.5rem;">✏️ Modifier : {{ $user->name }}</h1>
    </div>

    <div class="card">
        <form method="POST" action="{{ route('admin.users.update', $user) }}">
            @csrf @method('PUT')

            <div class="form-group">
                <label for="name">NOM COMPLET *</label>
                <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required>
                @error('name') <div class="form-error">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label for="email">ADRESSE EMAIL *</label>
                <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required>
                @error('email') <div class="form-error">{{ $message }}</div> @enderror
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                <div class="form-group">
                    <label for="password">NOUVEAU MOT DE PASSE <span style="font-weight:400;color:var(--muted);">(laisser vide = inchangé)</span></label>
                    <input id="password" name="password" type="password" placeholder="Min. 6 caractères">
                    @error('password') <div class="form-error">{{ $message }}</div> @enderror
                </div>
                <div class="form-group">
                    <label for="password_confirmation">CONFIRMER MDP</label>
                    <input id="password_confirmation" name="password_confirmation" type="password">
                </div>
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                <div class="form-group">
                    <label for="role">RÔLE *</label>
                    <select id="role" name="role" required {{ $user->id === auth()->id() ? 'disabled' : '' }}>
                        <option value="user"  {{ old('role', $user->role) === 'user'  ? 'selected' : '' }}>Participant</option>
                        <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Administrateur</option>
                    </select>
                    @if($user->id === auth()->id())
                        <input type="hidden" name="role" value="{{ $user->role }}">
                        <div style="font-size:0.75rem;color:var(--muted);margin-top:0.3rem;">Vous ne pouvez pas modifier votre propre rôle.</div>
                    @endif
                    @error('role') <div class="form-error">{{ $message }}</div> @enderror
                </div>
                <div class="form-group">
                    <label for="team_id">ÉQUIPE</label>
                    <select id="team_id" name="team_id">
                        <option value="">— Sans équipe —</option>
                        @foreach($teams as $team)
                        @php $isCurrent = $user->team_id == $team->id; @endphp
                        <option value="{{ $team->id }}" {{ old('team_id', $user->team_id) == $team->id ? 'selected' : '' }}
                            {{ (!$isCurrent && $team->isFull()) ? 'disabled' : '' }}>
                            {{ $team->name }} ({{ $team->membersCount() }}/{{ $team->max_members }}){{ (!$isCurrent && $team->isFull()) ? ' — Complet' : '' }}
                        </option>
                        @endforeach
                    </select>
                    @error('team_id') <div class="form-error">{{ $message }}</div> @enderror
                </div>
            </div>

            <div style="display:flex;gap:0.75rem;margin-top:1.5rem;">
                <button type="submit" class="btn btn-primary" style="flex:1;padding:0.75rem;">💾 Enregistrer</button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Annuler</a>
            </div>
        </form>
    </div>

    @if($user->id !== auth()->id())
    <div class="card" style="margin-top:1.5rem;border-color:rgba(239,68,68,0.3);background:rgba(239,68,68,0.03);">
        <div style="font-weight:700;color:#f87171;margin-bottom:0.75rem;">⚠️ Zone dangereuse</div>
        <form method="POST" action="{{ route('admin.users.destroy', $user) }}">
            @csrf @method('DELETE')
            <button type="submit" class="btn btn-danger" onclick="return confirm('Supprimer définitivement {{ $user->name }} ?')">
                🗑️ Supprimer cet utilisateur
            </button>
        </form>
    </div>
    @endif

</div>
</x-app-layout>
